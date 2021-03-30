<?php

namespace App\Form;

use App\Entity\TreeTrunk;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TreeTrunkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, ['label' => 'Libellé de l\'article', 'attr' => ['placeholder' => 'Nom']])
            ->add('prix', NumberType::class, ['label' => 'prix d\' achat'])
            ->add('quantite', IntegerType::class, ['label' => 'quantité en stock'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TreeTrunk::class,
        ]);
    }
}
