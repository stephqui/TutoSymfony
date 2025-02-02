<?php

namespace App\Form;

use App\Contact\ContactDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'empty_data' => ''
            ])
            ->add('mail', EmailType::class, [
                'empty_data' => ''
            ])
            ->add('message', TextareaType::class, [
                'empty_data' => ''
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Envoyer'
            ])
            ->add('service', ChoiceType::class, [
                'choices' => [
                    'Compta' => 'compta@demo.fr',
                    'Support' => 'support@demo.fr',
                    'Marketing' => 'marketing@demo.fr',
                ],
                //'multiple' => true,
                //'expanded'=> true
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactDTO::class
        ]);
    }
}
