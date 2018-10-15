<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('localisation', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'La situation geographique'
                ]
            ])
            ->add('contact1', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Le contact telephonique 1'
                ]
            ])
            ->add('contact2', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Le contact telephonique 2'
                ]
            ])
            ->add('email1', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Adresse Email 1'
                ]
            ])
            ->add('email2', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Adresse Email 2'
                ]
            ])
            ->add('statut', CheckboxType::class,[
                'required' => 'form-control'
            ])
            //->add('slug')->add('publiePar')->add('modifiePar')->add('publieLe')->add('modifieLe')
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Contact'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_contact';
    }


}
