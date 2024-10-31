<?php

namespace App\Service;

/**
 * Abstract class BaseBidCalculator
 *
 * Provides a base implementation for calculating vehicle bids,
 * including basic fees and storage fees, that can be extended
 * for specific vehicle types.
 */
abstract class BaseBidCalculator implements BidCalculatorInterface
{
    // Base percentage rate applied for the buyer fee
    protected const BASE_FEE_RATE = 0.10;
    // Fixed storage fee applied to all vehicles
    protected const STORAGE_FEE = 100;

    /**
     * Defines the minimum and maximum buyer fee limits
     * that each subclass should provide.
     *
     * @return array An array with two elements: minimum and maximum buyer fee limits.
     */
    abstract protected function getBasicBuyerFeeLimits(): array;

    /**
     * Defines the seller's special fee rate for specific vehicle types.
     *
     * @return float Seller's special fee rate.
     */
    abstract protected function getSellerSpecialFeeRate(): float;

    /**
     * Calculates the total bid amount, including all fees, based on the base price.
     *
     * @param float $basePrice The base price of the vehicle.
     * @return array An array containing all calculated fees and the total bid amount.
     */
    public function calculateTotalBid(float $basePrice): array
    {
        $fees = [
            'basicBuyerFee' => $this->calculateBasicBuyerFee($basePrice),
            'sellerSpecialFee' => round($basePrice * $this->getSellerSpecialFeeRate(), 2),
            'associationFee' => $this->calculateAssociationFee($basePrice),
            'storageFee' => self::STORAGE_FEE,
        ];

        $total = $basePrice + array_sum($fees);

        return ['fees' => $fees, 'total' => $total];
    }

    /**
     * Calculates the basic buyer fee based on the base price and limits.
     *
     * @param float $basePrice The base price of the vehicle.
     * @return float The calculated basic buyer fee, rounded to 2 decimal places.
     */
    private function calculateBasicBuyerFee(float $basePrice): float
    {
        [$minFee, $maxFee] = $this->getBasicBuyerFeeLimits();
        $fee = min(max($basePrice * self::BASE_FEE_RATE, $minFee), $maxFee);

        return round($fee, 2);
    }

    /**
     * Calculates the association fee based on the base price.
     *
     * @param float $basePrice The base price of the vehicle.
     * @return int The calculated association fee.
     */
    private function calculateAssociationFee(float $basePrice): int
    {
        return match (true) {
            $basePrice <= 500 => 5,
            $basePrice <= 1000 => 10,
            $basePrice <= 3000 => 15,
            default => 20,
        };
    }
}
