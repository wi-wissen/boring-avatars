<?php

namespace BoringAvatars;

include_once './Avatar.php';

class AvatarRing extends Avatar
{
    const SIZE = 90;
    const COLORS = 5;

    protected static function generateColors($name, $colors) {
        $numFromName = self::hashCode($name);
        $range = count($colors);
        $colorsShuffle = array_map(function($i) use ($numFromName, $colors, $range) {
          return self::getRandomColor($numFromName + $i, $colors, $range);
        }, range(0, self::COLORS - 1));
        $colorsList = [];
        $colorsList[0] = $colorsShuffle[0];
        $colorsList[1] = $colorsShuffle[1];
        $colorsList[2] = $colorsShuffle[1];
        $colorsList[3] = $colorsShuffle[2];
        $colorsList[4] = $colorsShuffle[2];
        $colorsList[5] = $colorsShuffle[3];
        $colorsList[6] = $colorsShuffle[3];
        $colorsList[7] = $colorsShuffle[0];
        $colorsList[8] = $colorsShuffle[4];
      
        return $colorsList;
    }


    public static function make($props) {
        $ringColors = self::generateColors($props['name'], $props['colors']);

        $svg = '';

        $svg .= '<svg viewBox="0 0 ' . self::SIZE . ' ' . self::SIZE . '" fill="none" role="img" xmlns="http://www.w3.org/2000/svg" width="' . $props['size'] . '" height="' . $props['size'] . '">';
        if ($props['title']) {
            $svg .= '<title>' . $props['name'] . '</title>';
        }
        $svg .= '<mask id="mask__ring" maskUnits="userSpaceOnUse" x="0" y="0" width="' . self::SIZE . '" height="' . self::SIZE . '">';
        $svg .= '<rect width="' . self::SIZE . '" height="' . self::SIZE . '"';
        if (!$props['square']) {
            $svg .= ' rx="' . self::SIZE * 2 . '"';
        }
        $svg .= ' fill="#FFFFFF" />';
        $svg .= '</mask>';
        $svg .= '<g mask="url(#mask__ring)">';
        $svg .= '<path d="M0 0h90v45H0z" fill="' . $ringColors[0] . '" />';
        $svg .= '<path d="M0 45h90v45H0z" fill="' . $ringColors[1] . '" />';
        $svg .= '<path d="M83 45a38 38 0 00-76 0h76z" fill="' . $ringColors[2] . '" />';
        $svg .= '<path d="M83 45a38 38 0 01-76 0h76z" fill="' . $ringColors[3] . '" />';
        $svg .= '<path d="M77 45a32 32 0 10-64 0h64z" fill="' . $ringColors[4] . '" />';
        $svg .= '<path d="M77 45a32 32 0 11-64 0h64z" fill="' . $ringColors[5] . '" />';
        $svg .= '<path d="M71 45a26 26 0 00-52 0h52z" fill="' . $ringColors[6] . '" />';
        $svg .= '<path d="M71 45a26 26 0 01-52 0h52z" fill="' . $ringColors[7] . '" />';
        $svg .= '<circle cx="45" cy="45" r="23" fill="' . $ringColors[8] . '" />';
        $svg .= '</g>';
        $svg .= '</svg>';
    
        return $svg;
    } 
}