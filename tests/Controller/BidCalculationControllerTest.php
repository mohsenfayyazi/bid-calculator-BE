<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BidCalculationControllerTest extends WebTestCase
{
    public function testCalculateBidWithCommonVehicle()
    {
        $client = static::createClient();

        $client->request('POST', '/api/calculate-bid', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'basePrice' => 398.00,
            'vehicleType' => 'Common'
        ]));

        $this->assertResponseIsSuccessful();
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('fees', $responseData);
        $this->assertEquals(39.80, $responseData['fees']['basicBuyerFee']);
        $this->assertEquals(7.96, $responseData['fees']['sellerSpecialFee']);
        $this->assertEquals(5.00, $responseData['fees']['associationFee']);
        $this->assertEquals(100.00, $responseData['fees']['storageFee']);
        $this->assertEquals(550.76, $responseData['total']);
    }

    public function testCalculateBidWithLuxuryVehicle()
    {
        $client = static::createClient();

        $client->request('POST', '/api/calculate-bid', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'basePrice' => 1800.00,
            'vehicleType' => 'Luxury'
        ]));

        $this->assertResponseIsSuccessful();
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('fees', $responseData);
        $this->assertEquals(180.00, $responseData['fees']['basicBuyerFee']);
        $this->assertEquals(72.00, $responseData['fees']['sellerSpecialFee']);
        $this->assertEquals(15.00, $responseData['fees']['associationFee']);
        $this->assertEquals(100.00, $responseData['fees']['storageFee']);
        $this->assertEquals(2167.00, $responseData['total']);
    }

    public function testCalculateBidWithInvalidVehicleType()
    {
        $client = static::createClient();

        $client->request('POST', '/api/calculate-bid', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'basePrice' => 1000.00,
            'vehicleType' => 'InvalidType'
        ]));

        $this->assertResponseStatusCodeSame(400);
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(null, $responseData['error']);
    }
}