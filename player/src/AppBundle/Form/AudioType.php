<?php

namespace AppBundle\Form;

use AppBundle\AppBundle;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Tests\Form\DataTransformer\CollectionToArrayTransformerTest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class AudioType extends AbstractType
{
    public static $TYPE_CREATE = 0x01;
    public static $TYPE_UPDATE = 0x10;
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if( ($options['form_type'] & AudioType::$TYPE_CREATE) == AudioType::$TYPE_CREATE)
        {
            $builder
                ->add('audioFile', FileType::class)
            ;
        }

        if( ($options['form_type'] & AudioType::$TYPE_UPDATE) == AudioType::$TYPE_UPDATE)
        {
            $builder
                ->add('name')
                ->add('playlists', EntityType::class, array(
                    'class' => 'AppBundle:Playlist',
                    'choice_label' => 'name',
                    'multiple' => true,
                    'expanded' => true,
                    'required' => false,
                    'by_reference' => false,
                    'choices' => $options['user']->getPlaylists()
                ))
            ;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Audio',
            'form_type' => AudioType::$TYPE_CREATE,
            'user' => null
        ));

        $resolver->setRequired('user');
        $resolver->setAllowedTypes('user', User::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_audio';
    }
}
