<?php

namespace App\Form;

use App\Entity\Generation;
use App\Repository\GenerationRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChoicesGenerationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
//        $builder
//            ->add('generation', EntityType::class, [
//                'class' => Generation::class,
//                'placeholder' => '',
//                'attr' => ['onchange' => 'this.form.submit()'],
//                'query_builder' => function (GenerationRepository $er) use ($options) {
//                    return $er->getGenerationWithBrandModelRelation(
//                        $options['brand'], $options['model'])
//                        ;
//                    //return $er->createQueryBuilder('m')
//                    //    ->andWhere('m.model = :val')
//                    //    ->setParameter('val', $options['model']);
//                },
//            ]);

        $name = array_map(function ($object) { return $object->getName();}, $options['generation']);
        $builder
            ->add('generation',ChoiceType::class,[
                'choices' => array_combine($name,$name),
                'placeholder' => '',
                'attr' => ['onchange' => 'this.form.submit()'],
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'generation' => 1
        ]);
        $resolver->setAllowedTypes('generation','array');
    }
}