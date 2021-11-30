<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Model;
use App\Repository\BrandRepository;
use App\Repository\ModelRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChoicesModelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('model', EntityType::class, [
                'class' => Model::class,
                'placeholder' => '',
                'attr' => ['onchange' => 'this.form.submit()'],
                'query_builder' => function (ModelRepository $er) use ($options) {
                    return $er->createQueryBuilder('m')
                        ->andWhere('m.brand = :val')
                        ->setParameter('val', $options['brand']);
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'brand' => 1
        ]);
        $resolver->setAllowedTypes('brand','int');
    }
}
