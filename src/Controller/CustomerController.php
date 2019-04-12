<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class CustomerController extends AbstractController
{
    /**
     * @Route("/customer", name="customer_list", methods={"GET"})
     */
    public function list(CustomerRepository $customerRepository): JsonResponse
    {
        $customers = $customerRepository->findBy(array('deleted' => false));

        return new JsonResponse($customers);
    }

    /**
     * @Route("/customer", name="customer_create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $customer = new Customer();

        $form = $this->createForm(CustomerType::class, $customer);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $customer->setCreator($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($customer);
            $entityManager->flush();

            return new JsonResponse(['success' => true], Response::HTTP_CREATED);
        }

        return new JsonResponse(['success' => false, 'errors' => $form->getErrors()], Response::HTTP_OK);
    }

    /**
     * @Route("/customer/{id}", name="customer_update", methods={"PUT"})
     */
    public function update(Request $request, $id, CustomerRepository $customerRepository): JsonResponse
    {
        $customer = $customerRepository->find($id);

        if (!$this->isValidCustomer($customer)) {
            return new JsonResponse(['success' => false, 'msg' => 'No customer found for id '. $id]);
        }

        $form = $this->createForm(CustomerType::class, $customer);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $customer->setLastEditor($user);

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return new JsonResponse(['success' => true], Response::HTTP_OK);
        }

        return new JsonResponse(['success' => false, 'errors' => $form->getErrors()], Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="customer_delete", methods={"DELETE"})
     */
    public function delete(Request $request, $id, CustomerRepository $customerRepository): JsonResponse
    {
        $customer = $customerRepository->find($id);

        if (!$this->isValidCustomer($customer)) {
            return new JsonResponse(['success' => false, 'msg' => 'No customer found for id '. $id]);
        }

        $user = $this->getUser();
        $customer->setLastEditor($user);
        $customer->setDeleted(true);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->handleView($this->view(['success' => true], Response::HTTP_OK));
    }

    private function isValidCustomer($customer): ?bool
    {
        return ($customer instanceof Customer) && !$customer->getDeleted();
    }
}
