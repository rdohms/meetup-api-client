<?php

namespace DMS\Service\Meetup\Plugin;

class RateLimitPluginProxy extends RateLimitPlugin
{
    public $slowdowns = 0;

    /**
     * Override and capture slowdowns
     */
    protected function slowdownRequests()
    {
        parent::slowdownRequests();

        $this->slowdowns++;
    }

}
