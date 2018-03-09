<?php namespace Smartshop\Catalog\Models;

use Event;
use Exception;
use BackendAuth;
use ApplicationException;
use Backend\Models\ImportModel;

/**
 * ProductImport Model
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

    protected $template;

    protected $bindingNameCache = [];

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

                foreach (array_except($data, $exceptAttributes) as $attribute => $value) {
                    $value ? $product->{$attribute} = $value : null;
                }

                $product->publisher = $this->findPublisherFromName($data);
                $product->publisher_set = $this->findPublisherSetFromName($data);

                // Save
                $product->save();

                // Sync categories
                $product->categories()->sync($this->getCategoriesIds($data));

                // Sync bindings
                $product->bindings()->sync($this->getBindingsIds($data));

                // Sync properties
                // $product->properties()->sync($this->getPropertiesIds($data));

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
            BackendAuth::getUser(),
            $this->template,
        ]);
    }























    /**
     * @param $data
     * @return \October\Rain\Database\Model
     */
    private function findDuplicateProduct($data)
    {
        return array_get($data, 'id')
            ? Product::find(array_get($data, 'id'))
            : Product::where('sku', array_get($data, 'sku'))->first();
    }

    /**
     * Find Publisher by name
     * @param $data
     * @return \October\Rain\Database\Model|mixed|null
     */
    private function findPublisherFromName($data)
    {
        if (!$name = array_get($data, 'publisher')) {
            return null;
        }

        if (isset($this->publisherNameCache[$name])) {
            return $this->publisherNameCache[$name];
        }

        $publisher = Publisher::firstOrCreate(['name' => $name]);

        return $this->publisherNameCache[$name] = $publisher;
    }

    /**
     * Get Publisher Id
     */
    private function getPublisherId($data)
    {
        $publisher = $this->findPublisherFromName($data);

        return $publisher ? $publisher->id : null;
    }

    /**
     * Find PublisherSet by name
     * @param $data
     * @return \October\Rain\Database\Model|mixed|null
     */
    private function findPublisherSetFromName($data)
    {
        if (!$name = array_get($data, 'publisher_set')) {
            return null;
        }

        if (isset($this->publisherSetNameCache[$name])) {
            return $this->publisherSetNameCache[$name];
        }

        $publisherSet = PublisherSet::firstOrCreate([
            'name' => $name,
            'publisher_id' => $this->getPublisherId($data),
        ]);

        return $this->publisherSetNameCache[$name] = $publisherSet;
    }

    /**
     * Get Bindings id's
     * @param $data
     * @return array
     */
    private function getBindingsIds($data)
    {
        $ids = [];
        $bindings = $this->decodeArrayValue(array_get($data, 'bindings'));

        foreach ($bindings as $encodedBinding)
        {
            $result = $this->decodeTwoLevelArrayValue($encodedBinding);

            $bindingType = $result['code'];
            $bindingName = $result['value'];

            if (isset($this->bindingNameCache[$bindingType][$bindingName])) {
                $ids[] = $this->bindingNameCache[$bindingType][$bindingName];
            } else {
                $model = Binding::firstOrCreate([
                    'name' => $bindingName,
                    'binding_type' => $this->getBindingTypeIdByCode($bindingType)
                ]);
                $ids[] = $this->bindingNameCache[$bindingType][$bindingName] = $model->id;
            }
        }

        return $ids;
    }

    /**
     *
     */
    private function getBindingTypeIdByCode($code)
    {
        if ($bindingType = BindingType::whereCode($code)->first()) {
            return $bindingType->id;
        }

        $model = BindingType::create([
            'name' => $code,
            'code' => $code,
        ]);

        return $model->id;
    }



    /**
     * Get Categories id's
     * @param $data
     * @return array
     */
    private function getCategoriesIds($data)
    {
        $ids = [];
        $categories = $this->decodeArrayValue(array_get($data, 'categories'));

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
     * Decode Two Level Array Value
     *
     * @param string $string
     * @return array|bool
     */
    private function decodeTwoLevelArrayValue($string)
    {
        $data = $this->decodeArrayValue($string, self::TWO_LEVEL_DELIMETER);

        if (is_array($data) && isset($data[0], $data[1])) {
            return ['code' => $data[0], 'value' => $data[1]];
        }

        return false;
    }
















//    /**
//     * Get Properties Ids
//     */
//    private function getPropertiesIds($data)
//    {
//        $ids = [];
//        $properties = $this->decodeArrayValue(array_get($data, 'properties'));
//
//        foreach ($properties as $property) {
//
//            $property = $this->decodeArrayValue($property, '::');
//            $propertyCode = isset($property[0]) ? $property[0] : null;
//            $propertyValue = isset($property[1]) ? $property[1] : null;
//
//            if (is_null($propertyCode) && is_null($propertyValue)) {
//                continue;
//            }
//
//            if (isset($this->propertyNameCache[$propertyCode])) {
//                $id = $this->propertyNameCache[$propertyCode];
//            } else {
//                $model = ProductProperty::firstOrCreate([]);
//                $id = $this->propertyNameCache[$propertyCode] = $model->id;
//            }
//
//
////            $str = strpos($property, "::");
////
////            // $propertyCode = ;
////
////            $test1 = strstr($property, '::',true);
////
////            $propertyCode2 = substr($property, 0, stristr($property, '::'));
////
////
////            $propertyValue = '';
//
//
////            $property = $this->decodeArrayValue($property, '::');
////
////            $propertyCode = isset($property[0]) ? $property[0] : null;
////            $propertyValue = isset($property[1]) ? $property[1] : null;
////
////            if (is_null($propertyCode) && is_null($propertyValue)) {
////                continue;
////            }
////
////            if (isset($this->propertyNameCache[$propertyCode])) {
////                $id = $this->propertyNameCache[$propertyCode];
////            } else {
////                $model = ProductProperty::firstOrCreate([
////                    'name' => $propertyCode,
////                    'code' => $propertyCode
////                ]);
////                $id = $this->propertyNameCache[$propertyCode] = $model->id;
////            }
////
////            $ids[$id] = [ 'property_value_id' =>
////                    $this->getProductPropertyValueId($propertyCode, $propertyValue)
////            ];
//        }
//
//        return $ids;
//    }
//
//    /**
//     * Get ProductPropertyValue by code
//     * @return int
//     */
//    private function getProductPropertyValueId($propertyId, $value)
//    {
//        if (isset($this->propertyValueCache[$propertyId][$value])) {
//            return $this->propertyValueCache[$propertyId][$value];
//        } else {
//            $model = ProductProperty::firstOrCreate([
//                'product_property_id' => $propertyId,
//                'value' => $value
//            ]);
//            return $this->propertyValueCache[$propertyId][$value] = $model->id;
//        }
//    }
}