<?php

namespace Piv\Guestbook\App\Forms;

use Symfony\Component\Form\{AbstractType, FormBuilderInterface};
use Symfony\Component\Form\Extension\Core\Type\{DateType, SubmitType, TextType, TextareaType, CollectionType, FileType};
use Symfony\Component\OptionsResolver\OptionsResolver;

use Piv\Guestbook\App\Entities\Message;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('theme', TextType::class)
            ->add('text', TextareaType::class)
            ->add('pictures', FileType::class)
            ->add('filepath', FileType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
