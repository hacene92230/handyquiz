<?php

namespace App\Form;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('texte', TextType::class, ["label" => "saisir le texte de votre question", "attr" => ["placeholder" => "texte de votre question"]])
            ->add('reponse1', TextType::class, ['label' => "saisir la première réponse", "attr" => ['placeholder' => "réponse 1"]])
->add('reponse2' , TextType::class, ['label' => "saisir la seconde réponse", "attr" => ['placeholder' => "réponse 2"]])
->add('reponse3' , TextType::class, ['label' => "saisir la troisième réponse", "attr" => ['placeholder' => "réponse 3"]])
            ->add('reponse4' , TextType::class, ["required" => false, 'label' => "saisir la quatrième réponse", "attr" => ['placeholder' => "réponse 4"]])
            ->add('reponse5' , TextType::class, ["required" => false, 'label' => "saisir la cinquième réponse", "attr" => ['placeholder' => "réponse 5"]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
