<?php

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use FOS\UserBundle\Form\Type\ProfileFormType as BaseProfileFormType;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('bio')
            ->remove('email')
            ->remove('username')
        ;
    }

    public function getParent()
    {
        return BaseProfileFormType::class;
    }

    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }
}