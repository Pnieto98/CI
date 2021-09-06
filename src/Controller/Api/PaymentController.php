<?php


namespace App\Controller\Api;

use App\Entity\PaymentStatus;
use App\Repository\PaymentRepository;
use App\Repository\PaymentStatusRepository;
use Exception;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class PaymentController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(path="/payments")
     * @Rest\View(serializerGroups={"payment"}, serializerEnableMaxDepthChecks=true)
     */
    public function getPayments(
    Request $request, 
    PaymentRepository $paymentRepository)
    {

        #I search if any of these parameters is not null
        $array_paramters = ['company', 'payment_date_from', 'payment_date_until'];

        #possible values
        $array_query_values = [];
        try {
            #I loop through the vector with possible query values
            foreach ($array_paramters as $name) {
                if ($request->query->get($name) != null) {
                    $array_query_values[$name] = $request->query->get($name); # push parameters with their values ​​into this array
                }
            }
            #Set data to response 
            $data = count($array_query_values) > 0 ? $paymentRepository->findPaymentBySomeField($array_query_values, $array_paramters) : $paymentRepository->findAll();

            #Array response
            $response = [
                'total_items' => count($data),
                'data' => $data
            ];
        } catch (Exception $e) {
            dd("Error, message: $e->getMessage()\nLine: $e->getLine()");
        }
        return $response;
    }
    /**
     * @Rest\Patch(path="/payments/{id}")
     * @Rest\View(serializerGroups={"payment"}, serializerEnableMaxDepthChecks=true)
     */
    public function updatePayment(
    int $id, 
    Request $request,
    PaymentRepository $paymentRepository,
    PaymentStatusRepository $paymentStatusRepository)
    {
        #Decode request
        $obj = json_decode($request->getContent());

        #Var response 
        $response = null;
        if (isset($obj->status)) {
            $payment_status = $paymentStatusRepository->findOneBy(["status" => $obj->status]);
            if (
                $payment_status != null
            ) {
                $payment = $paymentRepository->find($id);
                if (
                    $payment != null
                ) {
                    $response =  $payment->setPaymentStatus($payment_status);
                } else {
                    $response = [
                        "status" => 405,
                        "message" => "payment id: {$id} not found."
                    ];
                }
            } else {
                $response = [
                    "status" => 405,
                    "message" => "payment_status  {$obj->status} not found."
                ];
            }
        } else {
            $response = [
                "status" => 500,
                "message" => "request not found."
            ];
        }
        return $response;
    }
}