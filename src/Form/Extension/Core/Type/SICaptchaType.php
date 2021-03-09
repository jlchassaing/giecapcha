<?php
/**
 * @author jlchassaing <jlchassaing@gmail.com>
 * @licence MIT
 */

namespace Gie\SecureImage\Form\Extension\Core\Type;

use Gie\SecureImage\Provider\SecureImageConfig;
use Gie\SecureImage\Validator\Constraints\ValidCaptcha;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SICaptchaType extends AbstractType
{
    /** @var \Gie\SecureImage\Provider\SecureImageConfig  */
    private SecureImageConfig $config;

    /** @var \Symfony\Component\HttpFoundation\Session\SessionInterface  */
    private SessionInterface $session;

    public function __construct(SecureImageConfig $config, SessionInterface $session)
    {
        $this->config = $config;
        $this->session = $session;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'constraints' => new ValidCaptcha(),
        ]);
    }

    public function getParent(): string
    {
        return TextType::class;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $id = 'id_' . md5($view->vars['id'] .'-' . time());

        $options = $this->config->getConfig([
            'captcha_id' => $id,
            'image_id' => $id,
        ]);

        $this->session->set('captcha_id', $id );

        $view->vars['captcha_img'] = \Securimage::getCaptchaHtml($options, \Securimage::HTML_IMG);
        $view->vars['captcha_refresh'] = \Securimage::getCaptchaHtml($options, \Securimage::HTML_ICON_REFRESH);
        $view->vars['captcha_audio'] = \Securimage::getCaptchaHtml($options, \Securimage::HTML_AUDIO);
        $view->vars['captcha_label'] = \Securimage::getCaptchaHtml($options, \Securimage::HTML_INPUT_LABEL);
        $view->vars['captcha_id'] = $id;
    }
}