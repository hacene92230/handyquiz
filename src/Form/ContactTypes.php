<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactTypes extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('phone', TextType::class, ['label' => "Saisir votre numéro de téléphone", "attr" => ["placeholder" => "numéro de téléphone"]])
            ->add('email', EmailType::class, ['label' => "Saisir votre adresse email", "attr" => ['placeholder' => "votre email"]])
            ->add('request', TextType::class, ['label' => "Quel est votre sujet", "attr" => ['placeholder' => "sujet"]])
            ->add('content', TextareaType::class, ['label' => "quel est le contenu de votre message", "attr" => ['placeholder' => "contenu du message"]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}
