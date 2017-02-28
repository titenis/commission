<?php

namespace Commission;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class FileReader
{
    /**
     * @var \Commission\PaymentCreator
     */
    private $PaymentCreator;

    /**
     * FileReader constructor.
     *
     * @param \Commission\PaymentCreator $PaymentCreator
     */
    public function __construct(PaymentCreator $PaymentCreator)
    {
        $this->PaymentCreator = $PaymentCreator;
    }

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