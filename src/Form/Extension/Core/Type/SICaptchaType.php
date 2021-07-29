<?php
/**
 * @author jlchassaing <jlchassaing@gmail.com>
 * @licence MIT
 */

namespace Gie\SecureImage\Form\Extension\Core\Type;

use EzSystems\EzPlatformFormBuilder\FieldType\Model\Field;
use Gie\SecureImage\Provider\SecureImageConfig;
use Gie\SecureImage\Validator\Constraints\ValidCaptcha;
use Gie\SecureImage\Validator\Constraints\ValidCaptchaValidator;
use Gregwar\CaptchaBundle\Validator\CaptchaValidator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class SICaptchaType extends AbstractType
{
    /** @var \Gie\SecureImage\Provider\SecureImageConfig  */
    private SecureImageConfig $config;

    /** @var \Symfony\Component\HttpFoundation\Session\SessionInterface  */
    private SessionInterface $session;

    private $translator;

    public function __construct(SecureImageConfig $config, SessionInterface $session, TranslatorInterface $translator)
    {
        $this->config = $config;
        $this->session = $session;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $validator = new ValidCaptchaValidator($this->session, $this->translator, $this->config);

        $builder->addEventListener(FormEvents::POST_SUBMIT, array($validator, 'validate'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('field',  null);
        $resolver->setDefaults([
            'validation_groups' => ['fields'],
            'constraints' => new ValidCaptcha(),
        ]);

    }

    public function getParent(): string
    {
        return TextType::class;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $id =  \Securimage::generateCaptchaId();

        $options += $this->config->getConfig([
            'captcha_id' => $id,
            'image_id' => $id,
        ]);

        $view->vars += [
            'field' => $options['field'] ?? null,
            'captcha_img' => \Securimage::getCaptchaHtml($options, \Securimage::HTML_IMG),
            'captcha_refresh' => \Securimage::getCaptchaHtml($options, \Securimage::HTML_ICON_REFRESH),
            'captcha_audio' => \Securimage::getCaptchaHtml($options, \Securimage::HTML_AUDIO),
            'captcha_label' => \Securimage::getCaptchaHtml($options, \Securimage::HTML_INPUT_LABEL),
           'captcha_id' => $id,
        ];
    }
}