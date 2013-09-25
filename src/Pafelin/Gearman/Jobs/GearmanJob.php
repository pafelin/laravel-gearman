<?php

namespace Pafelin\Gearman\Jobs;
use Illuminate\Container\Container;
use Illuminate\Queue\Jobs\Job;
use \GearmanWorker;

class GearmanJob extends Job {

    protected $gearman;

    protected $job;

    public function __construct(Container $container, GearmanWorker $worker)
    {
        $this->container = $container;
        $this->worker = $worker;
    }

    public function fire(){
        die('in fire@GearmanJob');
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

}