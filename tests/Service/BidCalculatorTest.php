<?php

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Service\CommonBidCalculator;
use App\Service\LuxuryBidCalculator;

class BidCalculatorTest extends TestCase
{
    /**
     * @dataProvider bidCalculationProvider
     */
    public function testCalculateTotalBid($vehicleType, $basePrice, $expectedFees, $expectedTotal)
    {
        $calculator = $vehicleType === 'Common' ? new CommonBidCalculator() : new LuxuryBidCalculator();
        $result = $calculator->calculateTotalBid($basePrice);

        $this->assertEquals($expectedFees['basicBuyerFee'], $result['fees']['basicBuyerFee']);
        $this->assertEquals($expectedFees['sellerSpecialFee'], $result['fees']['sellerSpecialFee']);
        $this->assertEquals($expectedFees['associationFee'], $result['fees']['associationFee']);
        $this->assertEquals($expectedFees['storageFee'], $result['fees']['storageFee']);
        $this->assertEquals($expectedTotal, $result['total']);
    }

    public static function bidCalculationProvider(): array
    {
        return [
            ['Common', 398.00, ['basicBuyerFee' => 39.80, 'sellerSpecialFee' => 7.96, 'associationFee' => 5.00, 'storageFee' => 100.00], 550.76],
            ['Common', 501.00, ['basicBuyerFee' => 50.00, 'sellerSpecialFee' => 10.02, 'associationFee' => 10.00, 'storageFee' => 100.00], 671.02],
            ['Luxury', 1800.00, ['basicBuyerFee' => 180.00, 'sellerSpecialFee' => 72.00, 'associationFee' => 15.00, 'storageFee' => 100.00], 2167.00],
            ['Common', 1100.00, ['basicBuyerFee' => 50.00, 'sellerSpecialFee' => 22.00, 'associationFee' => 15.00, 'storageFee' => 100.00], 1287.00],
            ['Luxury', 1000000.00, ['basicBuyerFee' => 200.00, 'sellerSpecialFee' => 40000.00, 'associationFee' => 20.00, 'storageFee' => 100.00], 1040320.00],
        ];
    }
}
