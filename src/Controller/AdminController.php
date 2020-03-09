<?php
namespace App\Controller;

use App\Entity\Article;
use App\Entity\Project;
use App\Entity\User;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends EasyAdminController
{
    private $encoder;
    public function __construct( UserPasswordEncoderInterface $encoder)
    {
        $this->encoder=$encoder;
    }

    protected function prePersistUserEntity(User $user)
    {
        $encodedPassword = $this->encodePassword($user, $user->getPassword());
        $user->setPassword($encodedPassword);
    }

    protected function preUpdateUserEntity(User $user)
    {
        if (!$user->getPlainPassword()) {
            return;
        }
        $encodedPassword = $this->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($encodedPassword);
    }

    private function encodePassword(User $user, $password)
    {
        //$passwordEncoderFactory = $this->get('security.encoder_factory');
        //$encoder = $passwordEncoderFactory->getEncoder($user);
        return $this->encoder->encodePassword($password, $user->getSalt());
    }


}
