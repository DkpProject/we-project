<?php

namespace App\Helpers;


class TextToImage
{
    public static function convert(String $text) {
        $image = imagecreatetruecolor(280, 35);
        $transparent = imagecolorallocatealpha($image, 0, 0, 0, 127);
        imagefill($image, 0, 0, $transparent);
        imagesavealpha($image, true);
        imageantialias($image,0);
        $white = imagecolorallocate($image, 0, 0, 0);
        putenv('GDFONTPATH=' . realpath('./fonts')); // Для линукса
        $font_path = public_path('fonts\HelveticaNeue.ttf'); //Для Винды
        imagettftext($image, 25, 0, 10, 26, $white, $font_path, $text);
        ob_start();
        imagepng($image);
        $contents =  ob_get_contents();
        ob_end_clean();
        $base64 = 'data:image/png;base64,' . base64_encode($contents);
        return "<img src='".$base64."' height='15px'>";

        imagedestroy($image);
    }
}