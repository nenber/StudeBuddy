<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'required' => true
            ])
            ->add('address', null, [
                'required' => true
            ])
            ->add('description', null, [
                'required' => true
            ])
            ->add('date', DateType::class, [
                'required' => true,
                'data'   => new \DateTime(),
                'attr'   => ['min' => ( new \DateTime("now") )->format('Y-m-d H:i:s')]
            ])
            // ->add('marker_id')
            // ->add('organizer_id')
            // ->add('participant_id')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
            'csrf_protection' => true,
        ]);
    }
}
