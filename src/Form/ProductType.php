<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder 
            ->add('name', TextType::class, ['label' => 'Nome do Produto: '])
            ->add('price', TextType::class, ['label' => 'Valor: '])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'description',
                'label' => 'Categoria: '
            ])
            ->add('Salvar', SubmitType::class);
    }
}
