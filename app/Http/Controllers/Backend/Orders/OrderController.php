<?php

namespace App\Http\Controllers\Backend\Orders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Events\API\Client\OrderCreated;
use App\Models\Orders\Order;
use App\Models\Clients\Client;
use App\Models\Resource\ResourceProvisioning;

class OrderController extends Controller {

    /**
     * Display all records of resource
     * @param $id
     * @return $this
     */
    public function index($id) {
    	
		return view ( 'backend.orders.index' )->with('id',$id);
	}

    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	
	public function show($id) {
		
		$order = Order::findOrFail($id);
		
		$this->order = $order;
        
        $resources = $order->provisioning()->with('resource')->get()->toArray();
        
        return view ( 'backend.orders.show', compact('order','resources') );
	}

    public function destory($id) {
		
		try{

		$order = Order::findOrFail($id);
		
		$res_prs = ResourceProvisioning::where('id', $order->client_id)->get();
        
        $client = Client::where('id', $order->client_id)->first(); 

        foreach ($res_prs as $res_pr) {
        
        $res_pr->delete();
        
        }
        
        $order->delete();
		
		}catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.order.index',['id'=> $client->id] )->withFlashDanger ( $exp->getMessage () );
		}

		return redirect ()->back ()->withInput ()->withFlashSuccess ( trans ( 'alerts.backend.order.deleted' ) );
        
	}


	public function getForDataTable() {

	 	return Datatables::of ( (new Order ())->getForDataTable(request('id')))->addColumn ( 'actions', function ($orders) {
			return $orders->action_buttons;
		} )->rawColumns ( [ 
				'actions' 
		] )->make ( true );
	 }
	 
	public function getAllOrders(Request $request) {
		return $this->getForDataTable ( );
	}

	
}	