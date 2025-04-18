<?php

namespace App\Form;
/*
use App\Entity\LogIn;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
*/
use App\Entity\LogIn;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class LogInType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /*
        $builder
            ->add('name')
            ->add('lname')
            ->add('password')
        ;*/

        
        $builder
        ->add('password', PasswordType::class, [
            'label' => 'Şifre', // Burada etiketin adını değiştiriyoruz
        ])
        ->add('username', TextType::class, [
            'label' => 'Kullanıcı Adı', // Burada etiketin adını değiştiriyoruz
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LogIn::class,
        ]);
    }
}
