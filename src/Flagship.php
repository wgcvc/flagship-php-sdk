<?php

declare(strict_types=1);

namespace Wcomnisky\Flagship;

use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Wcomnisky\Flagship\Api\RequestParameters;
use Wcomnisky\Flagship\Context\ContextInterface;

/**
 * Class Flagship
 * @package Wcomnisky\Flagship
 * @see http://developers.flagship.io/api/v1/
 */
class Flagship
{
    private const NAMED_PARAM_ENV_ID = '%ENVIRONMENT_ID';
    private const NAMED_PARAM_CAMPAIGN_ID = '%CAMPAIGN_ID';

    private const URL_BASE = 'https://decision-api.flagship.io/v1';
    private const URL_ALL_CAMPAIGNS = self::URL_BASE . '/' . self::NAMED_PARAM_ENV_ID . '/campaigns';
    private const URL_SINGLE_CAMPAIGN = self::URL_ALL_CAMPAIGNS . '/' . self::NAMED_PARAM_CAMPAIGN_ID;

    /**
     * @var RequestParameters
     * @see http://developers.flagship.io/api/v1/#request-parameters
     */
    private $requestParameters;

    /**
     * @var string The environment ID identifies your account and environment
     */
    private $environmentId;

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * Flagship constructor
     *
     * @param string $environmentId Flagship Environment ID
     * @param HttpClientInterface $httpClient
     */
    public function __construct(string $environmentId, HttpClientInterface $httpClient)
    {
        if (empty($environmentId)) {
            throw new \InvalidArgumentException('Environment ID cannot be empty');
        }

        $this->environmentId = $environmentId;
        $this->httpClient = $httpClient;
        $this->requestParameters = new RequestParameters();
    }

    /**
     * Sets the Request Parameters
     *
     * @param RequestParameters $requestParameters
     */
    public function setRequestParameters(RequestParameters $requestParameters): void
    {
        $this->requestParameters = $requestParameters;
    }

    /**
     * @param string $visitorId ID of the visitor
     * @param string $campaignId The same as Custom ID on their docs
     * @param ContextInterface $context
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function requestSingleCampaign(
        string $visitorId,
        string $campaignId,
        ContextInterface $context
    ): ResponseInterface {

        $jsonArray = [
            'visitor_id' => $visitorId,
            'context' => $context->getList(),
            'decision_group' => $this->requestParameters->getDecisionGroup(),
            'format_response' => true, // this has to be added to the request parameters
            'trigger_hit' => $this->requestParameters->isTriggerHitEnabled()
        ];

        $response = $this->httpClient->request(
            'POST',
            $this->getSingleCampaignUrl($campaignId),
            [
                'json' => $jsonArray
            ]
        );

        return $response;
    }

    public function requestAllCampaigns(string $visitorId, ContextInterface $context): ResponseInterface
    {
        return new MockResponse();
    }

    /**
     * Replaces the named parameter (key) with its correlated value
     *
     * @param string $source
     * @param array $namedParamKVP
     * @return string
     */
    private function replaceNamedParameter(string $source, array $namedParamKVP): string
    {
        return str_replace(array_keys($namedParamKVP), array_values($namedParamKVP), $source);
    }

    private function getSingleCampaignUrl(string $campaignId): string
    {
        return $this->replaceNamedParameter(self::URL_SINGLE_CAMPAIGN, [
            self::NAMED_PARAM_ENV_ID => $this->environmentId,
            self::NAMED_PARAM_CAMPAIGN_ID => $campaignId
        ]);
    }

    private function getAllCampaignsUrl(): string
    {
        return $this->replaceNamedParameter(self::URL_ALL_CAMPAIGNS, [
            self::NAMED_PARAM_ENV_ID => $this->environmentId,
        ]);
    }
}
