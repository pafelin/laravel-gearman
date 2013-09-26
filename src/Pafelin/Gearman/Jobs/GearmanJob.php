<?php

namespace Pafelin\Gearman\Jobs;
use Illuminate\Container\Container;
use Illuminate\Queue\Jobs\Job;
use \GearmanWorker;

class GearmanJob extends Job {

    protected $gearman;

    protected $job;

    private $maxRunTime = 1;

    private $single = false;

    public function __construct(Container $container, GearmanWorker $worker, $queue)
    {
        $this->container = $container;
        $this->worker = $worker;
        $this->worker->addFunction($queue, array($this,'fire'));
    }

    public function fire(){
        // Do one job, then terminate.
        if($this->single) {

            $this->worker->work();

            return $this->worker->returnCode();

        }
        // Run for an amount of time.
        else {

            $startTime = time();

            while($this->worker->work() || $this->worker->returnCode() == GEARMAN_TIMEOUT) {
                // Check for expiry.
                if((time() - $startTime) >= 60 * $this->maxRunTime) {
                    echo sprintf('%s minutes have elapsed, expiring.', $this->maxRunTime) . PHP_EOL;
                    break;
                }
            }

        }

    }

    public function delete(){

    }

    public function release($delay = 0) {

    }

    public function attempts() {

    }

    public function getJobId() {

    }

    public function getContainer() {
        return $this->container;
    }

    public function getGearman() {
        return $this->gearman;
    }

    public function getGearmanJob() {
        return $this->job;
    }

    public function onGearmanJob(\GearmanJob $job) {
        $this->job = $job;
    }

}