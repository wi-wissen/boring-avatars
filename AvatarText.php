<?php

namespace BoringAvatars;

include_once './Avatar.php';

class AvatarText extends Avatar
{
    const SIZE = 64;
    const LENGTH = 3;

    protected static function generateData($name, $colors) {

        $data = [];

        if (strlen($name) > self::LENGTH) {
            $nameArr = explode(" ", $name);
            $data['initials'] = substr($name, 0, 1);
            if (count($nameArr) > 1) {
                $data['initials'] .= substr(end($nameArr), 0, 1);
            }
        }
        else {
            $data['initials'] = $name;
        }

        $data['bg'] = $colors[0];
        $data['text'] = $colors[1];

        return $data;
    }


    public static function make($props) {
        $data = self::generateData($props['name'], $props['colors']);

        return "
            <svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='" . $props['size'] . "' height='" . $props['size'] . "' viewBox='0 0 " . self::SIZE . " " . self::SIZE . "' version='1.1' >
                " . ( ($props['title']) ? '<title>' . $props['name'] . '</title>' : '' ) . "
                <rect fill='".$data['bg']."' width='" . self::SIZE . "' height='" . self::SIZE . "' " . ( ($props['square']) ? '' : ' rx="' . self::SIZE * 2 . '"' ) . "/>
                <text x='50%' y='50%' style='color: ".$data['text']."; line-height: 1;font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", \"Roboto\", \"Oxygen\", \"Ubuntu\", \"Fira Sans\", \"Droid Sans\", \"Helvetica Neue\", sans-serif;' alignment-baseline='middle' text-anchor='middle' font-size='28' font-weight='400' dy='.1em' dominant-baseline='middle' fill='".$data['text']."'>
                    " . $data['initials'] . "
                </text>
            </svg>";
    } 
}