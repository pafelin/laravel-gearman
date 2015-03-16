<?php namespace Pafelin\Gearman\Connectors;

use \GearmanClient;
use \GearmanWorker;
use Pafelin\Gearman\GearmanQueue;
use Illuminate\Queue\Connectors\ConnectorInterface;

class GearmanConnector implements ConnectorInterface {

	/**
	 * @param array $config
	 *
	 * @return GearmanQueue
	 */
    public function connect(array $config) {
        $client = new GearmanClient;
        $client->addServer($config['host'], (int) $config['port']);
        $this->setTimeout($client, $config);
        $worker = new GearmanWorker;
        $worker->addServer($config['host'], (int) $config['port']);
        return new GearmanQueue ($client, $worker, $config['queue']);
    }

	/**
	 * @param GearmanClient $client
	 * @param array $config
	 */
    private function setTimeout(GearmanClient $client, array $config) {
        if(isset ($config['timeout']) && is_numeric($config['timeout'])) {
            $client->setTimeout($config['timeout']);
        }
    }
}