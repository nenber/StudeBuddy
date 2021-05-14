<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Vich\UploaderBundle\Form\Type\VichImageType;


class CustomUserAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('profileImage', null, [
            //     'required' => true,
            // ])
            ->add('isGodson', CheckboxType::class, [
                'required' => false,
            ])
            ->add('isGodparent', CheckboxType::class, [
                'required' => false,
            ])
            ->add('spokenLanguage', LanguageType::class, [
                'required' => true,
                'multiple' => true
                // 'mapped'=>false,
            ])
            ->add('languageToLearn', LanguageType::class, [
                'required' => true,
                'multiple' => true
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_label' => false,
                'image_uri' => false,
            ]);


        // $builder->get('spokenLanguage')
        //     ->addModelTransformer(new CallbackTransformer(
        //         function ($tagsAsArray) {
        //             // transform the array to a string
        //             return implode(', ', $tagsAsArray);
        //         },
        //         function ($tagsAsString) {
        //             // transform the string back to an array
        //             return explode(', ', $tagsAsString);
        //         }
        //     ));

        // $builder->get('languageToLearn')
        //     ->addModelTransformer(new CallbackTransformer(
        //         function ($tagsAsArray) {
        //             // transform the array to a string
        //             return implode(', ', $tagsAsArray);
        //         },
        //         function ($tagsAsString) {
        //             // transform the string back to an array
        //             return explode(', ', $tagsAsString);
        //         }
        //     ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
