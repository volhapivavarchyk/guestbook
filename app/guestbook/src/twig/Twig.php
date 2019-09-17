<?php
declare(strict_types=1);

namespace Piv\Guestbook\Src\Twig;

use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Csrf\TokenStorage\SessionTokenStorage;
use Symfony\Component\Security\Csrf\TokenGenerator\UriSafeTokenGenerator;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Translation\Loader\YamlFileLoader as TransYamlFileLoader;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Piv\Guestbook\Config\Config;

class Twig
{
    protected $twig;

    public function __construct()
    {
        $defaultFormTheme = Config::FILE_OF_FORM_THEME;
        $appVariableReflection = new \ReflectionClass('\Symfony\Bridge\Twig\AppVariable');
        $vendorTwigBridgeDirectory = dirname($appVariableReflection->getFileName());
        $loader = new FilesystemLoader([
            '../templates/',
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
    }

    public function addExtension(object $extension)
    {
        $this->twig->addExtension($extension);
    }

    public function addFilterExtension(object $filterExtension)
    {
        $this->twig->addExtension($filterExtension);
        foreach ($filterExtension->getFilters() as $filter) {
            $this->twig->addFilter($filter);
        }
    }

    public function addFunctionExtension(object $functionExtension)
    {
        $this->twig->addExtension($functionExtension);
        foreach ($functionExtension->getFunctions() as $function) {
            $this->twig->addFunction($function);
        }
    }

    public function addTranslatationExtension(object $translator, string $language, string $fileName, string $fileType)
    {
        /*
        $translator->addLoader('xlf', new XliffFileLoader());
        $translator->addResource('xlf', 'messages.en.xlf', 'en');
        */
        $translator->addLoader($fileType, new TransYamlFileLoader());
        $translator->addResource($fileType, Config::FILE_OF_TRANSLATION.$fileName, $language);
        $this->addExtension(new TranslationExtension($translator));

    }

    public function getTwig(): Environment
    {
        return $this->twig;
    }
}
