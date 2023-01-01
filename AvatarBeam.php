<?php

namespace BoringAvatars;

include_once './Avatar.php';

class AvatarBeam extends Avatar
{
    const SIZE = 36;

    protected static function generateData($name, $colors) {
        $numFromName = self::hashCode($name);
        $range = count($colors);
        $wrapperColor = self::getRandomColor($numFromName, $colors, $range);
        $preTranslateX = self::getUnit($numFromName, 10, 1);
        $wrapperTranslateX = $preTranslateX < 5 ? $preTranslateX + self::SIZE / 9 : $preTranslateX;
        $preTranslateY = self::getUnit($numFromName, 10, 2);
        $wrapperTranslateY = $preTranslateY < 5 ? $preTranslateY + self::SIZE / 9 : $preTranslateY;

        $data = [
            'wrapperColor' => $wrapperColor,
            'faceColor' => self::getContrast($wrapperColor),
            'backgroundColor' => self::getRandomColor($numFromName + 13, $colors, $range),
            'wrapperTranslateX' => $wrapperTranslateX,
            'wrapperTranslateY' => $wrapperTranslateY,
            'wrapperRotate' => self::getUnit($numFromName, 360),
            'wrapperScale' => 1 + self::getUnit($numFromName, self::SIZE / 12) / 10,
            'isMouthOpen' => self::getBoolean($numFromName, 2),
            'isCircle' => self::getBoolean($numFromName, 1),
            'eyeSpread' => self::getUnit($numFromName, 5),
            'mouthSpread' => self::getUnit($numFromName, 3),
            'faceRotate' => self::getUnit($numFromName, 10, 3),
            'faceTranslateX' =>
            $wrapperTranslateX > self::SIZE / 6 ? $wrapperTranslateX / 2 : self::getUnit($numFromName, 8, 1),
            'faceTranslateY' =>
            $wrapperTranslateY > self::SIZE / 6 ? $wrapperTranslateY / 2 : self::getUnit($numFromName, 7, 2),
        ];

        return $data;
    }

    public static function make($props) {
        $data = self::generateData($props['name'], $props['colors']);
    
        return "
            <svg
                viewBox='0 0 ".self::SIZE." ".self::SIZE."'
                fill='none'
                role='img'
                xmlns='http://www.w3.org/2000/svg'
                width='".$props['size']."'
                height='".$props['size']."'
            >
                ".($props['title'] ? "<title>".$props['name']."</title>" : "")."
                <mask id='mask__beam' maskUnits='userSpaceOnUse' x='0' y='0' width='".self::SIZE."' height='".self::SIZE."'>
                <rect width='".self::SIZE."' height='".self::SIZE."' rx='".($props['square'] ? "" : self::SIZE*2)."' fill='#FFFFFF' />
                </mask>
                <g mask='url(#mask__beam)'>
                <rect width='".self::SIZE."' height='".self::SIZE."' fill='".$data['backgroundColor']."' />
                <rect
                    x='0'
                    y='0'
                    width='".self::SIZE."'
                    height='".self::SIZE."'
                    transform='
                    translate(".$data['wrapperTranslateX']." ".$data['wrapperTranslateY'].")
                    rotate(".$data['wrapperRotate']." ".(self::SIZE/2)." ".(self::SIZE/2).")
                    scale(".$data['wrapperScale'].")
                    '
                    fill='".$data['wrapperColor']."'
                    rx='".($data['isCircle'] ? self::SIZE : self::SIZE/6)."'
                />
                <g
                    transform='
                    translate(".$data['faceTranslateX']." ".$data['faceTranslateY'].")
                    rotate(".$data['faceRotate']." ".(self::SIZE/2)." ".(self::SIZE/2).")
                    '
                >
                    ".($data['isMouthOpen'] ? "
                    <path
                        d='M15 ".(19+$data['mouthSpread'])."c2 1 4 1 6 0'
                        stroke='".$data['faceColor']."'
                        fill='none'
                        strokeLinecap='round'
                    />
                    " : "
                    <path
                        d='M13,".(19+$data['mouthSpread'])." a1,0.75 0 0,0 10,0'
                        fill='".$data['faceColor']."'
                    />
                    ")."
                    <rect
                    x='".(14-$data['eyeSpread'])."'
                    y='14'
                    width='1.5'
                    height='2'
                    rx='1'
                    stroke='none'
                    fill='".$data['faceColor']."'
                    />
                    <rect
                    x='".(20+$data['eyeSpread'])."'
                    y='14'
                    width='1.5'
                    height='2'
                    rx='1'
                    stroke='none'
                    fill='".$data['faceColor']."'
                    />
                    </g>
                    </g>
                </svg>";
    } 
}