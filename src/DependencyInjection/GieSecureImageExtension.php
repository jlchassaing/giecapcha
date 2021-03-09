<?php
/**
 * @author jlchassaing <jlchassaing@gmail.com>
 * @licence MIT
 */
namespace Gie\SecureImage\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Yaml\Yaml;

class GieSecureImageExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        // Base services and services overrides
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter("gie_secure_image", $config);

        $resources = $container->getParameter('twig.form.resources');
        $container->setParameter(
            'twig.form.resources',
            array_merge(['@GieSecureImage/form/si_captcha_type.html.twig'], $resources)
        );
    }

    public function prepend(ContainerBuilder $container)
    {
        $configDirectoryPath = __DIR__.'/../Resources/config';

        $this->prependYamlConfigFile($container, 'gie_secure_image', $configDirectoryPath.'/gie_secure_image.yaml', 'gie_secure_image');
    }

    private function prependYamlConfigFile(ContainerBuilder $container, $extensionName, $configFilePath, $param = null)
    {
        $config = Yaml::parse(file_get_contents($configFilePath));
        $container->prependExtensionConfig($extensionName, $param !== null ? $config[$param]: $config);
    }


}