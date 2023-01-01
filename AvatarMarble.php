<?php

namespace BoringAvatars;

include_once './Avatar.php';

class AvatarMarble extends Avatar
{
    const ELEMENTS = 3;
    const SIZE = 80;

    protected static function generateColors($name, $colors) {
        $numFromName = self::hashCode($name);
        $range = count($colors);
      
        $elementsProperties = array_fill(0, self::ELEMENTS, []);
        for ($i = 0; $i < self::ELEMENTS; $i++) {
            $elementsProperties[$i]['color'] = self::getRandomColor($numFromName + $i, $colors, $range);
            $elementsProperties[$i]['translateX'] = self::getUnit($numFromName * ($i + 1), self::SIZE / 10, 1);
            $elementsProperties[$i]['translateY'] = self::getUnit($numFromName * ($i + 1), self::SIZE / 10, 2);
            $elementsProperties[$i]['scale'] = 1.2 + self::getUnit($numFromName * ($i + 1), self::SIZE / 20) / 10;
            $elementsProperties[$i]['rotate'] = self::getUnit($numFromName * ($i + 1), 360, 1);
        }
      
        return $elementsProperties;
    }

    public static function make($props) {
        $properties = self::generateColors($props['name'], $props['colors']);
    
        $svg = '';

        $svg .= '<svg viewBox="0 0 '.self::SIZE.' '.self::SIZE.'" fill="none" role="img" xmlns="http://www.w3.org/2000/svg" width="'.$props['size'].'" height="'.$props['size'].'">';
        if ($props['title']) {
            $svg .= '<title>'.$props['name'].'</title>';
        }
        $svg .= '<mask id="mask__marble" maskUnits="userSpaceOnUse" x="0" y="0" width="'.self::SIZE.'" height="'.self::SIZE.'">';
        $svg .= '<rect width="'.self::SIZE.'" height="'.self::SIZE.'" '.($props['square'] ? '' : 'rx="'.(self::SIZE * 2).'"').' fill="#FFFFFF" />';
        $svg .= '</mask>';
        $svg .= '<g mask="url(#mask__marble)">';
        $svg .= '<rect width="'.self::SIZE.'" height="'.self::SIZE.'" fill="'.$properties[0]['color'].'" />';
        $svg .= '<path filter="url(#prefix__filter0_f)" d="M32.414 59.35L50.376 70.5H72.5v-71H33.728L26.5 13.381l19.057 27.08L32.414 59.35z" fill="'.$properties[1]['color'].'" transform="translate('.$properties[1]['translateX'].' '.$properties[1]['translateY'].') rotate('.$properties[1]['rotate'].' '.(self::SIZE/2).' '.(self::SIZE/2).') scale('.$properties[2]['scale'].')" />';
        $svg .= '<path filter="url(#prefix__filter0_f)" style="mixBlendMode:overlay" d="M22.216 24L0 46.75l14.108 38.129L78 86l-3.081-59.276-22.378 4.005 12.972 20.186-23.35 27.395L22.215 24z" fill="'.$properties[2]['color'].'" transform="translate('.$properties[2]['translateX'].' '.$properties[2]['translateY'].') rotate('.$properties[2]['rotate'].' '.(self::SIZE/2).' '.(self::SIZE/2).') scale('.$properties[2]['scale'].')" />';
        $svg .= '</g>';
        $svg .= '<defs>';
        $svg .= '<filter id="prefix__filter0_f" filterUnits="userSpaceOnUse" colorInterpolationFilters="sRGB">';
        $svg .= '<feFlood floodOpacity="0" result="BackgroundImageFix" />';
        $svg .= '<feBlend in="SourceGraphic" in2="BackgroundImageFix" result="shape" />';
        $svg .= '<feGaussianBlur stdDeviation="7" result="effect1_foregroundBlur" />';
        $svg .= '</filter>';
        $svg .= '</defs>';
        $svg .= '</svg>';

        return $svg;
    } 
}