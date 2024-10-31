<?php

namespace App\Service;

/**
 * Interface for Bid Calculators.
 *
 * Defines the contract for classes that calculate
 * total bid amounts for different vehicle types.
 */
interface BidCalculatorInterface
{
    /**
     * Calculate the total bid based on the base price.
     *
     * @param float $basePrice The base price of the vehicle.
     * @return array An array containing calculated fees and total bid amount.
     */
    public function calculateTotalBid(float $basePrice): array;
}
