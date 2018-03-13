<?php
return [ 
		
		/*
		 * |--------------------------------------------------------------------------
		 * | Alert Language Lines
		 * |--------------------------------------------------------------------------
		 * |
		 * | The following language lines contain alert messages for various scenarios
		 * | during CRUD operations. You are free to modify these language lines
		 * | according to your application's requirements.
		 * |
		 */
		
		'backend' => [ 
				'roles' => [ 
						'created' => 'Role created successfully!',
						'deleted' => 'Role deleted successfully!',
						'updated' => 'Role updated successfully!'
				],
				
				'users' => [ 
						'confirmation_email' => 'A new confirmation email has been sent.',
						'created' => 'User created successfully!',
						'deleted' => 'User deleted successfully!',
						'deleted_permanently' => 'User deleted permanently!',
						'restored' => 'User restored successfully!',
						'session_cleared' => "Session cleared successfully!",
						'updated' => 'User updated successfully!',
						'updated_password' => "Password updated successfully!"
				],
				'themes' => [ 
						'created' => 'The theme was successfully created.',
						'deleted' => 'The theme was successfully deleted.',
						'updated' => 'The theme was successfully updated.',
						'status_update' => 'The theme status was updated successfully',
						'versions' => [ 
								'created' => 'The theme version was successfully created.',
								'deleted' => 'The theme version was successfully deleted.',
								'updated' => 'The theme version was successfully updated.',
								'status_update' => 'The theme version status was updated successfully',
								'restored' => 'The theme version was successfully restored.',
						] 
				
				],
				'wordpress' => [ 
						'created' => 'The wordpress version was successfully created.',
						'deleted' => 'The wordpress version was successfully deleted.',
						'updated' => 'The wordpress version was successfully updated.',
						'status_update' => 'The wordpress version status was updated successfully' 
				],
				'plugins' => [
						'created' => 'The plugin was successfully created.',
						'deleted' => 'The plugin was successfully deleted.',
						'updated' => 'The plugin was successfully updated.',
						'status_update' => 'The plugin status was updated successfully',
						'versions' => [
								'created' => 'The plugin version was successfully created.',
								'deleted' => 'The plugin version was successfully deleted.',
								'updated' => 'The plugin version was successfully updated.',
								'status_update' => 'The plugin version status was updated successfully',
								'restored' => 'The plugin version was successfully restored.',

						]
						
				],
				'order' => [ 
						
						'deleted' => 'The order was successfully deleted.'
						
				],
				'client' => [ 
						
						'deleted' => 'The client was successfully deleted.'
						
				],
		] 
];
