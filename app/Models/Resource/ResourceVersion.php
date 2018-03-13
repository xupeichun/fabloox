<?php

namespace App\Models\Resource;

use Arcanedev\Support\Bases\Model;
use App\Models\History\Traits\Relationship\HistoryRelationship;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Resource\Traits\Attribute\ResourceAttribute;
use App\Models\Plugins\Plugin;

class ResourceVersion extends Model {
	use HistoryRelationship, ResourceAttribute,SoftDeletes;
	protected $table = 'resource_version';
	protected $fillable = [
			'id',
			'resource_id',
			'resource_type',
			'version',
			'path',
			'is_current'
	];
	
	public function getResourceById($id){
		return self::find($id);
	}
	public function plugin(){
		return $this->belongsTo('App\Models\Plugins\Plugin','resource_id','id');
	}
}