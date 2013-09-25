<?php

namespace Pafelin\Gearman;

use \GearmanClient;
use \GearmanWorker;
use Illuminate\Queue\Queue;
use Illuminate\Queue\QueueInterface;
use \Exception;
use Pafelin\Gearman\Jobs\GearmanJob;

class GearmanQueue extends Queue implements QueueInterface
{

    protected $worker;
    protected $client;
    protected $queue;

    public function __construct(GearmanClient $client, GearmanWorker $worker, $queue)
    {
        $this->client = $client;
        $this->worker = $worker;
        $this->queue = $queue;
    }

    /**
     * Push job to the queue
     *
     * @param string $job
     * @param string $data
     * @param strin|null $queue
     * @return int|mixed Return gearman code
     */
    public function push($job, $data = '', $queue = null)
    {
        if(!$queue) {
            $queue = $this->queue;
        }
        $payload = $this->createPayload($job, $data);

        $this->client->doBackground($queue, $payload);

        return $this->client->returnCode();
    }

    public function later($delay, $job, $data = '', $queue = null)
    {
        throw new Exception('Gearman driver do not support the method later');
    }

    /**
     * take a job from the queue
     *
     * @param null $queue
     * @return \Illuminate\Queue\Jobs\Job|\Illuminate\Queue\nul|GearmanJob
     */
    public function pop($queue = null)
    {
        if(!$queue) {
            $queue = $this->queue;
        }

        $geramanJob = new GearmanJob($this->container, $this->worker);

        $this->worker->addFunction($queue, array($geramanJob,'onGearmanJob'));

        return $geramanJob;
    }
}