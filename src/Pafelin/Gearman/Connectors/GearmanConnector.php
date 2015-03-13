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
        $this->_setTimeout($client, $config);
        $worker = new GearmanWorker;
        $worker->addServer($config['host'], (int) $config['port']);
        return new GearmanQueue ($client, $worker, $config['queue']);
    }

    private function _setTimeout(GearmanClient $client, array $config) {
        if(isset ($config['timeout']) && is_numeric($config['timeout'])) {
            $client->setTimeout($config['timeout']);
        }
    }
}