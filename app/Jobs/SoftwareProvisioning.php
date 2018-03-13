<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Orders\Order;
use Exception;
use App\Models\Clients\Client;

class SoftwareProvisioning implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $order;

    private $software;

    private $output;

    /**
     * Create a new job instance.
     *
     * @param Order $order
     * @param array $softwareStack
     */
    public function __construct(Order $order, array $softwareStack)
    {
        $this->order = $order;
        $this->software = $softwareStack;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->output = [];
        \Config::set('remote.connections.production.host', $this->order->pleskServer);
        \Config::set('remote.connections.production.port', '22');
        \Config::set('remote.connections.production.username', 'osrohail');
        \Config::set('remote.connections.production.keyphrase', 'rohail');
        \Config::set('remote.connections.production.key', storage_path('ssh/id_rsa'));
        $client = Client::find($this->order->client_id);
        foreach ($this->software as $key => $softwareStack) {
            $path = storage_path('app/' . array_get($softwareStack, 'source.path'));
            $nameSpace = explode('\\', array_get($softwareStack, 'source.resource_type'));
            $softWareType = end($nameSpace);
            $remoteLocation = sprintf('/var/www/vhosts/%s/httpdocs/', $this->order->domain);
            switch ($softWareType) {
                case 'Wordpress':
                    \SSH::into('production')->run([
                        'sudo chmod -R 777 '.$remoteLocation,
                        'cd ' . $remoteLocation,
                        'ls'
                    ], function ($output) {
                       $this->output[] = $output;
                    });
                    \SSH::into('production')->put($path, $remoteLocation . 'wp-core.zip', function ($output) {
                        $this->output[] = $output;
                    });
                    \SSH::into('production')->run([
                        'cd ' . $remoteLocation,
                        'ls',
                        'unzip -q wp-core.zip',
                        sprintf('/usr/local/bin/wp core config --dbname=%s --dbuser=%s --dbpass=%s --dbhost=localhost --dbprefix=wp_ --skip-check', $this->order->id . '_' . $this->order->hostingUsername, $this->order->hostingUsername, $this->order->hostingPassword),
                        sprintf('sudo plesk bin database --create %s -domain %s -type mysql', $this->order->id . '_' . $this->order->hostingUsername, $this->order->domain),
                        sprintf('sudo plesk bin database --create-dbuser %s -passwd %s -user-role readWrite -domain %s -server localhost:3306 -database %s', $this->order->hostingUsername, $this->order->hostingPassword, $this->order->domain, $this->order->id . '_' . $this->order->hostingUsername),
                        sprintf("/usr/local/bin/wp core install --url=%s --title=%s --admin_user=%s --admin_email=%s --admin_password=%s --allow-root  --skip-email", $this->order->domain, 'Wordpress', $this->order->hostingUsername, $client->email, $this->order->hostingPassword),
                        'rm -rf wp-core.zip'
                    ], function ($output) {
                        $this->output[] = $output;
                    });
                    break;
                case 'Theme':
                    \SSH::into('production')->put($path, $remoteLocation . 'theme.zip', function ($output) {
                        $this->output[] = $output;
                    });
                    \SSH::into('production')->run([
                        'cd ' . $remoteLocation,
                        'ls',
                        '/usr/local/bin/wp theme install theme.zip --activate',
                        'rm -rf theme.zip',
                        "/usr/local/bin/wp rewrite structure '/%postname%/'"
                    
                    ], function ($output) {
                        $this->output[] = $output;
                    });
                    break;
                case 'Plugin':
                    $pluginName = explode('/', $path);
                    $pluginName = end($pluginName);
                    \Log::debug('upload Plugin: ' . $pluginName);
                    \SSH::into('production')->put($path, $remoteLocation . $pluginName, function ($output) {
                        $this->output[] = $output;
                    });
                    \SSH::into('production')->run([
                        'cd ' . $remoteLocation,
                        sprintf('/usr/local/bin/wp plugin install %s --activate', $pluginName),
                        sprintf('rm -rf %s', $pluginName)
                    
                    ], function ($output) {
                        $this->output[] = $output;
                    });
                    break;
                default:
                    \Log::critical('Invalid type software to install ( ' . $softWareType . ' )');
            }
        }
        \Log::debug($this->order->domain.' depkoyment Logs',$this->output);
        try{
            $this->order->fill(['status'=>'Processed'])->update();
        }catch (\Exception $exp){
            \Log::error('Update Order Status',['error'=>$exp->getMessage()]);
        }
    }

    /**
     * The job failed to process.
     *
     * @param Exception $exception            
     * @return void
     */
    public function failed(Exception $exception)
    {
        // Send user notification of failure, etc...
    }
}
