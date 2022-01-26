<?php

namespace App\Form\Type;

use App\Entity\User;
use Exception;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('roles', TextType::class, [
				'label' => 'Roles (split roles by coma ",")',
				'required' => true,

			])
			->add('email', EmailType::class, [
				'label' => 'Email',
				'required' => true,
			])
			->add('first_name', TextType::class, [
				'label' => 'First name',
				'required' => true,
			])
			->add('last_name', TextType::class, [
				'label' => 'Last name',
				'required' => true,
			])
			->add('birth', DateType::class, [
				'label' => 'Birth',
				'required' => true,
				'years' => range(2020, 1900),
				'html5' => false
			])
			->add('Save', SubmitType::class, [
				'attr' => ['class' => 'btn btn-success btn-sm']
			])
			->getForm();

		$builder->get('roles')
			->addModelTransformer(new CallbackTransformer(
				function ($roles) {
					return implode(',', $roles);
				},
				function ($rolesAsString) {
					$rolesAsArray = explode(',', $rolesAsString);
					foreach ($rolesAsArray as $item) {
						if(str_contains($item, ' '))
							throw new Exception("You must split roles by coma and no whitespace are allowed. Ex: ROLE_ADMIN, ROLE_USER.");
					}
					return $rolesAsArray;
				}
			));
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => User::class,
		]);
	}
}
