<?php
namespace App\Models\Resource;

use Arcanedev\Support\Bases\Model;
use App\Models\History\Traits\Relationship\HistoryRelationship;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Resource\Traits\Attribute\ResourceAttribute;
use App\Models\Plugins\Plugin;

class ResourceProvisioning extends Model
{

    protected $table = 'resource_provisioning';

    protected $fillable = [
        'id',
        'order_id',
        'resource_version_id'
    
    ];

    public function getCreatedAtAttribute($value){
        return \Carbon\Carbon::parse($value)->format('d-m-y');
    }
    public function getUpdatedAtAttribute($value){
        return \Carbon\Carbon::parse($value)->format('d-m-y');
    }


    /**
     * Expects Object of model class
     * @param $modelObject
     * @param $orderId
     * @return $this
     */
    
    public function populate($modelObject, $orderId){
        $this->order_id = $orderId;
        $this->resource_version_id = $modelObject->resource_version_id;
        $this->resource_id =  $modelObject->resource_id;
        $this->resource_type = get_class($modelObject);
        return $this;
    }
    
    public function getResourceById($id)
    {
        return self::find($id);
    }
    
    public function resource(){
        return $this->morphTo();
    }
    public function source(){
        return $this->belongsTo('App\Models\Resource\ResourceVersion','resource_version_id','id');
    }

    public function plugin()
    {
        return $this->belongsTo('App\Models\Plugins\Plugin', 'resource_id', 'id');
    }

    public function wordpress()
    {
        return $this->belongsTo('App\Models\Wordpress\Wordpress', 'resource_id', 'id');
    }

    public function themes()
    {
        return $this->belongsTo('App\Models\Themes\Theme', 'resource_id', 'id');
    }
}