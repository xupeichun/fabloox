<?php

namespace App\Listeners\Backend\Plugins\Versions;

/**
 * Class UserEventListener.
 */
class PluginVersionEventListener
{
	/**
	 * @var string
	 */
	private $history_slug = 'Plugin_Version';
	
	/**
	 * @param $event
	 */
	public function onCreated($event)
	{
		$plugin = $event->version->plugin()->first();
		history()->withType($this->history_slug)
		->withEntity($event->version->id)
		->withText('trans("history.backend.plugin.version.created") <strong>{user}</strong>')
		->withIcon('plus')
		->withClass('bg-green')
		->withAssets([
				'user_link' => ['admin.plugins.version.edit', $plugin->name.' '.$event->version->version,[$event->version->resource_id, $event->version->id]],
		])
		->log();
	}
	
	/**
	 * @param $event
	 */
	public function onUpdated($event)
	{
		$plugin = $event->version->plugin()->first();
		history()->withType($this->history_slug)
		->withEntity($event->version->id)
		->withText('trans("history.backend.plugin.version.updated") <strong>{user}</strong>')
		->withIcon('save')
		->withClass('bg-aqua')
		->withAssets([
				'user_link' => ['admin.plugins.version.edit', $plugin->name.' '.$event->version->version,[$event->version->resource_id, $event->version->id]],
		])
		->log();
	}
	
	/**
	 * @param $event
	 */
	public function onDeleted($event)
	{
		$plugin = $event->version->plugin()->first();
		history()->withType($this->history_slug)
		->withEntity($event->version->id)
		->withText('trans("history.backend.plugin.version.deleted") <strong>{user}</strong>')
		->withIcon('trash')
		->withClass('bg-maroon')
		->withAssets([
				'user_link' => ['admin.plugins.version.edit', $plugin->name.' '.$event->version->version,[$event->version->resource_id, $event->version->id]],
		])
		->log();
	}
	
	/**
	 * @param $event
	 */
	public function onRestored($event)
	{
		$plugin = $event->version->plugin()->first();
		history()->withType($this->history_slug)
		->withEntity($event->version->id)
		->withText('trans("history.backend.plugin.version.restored") <strong>{user}</strong>')
		->withIcon('refresh')
		->withClass('bg-aqua')
		->withAssets([
				'user_link' => ['admin.plugins.plugins.edit', $plugin->name.' '.$event->version->version,[$event->version->resource_id, $event->version->id]],
		])
		->log();
	}
	
	/**
	 * @param $event
	 */
	public function onPermanentlyDeleted($event)
	{
		$plugin = $event->version->plugin()->first();
		history()->withType($this->history_slug)
		->withEntity($event->plugin->id)
		->withText('trans("history.backend.plugin.version.permanently_deleted") <strong>{user}</strong>')
		->withIcon('trash')
		->withClass('bg-maroon')
		->withAssets([
				'user_string' => $plugin->name.' '.$event->version->version,
		])
		->log();
		
		history()->withType($this->history_slug)
		->withEntity($event->version->id)
		->withAssets([
				'user_string' => $plugin->name.' '.$event->version->version,
		])
		->updateUserLinkAssets();
	}
	
	
	/**
	 * @param $event
	 */
	public function onDeactivated($event)
	{
		$plugin = $event->plugin;
		history()->withType($this->history_slug)
		->withEntity($event->plugin->id)
		->withText('trans("history.backend.plugin.version.deactivated") <strong>{user}</strong>')
		->withIcon('times')
		->withClass('bg-yellow')
		->withAssets([
				'user_link' => ['admin.plugins.version.edit', $plugin->name.' '.$event->version->version, [$event->version->resource_id, $event->version->id]],
		])
		->log();
	}
	
	/**
	 * @param $event
	 */
	public function onReactivated($event)
	{
		$plugin = $event->version->plugin()->first();
		history()->withType($this->history_slug)
		->withEntity($event->version->id)
		->withText('trans("history.backend.plugin.reactivated") <strong>{user}</strong>')
		->withIcon('check')
		->withClass('bg-green')
		->withAssets([
				'user_link' => ['admin.plugins.version.edit',$plugin->name.' '.$event->version->version,[$event->version->resource_id, $event->version->id]],
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
				\App\Events\Backend\Plugins\Versions\PluginVersionCreated::class,
				'App\Listeners\Backend\Plugins\Versions\PluginVersionEventListener@onCreated'
				);
		
		$events->listen(
				\App\Events\Backend\Plugins\Versions\PluginVersionUpdated::class,
				'App\Listeners\Backend\Plugins\Versions\PluginVersionEventListener@onUpdated'
				);
		
		$events->listen(
				\App\Events\Backend\Plugins\Versions\PluginVersionDeleted::class,
				'App\Listeners\Backend\Plugins\Versions\PluginVersionEventListener@onDeleted'
				);
		
		$events->listen(
				\App\Events\Backend\Plugins\Versions\PluginVersionRestored::class,
				'App\Listeners\Backend\Plugins\Versions\PluginVersionEventListener@onRestored'
				);
		
		$events->listen(
				\App\Events\Backend\Plugins\Versions\PluginVersionPermanentlyDeleted::class,
				'App\Listeners\Backend\Plugins\Versions\PluginVersionEventListener@onPermanentlyDeleted'
				);
	
		$events->listen(
				\App\Events\Backend\Plugins\Versions\PluginVersionDeactivated::class,
				'App\Listeners\Backend\Plugins\Versions\PluginVersionEventListener@onDeactivated'
				);
		
		$events->listen(
				\App\Events\Backend\Plugins\Versions\PluginVersionReactivated::class,
				'App\Listeners\Backend\Plugins\Versions\PluginVersionEventListener@onReactivated'
				);
	}
}
