<?php
use TPWeb\TargetPay\TargetPay;
use \TPWeb\TargetPay\Transaction\IVR;

class IVRGermanyTest extends \PHPUnit_Framework_TestCase
{
    private $config = ['klantcode' => 'xxx', 'layoutcode' => 'xxx', 'test' => true, 'debug' => false];
    
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testAmount199PM()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR(IVR::GERMANY, 1.99), $this->config);
        $this->assertEquals(1.99, $targetPay->transaction->getAmount());
        $this->assertEquals("PM", $targetPay->transaction->getMode());
        $this->assertEquals(60, $targetPay->transaction->getDuration());
        $targetPay->transaction->calculateAmount();
        $this->assertEquals(1.99, $targetPay->transaction->getAmount());
    }
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\AmountException
     */
    public function testMinimumAmountAmountIsLower()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $this->config);
        $targetPay->transaction->setCountry(IVR::GERMANY);
        $targetPay->transaction->setAmount(1.49);
    }
    
    /**
     * @expectedException TPWeb\TargetPay\Exception\AmountException
     */
    public function testMaximumAmountAmountIsHiger()
    {
        $targetPay = new TargetPay(new \TPWeb\TargetPay\Transaction\IVR, $this->config);
        $targetPay->transaction->setCountry(IVR::GERMANY);
        $targetPay->transaction->setAmount(20.01);
    }
}