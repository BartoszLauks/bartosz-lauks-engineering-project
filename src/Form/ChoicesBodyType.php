<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChoicesBodyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $name = array_map(function ($object) { return $object->getName(); }, $options['body']);
        $builder
            ->add('body', ChoiceType::class, [
                'label' => "Select body car : ",
                'choices' => array_combine($name, $name),
                'placeholder' => '',
                'attr' => ['onchange' => 'this.form.submit()'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'body'=> 1
        ]);
        $resolver->setAllowedTypes('body','array');
    }
}
