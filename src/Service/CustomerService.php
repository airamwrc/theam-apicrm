<?php

namespace App\Service;

use App\Entity\Customer;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CustomerService
{
    private $router,
            $latestStableApiVersion;

    public function __construct(RouterInterface $router, $latestStableApiVersion)
    {
        $this->router = $router;
        $this->latestStableApiVersion = $latestStableApiVersion;
    }

    public function completeSerializableDataSingle(Customer $customer)
    {
        $photoUrl = '';

        if ($customer->getPhoto()) {
            $urlParams = [
                'id' => $customer->getId(),
                'version' => $this->latestStableApiVersion,
            ];
            $photoUrl = $this->router->generate('api_customer_get_photo', $urlParams, UrlGeneratorInterface::ABSOLUTE_URL);
        }

        $complementarySerializableData = [
            'photoUrl' => $photoUrl,
        ];

        $customer->addSerializableData($complementarySerializableData);
    }

    public function completeSerializableData($customers)
    {
        array_walk($customers, [$this, 'completeSerializableDataSingle']);
    }
}