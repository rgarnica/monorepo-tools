<?php

namespace Shopsys\ShopBundle\Form\Admin\Customer;

use Shopsys\ShopBundle\Form\FormType;
use Shopsys\ShopBundle\Model\Customer\CustomerData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerFormType extends AbstractType
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_EDIT = 'edit';

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userData', UserFormType::class, [
                'scenario' => $options['scenario'],
                'domain_id' => $options['domain_id'],
            ])
            ->add('billingAddressData', BillingAddressFormType::class, [
                'domain_id' => $options['domain_id'],
            ])
            ->add('deliveryAddressData', DeliveryAddressFormType::class, [
                'domain_id' => $options['domain_id'],
            ])
            ->add('save', FormType::SUBMIT);

        if ($options['scenario'] === self::SCENARIO_CREATE) {
            $builder->add('sendRegistrationMail', FormType::CHECKBOX, ['required' => false]);
        }
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired(['scenario', 'domain_id'])
            ->setAllowedValues('scenario', [self::SCENARIO_CREATE, self::SCENARIO_EDIT])
            ->setAllowedTypes('domain_id', 'int')
            ->setDefaults([
                'data_class' => CustomerData::class,
                'attr' => ['novalidate' => 'novalidate'],
            ]);
    }
}
