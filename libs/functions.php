<?php
function changeTag($text)
{
    $bbcode = array("[strong]", "[strike]", "[italic]", "[code]", "[/strong]", "[/strike]", "[/italic]", "[/code]");
    $htmltag   = array("<strong>", "<strike>", "<i>", "<code>", "</strong>", "</strike>", "</i>", "</code>");
    $text = str_replace($bbcode, $htmltag, $text);
    $text = preg_replace_callback('/\[url=(.*)\](.*)\[\/url\]/Usi', function($match) {
        return '<a href="'.$match[1].'" target="_blank">'.(empty($match[2]) ? $match[1] : $match[2]).'</a>';
     }, $text);
     return $text;
}

function getNameResizedImage($fileImg, $filename) {
  list($width, $height, $type) = getimagesize($filename);
  $new_width = 320;
  $new_height = 240;
  $size = getimagesize($filename);
  if (($width > $new_width) || ($height > $new_height)) {
    $w_index = $new_width / $width;
    $h_index = $new_height / $height;
    $new_width = $w_index>$h_index ? $width*$h_index : $width*$w_index;
    $new_height = $w_index>$h_index ? $height*$h_index : $height*$w_index;
  }
  $new_image = imagecreatetruecolor($new_width, $new_height);
  switch ($type) {
    case 3:
        $image = imagecreatefrompng($filename);
        break;
    case 2:
        $image = imagecreatefromjpg($filename);
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
        imagepng($new_image, "upload/img/small/".$fileImg->getClientFilename());
        break;
    case 2:
        //header("Content-type: image/jpeg");
        imagejpeg($new_image, "upload/img/small/".$fileImg->getClientFilename());
        break;
    case 1:
        //header("Content-type: image/gif");
        imagegif($new_image, "upload/img/small/".$fileImg->getClientFilename());
        break;
    default:
        // error;
  }
  //unlink($filename);
}
