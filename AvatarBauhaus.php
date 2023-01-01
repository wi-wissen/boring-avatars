<?php

namespace BoringAvatars;

include_once './Avatar.php';

class AvatarBauhaus extends Avatar
{
    public const ELEMENTS = 4;
    public const SIZE = 80;

    public static function generateColors($name, $colors)
    {
        $numFromName = self::hashCode($name);
        $range = count($colors);

        $elementsProperties = array_fill(0, self::ELEMENTS, []);
        for ($i = 0; $i < self::ELEMENTS; $i++) {
            $elementsProperties[$i]['color'] = self::getRandomColor($numFromName + $i, $colors, $range);
            $elementsProperties[$i]['translateX'] = self::getUnit($numFromName * ($i + 1), self::SIZE / 2 - ($i + 17), 1);
            $elementsProperties[$i]['translateY'] = self::getUnit($numFromName * ($i + 1), self::SIZE / 2 - ($i + 17), 2);
            $elementsProperties[$i]['rotate'] = self::getUnit($numFromName * ($i + 1), 360);
            $elementsProperties[$i]['isSquare'] = self::getBoolean($numFromName, 2);
        }

        return $elementsProperties;
    }

    public static function make($props)
    {
        $properties = self::generateColors($props['name'], $props['colors']);

        $svg = '';

        $svg .= '<svg';
        $svg .= " viewBox='0 0 ".self::SIZE." ".self::SIZE."'";
        $svg .= ' fill="none"';
        $svg .= ' role="img"';
        $svg .= ' xmlns="http://www.w3.org/2000/svg"';
        $svg .= " width='".$props['size']."'";
        $svg .= " height='".$props['size']."'";
        $svg .= '>';
        if ($props['title']) {
            $svg .= "<title>".$props['name']."</title>";
        }
        $svg .= '<mask id="mask__bauhaus" maskUnits="userSpaceOnUse" x="0" y="0" width="' . self::SIZE . '" height="' . self::SIZE . '">';
        $svg .= '<rect width="' . self::SIZE . '" height="' . self::SIZE . '"';
        if (! $props['square']) {
            $svg .= ' rx="' . self::SIZE * 2 . '"';
        }
        $svg .= ' fill="#FFFFFF" />';
        $svg .= '</mask>';
        $svg .= '<g mask="url(#mask__bauhaus)">';
        $svg .= '<rect width="' . self::SIZE . '" height="' . self::SIZE . '" fill="' . $properties[0]['color'] . '" />';
        $svg .= '<rect';
        $svg .= ' x="' . ((self::SIZE - 60) / 2) . '"';
        $svg .= ' y="' . ((self::SIZE - 20) / 2) . '"';
        $svg .= ' width="' . self::SIZE . '"';
        $svg .= ' height="' . ($properties[1]['isSquare'] ? self::SIZE : self::SIZE / 8) . '"';
        $svg .= ' fill="' . $properties[1]['color'] . '"';
        $svg .= " transform='translate({$properties[1]['translateX']} {$properties[1]['translateY']}) rotate({$properties[1]['rotate']} " . self::SIZE / 2 . ' ' . self::SIZE / 2 . ")'";
        $svg .= ' />';
        $svg .= '<circle';
        $svg .= " cx='" . self::SIZE / 2 . "'";
        $svg .= " cy='" . self::SIZE / 2 . "'";
        $svg .= ' fill="' . $properties[2]['color'] . '"';
        $svg .= " r='" . self::SIZE / 5 . "'";
        $svg .= " transform='translate({$properties[2]['translateX']} {$properties[2]['translateY']})'";
        $svg .= ' />';
        $svg .= '<line';
        $svg .= ' x1="0"';
        $svg .= " y1='" . self::SIZE / 2 . "'";
        $svg .= ' x2="' . self::SIZE . '"';
        $svg .= " y2='" . self::SIZE / 2 . "'";
        $svg .= ' strokeWidth="2"';
        $svg .= ' stroke="' . $properties[3]['color'] . '"';
        $svg .= " transform='translate({$properties[3]['translateX']} {$properties[3]['translateY']}) rotate({$properties[3]['rotate']} " . self::SIZE / 2 . ' ' . self::SIZE / 2 . ")'";
        $svg .= ' />';
        $svg .= '</g>';
        $svg .= '</svg>';

        return $svg;
    }
}