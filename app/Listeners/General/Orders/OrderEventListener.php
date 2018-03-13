<?php
namespace App\Listeners\General\Orders;

/**
 * Class UserEventListener.
 */
class OrderEventListener
{

    /**
     *
     * @var string
     */
    private $history_slug = 'Orders';

    /**
     *
     * @param
     *            $event
     */
    public function onCreated($event)
    {
       /*  history()->withType($this->history_slug)
            ->withEntity($event->order->id)
            ->withText('trans("history.backend.client.created") <strong>{user}</strong>')
            ->withIcon('plus')
            ->withClass('bg-green')
            ->withAssets([
            'user_link' => [
                'admin.order.show',
                'View order',
                $event->order->id
            ]
        ])
            ->log(); */
        \Log::info('New order created: ' . $event->order->id);
    }

    /**
     *
     * @param
     *            $event
     */
    public function onUpdated($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->client->id)
            ->withText('trans("history.backend.client.updated") <strong>{user}</strong>')
            ->withIcon('save')
            ->withClass('bg-aqua')
            ->withAssets([
            'user_link' => [
                'admin.client.show',
                $event->client->first_name . ' ' . $event->client->last_name,
                $event->client->id
            ]
        ])
            ->log();
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events            
     */
    public function subscribe($events)
    {
        $events->listen(\App\Events\General\Orders\OrderCreated::class, 'App\Listeners\General\Orders\OrderEventListener@onCreated');
    }
}
