<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('text', CKEditorType::class,[
                "label" => "Corps de l'article"
            ])
            ->add('status', ChoiceType::class, [
                'choices' => $this->GetChoices('STATUS')
            ])
            ->add('image', TextType::class,  [
                "label" => "Image mise en avant"
            ])
            ->add('categorie', EntityType::class, [
                // looks for choices from this entity
                'class' => Categorie::class,

                // uses the User.username property as the visible option string
                'choice_label' => 'name',

                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'translation_domain' => 'forms'
        ]);
    }

    public function getChoices($value)
    {
        if ($value == 'STATUS') {
            $choices = Article::STATUS;
        }


        $output = [];
        foreach ($choices as $k => $v) {
            $output[$v] = $k;
        }
        return $output;
    }
}
