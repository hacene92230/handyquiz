<?php

namespace App\Form;

use App\Entity\Quiz;
use App\Entity\Question;
use App\Repository\QuestionRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class QuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, ["label" => "saisir un nom pour pouvoir identifier plus facilement votre quiz", "attr" => ["placeholder" => "nom de votre quiz"]])
            ->add(
                'question',
                EntityType::class,
                [
                    'class' => Question::class, 'choice_label' => 'texte',
                    'multiple' => true,
                     'expanded' => true,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quiz::class,
        ]);
    }
}
