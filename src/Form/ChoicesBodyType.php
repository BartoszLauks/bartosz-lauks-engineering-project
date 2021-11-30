<?php

namespace App\Form;

use App\Entity\CarBody;
use App\Repository\CarBodyRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChoicesBodyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('body', EntityType::class, [
                'class' => CarBody::class,
                'placeholder' => '',
                'attr' => ['onchange' => 'this.form.submit()'],
                'query_builder' => function (CarBodyRepository $er) use ($options) {
                    return $er->createQueryBuilder('m')
                        ->andWhere('m.generation = :val')
                        ->setParameter('val', $options['generation']);
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'generation' => 1
        ]);
        $resolver->setAllowedTypes('generation','int');
    }
}
