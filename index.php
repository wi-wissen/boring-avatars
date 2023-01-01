<?php

namespace BoringAvatars;

include_once './AvatarBauhaus.php';
include_once './AvatarBeam.php';
include_once './AvatarMarble.php';
include_once './AvatarRing.php';
include_once './AvatarText.php';

function getParam($key, $default = null) {
    if(array_key_exists($key, $_GET)) {
        $param = htmlspecialchars($_GET[$key]);

        if($param === 'false') {
            return false;
        }
        else if ($param === 'true') {
            return true;
        }
        else {
            return $param;
        }
    }
    else {
        return $default;
    }
}
    
$variant = getParam('variant', null);

$avatarProps = [
    'colors' => explode( ',', getParam('colors','#ffad08,#edd75a,#73b06f,#0c8f8f,#405059') ),
    'name' => getParam('name', null),
    'title' => getParam('title', true),
    'size' => getParam('size', 120),
    'square' => getParam('square', false)
];

if ($avatarProps['name']) {
    header('Content-Type: image/svg+xml');

    switch ($variant) {
        case "bauhaus":
            echo AvatarBauhaus::make($avatarProps);
            break;
        case "beam":
            echo AvatarBeam::make($avatarProps);
            break;
        case "marble":
            echo AvatarMarble::make($avatarProps);
            break;
        case "ring":
            echo AvatarRing::make($avatarProps);
            break;
        case "text":
            echo AvatarText::make($avatarProps);
            break;
        default:
            echo AvatarText::make($avatarProps);
    }
}
else {
    //landing page
    header('Content-Type: html');
    $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <title>Boring Avatars</title>
            <link rel="icon" type="image/svg+xml" href="'.$baseUrl.'?variant=beam&name=Jane Doe" sizes="any">
            <style>
                html, body {margin: 0; padding: 0;}
                body {
                    min-height: 100vh;
                    display: flex;
                    justify-content: center; /* align item horizontally */
                    align-items: center; /* align item vertically */
                    font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"
                }
                main {
                    display: flex;
                    flex-direction: column;
                    align-items: center; /* align item vertically */   
                    text-align: center;
                }
                p {
                    margin: 0.4em 0;
                }
            </style>
        </head>
            <body>
                <main>
                    <a href="'.$baseUrl.'?variant=beam&name=Jane Doe">'.AvatarBeam::make(array_merge($avatarProps, ['name' => 'Jane Doe'])).'</a>
                    <h1>Boring Avatars</h1>
                    <p>PHP implementation of <a href="https://boringavatars.com/">Boring Avatars</a>.</p>
                    <p style=\'font-family:SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace\'>
                        '.$baseUrl
                        .'?variant={bauhaus|beam|marble|ring|text}&name=Jane Doe&size=120&colors=#ffad08,#edd75a,#73b06f,#0c8f8f,#405059&title=true&square=false
                    </p>
                </main>
            </body>
        </html>
    ';
}