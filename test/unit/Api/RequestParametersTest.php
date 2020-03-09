<?php

declare(strict_types=1);

namespace Wcomnisky\Flagship\UnitTests\Api;

use PHPUnit\Framework\TestCase;
use Wcomnisky\Flagship\Api\RequestParameters;

class RequestParametersTest extends TestCase
{
    /**
     * @covers \Wcomnisky\Flagship\Api\RequestParameters::getMode
     * @covers \Wcomnisky\Flagship\Api\RequestParameters::getDecisionGroup
     * @covers \Wcomnisky\Flagship\Api\RequestParameters::isTriggerHitEnabled
     */
    public function test_successful_new_instance()
    {
        $parameters = new RequestParameters();
        $this->assertInstanceOf(RequestParameters::class, $parameters);
        $this->assertSame('normal', $parameters->getMode());
        $this->assertSame(null, $parameters->getDecisionGroup());
        $this->assertSame(true, $parameters->isTriggerHitEnabled());
    }

    /**
     * @covers \Wcomnisky\Flagship\Api\RequestParameters::enableModeFull
     * @covers \Wcomnisky\Flagship\Api\RequestParameters::getMode
     */
    public function test_successful_enableModeFull()
    {
        $parameters = new RequestParameters();
        $parameters->enableModeFull();
        $this->assertSame('full', $parameters->getMode());
    }

    /**
     * @covers \Wcomnisky\Flagship\Api\RequestParameters::enableModeSimple
     * @covers \Wcomnisky\Flagship\Api\RequestParameters::getMode
     */
    public function test_successful_enableModeSimple()
    {
        $parameters = new RequestParameters();
        $parameters->enableModeSimple();
        $this->assertSame('simple', $parameters->getMode());
    }

    /**
     * @covers \Wcomnisky\Flagship\Api\RequestParameters::enableModeNormal
     * @covers \Wcomnisky\Flagship\Api\RequestParameters::enableModeFull
     * @covers \Wcomnisky\Flagship\Api\RequestParameters::getMode
     * @covers \Wcomnisky\Flagship\Api\RequestParameters::isDefaultMode
     */
    public function test_successful_enableModeNormal()
    {
        $parameters = new RequestParameters();
        $this->assertSame('normal', $parameters->getMode());
        $this->assertTrue($parameters->isDefaultMode());

        $parameters->enableModeFull();
        $this->assertNotSame('normal', $parameters->getMode());
        $this->assertFalse($parameters->isDefaultMode());

        $parameters->enableModeNormal();
        $this->assertSame('normal', $parameters->getMode());
        $this->assertTrue($parameters->isDefaultMode());
    }

    /**
     * @covers \Wcomnisky\Flagship\Api\RequestParameters::setDecisionGroup
     * @covers \Wcomnisky\Flagship\Api\RequestParameters::getDecisionGroup
     */
    public function test_successful_setDecisionGroup()
    {
        $parameters = new RequestParameters();
        $this->assertSame(null, $parameters->getDecisionGroup());
        $parameters->setDecisionGroup('Decision Group Name');
        $this->assertSame('Decision Group Name', $parameters->getDecisionGroup());
    }

    /**
     * @covers \Wcomnisky\Flagship\Api\RequestParameters::disableTriggerHit
     * @covers \Wcomnisky\Flagship\Api\RequestParameters::enableTriggerHit
     * @covers \Wcomnisky\Flagship\Api\RequestParameters::isTriggerHitEnabled
     */
    public function test_successful_disableTriggerHit_and_enableTriggerHit()
    {
        $parameters = new RequestParameters();
        $this->assertSame(true, $parameters->isTriggerHitEnabled());
        $parameters->disableTriggerHit();
        $this->assertSame(false, $parameters->isTriggerHitEnabled());
        $parameters->enableTriggerHit();
        $this->assertSame(true, $parameters->isTriggerHitEnabled());
    }

    /**
     * @covers \Wcomnisky\Flagship\Api\RequestParameters::disableFormatResponse
     * @covers \Wcomnisky\Flagship\Api\RequestParameters::enableFormatResponse
     * @covers \Wcomnisky\Flagship\Api\RequestParameters::isFormatResponseEnabled
     */
    public function test_successful_disableFormatResponse_and_enableFormatResponse()
    {
        $parameters = new RequestParameters();
        $this->assertSame(false, $parameters->isFormatResponseEnabled());
        $parameters->enableFormatResponse();
        $this->assertSame(true, $parameters->isFormatResponseEnabled());
        $parameters->disableFormatResponse();
        $this->assertSame(false, $parameters->isFormatResponseEnabled());
    }
}
