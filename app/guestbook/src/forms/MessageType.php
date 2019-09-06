<?php
namespace Piv\Guestbook\Src\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Piv\Guestbook\Src\Entities\Message;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('theme', TextType::class, [
                'label' => 'message.theme',
                'label_translation_parameters' => [],
                'translation_domain' => 'messages',
                'required' => true,
                'attr' => [
                    'placeholder' => 'тема сообщения',
                    'rows' => 8,
                    'cols' => 50,
                ],
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Это значение слишком короткое. Оно должно иметь 3 или более символов',
                        'max' => 150,
                        'maxMessage' => 'Это значение слишком длинное. Оно должно иметь 150 или менее символов',
                    ]),
                ],
            ])
            ->add('text', TextareaType::class, [
              'label' => 'message.text',
              'label_translation_parameters' => [],
              'translation_domain' => 'messages',
              'required' => true,
              'attr' => [
                  'placeholder' => 'текст сообщения',
                  'rows' => 8,
                  'cols' => 50,
              ],
            ])
            ->add('pictures', FileType::class, [
                'label' => 'message.add.picture',
                'label_translation_parameters' => [],
                'translation_domain' => 'messages',
                'required' => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/png',
                            'image/gif',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Допустимые типы файлов - .png, .jpeg, .gif',
                    ])
                ],
            ])
            ->add('filepath', FileType::class, [
              'label' => 'message.add.txt',
              'label_translation_parameters' => [],
              'translation_domain' => 'messages',
              'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '100k',
                        'maxSizeMessage' => 'Допустимый размер файла 100 Кб',
                        'mimeTypes' => ['text/plain'],
                        'mimeTypesMessage' => 'Допустимый тип файла - .txt',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
