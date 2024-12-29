<?php

namespace App\Form;
use App\Entity\Item;
use App\Entity\Menu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
                'attr' => ['class' => 'form-control', 'id' => 'regularPrice'],
            ])
            ->add('dealPercentage', NumberType::class, [
                'attr' => ['class' => 'form-control', 'id' => 'dealPercentage'],
                'data' => 0,
            ])
            ->add('dealPrice', NumberType::class, [
                'attr' => ['class' => 'form-control', 'id' => 'dealPrice'],
            ])

            ->add('quantityStock', NumberType::class, [
                'label' => 'Quantity in Stock',
            ])
            ->add('imagepath', FileType::class, [
                'label' => 'Menu Image (JPEG, PNG)',
                'mapped' => false, // This indicates the file is not directly mapped to the entity
            ])
            ->add('items', EntityType::class, [
                'class' => Item::class,
                'choice_label' => function (Item $item) {
                    return $item->getName(); // Display item name
                },
                'multiple' => true,
                'expanded' => true, // Use checkboxes instead of a multi-select
                'label' => 'Select Items',
                'choice_attr' => function (Item $item) {
                    return [
                        'data-image' => '/uploads/items/' . basename($item->getImagepath()), // Strip leading path from getImagepath()
                        'class' => 'item-option', // Custom class for styling
                    ];
                },
            ])
        ->add('submit', SubmitType::class, [
            'label' => 'Submit',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}
