<?php

namespace VSS\Forms;

use VSS\Entities\Product;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class BasketForm extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('products', EntityType::class, [
				'class' => Product::class,
				'choice_label' => function (Product $product) {
					return $product->getName() . ' (' . $product->getPrice() . ' €)';
				},
				'multiple' => true,
				'expanded' => true,
				'label' => 'Out Products:'
			])
			->add('vat_id', TextType::class, ['label' => 'Please enter your VAT ID:', 'attr' => ['placeholder' => 'CCXXXXXXXXXxx'],])
			->add('calculate', SubmitType::class, ['label' => 'Calculate Final Price'])
		;
	}
}