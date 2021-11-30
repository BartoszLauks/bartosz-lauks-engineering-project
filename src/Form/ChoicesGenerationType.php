<?php

namespace App\Form;

use App\Entity\Generation;
use App\Repository\GenerationRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChoicesGenerationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('generation', EntityType::class, [
                'class' => Generation::class,
                'placeholder' => '',
                'attr' => ['onchange' => 'this.form.submit()'],
                'query_builder' => function (GenerationRepository $er) use ($options) {
                    return $er->createQueryBuilder('m')
                        ->andWhere('m.model = :val')
                        ->setParameter('val', $options['model']);
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'model' => 1
        ]);
        $resolver->setAllowedTypes('model','int');
    }
}
