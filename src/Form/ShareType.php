<?php

namespace App\Form;

use App\Entity\Quiz;
use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ShareType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("quiz", EntityType::class, ["class" => Quiz::class, 'choice_label' => 'nom', "label" => "Choisir le quiz à partager"])
            ->add("email", TextareaType::class, ["label" => "Saisir l'adresse des différentes personnes à qui vous souhaitez partager le quiz en mettant chaque adresse sur une ligne.", 'attr' => ['cols' => 40, 'rows' => 15]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}
