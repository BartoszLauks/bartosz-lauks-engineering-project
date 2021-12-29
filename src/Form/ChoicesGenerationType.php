<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChoicesGenerationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $name = array_map(function ($object) { return $object->getName();}, $options['generation']);
        $builder
            ->add('generation',ChoiceType::class,[
                'label' => "Select generation : ",
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
