<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType as SearchFieldType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('search', SearchFieldType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Search...',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver):void
    {
        $resolver->setDefaults([
        ]);
    }
}
