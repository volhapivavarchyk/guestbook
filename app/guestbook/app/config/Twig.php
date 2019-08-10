<?php

namespace Piv\Guestbook\App\Config;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\Form\Forms;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Component\Form\FormRenderer;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Bridge\Twig\Extension\TranslationExtension;

class Twig
{
    protected $twig;

    public function __construct()
    {
        // файл Twig, содержащий всю разметку по умолчанию для отображения форм
        // файл поставляется с TwigBridge
        $defaultFormTheme = 'form_div_layout.html.twig';
        $vendorDirectory = realpath(__DIR__.'/../vendor');
        // путь к библиотеке TwigBridge, чтобы Twig мог найти form_div_layout.html.twig
        $appVariableReflection = new \ReflectionClass('\Symfony\Bridge\Twig\AppVariable');
        $vendorTwigBridgeDirectory = dirname($appVariableReflection->getFileName());
        $loader = new FilesystemLoader([
            '../app/templates/',
            $vendorTwigBridgeDirectory.'/Resources/views/Form',
        ]);
        $this->twig = new Environment($loader, [
            'strict_variables' => false,
            'debug' => false,
            'cache' => false
        ]);
        $formEngine = new TwigRendererEngine([$defaultFormTheme], $this->twig);
        $this->twig->addRuntimeLoader(
            new \Twig_FactoryRuntimeLoader([
                FormRenderer::class => function () use ($formEngine, $csrfManager) {
                    return new FormRenderer($formEngine, $csrfManager);
                },
            ])
        );
        $this->twig->addExtension(new FormExtension());

        // создаёт Переводчик
        $translator = new Translator('en');
        // загружает некоторые переводы в него
        $translator->addLoader('xlf', new XliffFileLoader());
        $translator->addResource(
            'xlf',
            'messages.en.xlf',
            'en'
        );

        // добавляет TranslationExtension (даёт нам фильтры trans и transChoice)
        $this->twig->addExtension(new TranslationExtension($translator));
    }

    public function getTwig(): Environment
    {
        return $this->twig;
    }
}
