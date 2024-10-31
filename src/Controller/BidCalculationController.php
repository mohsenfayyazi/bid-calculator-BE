<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Factory\BidCalculatorFactory;
use App\Service\ValidationService;

/**
 * BidCalculationController class
 *
 * Handles API requests for calculating bid prices for vehicles.
 */
class BidCalculationController extends AbstractController
{
    private ValidationService $validationService;
    private BidCalculatorFactory $calculatorFactory;

    public function __construct(BidCalculatorFactory $calculatorFactory, ValidationService $validationService)
    {
        $this->calculatorFactory = $calculatorFactory;
        $this->validationService = $validationService;
    }

    /**
     * Calculates bid fees based on vehicle type and base price.
     *
     * @Route("/api/calculate-bid", name="calculate_bid", methods={"POST", "OPTIONS"})
     *
     * @param Request $request The HTTP request containing vehicle details.
     * @return JsonResponse The JSON response with calculated fees and total.
     */
    public function calculateBid(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return new JsonResponse(['error' => 'Invalid JSON format'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $errors = $this->validationService->validateBidData($data);
        if (count($errors) > 0) {
            return new JsonResponse(['errors' => $errors], JsonResponse::HTTP_BAD_REQUEST);
        }

        $basePrice = (float) $data['basePrice'];
        $vehicleType = $data['vehicleType'];

        try {
            $calculator = $this->calculatorFactory->createCalculator($vehicleType);
            $result = $calculator->calculateTotalBid($basePrice);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse([
            'basicFee' => $basePrice,
            'vehicleType' => $vehicleType,
            'fees' => $result['fees'],
            'total' => $result['total']
        ]);
    }
}
