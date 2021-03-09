<?php
/**
 * @author jlchassaing <jlchassaing@gmail.com>
 * @licence MIT
 */

namespace Gie\SecureImage\Validator\Constraints;


use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Contracts\Translation\TranslatorInterface;

class ValidCaptchaValidator extends ConstraintValidator
{
    /** @var \Symfony\Component\HttpFoundation\Session\SessionInterface  */
    private SessionInterface $session;

    /** @var \Symfony\Contracts\Translation\TranslatorInterface  */
    private TranslatorInterface $translator;

    public function __construct(SessionInterface $session, TranslatorInterface $translator)
    {
        $this->session = $session;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {

        $secureImage = new \Securimage();

        if ($secureImage->check($value, $this->session->get('captcha_id')) == false) {
            $this->context->addViolation($this->translator->trans('captcha_error', [], 'gie_captcha'));
        }
    }
}
