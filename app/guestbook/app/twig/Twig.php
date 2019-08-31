<?php
declare(strict_types=1);

namespace Piv\Guestbook\App\Twig;

use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Csrf\TokenStorage\SessionTokenStorage;
use Symfony\Component\Security\Csrf\TokenGenerator\UriSafeTokenGenerator;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader as TransYamlFileLoader;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Piv\Guestbook\App\Config\Config;

class Twig
{
    protected $twig;

    public function __construct()
    {
        $defaultFormTheme = Config::FILE_OF_FORM_THEME;
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

        $session = new Session();
        $csrfGenerator = new UriSafeTokenGenerator();
        $csrfStorage = new SessionTokenStorage($session);
        $csrfManager = new CsrfTokenManager($csrfGenerator, $csrfStorage);

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
        // создание переводчика
        $translator = new Translator('ru');
        $translator->addLoader('yaml', new TransYamlFileLoader());
        $translator->addResource('yaml', Config::FILE_OF_TRANSLATION.'messages.ru.yaml', 'ru');
        /*
        $translator->addLoader('xlf', new XliffFileLoader());
        $translator->addResource('xlf', 'messages.en.xlf', 'en');
        */
        $this->twig->addExtension(new TranslationExtension($translator));
    }

    public function getTwig(): Environment
    {
        return $this->twig;
    }
}
