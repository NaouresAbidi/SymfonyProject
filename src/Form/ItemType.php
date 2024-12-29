<?php

namespace App\Form;

use App\Entity\Item;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('price', NumberType::class, [
                'label' => 'Price',
                'attr' => [
                    'step' => 'any',  // This allows decimal values
                ],
            ])
            // Replacing the TextType for image path with FileType for file upload
            ->add('imagepath', FileType::class, [
                'label' => 'Item Image (JPEG, PNG)',
                'mapped' => false,  // We won't map this field to the entity directly
                'required' => false,  // Optional field
            ])
            ->add('quantityStock', IntegerType::class, [
                'label' => 'Quantity in Stock',
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
            ])
            ->add('name', TextType::class, [
                'label' => 'Name',
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Category',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Save',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}

