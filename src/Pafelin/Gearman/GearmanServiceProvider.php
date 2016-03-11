<?php namespace Pafelin\Gearman;

use Illuminate\Queue\QueueServiceProvider as ServiceProvider;
use Pafelin\Gearman\Connectors\GearmanConnector;

class GearmanServiceProvider extends ServiceProvider {

    /**
     * Register the connectors on the queue manager.
     *
     * @param  \Illuminate\Queue\QueueManager  $manager
     * @return void
     */
    public function registerConnectors($manager)
    {

        foreach (array('Sync', 'Beanstalkd', 'Sqs', 'Iron', 'Gearman') as $connector)
        {
            if (method_exists($this, "register{$connector}Connector")) {
                $this->{"register{$connector}Connector"}($manager);
            }
        }
    }

    /**
     * Register the Gearman queue connector.
     *
     * @param  \Illuminate\Queue\QueueManager  $manager
     * @return void
     */
    public function registerGearmanConnector($manager) {
        $manager->addConnector('gearman', function()
        {
            return new GearmanConnector();
        });
    }

}