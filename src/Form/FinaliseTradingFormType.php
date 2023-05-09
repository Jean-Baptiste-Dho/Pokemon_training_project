<?php

namespace App\Form;


use App\Entity\CapturedPokemon;
use App\Entity\Trade;
use App\Repository\CapturedPokemonRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class FinaliseTradingFormType extends AbstractType
{
    private TokenStorageInterface $storage;

    public function __construct(TokenStorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Accepter' => Trade::ACCEPTED,
                    'Refuser' => Trade::REFUSED,
                ],
                'expanded' => true,
//                'multiple' => true
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trade::class,
            'validation_groups' => [
                'Finalisation'
            ]
        ]);
    }
}
