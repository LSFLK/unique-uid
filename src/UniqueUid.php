<?php

namespace Lsflk\UniqueUid;

class UniqueUid
{
    static $charSet;

    public function __construct()
    {
        self::$charSet = '2346789BCDFGHJKMPQRTVWXY';
    }

    /**
     * set custom charset for the Unique ID
     *
     * @param [type] $characters
     * @return void
     */
    public function setCharSet($characters){
        self::$charSet = $characters;
    }

    /**
     * TO the the Code Point form the Character set
     *
     * @param [type] $character
     * @return void
     */
    public static function CodePointFromCharacter($character)
    {
        $characters = array_flip(str_split(self::$charSet));
        return $characters[$character];
    }

    /**
     * Get the Character set form the Code Point
     *
     * @param [type] $codePoint
     * @return void
     */
    public static function CharacterFromCodePoint($codePoint)
    {
        $characters = str_split(self::$charSet);
        return $characters[$codePoint];
    }

    /**
     * Get the number of Valid characters for Check digit
     *
     * @return void
     */
    public static function NumberOfValidCharacters()
    {
        return strlen(self::$charSet);
    }

    /**
     * This function will pass values to random generator.
     * Our function has 1 digit to 25 options
     * @input number - length of expected MoeUuid
     * @return string
     **/
    public static function getUniqueAlphanumeric($length = 9, $split = 3)
    {
        $token = "";
        $max = self::NumberOfValidCharacters(); // edited

        for ($i = 0; $i < $length; $i++) {
            $token .= self::$charSet[random_int(0, $max - 1)];
        }

        $checkDigit = self::GenerateCheckCharacter($token);
        $token .= $checkDigit;
        $token  = self::format($token, $split);
        return $token;
    }

    /**
     * Format the ID with given split range
     *
     * @param [type] $token
     * @param [type] $split
     * @return void
     */
    public  static function format($token, $split)
    {
        $partitions =  str_split($token, $split);
        $newToken = '';
        for ($i = 0; $i < count($partitions); $i++) {
            $newToken .= '-' . $partitions[$i];
        }
        return substr($newToken, 1, strlen($newToken));
    }

    /**
     * Check the valid ID
     *
     * @param [type] $unique
     * @param integer $type
     * @return boolean
     */
    public static function isValidUniqueId($token)
    {
        $token = str_replace("-", "", $token);

        if (preg_match("/[^".self::$charSet."]/", $token)) {
            return false;
        } else {
            return self::ValidateCheckCharacter($token);
        }
    }

    /**
     * Luhn mod N algorithm
     * @input string
     * @return string
     **/
    public static function GenerateCheckCharacter($checkNumber)
    {
        $length = strlen($checkNumber) - 1;
        $factor = 2;
        $total_sum = 0;
        $n = self::NumberOfValidCharacters();

        // Starting from the right and working leftwards is easier since
        // the initial "factor" will always be "2".
        for ($i = ($length); $i >= 0; --$i) {
            $codePoint = self::codePointFromCharacter($checkNumber[$i]);
            $added = $factor * $codePoint;

            // Alternate the "factor" that each "codePoint" is multiplied by
            $factor = ($factor == 2) ? 1 : 2;

            // Sum the digits of the "addend" as expressed in base "n"
            $added = ($added / $n) + ($added % $n);
            $total_sum += $added;
        }

        // Calculate the number that must be added to the "sum"
        // to make it divisible by "n".
        $reminder = $total_sum % $n;
        $checkCodePoint  = ($n - $reminder) % $n;
        return  self::CharacterFromCodePoint($checkCodePoint);
    }

    /**
     * Validate Luhn mod N algorithm
     *
     * @param [type] $checkNumber
     * @return void
     */
    public static function ValidateCheckCharacter($checkNumber)
    {
        $factor = 1;
        $total_sum = 0;
        $n = self::NumberOfValidCharacters();
        $length = strlen($checkNumber) - 1;

        // Starting from the right and working leftwards is easier since
        // the initial "factor" will always be "2".
        for ($i = $length; $i >= 0; --$i) {
            $codePoint = self::codePointFromCharacter($checkNumber[$i]);
            $added = $factor * $codePoint;

            // Alternate the "factor" that each "codePoint" is multiplied by
            $factor = ($factor == 2) ? 1 : 2;

            // Sum the digits of the "addend" as expressed in base "n"
            $added = ($added / $n) + ($added % $n);
            $total_sum += $added;
        }

        // Calculate the number that must be added to the "sum"
        // to make it divisible by "n".
        $reminder = $total_sum % $n;

        return ($reminder == 0);
    }
}
