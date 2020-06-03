<?php

namespace Lsf\UniqueUid;

class UniqueUid
{
    static $charSet;
    static $maxCharLen;

    public function __construct()
    {
        self::$charSet = '2346789BCDFGHJKMPQRTVWXY';
        self::$maxCharLen = strlen(self::$charSet);
    }

    /**
     * set custom charset for the Unique ID
     *
     * @param string $characters
     * @return void
     */
    public function setCharSet($characters)
    {
        self::$charSet = $characters;
        $this->setCharLen($characters);
    }

    /**
     * Set charset Len
     *
     * @param string $characters
     * @return void
     */
    public function setCharLen($characters)
    {
        self::$maxCharLen = strlen($characters);
    }

    /**
     * TO the the Code Point form the Character set
     *
     * @param string $character
     * @return integer
     */
    public static function CodePointFromCharacter($character)
    {
        $characters = array_flip(str_split(self::$charSet));
        return $characters[$character];
    }

    /**
     * Get the Character set form the Code Point
     *
     * @param integer $codePoint
     * @return string
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
     * @length integer - length of expected 
     * @split integer - split range
     * @return string
     **/
    public static function getUniqueAlphanumeric(int $length = 9, int $split = 3)
    {
        $token = "";

        // adjust the check digit place
        $length = $length - 1;

        for ($i = 0; $i < $length; $i++) {
            $token .= self::$charSet[random_int(0, self::$maxCharLen - 1)];
        }

        $checkChar = self::GenerateCheckCharacter($token);
        $token .= $checkChar;
        $token  = self::format($token, $split);
        return $token;
    }

    /**
     * Format the ID with given split range
     *
     * @param string $token
     * @return integer
     */
    public  static function format(string $token, int $split)
    {
        $partitions = str_split($token, $split);
        $length = count($partitions);
        $newToken = '';
        for ($i = 0; $i < $length; $i++) {
            $newToken .= '-' . $partitions[$i];
        }
        return substr($newToken, 1, strlen($newToken));
    }

    /**
     * Check the valid ID
     *
     * @param string $token
     * @return boolean
     */
    public static function isValidUniqueId(string $token)
    {
        //remove - form the token
        $token = str_replace("-", "", $token);

        // get the length of the token
        $length = strlen($token);


        // validate the character set
        $valid = preg_match("/^[" . self::$charSet . "]/", $token);
        if (!$valid && is_numeric($token)) {
            return false;
        } else {
            //get the check character from the token
            $checkChar = str_split($token)[$length - 1];

            // remove the check digit from the token
            $token = substr($token, 0, -1);

            // get the valid check character
            $ValidCheckChar = self::GenerateCheckCharacter($token);
            return $checkChar == $ValidCheckChar;
        }
    }

    /**
     * Luhn mod N algorithm
     * @input string $token
     * @return string
     **/
    public static function GenerateCheckCharacter(string $token)
    {
        $length = strlen($token) - 1;
        $factor = 2;
        $total_sum = 0;
        $n = self::NumberOfValidCharacters();

        // Starting from the right and working leftwards is easier since
        // the initial "factor" will always be "2".
        for ($i = ($length); $i >= 0; --$i) {
            $codePoint = self::codePointFromCharacter($token[$i]);
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
}
