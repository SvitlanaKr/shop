<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Entity\User;
use App\Entity\Payment;
use App\Entity\Delivery;
use App\Entity\OrderProduct;
use App\Entity\Product;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/order")
 */
class OrderController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="order_index", methods={"GET"})
     */
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('order/index.html.twig', [
            'orders' => $orderRepository->findAll(),
        ]);
    }

    /** 
     * @Route("/create", name="create", methods={"POST"})
     */
    public function create(Request $request): Response {
        $content = json_decode($request->getContent(), true);

        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : array());
        }

        $order = new Order();
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $request->request->get('user_id')]);
        $payment = $this->entityManager->getRepository(Payment::class)->findOneBy(['id' => $request->request->get('payment_id')]);
        $delivery = $this->entityManager->getRepository(Delivery::class)->findOneBy(['id' => $request->request->get('delivery_id')]);
        $products = $request->request->get('products');

        $order->setUser($user);
        $order->setPayment($payment);
        $order->setDelivery($delivery);
        $order->setStatus($request->request->get('status'));

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        foreach($products as $product) {
            $orderProduct = new OrderProduct();

            $orderProduct->setProduct($this->entityManager->getRepository(Product::class)->findOneBy(['id' => $product['id']]));
            $orderProduct->setCount($product['count']);
            $orderProduct->setPrice($product['price']);
            $orderProduct->setOrderBlank($order);

            $this->entityManager->persist($orderProduct);
            $this->entityManager->flush();
        }

        return new JsonResponse(
            [
                'status' => 'ok',
            ],
            JsonResponse::HTTP_CREATED
        );
    }
    /**
     * @Route("/new", name="order_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        // $order = new Order();
        // $form = $this->createForm(OrderType::class, $order);
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => 1]);
        $form = $this->createForm(OrderType::class);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $order = $form->getData();
            // Після авторизації можна записати User
            //$order->setUser($this->getUser());
            $order->setUser($user);
            //dd($order);

            $entityManager->persist($order);
            $entityManager->flush();

            return $this->redirectToRoute('order_index');
        }

        return $this->render('order/new.html.twig', [
            // 'order' => $order,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="order_show", methods={"GET"})
     */
    public function show(Order $order): Response
    {
        return $this->render('order/show.html.twig', [
            'order' => $order,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="order_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Order $order): Response
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('order_index');
        }

        return $this->render('order/edit.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="order_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Order $order): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('order_index');
    }
}
