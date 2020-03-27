<?php

namespace App\Form;

use Kurokei\RecaptchaBundle\type\RecaptchaSubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName', TextType::class)
            ->add('fromEmail', EmailType::class)
            ->add('message', TextareaType::class)
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'btn btn-primary submit g-recaptcha',
                    'data-sitekey' => '6Levh-QUAAAAAMEWZS61dszdMbHwyaOLJjKby5Qa',
                    'data-callback' => 'onSubmit'
                ]
            ])
//            ->add('captcha' , RecaptchaSubmitType::class,[
//                'label' => 'Envoyer',
//                'attr' => [
//                    'class' => 'btn btn-primary submit'
//                ]
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
