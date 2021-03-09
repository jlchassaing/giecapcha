<?php
/**
 * @author jlchassaing <jlchassaing@gmail.com>
 * @licence MIT
 */

namespace Gie\SecureImage\Controller;

use eZ\Bundle\EzPublishCoreBundle\Controller;
use Gie\SecureImage\Provider\SecureImageConfig;
use \Securimage;
use Symfony\Component\HttpFoundation\Request;

class SecureImageController extends Controller
{
    /**
     * @param \Gie\SecureImage\Provider\SecureImageConfig $configuration
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return false|string
     * @throws \Exception
     */
    public function showImage(SecureImageConfig $configuration, Request $request)
    {
        dump($request->getLocale());
        $img = new \Securimage($configuration->getConfig(['captchaId' => $request->get('id')]));
        ob_start();
        $img->show();
        return ob_get_contents();
    }

    /**
     * @param \Gie\SecureImage\Provider\SecureImageConfig $configuration
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return false|string
     * @throws \Exception
     */
    public function play(SecureImageConfig $configuration, Request $request)
    {
        $options = $configuration->getConfig(['captchaId' => $request->get('id')]);
        $img = new \Securimage($options);
        // Other audio settings
//$img->audio_use_noise = true;
//$img->degrade_audio   = false;
//Securimage::$lame_binary_path = '/usr/bin/lame'; // for mp3 audio support

// To use an alternate language, uncomment the following and download the files from phpcaptcha.org
// $img->audio_path = $img->securimage_path . '/audio/es/';

// mp3 or wav format
        $format = ($request->get('format',null));
        if ($format and $format !== 'mp3') {
            $format = null;
        }
        ob_start();
        $img->outputAudioFile($format);
        return ob_get_contents();
    }

}