<?php

namespace Lsf\UniqueUid\Tests;

use TypeError;
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

    public function testInvalid(){
        $valid =$this->userId::isValidUniqueId('CYJ-DGQ-331');
        $this->assertEquals(false,$valid);
        $valid2 =$this->userId::isValidUniqueId('7K3-7M8-CR5');
        $this->assertEquals(false,$valid2);
        $valid3 =$this->userId::isValidUniqueId('DTT-8JD-3YW',9);
        $this->assertEquals(false,$valid3);
        $valid4 = $this->userId::isValidUniqueId('996-993-882');
        $this->assertEquals(false,$valid4);
        $valid5 = $this->userId::isValidUniqueId('1562083974');
        $this->assertEquals(false,$valid5);
        $valid6 = $this->userId::isValidUniqueId('A0401157841844');
        $this->assertEquals(false,$valid6);
        $valid6 = $this->userId::isValidUniqueId('B0216157494076');
        $this->assertEquals(false,$valid6);
        $valid7 = $this->userId::isValidUniqueId('45464565');
        $this->assertEquals(false,$valid7);
        $valid7 = $this->userId::isValidUniqueId('FCV-Y7P-YD2-M',9);
        $this->assertEquals(false,$valid7);
    }

    public function testArrayInput() {
        $this->expectException(TypeError::class);
        $this->userId::isValidUniqueId([]);
    }

    public function testValidCharacters()
    {
        $this->assertEquals('2346789BCDFGHJKMPQRTVWXY', $this->userId::$charSet);
    }
}
