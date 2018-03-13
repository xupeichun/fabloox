<?php

namespace App\Models\Resource\Traits\Attribute;

/**
 * Class UserAttribute.
 */
trait ResourceAttribute
{
	public static $accessingModel;
	/**
	 *
	 * @return string
	 */
	public function getEditButtonAttribute() {
		return '<a href="' . route ( 'admin.'.self::$accessingModel.'.version.edit', [$this->parentId,$this->id] ) . '" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans ( 'buttons.general.crud.edit' ) . '"></i></a> ';
	}
	
	
	public function getRestoreButtonAttribute(){
		return '<a href="' . route ( 'admin.'.self::$accessingModel.'.version.restore', [$this->parentId,$this->id]) . '" name="restore_user" class="btn btn-xs btn-info"><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="' . trans ( 'buttons.backend.'.self::$accessingModel.'.versions.restore' ) . '"></i></a> ';
	}
	
	public function getDeletePermanentlyButtonAttribute(){
		return '<a href="' . route ( 'admin.'.self::$accessingModel.'.version.delete-permanently', [$this->parentId,$this->id]) . '" name="delete_user_perm" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans ( 'buttons.backend.'.self::$accessingModel.'.delete_permanently' ) . '"></i></a> ';
	}
	/**
	 *
	 * @return string
	 */
	public function getDeleteButtonAttribute() {
		return '<a href="' . route ( 'admin.'.self::$accessingModel.'.version.destroy', [$this->parentId,$this->id]) . '"
                 data-method="delete"
                 data-trans-button-cancel="' . trans ( 'buttons.general.cancel' ) . '"
                 data-trans-button-confirm="' . trans ( 'buttons.general.crud.delete' ) . '"
                 data-trans-title="' . trans ( 'strings.backend.general.are_you_sure' ) . '"
                 class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans ( 'buttons.general.crud.delete' ) . '"></i></a> ';
		
	}
	/**
	 * 
	 * @return string
	 */
	public function getActionButtonsAttribute() {
		if ($this->trashed ()) {
			return $this->getRestoreButtonAttribute () . $this->getDeletePermanentlyButtonAttribute ();
		}
		
		return $this->getEditButtonAttribute () . $this->getDeleteButtonAttribute();
	}
}