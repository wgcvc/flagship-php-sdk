<?php

declare(strict_types=1);

namespace Wcomnisky\Flagship\UnitTests;

use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Wcomnisky\Flagship\Context\ContextInterface;
use Wcomnisky\Flagship\Flagship;

class FlagshipTest extends TestCase
{
    private const ENV_ID = 'cj12clb73ggr1p9ie64h';

    /**
     * @covers Wcomnisky\Flagship\Flagship::__construct
     */
    public function test_successful_new_instance()
    {
        $flagship = new Flagship(self::ENV_ID, $this->createMock(HttpClientInterface::class));
        $this->assertInstanceOf(Flagship::class, $flagship);
    }

    /**
     * @covers Wcomnisky\Flagship\Flagship::__construct
     */
    public function test_new_instance_with_empty_environmentId_should_throw_exception()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Flagship('', $this->createMock(HttpClientInterface::class));
    }

    /**
     * @covers \Wcomnisky\Flagship\Flagship::requestSingleCampaign
     * @covers \Wcomnisky\Flagship\Flagship::__construct
     * @covers \Wcomnisky\Flagship\Flagship::getSingleCampaignUrl
     * @covers \Wcomnisky\Flagship\Flagship::replaceNamedParameter
     * @uses \Wcomnisky\Flagship\Api\RequestParameters::getMode()
     * @uses \Wcomnisky\Flagship\Api\RequestParameters::isTriggerHitEnabled()
     * @uses \Wcomnisky\Flagship\Api\RequestParameters::getDecisionGroup()
     */
    public function test_successful_requestSingleCampaign_with_no_request_parameters()
    {
        $httpClient = $this->createMock(HttpClientInterface::class);
        $context = $this->createMock(ContextInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $environmentId = 'my_environment_id';
        $visitorId = 'my_visitor_id';
        $campaignId = 'my_campaign_id';

        $httpClient->expects($this->once())
            ->method('request')
             ->with(
                 $this->identicalTo('POST'),
                 $this->identicalTo("https://decision-api.flagship.io/v1/{$environmentId}/campaigns/{$campaignId}"),
                 $this->callback(function ($options) use ($visitorId) {
                    $expectedOptions = [
                        'json' => [
                            'visitor_id' => $visitorId,
                            'context' => [],
                            'decision_group' => null,
                            'format_response' => true,
                            'trigger_hit' => true
                        ]
                    ];

                    return $options === $expectedOptions;
                 })
             )->willReturn($response);

        $flagship = new Flagship($environmentId, $httpClient);
        $returnedResponse = $flagship->requestSingleCampaign($visitorId, $campaignId, $context);
        $this->assertSame($response, $returnedResponse);
    }
}
