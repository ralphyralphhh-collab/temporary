<?php

namespace App\Form;

use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ReviewFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reviewerName', TextType::class, [
                'label' => 'Your name',
                'constraints' => [
                    new Assert\NotBlank(message: 'Please enter your name.'),
                    new Assert\Length(min: 2, max: 100, maxMessage: 'Name is too long (max 100 characters).'),
                ],
            ])
            ->add('rating', ChoiceType::class, [
                'choices' => [
                    '★★★★★' => 5,
                    '★★★★☆' => 4,
                    '★★★☆☆' => 3,
                    '★★☆☆☆' => 2,
                    '★☆☆☆☆' => 1,
                ],
            ])
            ->add('reviewText', TextareaType::class, [
                'label' => 'Write a review',
                'constraints' => [
                    new Assert\NotBlank(message: 'Please write a review.'),
                    new Assert\Length(min: 5, max: 2000, maxMessage: 'Review is too long (max 2000 characters).'),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Review::class]);
    }
}
