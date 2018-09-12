<?php
namespace Pi\Guestbook\App;

use Pi\Guestbook\App\IndexController;
use Zend\Diactoros\Response;

class AppKernel
{
    public $response;

    public function handle($request)
    {
        $init = new IndexController();
        $params = require_once('config/env.php');

        $get = $request->getQueryParams();
        $post = $request->getParsedBody();
        $server = $request->getServerParams();
        $files = $request->getUploadedFiles();

        $sort = 'date_desc';
        $added = 'not';

        if (isset($post['send'])) {
          //validate captcha
            $response = $post["g-recaptcha-response"];
            $added = 'no';
            if (!empty($response)) {
                $url = CAPTCHA_URL."?secret=".CAPTCHA_SECRET."&response=".$response."&remoteip=".$server['REMOTE_ADDR'];
                $rsp = file_get_contents($url);
                $arr = json_decode($rsp, TRUE);
                if($arr['success']) {
                    $post['ip']  = $server['REMOTE_ADDR'];
                    $post['browser'] = $server['HTTP_USER_AGENT'];
                    $post['date'] = date("Y-m-d H:i:s");
                    // обработка текста сообщения
                    $post['text'] = $this->changeTags($post['text']);
                    // обработка изображения
                    if ($files['pictures']->getClientFilename() != ''){
                        $fileImg = $files['pictures'];
                        $filename = "upload/temp/".$fileImg->getClientFilename();
                        $fileImg->moveTo($filename);
                        $this->resizeAndMoveImage($fileImg, $filename, "upload/img/", 320, 240);
                        $this->resizeAndMoveImage($fileImg, $filename, "upload/img/small/", 60, 50);
                        unlink($filename);
                        $post['pictures'] = $fileImg->getClientFilename();
                    } else {
                        $post['pictures'] = '';
                    }
                    // обработка текстового файла
                    if ($files['filepath']->getClientFilename() != ''){
                        $fileTxt = $files['filepath'];
                        $filename = "upload/txt/".$fileTxt->getClientFilename();
                        $fileTxt->moveTo($filename);
                        $post['filepath'] = $filename;
                    } else {
                        $post['filepath'] = '';
                    }
                    // добавление записи
                    $added = $init->setMessage($post);
                }
            }
        } elseif (isset($get['sort'])) {
            $sort  = $get['sort'];
        }
        $content = $init->getListMessages($sort, $added);
        var_dump($content);
        return new Response('views/indexView.php');
    }

    protected function changeTags($text)
    {
        $bbcode = array("[strong]", "[strike]", "[italic]", "[code]", "[/strong]", "[/strike]", "[/italic]", "[/code]");
        $htmltag   = array("<strong>", "<strike>", "<i>", "<code>", "</strong>", "</strike>", "</i>", "</code>");
        $text = str_replace($bbcode, $htmltag, $text);
        $text = preg_replace_callback('/\[url=(.*)\](.*)\[\/url\]/Usi', function($match) {
            return '<a href="'.$match[1].'" target="_blank">'.(empty($match[2]) ? $match[1] : $match[2]).'</a>';
         }, $text);
         return $text;
    }

    protected function resizeAndMoveImage($fileImg, $filename, $path, $max_width, $max_height)
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
}
