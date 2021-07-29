<?php
/**
 * @author jlchassaing <jlchassaing@gmail.com>
 * @licence MIT
 */

namespace Gie\SecureImage\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('gie_secure_image');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode->children()
            ->booleanNode('disable_flash_fallback')->defaultValue(false)->end()
            ->scalarNode('show_image_url')->defaultNull()->end()
            ->scalarNode('audio_play_url')->defaultNull()->end()
            ->scalarNode('audio_path')->defaultNull()->end()
            ->scalarNode('securimage_path')->defaultValue('/bundles/giesecureimage')->end()
            ->scalarNode('input_text')->defaultNull()->end()
            ->scalarNode('refresh_title_text')->defaultNull()->end()
            ->scalarNode('refresh_alt_text')->defaultNull()->end()
            ->scalarNode('image_alt_text')->defaultNull()->end()
            ->scalarNode('ttf_file')->defaultNull()->end()
            ->scalarNode('text_color')->defaultValue('#707070')->end()
            ->scalarNode('line_color')->defaultValue('#707070')->end()
            ->scalarNode('noise_color')->defaultValue('#707070')->end()
            ->scalarNode('image_bg_color')->defaultValue('#ffffff')->end()
            ->booleanNode('no_session')->defaultValue(true)->end()
            ->booleanNode('use_redis')->defaultValue(true)->end()
            ->scalarNode('redis_server')->defaultNull()->end()
            ->end();

        return $treeBuilder;
    }
}