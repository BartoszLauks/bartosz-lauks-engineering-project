<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChoicesEngineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $name = array_map(function ($object) { return $object->getName(); }, $options['engine']);
        $builder
            ->add('engine',ChoiceType::class,[
                'label' => "Select engine : ",
                'choices' => array_combine($name,$name),
                'placeholder' => '',
                'attr' => ['onchange' => 'this.form.submit()'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'engine' => 1
        ]);
        $resolver->setAllowedTypes('engine','array');
    }
}
