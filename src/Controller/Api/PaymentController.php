<?php


namespace App\Controller\Api;

use App\Repository\PaymentRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class PaymentController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(path="/payments")
     * @Rest\View(serializerGroups={"payment"}, serializerEnableMaxDepthChecks=true)
     */
    public function getPayments(Request $request, PaymentRepository $paymentRepository){
        return $paymentRepository->findAll();
    }
}