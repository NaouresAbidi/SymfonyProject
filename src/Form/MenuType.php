<?php

namespace App\Form;

use App\Entity\Menu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Menu Name',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
            ])
            ->add('regularPrice', NumberType::class, [
                'label' => 'Regular Price',
            ])
            ->add('dealPercentage', NumberType::class, [
                'label' => 'Deal Percentage',
            ])
            ->add('dealPrice', NumberType::class, [
                'label' => 'Deal Price',
            ])
            ->add('quantityStock', NumberType::class, [
                'label' => 'Quantity in Stock',
            ])
            ->add('image', FileType::class, [
                'label' => 'Menu Image (JPG or PNG)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file (JPEG or PNG).',
                    ])
                ],
            ])
            ->add('items', CollectionType::class, [
                'entry_type' => TextType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => 'Items',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}
