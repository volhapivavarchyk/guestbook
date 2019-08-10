<?php

namespace Piv\Guestbook\App\Forms;

use Symfony\Component\Form\{AbstractType, FormBuilderInterface};
use Symfony\Component\Form\Extension\Core\Type\{TextType, EmailType, CollectionType, SubmitType};
use Symfony\Component\OptionsResolver\OptionsResolver;

use Piv\Guestbook\App\Entities\User;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->add('messages', CollectionType::class, [
                'label' => false,
                'entry_type' => MessageType::class,
                'entry_options' => ['label' => false],
                'by_reference' => false,
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Сохранить изменения',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
