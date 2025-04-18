<?php

namespace App\Form;

use App\Entity\NewCookBook;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert; // Burayı ekleyin
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class NewCookBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
            ])
            ->add('size', ChoiceType::class, [
                'choices' => [
                    '1' => 1,
                    '1.5' => 1.5,
                ],
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Görsel (PNG, JPG)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Assert\Image([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image',
                    ])
                ],
            ])
            ->add('total', TextType::class, [
                'label' => 'Maliyet',
                'attr' => ['readonly' => true],
                'required' => false,
            ])
            ->add('recommend_price', TextType::class, [
                'label' => 'Tavsiye edilen Satış Fiyatı',
                'attr' => ['readonly' => true],
                'required' => false,
            ])
            ->add('cost_percentage', TextType::class, [
                'label' => 'Cost %',
                'attr' => ['readonly' => true],
                'required' => false,
            ])
            ->add('time1')
            ->add('time2')
            ->add('time3')
            ->add('preparing')
            ->add('service')
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NewCookBook::class,
        ]);
    }
}
