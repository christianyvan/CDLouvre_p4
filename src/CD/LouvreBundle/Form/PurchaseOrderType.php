<?php

namespace CD\LouvreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class PurchaseOrderType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('visitType',ChoiceType::class,array(
        	'label' =>'Type de visite',
					 'choices' 	=> array(
				'Demi-journée'  => 0,
				'Journée'		=> 1
			)
		))
			->add('visitDate', TextType::class, array(
					'attr' => array('class' => 'datepicker','placeholder' => "Choisisser une date"),
					'label' => 'Date visite')

			)

			->add('numberTicketsDesired',ChoiceType::class, array(
				'label'   => 'Billets(max 5)',
				'choices'    =>array(
						'0' => 0,
						'1' => 1,
						'2' => 2,
						'3' => 3,
						'4' => 4,
						'5' => 5
					)
				))
			->add('customerEmail',EmailType::class,array(
				'required' => true))
			->add('ticketDescription', CollectionType::class, array(
				'entry_type'    => TicketDescriptionType::class,
				'allow_add'     => true,
				'allow_delete'  => false,
			))
			->add('Continuer', SubmitType::class)
		;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CD\LouvreBundle\Entity\PurchaseOrder'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'cd_louvrebundle_purchaseorder';
    }


}
