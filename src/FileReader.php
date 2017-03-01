<?php

namespace Commission;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;

/**
 * Class FileReader
 *
 * @package Commission
 */
class FileReader
{
    /**
     * @param $path
     * @param $csvLength
     * @param $csvDelimiter
     * @return array
     */
    public function readFile($path, $csvLength = 1000, $csvDelimiter = ',')
    {
        if (file_exists($path) == false) {
            throw new FileNotFoundException;
        }

        $fileArray = [];
        $fileResource = fopen($path, "r");
        while (($line = fgetcsv($fileResource, $csvLength, $csvDelimiter)) !== false) {
            $fileArray[] = $line;
        }

        fclose($fileResource);

        return $fileArray;
    }
}