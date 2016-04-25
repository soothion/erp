<?php

use DTS\eBaySDK\Trading\Enums\CommentTypeCodeType;

class CommentTypeCodeTypeTest extends \PHPUnit_Framework_TestCase
{
    private $obj;

    protected function setUp()
    {
        $this->obj = new CommentTypeCodeType();
    }

    public function testCanBeCreated()
    {
        $this->assertInstanceOf('\DTS\eBaySDK\Trading\Enums\CommentTypeCodeType', $this->obj);
    }
}
