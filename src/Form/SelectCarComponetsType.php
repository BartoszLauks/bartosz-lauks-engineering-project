<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Model;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SelectCarComponetsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /*
        $builder
            ->add('brand', EntityType::class, [
                'class' => Brand::class,
                'placeholder' => 'Select a category',
            ])
        ;
        $builder->get('brand')
            ->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                dd($event);

                $form = $event->getForm();

                $form->getParent()->add('models', EntityType::class, [
                    'class' => Model::class,
                    'placeholder' => 'Select a model',
                    'choices' => $form->getData()->getModels()
                ]);
            }
        );
        */
        $builder
            ->add('brand', EntityType::class, [
                'class' => Brand::class,
                'placeholder' => 'Select a Brand',
                'attr' => ['onchange' => 'this.form.submit()'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
