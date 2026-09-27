<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

// Replaces account/register.php's manual password-length/confirm checks.
// plainPassword is "mapped => false" — it's never persisted directly;
// the controller hashes it and sets it on the Customer entity itself.
class CustomerRegisterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', TextType::class, [
                'label' => 'Full name',
                'constraints' => [
                    new Assert\NotBlank(message: 'Please enter your name.'),
                    new Assert\Length(min: 2, max: 100, maxMessage: 'Name is too long (max 100 characters).'),
                ],
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Assert\NotBlank(message: 'Please enter a valid email address.'),
                    new Assert\Email(message: 'Please enter a valid email address.'),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Confirm password'],
                'invalid_message' => 'Passwords do not match.',
                'constraints' => [
                    new Assert\NotBlank(message: 'Please enter a password.'),
                    new Assert\Length(min: 8, minMessage: 'Password must be at least 8 characters.'),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Customer::class]);
    }
}
