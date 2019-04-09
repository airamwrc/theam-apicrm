<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Customer;
use App\Form\CustomerType;

/**
 * Customer controller.
 * @Route("/api", name="api_")
 */
class CustomerController extends FOSRestController
{
    /**
     * Lists all Customers.
     * @Rest\Get("/customers")
     *
     * @return Response
     */
    public function getCustomerAction()
    {
        $repository = $this->getDoctrine()->getRepository(Customer::class);
        $customers = $repository->findall();
        return $this->handleView($this->view($customers));
    }

    /**
     * Create Customer.
     * @Rest\Post("/customer")
     *
     * @return Response
     */
    public function postCustomerAction(Request $request)
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();
            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }
        return $this->handleView($this->view($form->getErrors()));
    }
}