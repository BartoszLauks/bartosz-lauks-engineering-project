<?php

namespace App\Form;

use App\Repository\EngineRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SelectCarComponetsType extends AbstractType
{
    private $engineRepository;

    public function __construct(
        EngineRepository $engineRepository
    ) {
        $this->engineRepository = $engineRepository;
    }

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
        $en = $this->engineRepository->findAll();

        $en = array_map(function ($o) { return $o->getName();}, $en);
        //dd(array_flip($en));
        $builder
            ->add('brand',ChoiceType::class,[
                'choices' => array_flip($en),

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
