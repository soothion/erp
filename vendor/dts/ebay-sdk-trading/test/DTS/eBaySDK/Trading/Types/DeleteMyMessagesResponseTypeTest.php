<?php

use DTS\eBaySDK\Trading\Types\DeleteMyMessagesResponseType;

class DeleteMyMessagesResponseTypeTest extends \PHPUnit_Framework_TestCase
{
    private $obj;

    protected function setUp()
    {
        $this->obj = new DeleteMyMessagesResponseType();
    }

    public function testCanBeCreated()
    {
        $this->assertInstanceOf('\DTS\eBaySDK\Trading\Types\DeleteMyMessagesResponseType', $this->obj);
    }

    public function testExtendsAbstractResponseType()
    {
        $this->assertInstanceOf('\DTS\eBaySDK\Trading\Types\AbstractResponseType', $this->obj);
    }
}
