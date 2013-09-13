# Description

This package gives you the possibily to add gearman as native queue back-end service

#Installation

first you need to add it to your composer.json

second you need to comment out the native queue service provider

    //'Illuminate\Queue\QueueServiceProvider',

and to put this instead:

    'Pafelin\Gearman\GearmanServiceProvider',

Than in your config/queue.php file you can add:

    'default' => 'gearman',
    'connections' => array(

    		'gearman' => array(
                'driver' => 'gearman',
                'host'   => 'localserver.6min.local',
                'queue'  => 'default',
                'port'   => '4730'
            )
    )

Then in your code you can add code as (this is the native way to add jobs to the queue):

    Queue::push('SomeClass', array('message' => 'dannite koito trqbva da se izpratqt'));


#What's next:

Very soon I will add the native command for artisan to listen. Currently the worker you need to implement on your own
This package is still not final version. It is in dev progress.