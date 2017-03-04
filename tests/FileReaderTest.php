<?php

namespace Commission\Tests;

use Commission\FileReader;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class FileReaderTest extends TestCase
{
    /**
     * @var FileReader
     */
    private $fileReader;
    private $filePath = 'test_tmp/test_data.csv';

    public function setUp()
    {
        $this->fileReader = new FileReader();
        vfsStream::setup('test_tmp');

        $file = vfsStream::url($this->filePath);
        file_put_contents($file, "2016-01-05,1,natural,cash_in,200.00,EUR
2016-01-06,2,legal,cash_out,300.00,EUR
");
    }

    public function testReadFile()
    {
        $results = $this->fileReader->readFile(vfsStream::url($this->filePath));

        $this->assertTrue(is_array($results));
        $this->assertCount(2, $results);
        $this->assertCount(6, $results[0]);
    }

    public function testReadNonExistantFile()
    {
        $this->expectException(FileNotFoundException::class);
        $this->fileReader->readFile('non-existant.csv');
    }
}