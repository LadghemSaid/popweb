<?php

namespace App\Faker\Provider;

use Faker\Provider\Base as BaseProvider;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class PasswordProvider extends BaseProvider
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function encodePassword($user, string $plainPassword)
    {
        return $this->encoder->encodePassword($user, $plainPassword);
    }
}
