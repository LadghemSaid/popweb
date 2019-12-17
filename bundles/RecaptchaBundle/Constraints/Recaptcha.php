<?php

namespace  Kurokei\RecaptchaBundle\Constraints;

use Symfony\Component\Validator\Constraint;

class Recaptcha extends  Constraint{

    public $message = 'Captcha invalide';
}
