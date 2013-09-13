<?php

namespace Pafelin\Gearman\Connectors;

use \GearmanClient;
use Pafelin\Gearman\GearmanQueue;
use Illuminate\Queue\Connectors\ConnectorInterface;



class GearmanConnector implements ConnectorInterface {

    public function connect(array $config) {
        $gearman = new GearmanClient();
        $gearman->addServer($config['host'], (int) $config['port']);
        return new GearmanQueue ($gearman);
    }
}