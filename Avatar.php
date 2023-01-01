<?php

namespace BoringAvatars;

class Avatar
{
    protected static function charCodeAt($string, $offset) {
        $string = mb_substr($string, $offset, 1);
        list(, $ret) = unpack('S', mb_convert_encoding($string, 'UTF-16LE'));
        return $ret;
    }

    protected static function hashCode($name) {
        $hash = 0;
        for ($i = 0; $i < strlen($name); $i++) {
            $character = self::charCodeAt($name, $i);
            $hash = (($hash<<5)-$hash)+$character;
            $hash = $hash & $hash; // Convert to 32bit integer
        }
        return abs($hash);
    }

    protected static function getModulus($num, $max) {
        return $num % $max;
    }

    protected static function getDigit($number, $ntn) {
        return floor(( $number/ pow(10, $ntn)) % 10);
    }

    protected static function getBoolean($number, $ntn) {
        return (!((self::getDigit($number, $ntn)) % 2));
    }

    protected static function getAngle($x, $y) {
        return atan2($y, $x) * 180 / pi();
    }

    protected static function getUnit($number, $range, $index = 0) {
        $value = $number % $range;

        if($index && ((self::getDigit($number, $index) % 2) === 0)) {
            return $value * -1;
        } 
        else {
            return $value;
        }
    }

    protected static function getRandomColor($number, $colors, $range) {
        return $colors[($number) % $range];
    }

    protected static function getContrast($hexcolor) {

        // If a leading # is provided, remove it
        if (substr($hexcolor, 0, 1) === '#') {
            $hexcolor = substr($hexcolor, 1);
        }

        // Convert to RGB value
        $r = hexdec(substr($hexcolor, 0, 2));
        $g = hexdec(substr($hexcolor, 2, 2));
        $b = hexdec(substr($hexcolor, 4, 2));

        // Get YIQ ratio
        $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;

        // Check contrast
        return ($yiq >= 128) ? '#000000' : '#FFFFFF';
    }
}
