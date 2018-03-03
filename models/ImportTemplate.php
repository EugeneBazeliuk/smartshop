<?php namespace Smartshop\Catalog\Models;

use Model;
use ApplicationException;

/**
 * ImportTemplate Model
 *
 * @property \System\Models\File $file
 *
 * @method \October\Rain\Database\Relations\AttachOne file
 *
 * @mixin \Eloquent
 */
class ImportTemplate extends Model
{
    use \October\Rain\Database\Traits\Validation;

    const FIRST_LEVEL_DELIMETER = '|';
    const SECOND_LEVEL_DELIMETER = '::';

    /**
     * @var string The database table used by the model.
     */
    public $table = 'smartshop_import_templates';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'name',
        'mapping',
        'description',
    ];

    /**
     * @var array Json fields
     */
    protected $jsonable  = ['mapping'];

    /**
     * @var array Relations AttachOne
     */
    public $attachOne = [
        'file' => ['System\Models\File']
    ];

    /**
     * Validation
     */
    public $rules = [
        'name' => 'required|between:1,255',
        'file' => 'required',
        'mapping' => 'required',
    ];

    //
    // Options
    //
    public function getMappingDataTableOptions($value, $data)
    {
        $t = 1;
    }


    //
    //
    //

    /**
     * @param \System\Models\File $file
     *
     * @return array
     * @throws \ApplicationException
     */
    public function getFileMapping($file)
    {
        $mapping = [];

        foreach ($this->getFileFirstRow($file) as $key => $val)
        {
            $mapping[] = [
                'file_column' => $key,
                'file_value' => $val,
                'db_column' => '',
            ];
        }

        return $mapping;
    }

    /**
     * @param \System\Models\File $file
     *
     * @return array
     * @throws \ApplicationException
     */
    public function getFileData($file)
    {
        $data = [];
        $content = $this->getFileContent($file);

        for ($i = 0; $i < $content->count(); $i++) {
            foreach ($content->children()[$i] as $k => $v) {
                $data[$i][$k] = trim((string) $v);
            }
        }

        return $data;
    }


    /**
     * Get file first children row
     * @param $file
     *
     * @return array
     * @throws \ApplicationException
     */
    private function getFileFirstRow($file)
    {
        $data = [];
        $content = $this->getFileContent($file);

        if ($content->count()) {
            foreach ($content->children()[0] as $key => $val) {
                $data[$key] = trim((string) $val);
            }
        }

        return $data;
    }

    /**
     * Get file content
     *
     * @param \System\Models\File $file
     *
     * @return \SimpleXMLElement
     * @throws \ApplicationException
     */
    private function getFileContent($file)
    {
        if (!$file instanceof \System\Models\File) {
            throw new ApplicationException('Wrong file object');
        }

        return @simplexml_load_file($file->getLocalPath(), 'SimpleXMLElement', LIBXML_COMPACT);
    }
}