<?php

namespace CD\LouvreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TicketDescriptionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('visitorLastName',TextType::class,array(
			'label' => 'Nom'
		))
			->add('visitorFirstName',TextType::class,array(
				'label' => 'Prénom'
			))
			->add('visitorBirthDate',BirthdayType::class,array(
				'label' => 'Date de naissance ',
				'years'     => range(1900, date('Y')),
				'format' => 'dd-MM-yyyy',
			))
			->add('visitorCountry',CountryType::class,array(
				'label' => 'Pays',
				'preferred_choices' => array(
					'France' => 'FR'
				)
			))
			->add('reducedPrice',CheckboxType::class,array(
				'label' => 'Tarif réduit (un justificatif pourra être demandé)',
				'required' => false ))
		;

    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CD\LouvreBundle\Entity\TicketDescription'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'cd_louvrebundle_ticketdescription';
    }
}
