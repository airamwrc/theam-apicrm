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
        $customers = $repository->findBy(array('deleted' => false));

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
            $user = $this->getUser();
            $customer->setCreator($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            return $this->handleView($this->view(['success' => true], Response::HTTP_CREATED));
        }

        return $this->handleView($this->view($form->getErrors()));
    }

    /**
     * Update Customer.
     * @Rest\Put("/customer/{id}")
     *
     * @return Response
     */
    public function putCustomerAction(Request $request, $id)
    {
        $customerRepo = $this->getDoctrine()
            ->getRepository(Customer::class);

        $customer = $customerRepo->find($id);

        if (!$customer) {
            return $this->handleView($this->view(['success' => false, 'msg' => 'No customer found for id '. $id]));
        }

        $form = $this->createForm(CustomerType::class, $customer);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $customer->setLastEditor($user);

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->handleView($this->view(['success' => true], Response::HTTP_OK));
        }

        return $this->handleView($this->view($form->getErrors()));
    }

    /**
     * Delete Customer.
     * @Rest\Delete("/customer/{id}")
     *
     * @return Response
     */
    public function deleteCustomerAction(Request $request, $id)
    {
        $customerRepo = $this->getDoctrine()
            ->getRepository(Customer::class);

        $customer = $customerRepo->find($id);

        if (!$customer) {
            return $this->handleView($this->view(['success' => false, 'msg' => 'No customer found for id '. $id]));
        }

        $user = $this->getUser();
        $customer->setLastEditor($user);
        $customer->setDeleted(true);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->handleView($this->view(['success' => true], Response::HTTP_OK));
    }
}