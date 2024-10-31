<?php

namespace App\Service;

/**
 * CommonBidCalculator class
 *
 * Calculates bid details for common vehicles.
 */
class CommonBidCalculator extends BaseBidCalculator
{
    /**
     * Defines the buyer fee limits for common vehicles.
     *
     * @return array Array with minimum and maximum fee limits.
     */
    protected function getBasicBuyerFeeLimits(): array
    {
        return [10, 50];
    }

    /**
     * Defines the seller special fee rate for common vehicles.
     *
     * @return float The seller special fee rate.
     */
    protected function getSellerSpecialFeeRate(): float
    {
        return 0.02;
    }
}
