<?php
namespace Guestbook\App\Controllers;

use Guestbook\App\Controllers\ABaseController;
use Guestbook\App\Database\Message;
use Zend\Diactoros\UploadedFile;
use Zend\Diactoros\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;

class IndexController extends ABaseController
{
    public $message;
    public $content;
    public $params;

    public function __construct()
    {
        $this->message = new Message();
        $this->params = array();
        $this->params['added_message'] = '';
        $this->content = 'indexView.php';
    }

    public function show(ServerRequestInterface $request)
    {
        $get = $request->getQueryParams();
        $post = $request->getParsedBody();
        $server = $request->getServerParams();
        $files = $request->getUploadedFiles();

        $this->params['sort'] = 'date_desc';

        if (isset($post['send'])) {
            $this->params['added_message'] = 'сообщение не добавлено';
            $response = $post["g-recaptcha-response"];
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
                    if ($files['pictures']->getClientFilename() !== ''){
                        $fileImg = $files['pictures'];
                        $filename = DIR_PUBLIC."upload/temp/".$fileImg->getClientFilename();
                        $fileImg->moveTo($filename);
                        $this->resizeAndMoveImage($fileImg, $filename, DIR_PUBLIC."upload/img/", 320, 240);
                        $this->resizeAndMoveImage($fileImg, $filename, DIR_PUBLIC."upload/img/small/", 60, 50);
                        unlink($filename);
                        $post['pictures'] = $fileImg->getClientFilename();
                    } else {
                        $post['pictures'] = '';
                    }
                    // обработка текстового файла
                    if ($files['filepath']->getClientFilename() !== ''){
                        $fileTxt = $files['filepath'];
                        $filename = DIR_PUBLIC."upload/txt/".$fileTxt->getClientFilename();
                        $fileTxt->moveTo($filename);
                        $post['filepath'] = $filename;
                    } else {
                        $post['filepath'] = '';
                    }
                    // добавление записи
                    $this->params['added_message'] = $this->addMessage($post);
                }
            }
        }

        if (isset($get['sort'])) {
            $this->params['sort'] = $get['sort'];
        }

        $this->params['blocksOfMessages'] = $this->getListMessages($this->params['sort']);
        $this->params['countOfMessages'] = count($this->params['blocksOfMessages']);
        return [
            'params'=>$this->params,
            'content'=>$this->content
        ];
    }

    public function getListMessages($sort)
    {
        return $this->message->getAllItems25($sort);
    }

    public function addMessage($post)
    {
        return $this->message->addItem($post);
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
        }
        imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        switch ($type) {
            case 3:
                imagepng($new_image, $path.$fileImg->getClientFilename());
                break;
            case 2:
                imagejpeg($new_image, $path.$fileImg->getClientFilename());
                break;
            case 1:
                imagegif($new_image, $path.$fileImg->getClientFilename());
                break;
            default:
        }
    }
}
