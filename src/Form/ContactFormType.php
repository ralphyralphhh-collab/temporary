<?php

namespace App\Form;

use App\Entity\ContactMessage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(message: 'Please enter your name.'),
                    new Assert\Length(min: 2, max: 100, maxMessage: 'Name is too long (max 100 characters).'),
                ],
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Assert\NotBlank(message: 'Please enter your email address.'),
                    new Assert\Email(message: 'Please enter a valid email address.'),
                ],
            ])
            ->add('message', TextareaType::class, [
                'constraints' => [
                    new Assert\NotBlank(message: 'Please enter a message.'),
                    new Assert\Length(min: 5, max: 5000, maxMessage: 'Message is too long (max 5000 characters).'),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => ContactMessage::class]);
    }
}
