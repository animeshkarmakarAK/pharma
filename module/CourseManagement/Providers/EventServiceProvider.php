<?php


namespace Module\CourseManagement\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [];


    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        $events = $this->getEvents();

        foreach ($events as $event => $listeners) {
            if (class_exists($event)) {
                foreach (array_unique($listeners) as $listener) {
                    if (class_exists($listener)) {
                        Event::listen($event, $listener);
                    }
                }
            }
        }

        foreach ($this->subscribe as $subscriber) {
            if (class_exists($subscriber)) {
                Event::subscribe($subscriber);
            }
        }
    }
}
