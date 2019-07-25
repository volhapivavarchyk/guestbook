<?php
declare(strict_types=1);

namespace Piv\Guestbook\App\Controllers;

use Zend\Diactoros\{UploadedFile, ServerRequest};
use Psr\Http\Message\ServerRequestInterface;
use Piv\Guestbook\App\Controllers\ABaseController;
use Piv\Guestbook\App\Entity\{Message, User};
use Piv\Guestbook\App\Config\Bootstrap;

class IndexController extends ABaseController
{

    public function show(ServerRequestInterface $request): array
    {
        $params['added_message'] = '';
        $params['sort'] = 'date_desc';
        $content = 'indexView.php';

        $get = $request->getQueryParams();
        $post = $request->getParsedBody();
        $server = $request->getServerParams();
        $files = $request->getUploadedFiles();

        $entityManager = (new Bootstrap())->getEntityManager();

        if (isset($post['send'])) {
            $params['added_message'] = 'сообщение не добавлено';
            $response = $post["g-recaptcha-response"];
            if (!empty($response)) {
                $captcha_url = $_ENV['GUESTBOOK_CAPTCHA_URL'];
                $captcha_secret = $_ENV['GUESTBOOK_CAPTCHA_SECRET'];
                $url = $captcha_url . "?secret=" . $captcha_secret . "&response=" . $response . "&remoteip=" . $server['REMOTE_ADDR'];
                $rsp = file_get_contents($url);
                $arr = json_decode($rsp, true);
                if ($arr['success']) {
                    $usersRepository = $entityManager->getRepository(User::class);
                    $user = $usersRepository->findOneBy([
                        'name' => $post['name'],
                        'email' => $post['email']
                    ]);
                    if (!isset($user))
                    {
                        $user = new User();
                        $user->setName($post['name']);
                        $user->setEmail($post['email']);
                        $entityManager->persist($user);
                        //$entityManager->flush();
                    }
                    $message = new Message();
                    $message->setUser($user);
                    $message->setTheme($post['theme']);
                    // обработка текста сообщения
                    $message->setText($this->changeTags($post['text']));
                    // обработка изображения
                    if ($files['pictures']->getClientFilename() !== '') {
                        $factory = new ImageFactory($files['pictures']);
                        switch (filetype($factory->image)) {
                            case 3:
                                $image = $factory->createPngImage();
                                break;
                            case 2:
                                $image = $factory->createJpegImage();
                                break;
                            case 1:
                                $image = $factory->createGifImage();
                                break;
                            default:
                                // no default value
                                break;
                        }
                        $message->setPictures($image->createImage());
                    } else {
                        $message->setPictures('');
                    }
                    // обработка текстового файла
                    if ($files['filepath']->getClientFilename() !== '') {
                        $fileTxt = $files['filepath'];
                        $filename = Config::DIR_PUBLIC . "upload/txt/" . $fileTxt->getClientFilename();
                        $fileTxt->moveTo($filename);
                        $message->setFilepath($filename);
                    } else {
                        $message->setFilepath('');
                    }
                    // добавляем информацию
                    $message->setIp($server['REMOTE_ADDR']);
                    $message->setBrowser($server['HTTP_USER_AGENT']);
                    $message->setDate(new \DateTime("now"));
                    // добавление записи в БД
                    $entityManager->persist($message);
                    var_dump($message);
                    $entityManager->flush();
                    $params['added_message'] = 'запись успешно добавлена';
                }
            }
        }

        if (isset($get['sort'])) {
            $params['sort'] = $get['sort'];
        }
        $messagesRepository = $entityManager->getRepository(Message::class);
        $messages = $messagesRepository->findAll();
        $i = 0;
        $j = 0;
        $blocksOfMessages = [];
        foreach ($messages as $message) {
            //$message['name'] = $message->getUser()->getName();
            //$message['email'] = $message->getUser()->getEmail();
            $blocksOfMessages[$i][$j] = $message;
            if ($j === 25)
            {
                $i += 1;
                $j = 0;
            } else {
                $j += 1;
            }
        }
        $params['blocksOfMessages'] = $blocksOfMessages;
        $params['countOfMessages'] = count($params['blocksOfMessages']);
        return [
            'params' => $params,
            'content' => $content
        ];
    }

    protected function changeTags(string $text): string
    {
        $bbcode = ["[strong]", "[strike]", "[italic]", "[code]", "[/strong]", "[/strike]", "[/italic]", "[/code]"];
        $htmltag = ["<strong>", "<strike>", "<i>", "<code>", "</strong>", "</strike>", "</i>", "</code>"];
        $text = str_replace($bbcode, $htmltag, $text);
        $text = preg_replace_callback('/\[url=(.*)\](.*)\[\/url\]/Usi', function ($match) {
            return '<a href="' . $match[1] . '" target="_blank">' . (empty($match[2]) ? $match[1] : $match[2]) . '</a>';
        }, $text);
        return $text;
    }

}
