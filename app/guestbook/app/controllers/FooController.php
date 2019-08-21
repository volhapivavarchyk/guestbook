<?php
namespace Piv\Guestbook\App\Controllers;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Extension\Core\Type\{DateType, SubmitType, TextType};
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Validator\Validation;

use Piv\Guestbook\App\Twig\Twig;
use Piv\Guestbook\App\Forms\{MessageType, UserType};
use Piv\Guestbook\App\Config\{Config, Bootstrap};
use Piv\Guestbook\App\Entities\{Message, User};
use Piv\Guestbook\App\Controllers\UploadedFiles\{ImageFactory, FileTxt};

class FooController
{
    public static function show(Request $request): Response
    {
      $response = new Response(
          'Ok!',
          Response::HTTP_OK,
          array('content-type' => 'text/html')
      );
      return $response;
    }
}
