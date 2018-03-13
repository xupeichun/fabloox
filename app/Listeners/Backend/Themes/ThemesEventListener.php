<?php

namespace App\Listeners\Backend\Themes;

/**
 * Class UserEventListener.
 */
class ThemesEventListener
{
	/**
	 * @var string
	 */
	private $history_slug = 'Theme';
	
	/**
	 * @param $event
	 */
	public function onCreated($event)
	{
		
		history()->withType($this->history_slug)
		->withEntity($event->theme->id)
		->withText('trans("history.backend.theme.created") <strong>{theme}</strong>')
		->withIcon('plus')
		->withClass('bg-green')
		->withAssets([
				'theme_link' => ['admin.themes.themes.edit', $event->theme->slug, $event->theme->id],
		])
		->log();
	}
	
	/**
	 * @param $event
	 */
	public function onUpdated($event)
	{
		
		history()->withType($this->history_slug)
		->withEntity($event->theme->id)
		->withText('trans("history.backend.theme.updated") <strong>{theme}</strong>')
		->withIcon('save')
		->withClass('bg-aqua')
		->withAssets([
				'theme_link' => ['admin.themes.themes.edit', $event->theme->slug, $event->theme->id],
		])
		->log();
	}
	
	/**
	 * @param $event
	 */
	public function onDeleted($event)
	{
		history()->withType($this->history_slug)
		->withEntity($event->theme->id)
		->withText('trans("history.backend.theme.deleted") <strong>{theme}</strong>')
		->withIcon('trash')
		->withClass('bg-maroon')
		->withAssets([
				'theme_link' => ['admin.themes.themes.edit', $event->theme->slug, $event->theme->id],
		])
		->log();
	}
	
	/**
	 * @param $event
	 */
	public function onRestored($event)
	{
		history()->withType($this->history_slug)
		->withEntity($event->theme->id)
		->withText('trans("history.backend.theme.restored") <strong>{theme}</strong>')
		->withIcon('refresh')
		->withClass('bg-aqua')
		->withAssets([
				'theme_link' => ['admin.themes.themes.edit', $event->theme->slug, $event->theme->id],
		])
		->log();
	}
	
	/**
	 * @param $event
	 */
	public function onPermanentlyDeleted($event)
	{
		history()->withType($this->history_slug)
		->withEntity($event->theme->id)
		->withText('trans("history.backend.theme.permanently_deleted") <strong>{theme}</strong>')
		->withIcon('trash')
		->withClass('bg-maroon')
		->withAssets([
				'theme_string' => $event->theme->slug,
		])
		->log();
		
		history()->withType($this->history_slug)
		->withEntity($event->theme->id)
		->withAssets([
				'theme_string' => $event->theme->slug,
		])
		->updateUserLinkAssets();
	}
	
	
	/**
	 * @param $event
	 */
	public function onDeactivated($event)
	{
		history()->withType($this->history_slug)
		->withEntity($event->theme->id)
		->withText('trans("history.backend.theme.deactivated") <strong>{theme}</strong>')
		->withIcon('times')
		->withClass('bg-yellow')
		->withAssets([
				'theme_link' => ['admin.themes.themes.edit', $event->theme->slug, $event->theme->id],
		])
		->log();
	}
	
	/**
	 * @param $event
	 */
	public function onReactivated($event)
	{
		history()->withType($this->history_slug)
		->withEntity($event->theme->id)
		->withText('trans("history.backend.theme.reactivated") <strong>{theme}</strong>')
		->withIcon('check')
		->withClass('bg-green')
		->withAssets([
				'theme_link' => ['admin.themes.themes.edit', $event->theme->slug, $event->theme->id],
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
				\App\Events\Backend\Themes\ThemeCreated::class,
				'App\Listeners\Backend\Themes\ThemesEventListener@onCreated'
				);
		
		$events->listen(
				\App\Events\Backend\Themes\ThemeUpdated::class,
				'App\Listeners\Backend\Themes\ThemesEventListener@onUpdated'
				);
		
		$events->listen(
				\App\Events\Backend\Themes\ThemeDeleted::class,
				'App\Listeners\Backend\Themes\ThemesEventListener@onDeleted'
				);
		
		$events->listen(
				\App\Events\Backend\Themes\ThemeRestored::class,
				'App\Listeners\Backend\Themes\ThemesEventListener@onRestored'
				);
		
		$events->listen(
				\App\Events\Backend\Themes\ThemePermanentlyDeleted::class,
				'App\Listeners\Backend\Themes\ThemesEventListener@onPermanentlyDeleted'
				);
	
		$events->listen(
				\App\Events\Backend\Themes\ThemeDeactivated::class,
				'App\Listeners\Backend\Themes\ThemesEventListener@onDeactivated'
				);
		
		$events->listen(
				\App\Events\Backend\Themes\ThemeReactivated::class,
				'App\Listeners\Backend\Themes\ThemesEventListener@onReactivated'
				);
	}
}
