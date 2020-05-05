<?php

namespace App\Form;

use App\Entity\Order;
use App\Entity\Payment;
use App\Entity\Delivery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityManagerInterface;


class OrderType extends AbstractType
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $payments = $this->entityManager->getRepository(Payment::class)->findAll();
        // $paymentTypes = [];
        // foreach ($payments as $payment) {
        //     $paymentTypes[] = $payment->getType();  
        // }
       
        $deliveries = $this->entityManager->getRepository(Delivery::class)->findAll();
        // $deliveryNames = [];
        // foreach ($deliveries as $delivery){
        //     $deliveryNames[] = $delivery->getName();
        // }
        $builder
           ->add('payment', ChoiceType::class,[
            'choices' => $payments,
            ]
            )
            ->add('delivery', ChoiceType::class,[
                'choices' => $deliveries,
                'choice_name' => 'name',
                ])  
            ->add('description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
