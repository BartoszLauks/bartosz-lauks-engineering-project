<?php

namespace App\Form;

use App\Entity\SalesOffers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Positive;

class NewOfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('price',MoneyType::class,[
                'constraints' => [new Positive()],
                'attr' => [
                    'min' => 1
                ]
            ])
            ->add('mileage',IntegerType::class,[
                'constraints' => [new Positive()],
                'attr' => [
                    'min' => 1
                ]
            ])
            ->add('details',TextareaType::class)
            ->add('producedAt',DateType::class, array(
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y')-100))
            )
            ->add('file',FileType::class)
            ->add('Add',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SalesOffers::class,
        ]);
    }
}
