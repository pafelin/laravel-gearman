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
     * @param string|null $queue
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
     * @return \Illuminate\Queue\Jobs\Job|\Illuminate\Queue\null|GearmanJob
     */
    public function pop($queue = null)
    {
        if(!$queue) {
            $queue = $this->queue;
        }

        return new GearmanJob($this->container, $this->worker, $queue);
    }

	/**
	 * Push a raw payload onto the queue.
	 *
	 * @param  string $payload
	 * @param  string $queue
	 * @param  array $options
	 * @throws \Exception
	 * @return mixed
	 */
	public function pushRaw($payload, $queue = null, array $options = array())
	{

		throw new Exception('Gearman driver do not support the method pushRaw');
	}

}