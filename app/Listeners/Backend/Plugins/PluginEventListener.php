<?php

namespace App\Listeners\Backend\Plugins;

/**
 * Class UserEventListener.
 */
class PluginEventListener
{
	/**
	 * @var string
	 */
	private $history_slug = 'Plugin';
	
	/**
	 * @param $event
	 */
	public function onCreated($event)
	{
		
		history()->withType($this->history_slug)
		->withEntity($event->plugin->id)
		->withText('trans("history.backend.plugin.created") <strong>{user}</strong>')
		->withIcon('plus')
		->withClass('bg-green')
		->withAssets([
				'user_link' => ['admin.plugins.plugins.edit', $event->plugin->slug, $event->plugin->id],
		])
		->log();
	}
	
	/**
	 * @param $event
	 */
	public function onUpdated($event)
	{
		
		history()->withType($this->history_slug)
		->withEntity($event->plugin->id)
		->withText('trans("history.backend.plugin.updated") <strong>{user}</strong>')
		->withIcon('save')
		->withClass('bg-aqua')
		->withAssets([
				'user_link' => ['admin.plugins.plugins.edit', $event->plugin->slug, $event->plugin->id],
		])
		->log();
	}
	
	/**
	 * @param $event
	 */
	public function onDeleted($event)
	{
		history()->withType($this->history_slug)
		->withEntity($event->plugin->id)
		->withText('trans("history.backend.plugin.deleted") <strong>{user}</strong>')
		->withIcon('trash')
		->withClass('bg-maroon')
		->withAssets([
				'user_link' => ['admin.plugins.plugins.edit', $event->plugin->slug, $event->plugin->id],
		])
		->log();
	}
	
	/**
	 * @param $event
	 */
	public function onRestored($event)
	{
		history()->withType($this->history_slug)
		->withEntity($event->plugin->id)
		->withText('trans("history.backend.plugin.restored") <strong>{user}</strong>')
		->withIcon('refresh')
		->withClass('bg-aqua')
		->withAssets([
				'user_link' => ['admin.plugins.plugins.edit', $event->plugin->slug, $event->plugin->id],
		])
		->log();
	}
	
	/**
	 * @param $event
	 */
	public function onPermanentlyDeleted($event)
	{
		history()->withType($this->history_slug)
		->withEntity($event->plugin->id)
		->withText('trans("history.backend.plugin.permanently_deleted") <strong>{user}</strong>')
		->withIcon('trash')
		->withClass('bg-maroon')
		->withAssets([
				'user_string' => $event->plugin->slug,
		])
		->log();
		
		history()->withType($this->history_slug)
		->withEntity($event->plugin->id)
		->withAssets([
				'user_string' => $event->plugin->slug,
		])
		->updateUserLinkAssets();
	}
	
	
	/**
	 * @param $event
	 */
	public function onDeactivated($event)
	{
		history()->withType($this->history_slug)
		->withEntity($event->plugin->id)
		->withText('trans("history.backend.plugin.deactivated") <strong>{user}</strong>')
		->withIcon('times')
		->withClass('bg-yellow')
		->withAssets([
				'user_link' => ['admin.plugins.plugins.edit', $event->plugin->slug, $event->plugin->id],
		])
		->log();
	}
	
	/**
	 * @param $event
	 */
	public function onReactivated($event)
	{
		history()->withType($this->history_slug)
		->withEntity($event->plugin->id)
		->withText('trans("history.backend.plugin.reactivated") <strong>{user}</strong>')
		->withIcon('check')
		->withClass('bg-green')
		->withAssets([
				'user_link' => ['admin.plugins.plugins.edit', $event->plugin->slug, $event->plugin->id],
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
				\App\Events\Backend\Plugins\PluginCreated::class,
				'App\Listeners\Backend\Plugins\PluginEventListener@onCreated'
				);
		
		$events->listen(
				\App\Events\Backend\Plugins\PluginUpdated::class,
				'App\Listeners\Backend\Plugins\PluginEventListener@onUpdated'
				);
		
		$events->listen(
				\App\Events\Backend\Plugins\PluginDeleted::class,
				'App\Listeners\Backend\Plugins\PluginEventListener@onDeleted'
				);
		
		$events->listen(
				\App\Events\Backend\Plugins\PluginRestored::class,
				'App\Listeners\Backend\Plugins\PluginEventListener@onRestored'
				);
		
		$events->listen(
				\App\Events\Backend\Plugins\PluginPermanentlyDeleted::class,
				'App\Listeners\Backend\Plugins\PluginEventListener@onPermanentlyDeleted'
				);
	
		$events->listen(
				\App\Events\Backend\Plugins\PluginDeactivated::class,
				'App\Listeners\Backend\Plugins\PluginEventListener@onDeactivated'
				);
		
		$events->listen(
				\App\Events\Backend\Plugins\PluginReactivated::class,
				'App\Listeners\Backend\Plugins\PluginEventListener@onReactivated'
				);
	}
}
