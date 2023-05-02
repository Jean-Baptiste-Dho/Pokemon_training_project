<?php

namespace App\Form;

use App\Entity\CapturedPokemon;
use App\Entity\Pokemon;
use App\Repository\PokemonRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CapturedPokemonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('surname', TextType::class, [
                'required' => true
            ])
//            ->add('type', TextType::class)
            ->add('pokemon', EntityType::class, [
                'class' => Pokemon::class,
                'query_builder' => function (PokemonRepository $repo) {
                    return $repo->findAllOrderedQB();
                }
            ])
            ->add('Ajouter', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CapturedPokemon::class,
        ]);
    }

}
