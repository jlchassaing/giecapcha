<?php
/**
 * @author jlchassaing <jlchassaing@gmail.com>
 * @licence MIT
 */

namespace Gie\SecureImage\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
* @Annotation
*/
class ValidCaptcha extends Constraint
{

    /*
     * @var string
     */
    public $message = 'CAPTCHA validation failed, please try again.';




    /**
     * {@inheritdoc}
     */
    public function validatedBy(): string
    {
        return 'si.captcha.valid';
    }
}
