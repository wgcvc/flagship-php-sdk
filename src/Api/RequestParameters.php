<?php

declare(strict_types=1);

namespace Wcomnisky\Flagship\Api;

class RequestParameters
{
    /**
     * Decision Group
     *
     * If specified, visitors that matches targeting will be
     * affected to a unique variation ID per decision group
     *
     * @var string
     * @see http://developers.flagship.io/api/v1/#decision-group
     */
    private $decisionGroup;

    /**
     * Trigger Hit
     *
     * Should the visitor be affected to targeted campaigns
     *
     * @var bool
     * @see http://developers.flagship.io/api/v1/#trigger-hit
     */
    private $triggerHit = true;

    /**
     * Mode
     *
     * The mode of the response body you want to receive
     *
     * @var string Mode
     * @see http://developers.flagship.io/api/v1/#mode
     */
    private $mode = 'normal';

    /**
     * Format Response
     *
     * If set to true, the response of the API call will be formatted according to your modification
     *
     * @var bool
     * @see http://developers.flagship.io/api/v1/#run-a-single-campaign-assignment
     * @see http://developers.flagship.io/api/v1/#formatted-campaign
     */
    private $formatResponse = false;

    /**
     * Enables the Format Response
     */
    public function enableFormatResponse(): void
    {
        $this->formatResponse = true;
    }

    /**
     * Disables the Format Response
     */
    public function disableFormatResponse(): void
    {
        $this->formatResponse = false;
    }

    /**
     * Returns a bool if Format Response parameter is enabled/disabled
     *
     * @return bool
     */
    public function isFormatResponseEnabled(): bool
    {
        return $this->formatResponse;
    }

    /**
     * @param string $decisionGroup
     */
    public function setDecisionGroup(string $decisionGroup): void
    {
        $this->decisionGroup = $decisionGroup;
    }

    /**
     * @return string|null
     */
    public function getDecisionGroup(): ?string
    {
        return $this->decisionGroup;
    }

    /**
     * Enables the Trigger Hit parameter
     */
    public function enableTriggerHit(): void
    {
        $this->triggerHit = true;
    }

    /**
     * Disables the Trigger Hit parameter
     */
    public function disableTriggerHit(): void
    {
        $this->triggerHit = false;
    }

    /**
     * Returns a bool if Trigger Hit parameter is enabled/disabled
     */
    public function isTriggerHitEnabled(): bool
    {
        return $this->triggerHit;
    }


    /**
     * Defines the mode parameter to normal
     */
    public function enableModeNormal(): void
    {
        $this->mode = 'normal';
    }

    /**
     * Defines the mode parameter to simple
     */
    public function enableModeSimple(): void
    {
        $this->mode = 'simple';
    }

    /**
     * Defines the mode parameter to full
     */
    public function enableModeFull(): void
    {
        $this->mode = 'full';
    }

    /**
     * Returns the mode parameter value
     *
     * @return string
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * Returns a bool if the Mode is currently set to its default value (normal) or not
     *
     * @return bool
     */
    public function isDefaultMode(): bool
    {
        return $this->mode === 'normal';
    }
}
