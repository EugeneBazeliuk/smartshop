<?php namespace Smartshop\Catalog\Models;

use Exception;
use Backend\Models\ImportModel;

/**
 * ProductImport Model
 */
class ProductImport extends ImportModel
{
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
                    'publisher',
                    'publisher_set',
                    'categories',
                    'properties',
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