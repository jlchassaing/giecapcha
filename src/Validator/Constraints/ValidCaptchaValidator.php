<?php
/**
 * @author jlchassaing <jlchassaing@gmail.com>
 * @licence MIT
 */

namespace Gie\SecureImage\Validator\Constraints;


use Gie\SecureImage\Provider\SecureImageConfig;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Contracts\Translation\TranslatorInterface;

class ValidCaptchaValidator
{
    /** @var \Symfony\Component\HttpFoundation\Session\SessionInterface  */
    private SessionInterface $session;

    /** @var \Symfony\Contracts\Translation\TranslatorInterface  */
    private TranslatorInterface $translator;

    private $config;

    public function __construct(SessionInterface $session, TranslatorInterface $translator, SecureImageConfig $config)
    {
        $this->session = $session;
        $this->translator = $translator;
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function validate(FormEvent $event)
    {
        $value = $event->getData();
        $form = $event->getForm();

        $secureImage = new \Securimage($this->config->getConfig());

        if ($secureImage->check($value) === false) {
            $form->addError(new FormError($this->translator->trans('captcha_error', [], 'gie_captcha')));
        }
    }
}
