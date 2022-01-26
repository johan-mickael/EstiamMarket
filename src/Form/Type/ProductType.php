<?php

namespace App\Form\Type;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('label', TextType::class, [
				'label' => 'Name',
				'required' => true,
			])
			->add('description', TextareaType::class, [
				'label' => 'Description'
			])
			->add('htprice', MoneyType::class, [
				'required' => true,
				'label' => 'HT price',
				'html5' => true
			])
			->add('vat', NumberType::class, [
				'required' => true,
				'label' => 'VAT',
				'html5' => true,
				'attr' => [
					'min' => 0,
					'max' => 100
				]
			])
			->add('quantity', NumberType::class, [
				'label' => 'Quantity',
				'html5' => true,
				'attr' => [
					'min' => 0
				]
			])
			->add('reference', TextType::class, [
				'label' => 'Reference'
			])
			->add('categories', EntityType::class, [
				'class' => Category::class,
				'choice_label' => 'label',
				'multiple' => true,
				'required' => true,
			])
			->add('Save', SubmitType::class, [
				'attr' => ['class' => 'btn btn-success btn-sm']
			])
			->getForm();
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => Product::class,
		]);
	}
}
