<?php

namespace App\Form;

use App\Entity\Utilisateurs;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;


class UtilisateursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('identifiant', TextType::class, ['label' => 'identifiant', 'attr' => ['placeholder' => 'identifiant']])
            ->add('motdepasse', PasswordType::class)
            ->add('nom',TextType::class, ['label' => 'nom de l\'utilisateur', 'attr' => ['placeholder' => 'nom']])
            ->add('prenom',TextType::class, ['label' => 'prenom de l\'utilisateur', 'attr' => ['placeholder' => 'prenom']])
            ->add('anniversaire', BirthdayType::class)
            ->add('isadmin')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateurs::class,
        ]);
    }
}
