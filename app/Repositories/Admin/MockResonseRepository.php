<?php

namespace App\Repositories\Admin;

use App\Models\Admin\MockResonse;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MockResonseRepository
 * @package App\Repositories\Admin
 * @version October 3, 2017, 10:28 am UTC
 *
 * @method MockResonse findWithoutFail($id, $columns = ['*'])
 * @method MockResonse find($id, $columns = ['*'])
 * @method MockResonse first($columns = ['*'])
*/
class MockResonseRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'url',
        'response'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MockResonse::class;
    }
}
