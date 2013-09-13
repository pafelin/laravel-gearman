<?php

namespace Pafelin\Gearman;

use \GearmanClient;
use Illuminate\Queue\Queue;
use Illuminate\Queue\QueueInterface;
use \Exception;

class GearmanQueue extends Queue implements QueueInterface
{

    protected $gearman;

    public function __construct(GearmanClient $gearman)
    {
        $this->gearman = $gearman;
    }

    public function push($job, $data = '', $queue = null)
    {
        if($queue !== null) {
            throw new Exception('Gearman provider do not support different queues');
        }

        $payload = $this->createPayload($job, $data);

        return $this->gearman->doBackground($job, $payload);
    }

    public function later($delay, $job, $data = '', $queue = null)
    {
        throw new Exception('Gearman driver do not support the method later');
    }

    public function pop($queue = null)
    {
        throw new Exception('Gearman driver do not support the method pop');
    }
}