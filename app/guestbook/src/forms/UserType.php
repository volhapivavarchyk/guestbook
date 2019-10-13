<?php
namespace Piv\Guestbook\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Piv\Guestbook\Entity\User;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'user.name',
                'translation_domain' => 'messages',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Иван Иванов',
                ],
                'constraints' => [
                  new Length([
                      'min' => 3,
                      'minMessage' => 'Это значение слишком короткое. Оно должно иметь 3 или более символов',
                      'max' => 120,
                      'maxMessage' => 'Это значение слишком длинное. Оно должно иметь 120 или менее символов',
                  ]),
                    new Regex([
                        'pattern' => '/[A-Za-zА-Яа-я0-9\s]*/',
                        'match' => true,
                        'message' => 'Имя пользователя должно содержать буквы и цифры'
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'user.email',
                'label_translation_parameters' => [],
                'translation_domain' => 'messages',
                'required' => true,
                'attr' => [
                    'placeholder' => 'mailbox@hostname',
                ],
            ])
            ->add('messages', CollectionType::class, [
                'label' => 'user.message',
                'label_translation_parameters' => [],
                'translation_domain' => 'messages',
                'entry_type' => MessageType::class,
                'entry_options' => ['label' => 'сообщение'],
                'by_reference' => false,
                'prototype' => true,
                'allow_add' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Сохранить',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
