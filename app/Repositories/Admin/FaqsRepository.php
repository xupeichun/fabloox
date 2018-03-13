<?php

namespace App\Repositories\Admin;

use App\Models\Admin\Faqs;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class FaqsRepository
 * @package App\Repositories\Admin
 * @version October 30, 2017, 10:25 am UTC
 *
 * @method Faqs findWithoutFail($id, $columns = ['*'])
 * @method Faqs find($id, $columns = ['*'])
 * @method Faqs first($columns = ['*'])
*/
class FaqsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'question',
        'answer'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Faqs::class;
    }
}
