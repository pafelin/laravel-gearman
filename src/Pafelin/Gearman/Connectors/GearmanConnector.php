<?php

namespace Pafelin\Gearman\Connectors;

use \GearmanClient;
use \GearmanWorker;
use Pafelin\Gearman\GearmanQueue;
use Illuminate\Queue\Connectors\ConnectorInterface;



class GearmanConnector implements ConnectorInterface {

    public function connect(array $config) {

        $client = new GearmanClient;
        $client->addServer($config['host'], (int) $config['port']);
        $worker = new GearmanWorker;
        $worker->addServer($config['host'], (int) $config['port']);
        return new GearmanQueue ($client, $worker, $config['queue']);
    }
}