<?php

namespace App\Listeners\Backend\Wordpress;

/**
 * Class UserEventListener.
 */
class WordpressEventListener
{
	/**
	 * @var string
	 */
	private $history_slug = 'Wordpress';
	
	/**
	 * @param $event
	 */
	public function onCreated($event)
	{
		
		history()->withType($this->history_slug)
		->withEntity($event->wordpress->id)
		->withText('trans("history.backend.wordpress.created") <strong>{user}</strong>')
		->withIcon('plus')
		->withClass('bg-green')
		->withAssets([
				'user_link' => ['admin.wordpress.wordpress.edit', $event->wordpress->slug, $event->wordpress->id],
		])
		->log();
	}
	
	/**
	 * @param $event
	 */
	public function onUpdated($event)
	{
		
		history()->withType($this->history_slug)
		->withEntity($event->wordpress->id)
		->withText('trans("history.backend.wordpress.updated") <strong>{user}</strong>')
		->withIcon('save')
		->withClass('bg-aqua')
		->withAssets([
				'user_link' => ['admin.wordpress.wordpress.edit', $event->wordpress->slug, $event->wordpress->id],
		])
		->log();
	}
	
	/**
	 * @param $event
	 */
	public function onDeleted($event)
	{
		history()->withType($this->history_slug)
		->withEntity($event->wordpress->id)
		->withText('trans("history.backend.wordpress.deleted") <strong>{user}</strong>')
		->withIcon('trash')
		->withClass('bg-maroon')
		->withAssets([
				'user_link' => ['admin.wordpress.wordpress.edit', $event->wordpress->slug, $event->wordpress->id],
		])
		->log();
	}
	
	/**
	 * @param $event
	 */
	public function onRestored($event)
	{
		history()->withType($this->history_slug)
		->withEntity($event->wordpress->id)
		->withText('trans("history.backend.wordpress.restored") <strong>{user}</strong>')
		->withIcon('refresh')
		->withClass('bg-aqua')
		->withAssets([
				'user_link' => ['admin.themes.themes.edit', $event->wordpress->slug, $event->wordpress->id],
		])
		->log();
	}
	
	/**
	 * @param $event
	 */
	public function onPermanentlyDeleted($event)
	{
		history()->withType($this->history_slug)
		->withEntity($event->wordpress->id)
		->withText('trans("history.backend.wordpress.permanently_deleted") <strong>{user}</strong>')
		->withIcon('trash')
		->withClass('bg-maroon')
		->withAssets([
				'user_string' => $event->wordpress->slug,
		])
		->log();
		
		history()->withType($this->history_slug)
		->withEntity($event->wordpress->id)
		->withAssets([
				'user_string' => $event->wordpress->slug,
		])
		->updateUserLinkAssets();
	}
	
	
	/**
	 * @param $event
	 */
	public function onDeactivated($event)
	{
		history()->withType($this->history_slug)
		->withEntity($event->wordpress->id)
		->withText('trans("history.backend.theme.deactivated") <strong>{user}</strong>')
		->withIcon('times')
		->withClass('bg-yellow')
		->withAssets([
				'user_link' => ['admin.wordpress.wordpress.edit', $event->wordpress->slug, $event->wordpress->id],
		])
		->log();
	}
	
	/**
	 * @param $event
	 */
	public function onReactivated($event)
	{
		history()->withType($this->history_slug)
		->withEntity($event->wordpress->id)
		->withText('trans("history.backend.wordpress.reactivated") <strong>{user}</strong>')
		->withIcon('check')
		->withClass('bg-green')
		->withAssets([
				'user_link' => ['admin.wordpress.wordpress.edit', $event->wordpress->slug, $event->wordpress->id],
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
		
		$events->listen(
				\App\Events\Backend\Wordpress\WordpressCreated::class,
				'App\Listeners\Backend\Wordpress\WordpressEventListener@onCreated'
				);
		
		$events->listen(
				\App\Events\Backend\Wordpress\WordpressUpdated::class,
				'App\Listeners\Backend\Wordpress\WordpressEventListener@onUpdated'
				);
		
		$events->listen(
				\App\Events\Backend\Wordpress\WordpressDeleted::class,
				'App\Listeners\Backend\Wordpress\WordpressEventListener@onDeleted'
				);
		
		$events->listen(
				\App\Events\Backend\Wordpress\WordpressRestored::class,
				'App\Listeners\Backend\Wordpress\WordpressEventListener@onRestored'
				);
		
		$events->listen(
				\App\Events\Backend\Wordpress\WordpressPermanentlyDeleted::class,
				'App\Listeners\Backend\Wordpress\WordpressEventListener@onPermanentlyDeleted'
				);
	
		$events->listen(
				\App\Events\Backend\Wordpress\WordpressDeactivated::class,
				'App\Listeners\Backend\Wordpress\WordpressEventListener@onDeactivated'
				);
		
		$events->listen(
				\App\Events\Backend\Wordpress\WordpressReactivated::class,
				'App\Listeners\Backend\Wordpress\WordpressEventListener@onReactivated'
				);
	}
}
