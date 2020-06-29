<?php

namespace nickurt\PleskXml\Api;

class EventLog extends AbstractApi
{
    /**
     * @return mixed
     */
    public function all()
    {
        return $this->post([
            'event_log' => ['get' => []]
        ]);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function get($params)
    {
        return $this->post([
            'event_log' => ['get_events' => $params]
        ]);
    }

}
