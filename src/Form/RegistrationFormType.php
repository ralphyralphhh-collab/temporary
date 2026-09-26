<?php

namespace App\Form;

use App\Entity\Registration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

// This form replaces the manual sanitize_string/sanitize_email/sanitize_phone
// + $errors[] checks in actions/register.php. Symfony validates and
// re-displays old input + errors automatically — no flash_set()/flash_old()
// helpers needed.
class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', TextType::class, [
                'label' => 'Full name',
                'constraints' => [
                    new Assert\NotBlank(message: 'Please enter your full name.'),
                    new Assert\Length(min: 2, max: 100, minMessage: 'Name looks too short.', maxMessage: 'Name is too long (max 100 characters).'),
                ],
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Assert\NotBlank(message: 'Please enter your email address.'),
                    new Assert\Email(message: 'Please enter a valid email address.'),
                ],
            ])
            ->add('phone', TelType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\Regex(
                        pattern: '/^[0-9+()\-\s]{7,20}$/',
                        message: 'Please enter a valid contact number.',
                    ),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Registration::class]);
    }
}
