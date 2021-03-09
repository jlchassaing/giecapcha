<?php
/**
 * @author jlchassaing <jlchassaing@gmail.com>
 * @licence MIT
 */

namespace Gie\SecureImage\Provider;


use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class SecureImageConfig
{
    /** @var \Symfony\Component\Routing\RouterInterface  */
    private RouterInterface $router;

    /** @var \Symfony\Contracts\Translation\TranslatorInterface  */
    private TranslatorInterface $translator;

    /** @var array  */
    private array $config;

    public function __construct(RouterInterface $router, TranslatorInterface $translator, array $config)
    {
        $this->router = $router;
        $this->translator = $translator;
        $this->config = $config;

    }

    public function load()
    {
        $this->loadRoutes();
        $this->loadTranslations();
    }

    public function getConfig(array $config = []): array
    {
        $this->load();
        return array_merge($this->config, $config);
    }

    private function loadRoutes()
    {
        $paths = [
            'show_image_url' => '_secure_image_src',
            'audio_play_url' => '_secure_image_play',
        ];
        foreach ($paths as $path => $route) {
            if (empty($this->config[$path])) {
                $this->config[$path] = $this->router->generate($route);
            }
        }
    }

    private function loadTranslations()
    {
        $textFields = ['input_text','refresh_title_text', 'refresh_alt_text','image_alt_text'];
        foreach ($textFields as $textField) {
            if (empty($this->config[$textField])) {
                $this->config[$textField] = $this->translator->trans($textField, [], 'gie_captcha',);
            }
        }
    }

}