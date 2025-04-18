<?php

namespace App\Form;

use App\Entity\LogIn;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'label' => 'İsim', // Burada etiketin adını değiştiriyoruz
        ])
        ->add('lname', TextType::class, [
            'label' => 'Soyisim', // Burada etiketin adını değiştiriyoruz
        ])
        ->add('password', PasswordType::class, [
            'label' => 'Şifre', // Burada etiketin adını değiştiriyoruz
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LogIn::class,
        ]);
    }
}
