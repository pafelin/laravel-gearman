<?php

namespace Pafelin\Gearman\Jobs;
use Illuminate\Container\Container;

class GearmanJob extends Job {

    protected $gearman;

    protected $job;

    public function __construct(Container $container,
                                Gearman $gearman,
                                GearmanJob $job )
    {
        $this->job = $job;
        $this->container = $container;
        $this->gearman = $gearman;
    }

    public function fire(){
        $this->resolveAndFire(json_decode($this->job->getData(), true));
    }

    public function delete(){

    }

    public function release($delay = 0) {

    }

    public function atempts() {

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