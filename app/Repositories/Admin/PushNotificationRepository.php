<?php

namespace App\Repositories\Admin;

use App\Models\Admin\PushNotification;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PushNotificationRepository
 * @package App\Repositories\Admin
 * @version October 23, 2017, 7:40 am UTC
 *
 * @method PushNotification findWithoutFail($id, $columns = ['*'])
 * @method PushNotification find($id, $columns = ['*'])
 * @method PushNotification first($columns = ['*'])
*/
class PushNotificationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'detail',
        'time'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PushNotification::class;
    }
}
