<?php

namespace Lsf\UniqueUid\Tests;

use Lsf\UniqueUid\UniqueUid;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{

    public function setUp(): void
    {
        $this->userId = new UniqueUid();
    }

    public function testOne()
    {
        $id = $this->userId::getUniqueAlphanumeric();
        $valid =$this->userId::isValidUniqueId($id);
        $this->assertEquals(true,$valid);
    }

    public function testTest()
    {
        $number = 1000;
        while ($number >= 0) {
            $number--;
            $this->testOne();
        }
    }

    public function testValidCharacters()
    {
        $this->assertEquals('2346789BCDFGHJKMPQRTVWXY', $this->userId::$charSet);
    }
}
