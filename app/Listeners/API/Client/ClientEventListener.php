<?php
namespace App\Listeners\API\Client;

/**
 * Class UserEventListener.
 */
class ClientEventListener
{

    /**
     *
     * @var string
     */
    private $history_slug = 'Client';

    /**
     *
     * @param
     *            $event
     */
    public function onCreated($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->client->id)
            ->withText('trans("history.backend.client.created") <strong>{user}</strong>')
            ->withIcon('plus')
            ->withClass('bg-green')
            ->withAssets([
            'user_link' => [
                'admin.client.show',
                $event->client->first_name . ' ' . $event->client->last_name,
                $event->client->id
            ]
        ])
            ->log();
            \Log::info('Client Registered: '. $event->client->first_name . ' ' . $event->client->last_name);
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
     *
     * @param  $event
     */
    public function onDeleted($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->client->id)
            ->withText('trans("history.backend.client.deleted") <strong>{user}</strong>')
            ->withIcon('trash')
            ->withClass('bg-maroon')
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
     *
     * @param
     *            $event
     */
    public function onRestored($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->client->id)
            ->withText('trans("history.backend.plugin.restored") <strong>{user}</strong>')
            ->withIcon('refresh')
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
     *
     * @param $event
     */
    public function onPermanentlyDeleted($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->client->id)
            ->withText('trans("history.backend.client.permanently_deleted") <strong>{user}</strong>')
            ->withIcon('trash')
            ->withClass('bg-maroon')
            ->withAssets([
            'user_string' => $event->client->first_name . ' ' . $event->client->last_name
        ])
            ->log();
    }

    /**
     *
     * @param
     *            $event
     */
    public function onDeactivated($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->client->id)
            ->withText('trans("history.backend.client.deactivated") <strong>{user}</strong>')
            ->withIcon('times')
            ->withClass('bg-yellow')
            ->withAssets([
            'user_link' => [
                'admin.clients.client.deactiveted',
                $event->client->first_name . ' ' . $event->client->last_name,
                $event->client->id
            ]
        ])
            ->log();
    }

    /**
     *
     * @param
     *            $event
     */
    public function onReactivated($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->client->id)
            ->withText('trans("history.backend.client.reactivated") <strong>{user}</strong>')
            ->withIcon('check')
            ->withClass('bg-green')
            ->withAssets([
            'user_link' => [
                'admin.clients.client.reactivated',
                $event->client->first_name . ' ' . $event->client->last_name,
                $event->client->id
            ]
        ])
            ->log();
    }

    public function onLoggin($event){
        \Log::info('Client Logged In: '. $event->client->first_name . ' ' . $event->client->last_name);
    }
    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events            
     */
    public function subscribe($events)
    {
        $events->listen(\App\Events\API\Client\ClientCreated::class, 'App\Listeners\API\Client\ClientEventListener@onCreated');
        $events->listen(\App\Events\API\Client\ClientUpdated::class, 'App\Listeners\API\Client\ClientEventListener@onUpdated');
        $events->listen(\App\Events\API\Client\ClientDeleted::class, 'App\Listeners\API\Client\ClientEventListener@onDeleted');
        $events->listen(\App\Events\API\Client\ClientRestored::class, 'App\Listeners\API\Client\ClientEventListener@onRestored');
        $events->listen(\App\Events\API\Client\ClientPermanentlyDeleted::class, 'App\Listeners\API\Client\ClientEventListener@onPermanentlyDeleted');
        $events->listen(\App\Events\API\Client\ClientDeactivated::class, 'App\Listeners\API\Client\ClientEventListener@onDeactivated');
        $events->listen(\App\Events\API\Client\ClientReactivated::class, 'App\Listeners\API\Client\ClientEventListener@onReactivated');
        $events->listen(\App\Events\API\Client\ClientLoggedin::class, 'App\Listeners\API\Client\ClientEventListener@onLoggin');
    }
}
