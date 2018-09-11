<?php
namespace Pi\Guestbook\App;

use Pi\Guestbook\App\IndexController;
use Pi\Guestbook\Database\Message;

class AppKernel
{
    public handle($request)
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
                  $post['text'] = changeTags($post['text']);
                  // обработка изображения
                  if ($files['pictures']->getClientFilename() != ''){
                      $fileImg = $files['pictures'];
                      $filename = "upload/temp/".$fileImg->getClientFilename();
                      $fileImg->moveTo($filename);
                      resizeAndMoveImage($fileImg, $filename, "upload/img/", 320, 240);
                      resizeAndMoveImage($fileImg, $filename, "upload/img/small/", 60, 50);
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
          } elseif (isset($get['sort'])) {
              $sort  = $get['sort'];
          }

          $init->getListMessages($get['sort'], 'not');

          return $init->getBody($sort, $added);

    }
}
