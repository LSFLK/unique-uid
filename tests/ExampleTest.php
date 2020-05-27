<?php

namespace Lsflk\UniqueUid\Tests;

use Lsflk\UniqueUid\UniqueUid;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{

    public function setUp(): void
    {
        $this->userId = new UniqueUid();
    }
   
    public function testOne()
    {
        $users = 'users.txt';
        $id = $this->userId::getUniqueAlphanumeric(8);
        if(!file_exists($users)) fopen($users,'w');
        $file = file_get_contents($users);
        $text =  $id . "\n";
        $users = fopen($users, 'a+');
        $this->assertEquals(true, (strpos($file, $id) == false));
        if (strpos($file, $id)) {
            echo 'duplicated';
        } else {
            fwrite($users, $text);
            //                 echo $id . ' '. "\n";
        }
    }

    public function testTest()
    {
        $number = 10;
        while ($number >= 0) {
            $number--;
            $this->testOne();
        }
    }

    public function testValid()
    {
        $valid = $this->userId::isValidUniqueId('3KM-7DT-MB1', 4);
        $valid2 = $this->userId::isValidUniqueId('YMG-RYC-XF7');
        $this->assertEquals(false, $valid);
        $this->assertEquals(true, $valid2);
    }

    public function testValidCharacters()
    {
        $this->assertEquals('2346789BCDFGHJKMPQRTVWXY',$this->userId::$charSet);
    }
}
