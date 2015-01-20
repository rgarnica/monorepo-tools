<?php

namespace SS6\ShopBundle\Form\Admin\Vat;

use SS6\ShopBundle\Model\Pricing\Vat\VatData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints;

class VatFormType extends AbstractType {

	/**
	 * @return string
	 */
	public function getName() {
		return 'vat';
	}

	/**
	 * @param \Symfony\Component\Form\FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add('name', 'text', [
				'required' => false,
				'constraints' => [
					new Constraints\NotBlank(['message' => 'Vyplňte prosím název dph']),
					new Constraints\Length(['max' => 50, 'maxMessage' => 'Název DPH nesmí být delší než {{ limit }} znaků']),
				],
			])
			->add('percent', 'number', [
				'required' => false,
				'precision' => 4,
				'invalid_message' => 'Prosím zadejte DPH v platném formátu',
				'constraints' => [
					new Constraints\NotBlank(['message' => 'Vyplňte prosím výši dph']),
				],
			]);
	}

	/**
	 * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults([
			'data_class' => VatData::class,
			'attr' => ['novalidate' => 'novalidate'],
		]);
	}

}
