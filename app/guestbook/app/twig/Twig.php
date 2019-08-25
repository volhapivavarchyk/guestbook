<?php

namespace Piv\Guestbook\App\Twig;

use Symfony\Bridge\Twig\Extension\{FormExtension, TranslationExtension};
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Form\{Forms, FormRenderer};
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\{ArrayLoader, XliffFileLoader};
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Piv\Guestbook\App\Twig\{TwigFilterExtention, TwigFunctionExtention};

class Twig
{
    protected $twig;

    public function __construct()
    {
        $defaultFormTheme = 'form_div_layout.html.twig';
        $vendorDirectory = realpath(__DIR__.'/../vendor');
        $appVariableReflection = new \ReflectionClass('\Symfony\Bridge\Twig\AppVariable');
        $vendorTwigBridgeDirectory = dirname($appVariableReflection->getFileName());
        $loader = new FilesystemLoader([
            '../app/views/',
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
        $filterExtention = new TwigFilterExtention();
        $this->twig->addExtension($filterExtention);
        foreach ($filterExtention->getFilters() as $filter) {
            $this->twig->addFilter($filter);
        }
        $functionExtention = new TwigFunctionExtention();
        $this->twig->addExtension($functionExtention);
        foreach ($functionExtention->getFunctions() as $function) {
            $this->twig->addFunction($function);
        }
        // добавдение Webpack Encore
        //$containerBuilder = new ContainerBuilder();
        //$loader = new YamlFileLoader($containerBuilder, new FileLocator(__DIR__));
        //$loader->load('webpack_encore.yaml');
        //$entryFilesTwigExtention = new EntryFilesTwigExtension($containerBuilder);
        //$this->twig->addExtension($entryFilesTwigExtention);
        //foreach ($entryFilesTwigExtention->getFunctions() as $function) {
        //    $this->twig->addFunction($function);
        //}
        // создание переводчика
        $translator = new Translator('en');
        $translator->addLoader('array', new ArrayLoader());
        $translator->addResource('array', [
            'Имя пользователя' => 'User name',
            'Электронная почта' => 'E-mail',
            'Тема сообщения' => 'Theme',
            'Текст сообщения' => 'Text of message',
            'Добавить изображение' => 'Add a picture',
            'Добавить текстовый файл' => 'Add a file (.txt)',
        ], 'en');
        /*
        $translator->addLoader('xlf', new XliffFileLoader());
        $translator->addResource('xlf', 'messages.en.xlf', 'en');
        */
        // добавление TranslationExtension (фильтры trans и transChoice)
        $this->twig->addExtension(new TranslationExtension($translator));
    }

    public function getTwig(): Environment
    {
        return $this->twig;
    }
}
