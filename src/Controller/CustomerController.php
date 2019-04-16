<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
use App\Form\CustomerPhotoType;
use App\Repository\CustomerRepository;
use App\Service\CustomerPhotoManager;
use App\Service\CustomerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v{version}", name="api_", requirements={"version"="%apiVersionsAvailable%"})
 */
class CustomerController extends AbstractController
{
    /**
     * @Route("/customer", name="customer_list", methods={"GET"})
     */
    public function list(CustomerRepository $customerRepository, CustomerService $customerService): JsonResponse
    {
        $customers = $customerRepository->findBy(array('deleted' => false));
        $customerService->completeSerializableData($customers);

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
            $customer->setLastEditor($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($customer);
            $entityManager->flush();

            return new JsonResponse(['success' => true, 'customerId' => $customer->getId()], Response::HTTP_CREATED);
        }

        return $this->createResponseWithFormErrors($form);
    }

    /**
     * @Route("/customer/photo/{id}", name="customer_upload_photo", methods={"POST"})
     */
    public function uploadPhoto(Request $request, $id, CustomerRepository $customerRepository, CustomerPhotoManager $fileManager): JsonResponse
    {
        $customer = $customerRepository->find($id);

        if (!$this->isValidCustomer($customer)) {
            return $this->createCustomerNotFoundResponse();
        }

        $form = $this->createForm(CustomerPhotoType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $customer->setLastEditor($user);

            $file = $customer->getImageFile();
            $fileName = $fileManager->uploadAndRemoveOld($file, $customer);

            $customer->setPhoto($fileName);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($customer);
            $entityManager->flush();

            return new JsonResponse(['success' => true], Response::HTTP_CREATED);
        }

        return $this->createResponseWithFormErrors($form);
    }

    /**
     * @Route("/customer/photo/{id}", name="customer_get_photo", methods={"GET"})
     */
    public function getPhoto(Request $request, $id, CustomerRepository $customerRepository, CustomerPhotoManager $fileManager): Response
    {
        $customer = $customerRepository->find($id);

        if (!$this->isValidCustomer($customer)) {
            return $this->createCustomerNotFoundResponse();
        }

        $photoName = $customer->getPhoto();

        if (!$photoName) {
            return new JsonResponse(['success' => false, 'errors' => 'No photo found']);
        }

        $fileContent = $fileManager->getFileContents($photoName);
        $mimeType = $fileManager->getMimeType($photoName);

        $response = new Response($fileContent);
        $response->headers->set('Content-Type', $mimeType);

        return $response;
    }

    /**
     * @Route("/customer/{id}", name="customer_update", methods={"PUT"})
     */
    public function update(Request $request, $id, CustomerRepository $customerRepository): JsonResponse
    {
        $customer = $customerRepository->find($id);

        if (!$this->isValidCustomer($customer)) {
            return $this->createCustomerNotFoundResponse();
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

        return $this->createResponseWithFormErrors($form);
    }

    /**
     * @Route("/customer/{id}", name="customer_delete", methods={"DELETE"})
     */
    public function delete(Request $request, $id, CustomerRepository $customerRepository): JsonResponse
    {
        $customer = $customerRepository->find($id);

        if (!$this->isValidCustomer($customer)) {
            return $this->createCustomerNotFoundResponse();
        }

        $user = $this->getUser();
        $customer->setLastEditor($user);
        $customer->setDeleted(true);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return new JsonResponse(['success' => true], Response::HTTP_OK);
    }

    private function isValidCustomer($customer): ?bool
    {
        return ($customer instanceof Customer) && !$customer->getDeleted();
    }

    private function createCustomerNotFoundResponse(): JsonResponse
    {
        return new JsonResponse(['success' => false, 'errors' => 'Customer not found'], Response::HTTP_NOT_FOUND);
    }

    private function createResponseWithFormErrors($form): JsonResponse
    {
        $formErrors = $form->getErrors(true)->__toString();
        return new JsonResponse(['success' => false, 'errors' => $formErrors], Response::HTTP_OK);
    }
}
