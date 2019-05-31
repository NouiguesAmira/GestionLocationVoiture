<?php

namespace App\Form\Admin;

use App\Entity\Marque;
use App\Entity\Voiture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Doctrine\DBAL\Types\FloatType;

class VoitureType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('matricule', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                ]
            ])
            ->add('nbPorte', IntegerType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\Type(['type' => 'integer', 'message' => 'Un chiffre supérieur à 0 est requis']),
                    new Assert\GreaterThan(['value' => 0, 'message' => 'Un chiffre supérieur à 0 est requis']),
                ],
            ])
            ->add('nbPassager', IntegerType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\Type(['type' => 'integer', 'message' => 'Un chiffre supérieur à 0 est requis']),
                    new Assert\GreaterThan(['value' => 0, 'message' => 'Un chiffre supérieur à 0 est requis']),
                ],
            ])
            ->add('capaciteBagage', IntegerType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\Type(['type' => 'integer', 'message' => 'Un chiffre supérieur à 0 est requis']),
                    new Assert\GreaterThan(['value' => 0, 'message' => 'Un chiffre supérieur à 0 est requis']),
                ],
            ])
            ->add('kiloMetrage', IntegerType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\Type(['type' => 'integer', 'message' => 'Un chiffre supérieur à 0 est requis']),
                    new Assert\GreaterThan(['value' => 0, 'message' => 'Un chiffre supérieur à 0 est requis']),
                ],
            ])
            ->add('couleur', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                ]
            ])

            ->add('disponible', ChoiceType::class, [
                'choices'  => [
                    'Yes' => true,
                    'No' => false,
                ],
                'label' => 'Disponible?',
                'constraints' => [
                    new NotNull(),
                ]
            ])

            ->add('prix')

            ->add('logo', FileType::class, [
                'required' => false,
                'constraints' => [
                    new Image(),
                ]
            ])


            ->add('marque', EntityType::class, [
                'class' => Marque::class,
                'choice_label' => 'name',
                'constraints' => [
                    new NotBlank(),
                ]
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
