<?php

namespace App\Repositories\Admin;

use App\Models\Admin\BrandVideo;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BrandVideoRepository
 * @package App\Repositories\Admin
 * @version October 26, 2017, 5:47 am UTC
 *
 * @method BrandVideo findWithoutFail($id, $columns = ['*'])
 * @method BrandVideo find($id, $columns = ['*'])
 * @method BrandVideo first($columns = ['*'])
*/
class BrandVideoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'brand_id',
        'image',
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return BrandVideo::class;
    }
}
