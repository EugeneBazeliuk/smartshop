<?php namespace SmartShop\Classes\Import;

use ApplicationException;

abstract class ImportProvider
{

    public function __construct()
    {

    }

    public static function getInstance($file)
    {
        if (!$file instanceof \System\Models\File) {
            throw new ApplicationException('Wrong file object');
        }

        switch ($extension = $file->getExtension())
        {
            case 'xml':
                break;
            default:
                throw new ApplicationException('Unsupported file format');
        }
    }

    abstract public function loadFileContent($path);

    abstract public function getFileMapping();

    abstract public function getFileRow();

    abstract public function getFileData();
}