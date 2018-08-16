<?php
function changeTags($text)
{
    $bbcode = array("[strong]", "[strike]", "[italic]", "[code]", "[/strong]", "[/strike]", "[/italic]", "[/code]");
    $htmltag   = array("<strong>", "<strike>", "<i>", "<code>", "</strong>", "</strike>", "</i>", "</code>");
    $text = str_replace($bbcode, $htmltag, $text);
    $text = preg_replace_callback('/\[url=(.*)\](.*)\[\/url\]/Usi', function($match) {
        return '<a href="'.$match[1].'" target="_blank">'.(empty($match[2]) ? $match[1] : $match[2]).'</a>';
     }, $text);
     return $text;
}

function resizeAndMoveImage($fileImg, $filename, $path, $max_width, $max_height)
{
    list($width, $height, $type) = getimagesize($filename);
    $size = getimagesize($filename);
    if (($width > $max_width) || ($height > $max_height)) {
        $w_index = $max_width / $width;
        $h_index = $max_height / $height;
        $new_width = $w_index>$h_index ? $width*$h_index : $width*$w_index;
        $new_height = $w_index>$h_index ? $height*$h_index : $height*$w_index;
    } else {
        $new_width = $width;
        $new_height = $height;
    }
    $new_image = imagecreatetruecolor($new_width, $new_height);
    switch ($type) {
        case 3:
            $image = imagecreatefrompng($filename);
            break;
        case 2:
            $image = imagecreatefromjpeg($filename);
            break;
        case 1:
            $image = imagecreatefromgif($filename);
            break;
        default:
            // 'error';
    }
    imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    switch ($type) {
        case 3:
            //header("Content-type: image/png");
            imagepng($new_image, $path.$fileImg->getClientFilename());
            break;
        case 2:
            //header("Content-type: image/jpeg");
            imagejpeg($new_image, $path.$fileImg->getClientFilename());
            break;
        case 1:
            //header("Content-type: image/gif");
            imagegif($new_image, $path.$fileImg->getClientFilename());
            break;
        default:
            // error;
    }
}
