<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Unique;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
                'constraints' => [
                    new Unique([
                        'groups' =>'string',
            'message' => 'Il existe déjà un compte avec cette email',
        ])
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'required' => true,
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Veuillez accepter les conditions.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'required' => true,
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe.',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => '* Format incorrect : votre mot de passe doit contenir au minimum 6 caractères avec au moins 1 majuscule, 1 minusculte, 1 chiffre et 1 caractère spécial.',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    new Regex(array(
                 'pattern'   => '^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})^',
                'match'     => true,
                'message'   => '* Format incorrect : votre mot de passe doit contenir au minimum 6 caractères avec au moins 1 majuscule, 1 minusculte, 1 chiffre et 1 caractère spécial.'
            ))
                ],
            ])
            ->add('firstName', null, [
                'required' => true,
            ])
            ->add('lastName', null, [
                'required' => true,
            ])
            ->add('phoneNumber', TelType::class, [
                'required' => true,
                'constraints' => [
 new Regex(
                    array(
                        'pattern' => '^(0|(\\+33)|(0033))[1-9][0-9]{8}^',
                        'match' => true,
                        'message' => 'Numéro de téléphone incorrect'
                    )
                )
                ]
               
            ])
            ->add('school', null, [
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}