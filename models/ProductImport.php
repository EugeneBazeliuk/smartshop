<?php namespace Smartshop\Catalog\Models;

use Event;
use Exception;
use BackendAuth;
use Backend\Models\ImportModel;

/**
 * ProductImport Model
 *
 * @property \System\Models\File $import_file
 *
 * @method \October\Rain\Database\Relations\AttachOne import_file
 *
 *
 * @todo add Binding Import
 * @todo add BindingType Import
 * @todo add Property import
 */
class ProductImport extends ImportModel
{
    const TWO_LEVEL_DELIMETER = '::';

    /**
     * @var string The database table used by the model.
     */
    public $table = 'smartshop_products';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'title' => 'required',
        'sku' => 'required',
    ];

    protected $author;

    protected $template;

    protected $bindingNameCache = [];

    protected $bindingTypeCodeCache = [];

    protected $categoryNameCache = [];

    protected $propertyNameCache = [];

    protected $propertyValueCache = [];

    protected $publisherNameCache = [];

    protected $publisherSetNameCache = [];

    /**
     * @param      $results
     * @param null $sessionKey
     */
    public function importData($results, $sessionKey = null)
    {
        //
        // Import
        //
        foreach ($results as $row => $data) {
            try {

                // Check title
                if (!array_get($data, 'title') && !array_get($data, 'sku')) {
                    $this->logSkipped($row, 'Missing required fields');
                    continue;
                }

                // Find or create
                /** @var \Smartshop\Catalog\Models\Product $product */
                $product = Product::make();
                $product = $this->findDuplicateProduct($data) ?: $product;

                $productExists = $product->exists;

                $exceptAttributes = [
                    'id',
                    'bindings',
                    'categories',
                    'properties',
                    'publisher',
                    'publisher_set',
                ];

                foreach (array_except($data, $exceptAttributes) as $key => $value) {
                    $value ? $product->{$key} = $value : null;
                }

                $product->publisher = $this->getPublisherId($data);
                $product->publisher_set = $this->getPublisherSetId($data);

                // Save
                $product->save();

                // Sync Bindings
                if ($bindings = array_get($data, 'bindings')) {
                    $product->bindings()->sync($this->getBindingsIds($bindings));
                }

                // Sync Categories
                if ($categories = array_get($data, 'categories')) {
                    $product->categories()->sync($this->getCategoriesIds($categories));
                }

                // Sync Properties
                if ($properties = array_get($data, 'properties')) {
                    $product->properties()->sync($this->getPropertiesIds($properties));
                }

                //
                // Log results
                //
                if ($productExists) {
                    $this->logUpdated();
                } else {
                    $this->logCreated();
                }
            }
            catch (Exception $ex) {
                $this->logError($row, $ex->getMessage());
            }
        }

        Event::fire('smartshop.catalog.importRun', [
            $this->getResultStats(),
            $this->getImportFilePath($sessionKey),
            $this->getImportAuthorId(),
            $this->getImportTemplateId(),
        ]);
    }

    /**
     * Find duplicate of Product
     *
     * @param array $data
     * @return \October\Rain\Database\Model
     */
    private function findDuplicateProduct($data)
    {
        return array_get($data, 'id')
            ? Product::find(array_get($data, 'id'))
            : Product::where('sku', array_get($data, 'sku'))->first();
    }

    /**
     * Get Publisher id by name
     *
     * @param array $data
     * @return int
     */
    private function getPublisherId($data)
    {
        if (!$name = array_get($data, 'publisher')) {
            return null;
        }

        if (isset($this->publisherNameCache[$name])) {
            return $this->publisherNameCache[$name];
        }

        $publisher = Publisher::firstOrCreate(['name' => $name]);

        return $this->publisherNameCache[$name] = $publisher->id;
    }

    /**
     * Get PublisherSet id by name
     *
     * @param array $data
     * @return int
     * @throws Exception
     */
    private function getPublisherSetId($data)
    {
        if (!$publisherSetName = array_get($data, 'publisher_set')) {
            return null;
        }

        if (isset($this->publisherSetNameCache[$publisherSetName])) {
            return $this->publisherSetNameCache[$publisherSetName];
        }

        if (!$publisherId = $this->getPublisherId($data)) {
            throw new Exception('Не удалось получить Издательство для создания серии');
        }

        $publisherSet = PublisherSet::firstOrCreate([
            'name' => $publisherSetName,
            'publisher_id' => $publisherId,
        ]);

        return $this->publisherSetNameCache[$publisherSetName] = $publisherSet->id;
    }

    /**
     * Get Bindings ids
     *
     * @param string $bindingsString
     * @return array
     * @throws \Exception
     */
    private function getBindingsIds($bindingsString)
    {
        $ids = [];

        $bindings = $this->decodeArrayValue($bindingsString);

        foreach ($bindings as $encodedBinding) {

            if (!$binding = $this->decodeTwoLevelArrayValue($encodedBinding)) {
                continue;
            }

            if (isset($this->bindingNameCache[$binding['code']][$binding['value']])) {

                $ids[] = $this->bindingNameCache[$binding['code']][$binding['value']];

            } else {

                $model = Binding::firstOrCreate([
                    'name' => $binding['value'],
                    'binding_type_id' => $this->getBindingTypeId($binding['code']),
                ]);

                $ids[] = $this->bindingNameCache[$binding['code']][$binding['value']] = $model->id;
            }
        }

        return $ids;
    }

    /**
     * Get BindingType id by code
     *
     * @param string $code
     *
     * @return int
     * @throws \Exception
     * @todo Translate error
     */
    private function getBindingTypeId($code)
    {
        if (isset($this->bindingTypeCodeCache[$code])) {
            return $this->bindingTypeCodeCache[$code];
        }

        if ($model = BindingType::whereCode($code)->first()) {
            return $this->bindingTypeCodeCache[$code] = $model->id;
        }

        throw new Exception('Не удалось определить тип связи');
    }

    /**
     * Get Categories ids
     *
     * @param string $categoriesString
     * @return array
     */
    private function getCategoriesIds($categoriesString)
    {
        $ids = [];
        $categories = $this->decodeArrayValue($categoriesString);

        foreach ($categories as $name) {
            if (isset($this->categoryNameCache[$name])) {
                $ids[] = $this->categoryNameCache[$name];
            } else {
                $model = Category::firstOrCreate(['name' => $name]);
                $ids[] = $this->categoryNameCache[$name] = $model->id;
            }
        }

        return $ids;
    }

    /**
     * Get Properties
     *
     * @param string $propertiesString
     * @return array
     */
    private function getPropertiesIds($propertiesString)
    {
        $ids = [];
        $properties = $this->decodeArrayValue($propertiesString);

        foreach ($properties as $encodedProperty) {

            if (!$property = $this->decodeTwoLevelArrayValue($encodedProperty)) {
                continue;
            }

            if (isset($this->propertyNameCache[$property['code']])) {
                $id = $this->propertyNameCache[$property['code']];
            } else {
                $model = Property::firstOrCreate(['code' => $property['code']]);
                $id = $this->propertyNameCache[$property['code']] = $model->id;
            }

            $ids[$id] = [
                'property_value_id' => $this->getPropertyValueId($id, $property['value'])
            ];
        }

        return $ids;
    }

    /**
     * Get PropertyValue id
     *
     * @param int $propertyId
     * @param string $value
     *
     * @return int
     */
    private function getPropertyValueId($propertyId, $value)
    {
        if (isset($this->propertyValueCache[$propertyId][$value])) {
            return $this->propertyValueCache[$propertyId][$value];
        } else {

            $model = PropertyValue::firstOrCreate([
                'value' => $value,
                'property_id' => $propertyId
            ]);

            return $this->propertyValueCache[$propertyId][$value] = $model->id;
        }
    }

    //
    //
    //

    /**
     * Set ImportTemplate
     *
     * @param $template
     */
    public function setImportTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * Get import Template
     *
     * @return int|null
     */
    private function getImportTemplateId()
    {
        return $this->template ? $this->template->id : null;
    }

    /**
     * Get import Author
     *
     * @return int|null
     */
    private function getImportAuthorId()
    {
        if (!$author = $this->author) {
            $author = BackendAuth::getUser();
        }

        return $author ? $author->id : null;
    }

    /**
     * Decode Two Level Array Value
     *
     * @param string $string
     * @return array|null
     */
    private function decodeTwoLevelArrayValue($string)
    {
        $data = $this->decodeArrayValue($string, self::TWO_LEVEL_DELIMETER);
        return count($data) == 2 ? ['code' => $data[0], 'value' => $data[1]] : null;
    }
}