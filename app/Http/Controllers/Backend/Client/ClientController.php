<?php

namespace App\Http\Controllers\Backend\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Events\API\Client\ClientCreated;
use App\Models\Orders\Order;
use App\Models\Resource\ResourceProvisioning;
use App\Models\Clients\Client;

class ClientController extends Controller {
	
    /** 
    * Display all records of resource
    **/
    public function index() {
		
		return view ( 'backend.clients.index' );
	}

    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	
	public function show($id) {

		$client = Client::findOrFail($id);
		
		return view ( 'backend.clients.show', compact('client') );
	}

	public function delete($id) {
        
        		
		
		try{

        $client = Client::findOrFail($id);

		$orders = Order::where('client_id', $client->id)->get();
		
        foreach ($orders as $order) {
        
        $res_prs = ResourceProvisioning::where('order_id', $order->id)->get();
        
        foreach ($res_prs as $res_pr) {
        
        $res_pr->delete();
        
        }

        $order->delete();
        
        }

        $client->delete();
		
		}catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.client.index')->withFlashDanger ( $exp->getMessage () );
		}

		return redirect ()->back ()->withInput ()->withFlashSuccess ( trans ( 'alerts.backend.client.deleted' ) );
        
	}

	public function getForDataTable() {
	 	
	 	return Datatables::of ( (new Client ())->getForDataTable())->addColumn ( 'actions', function ($clients) {
			return $clients->action_buttons;
		} )->rawColumns ( [ 
				'actions' 
		] )->make ( true );
	 }
	 
	public function getAllClients(Request $request) {
		return $this->getForDataTable ( );
	}
}	