<?php
return [ 
		
		/*
		 * |--------------------------------------------------------------------------
		 * | Menus Language Lines
		 * |--------------------------------------------------------------------------
		 * |
		 * | The following language lines are used in menu items throughout the system.
		 * | Regardless where it is placed, a menu item can be listed here so it is easily
		 * | found in a intuitive way.
		 * |
		 */
		
		'backend' => [ 
				'access' => [ 
						'title' => 'Access Management',
						
						'roles' => [ 
								'all' => 'All Roles',
								'create' => 'Create Role',
								'edit' => 'Edit Role',
								'management' => 'Role Management',
								'main' => 'Roles' 
						],
						
						'users' => [ 
								'all' => 'All Users',
								'change-password' => 'Change Password',
								'create' => 'Create User',
								'deactivated' => 'Deactivated Users',
								'deleted' => 'Deleted Users',
								'edit' => 'Edit User',
								'main' => 'Users',
								'view' => 'View User' 
						] 
				],
				'themes' => [ 
						'title' => 'Themes Management',
						'crud' => [ 
								'index' => 'All Themes',
								'create' => 'Create Theme',
								'edit' => 'Edit Theme',
								'deactivated' => 'Deactivated Themes',
								'deleted' => 'Deleted Themes' 
						],
						'version' => [ 
								'title' => 'Themes Version Management',
								'crud' => [ 
										'index' => 'All Theme Versions',
										'create' => 'Create Version',
										'edit' => 'Edit Version',
										'deactivated' => 'Deactivated Version',
										'deleted' => 'Deleted Version' 
								] 
						
						] 
				],
				'wordpress' => [
						'title' => 'Wordpress Versions',
						'crud' => [
								'index' => 'All Wordpress Version',
								'create' => 'Create Wordpress Version',
								'edit' => 'Edit Wordpress Version',
								'deactivated' => 'Deactivated Wordpress Version',
								'deleted' => 'Deleted Wordpress Version'
						]
				],
				'plugins' => [
						'title' => 'Plugin Management',
						'crud' => [
								'index' => 'All Plugins',
								'create' => 'Create Plugin',
								'edit' => 'Edit Plugin',
								'deactivated' => 'Deactivated Plugins',
								'deleted' => 'Deleted Plugins'
						],
						'versions' => [
								'title' => 'Plugin Version Management',
								'crud' => [
										'index' => 'All Plugin Versions',
										'create' => 'Create Version',
										'edit' => 'Edit Version',
										'deactivated' => 'Deactivated Version',
										'deleted' => 'Deleted Version'
								]
								
						]
				],
				'client' => [
						'title' => 'Clients Management',
						'crud' => [
								'index' => 'All Clients',
								'create' => 'Create Client',
								'edit' => 'Edit Client',
								'deactivated' => 'Deactivated Client',
								'deleted' => 'Deleted Client'
						]
				],
				'order' => [
						'title' => 'Orders Management',
						'crud' => [
								'index' => 'All Orders',
								'create' => 'Create Order',
								'edit' => 'Edit Order',
								'deactivated' => 'Deactivated Order',
								'deleted' => 'Deleted Order'
						]
				],
				'log-viewer' => [ 
						'main' => 'Log Viewer',
						'dashboard' => 'Dashboard',
						'logs' => 'Logs' 
				],
				
				'sidebar' => [ 
						'dashboard' => 'Dashboard',
						'general' => 'General',
						'system' => 'System' 
				] 
		],
		
		'language-picker' => [ 
				'language' => 'Language',
        /*
         * Add the new language to this array.
         * The key should have the same language code as the folder name.
         * The string should be: 'Language-name-in-your-own-language (Language-name-in-English)'.
         * Be sure to add the new language in alphabetical order.
         */
        'langs' => [ 
						'ar' => 'Arabic',
						'zh' => 'Chinese Simplified',
						'zh-TW' => 'Chinese Traditional',
						'da' => 'Danish',
						'de' => 'German',
						'el' => 'Greek',
						'en' => 'English',
						'es' => 'Spanish',
						'fr' => 'French',
						'id' => 'Indonesian',
						'it' => 'Italian',
						'ja' => 'Japanese',
						'nl' => 'Dutch',
						'pt_BR' => 'Brazilian Portuguese',
						'ru' => 'Russian',
						'sv' => 'Swedish',
						'th' => 'Thai',
						'tr' => 'Turkish' 
				] 
		] 
];
