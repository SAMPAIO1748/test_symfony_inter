<?php

namespace App\Form;

use App\Entity\Media;
use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('src', FileType::class, [
                'mapped' => false
                // mapped false veut dire que le traitemnt automatique ne sera pas fait, 
                // il se fera à partir du code crée dans le controller.
            ])
            ->add('alt')
            ->add('title')
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'name'
            ])
            ->add('Enregistrer', SubmitType::class);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
        ]);
    }
}
