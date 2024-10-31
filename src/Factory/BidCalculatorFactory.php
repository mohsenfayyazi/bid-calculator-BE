<?php

namespace App\Factory;

use App\Service\BidCalculatorInterface;
use App\Service\CommonBidCalculator;
use App\Service\LuxuryBidCalculator;

/**
 * BidCalculatorFactory class
 *
 * A factory class responsible for creating appropriate bid calculator instances
 * based on the provided vehicle type.
 */
class BidCalculatorFactory
{
    /**
     * Creates a calculator based on the vehicle type.
     *
     * @param string $vehicleType The type of vehicle (e.g., 'Common', 'Luxury').
     * @return BidCalculatorInterface The corresponding calculator instance.
     * @throws \InvalidArgumentException if an invalid vehicle type is provided.
     */
    public function createCalculator(string $vehicleType): BidCalculatorInterface
    {
        return match ($vehicleType) {
            'Common' => new CommonBidCalculator(),
            'Luxury' => new LuxuryBidCalculator(),
            default => throw new \InvalidArgumentException("Invalid vehicle type"),
        };
    }
}
