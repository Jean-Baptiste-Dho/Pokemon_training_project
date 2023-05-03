<?php

namespace App\Form;

use App\Entity\CapturedPokemon;
use App\Entity\Pokemon;
use App\Entity\TradingManager;
use App\Repository\CapturedPokemonRepository;
use App\Repository\PokemonRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TradingFormType extends AbstractType
{
    private TokenStorageInterface $storage;

    public function __construct(TokenStorageInterface $storage)
    {

        $this->storage = $storage;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('capturedPokemonSeller', EntityType::class, [
                'class' => CapturedPokemon::class,
                'query_builder' => function (CapturedPokemonRepository $repo) {
                    return $repo->findMyQB($this->storage->getToken()->getUser());
                }
            ])
            ->add('pokemon', EntityType::class, [
                'class' => Pokemon::class,
                'query_builder' => function (PokemonRepository $repo) {
                    return $repo->findAllOrderedQB();
                }
            ])
            ->add('capturedPokemonBuyer', EntityType::class, [
                'class' => CapturedPokemon::class,
                'query_builder' => function (CapturedPokemonRepository $repo) {
                    return $repo->findNotMyQB($this->storage->getToken()->getUser());
                }
            ])
            ->add('Ajouter', SubmitType::class);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TradingManager::class,
        ]);
    }
}
