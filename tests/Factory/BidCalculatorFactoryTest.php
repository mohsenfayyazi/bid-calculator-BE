<?php

namespace App\Tests\Factory;

use PHPUnit\Framework\TestCase;
use App\Factory\BidCalculatorFactory;
use App\Service\CommonBidCalculator;
use App\Service\LuxuryBidCalculator;

class BidCalculatorFactoryTest extends TestCase
{
    private BidCalculatorFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new BidCalculatorFactory();
    }

    public function testCreateCommonCalculator()
    {
        $calculator = $this->factory->createCalculator('Common');
        $this->assertInstanceOf(CommonBidCalculator::class, $calculator);
    }

    public function testCreateLuxuryCalculator()
    {
        $calculator = $this->factory->createCalculator('Luxury');
        $this->assertInstanceOf(LuxuryBidCalculator::class, $calculator);
    }

    public function testInvalidVehicleType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->factory->createCalculator('InvalidType');
    }
}