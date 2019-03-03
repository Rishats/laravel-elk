<?php

namespace App\Configurators;

use ScoutElastic\IndexConfigurator;
use ScoutElastic\Migratable;

class PostIndexConfigurator extends IndexConfigurator
{
    use Migratable;

    // It's not obligatory to determine name. By default it'll be a snaked class name without `IndexConfigurator` part.
    protected $name = 'post_index';

    // You can specify any settings you want, for example, analyzers.
    protected $settings = [
        'analysis' => [
            'analyzer' => [
                'es_std' => [
                    'type' => 'standard',
                    'stopwords' => '_spanish_'
                ]
            ]
        ]
    ];
}