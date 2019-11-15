<?php

namespace Modules\Idocs\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Idocs\Events\DocumentWasCreated;
use Modules\Idocs\Events\Handlers\SendDocument;


class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        DocumentWasCreated::class=>[
            SendDocument::class,
        ]
    ];
}