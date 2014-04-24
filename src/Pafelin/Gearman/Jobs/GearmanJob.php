<?php

namespace Pafelin\Gearman\Jobs;
use Illuminate\Container\Container;
use Illuminate\Queue\Jobs\Job;
use \GearmanWorker;
use \Exception;

class GearmanJob extends Job {

    protected $worker;

    protected $job;

    protected $rawPayload = '';

    private $maxRunTime = 1;

    private $single = false;

    public function __construct(Container $container, GearmanWorker $worker, $queue)
    {
        $this->container = $container;
        $this->worker = $worker;
        $this->worker->addFunction($queue, array($this, 'onGearmanJob'));
    }

    public function fire(){

        $startTime = time();

        while($this->worker->work() || $this->worker->returnCode() == GEARMAN_TIMEOUT) {
            // Check for expiry.
            if((time() - $startTime) >= 60 * $this->maxRunTime) {
                echo sprintf('%s minutes have elapsed, expiring.', $this->maxRunTime) . PHP_EOL;
                break;
            }
        }
    }

    public function delete(){
        throw new Exception('No delete method is supported');
    }

    public function release($delay = 0) {
        throw new Exception('No delay is suported');
    }

    public function attempts() {
        throw new Exception('No attempts is suported');
    }

    public function getJobId() {
        return base64_encode($this->job);
    }

    public function getContainer() {
        return $this->container;
    }

    public function getGearmanWorker() {
        return $this->worker;
    }

    public function onGearmanJob(\GearmanJob $job) {
        $this->rawPayload = $job->workload();
        $this->resolveAndFire(json_decode($this->rawPayload, true));
    }

    /**
     * Get the raw body string for the job.
     *
     * @return string
     */
    public function getRawBody() {

        return $this->rawPayload;
    }
}