<?php

namespace App\Form;

use App\Entity\PokemonSpecie;
use App\Entity\Dresseur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PokemonsAddFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('name', TextType::class, [
                'required' => true
            ])
            ->add('type', TextType::class)
            ->add('dresseur', EntityType::class,[
                'class' => Dresseur::class,
                'choice_label' => 'dresseurname'
            ])
            ->add('Ajouter', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PokemonSpecie::class,
        ]);
    }

}
