<?php

namespace App\Form;

use App\Entity\CapturedPokemon;
use App\Entity\Pokemon;
use App\Entity\Trade;
use App\Repository\CapturedPokemonRepository;
use App\Repository\PokemonRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CreateTradingFormType extends AbstractType
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
                'label' => 'Pokémon à échanger :',
                'query_builder' => function (CapturedPokemonRepository $repo) {
                    return $repo->findMyQB($this->storage->getToken()->getUser());
                },
                'choice_label' => function (CapturedPokemon $pokemon) {
                    if (!$pokemon->getSurname()) {
                        return $pokemon->getPokemon();
                    } else {
                        return $pokemon->getPokemon() . ' (' . $pokemon->getSurname() . ')';
                    }
                }
            ])
            ->add('pokemon', EntityType::class, [
                'class' => Pokemon::class,
                'label' => 'Pokémon recherché :',
                'query_builder' => function (PokemonRepository $repo) {
                    return $repo->findAllOrderedQB();
                }
            ])
            ->add('capturedPokemonBuyer', EntityType::class, [
                'class' => CapturedPokemon::class,
                'label' => 'Pokémon des autres dresseurs :',
                'placeholder' => '---',
                'query_builder' => function (CapturedPokemonRepository $repo) {
                    return $repo->findNotMyQB($this->storage->getToken()->getUser());
                },
                'choice_label' => function (CapturedPokemon $pokemon) {
                    return $pokemon->getPokemon() . ' - ' . $pokemon->getDresseur();

                },
                'choice_attr' => ChoiceList::attr($this, function (?CapturedPokemon $pokemon) {
                    return $pokemon ? ['data-pokemon-id' => $pokemon->getPokemon()->getId()] : [];
                }),

            ])
            ->add('Ajouter', SubmitType::class);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trade::class,
            'validation_groups' => [
                'Creation'
            ]
        ]);
    }
}
