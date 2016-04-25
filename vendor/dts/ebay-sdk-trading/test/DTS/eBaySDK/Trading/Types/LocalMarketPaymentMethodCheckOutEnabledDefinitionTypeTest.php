<?php

use DTS\eBaySDK\Trading\Types\LocalMarketPaymentMethodCheckOutEnabledDefinitionType;

class LocalMarketPaymentMethodCheckOutEnabledDefinitionTypeTest extends \PHPUnit_Framework_TestCase
{
    private $obj;

    protected function setUp()
    {
        $this->obj = new LocalMarketPaymentMethodCheckOutEnabledDefinitionType();
    }

    public function testCanBeCreated()
    {
        $this->assertInstanceOf('\DTS\eBaySDK\Trading\Types\LocalMarketPaymentMethodCheckOutEnabledDefinitionType', $this->obj);
    }

    public function testExtendsBaseType()
    {
        $this->assertInstanceOf('\DTS\eBaySDK\Types\BaseType', $this->obj);
    }
}
