<?php

namespace App\Service;

/**
 * LuxuryBidCalculator class
 *
 * Calculates bid details for luxury vehicles.
 */
class LuxuryBidCalculator extends BaseBidCalculator
{
    /**
     * Defines the buyer fee limits for luxury vehicles.
     *
     * @return array Array with minimum and maximum fee limits.
     */
    protected function getBasicBuyerFeeLimits(): array
    {
        return [25, 200];
    }

    /**
     * Defines the seller special fee rate for luxury vehicles.
     *
     * @return float The seller special fee rate.
     */
    protected function getSellerSpecialFeeRate(): float
    {
        return 0.04;
    }
}
