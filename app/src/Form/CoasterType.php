<?php

namespace App\Form;

use App\Entity\Coaster;
use App\Entity\Category;
use App\Entity\Park;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoasterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,
        array $options
    ): void
    {
        $builder
            ->add('name')
            ->add('maxSpeed')
            ->add('length')
            ->add('maxHeight')
            ->add('operating')
            ->add('park', EntityType::class, [
                'class' => Park::class,
                'placeholder' => 'Aucun parc',
                'required' => false,
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Coaster::class,
        ]);
    }
}
