<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreatePushNotificationRequest;
use App\Http\Requests\Admin\UpdatePushNotificationRequest;
use App\Models\Admin\PushNotification;
use App\Repositories\Admin\PushNotificationRepository;
use App\Http\Controllers\AppBaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class PushNotificationController extends AppBaseController
{
    /** @var  PushNotificationRepository */
    private $pushNotificationRepository;

    public function __construct(PushNotificationRepository $pushNotificationRepo)
    {
        $this->pushNotificationRepository = $pushNotificationRepo;
    }

    /**
     * Display a listing of the PushNotification.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->pushNotificationRepository->pushCriteria(new RequestCriteria($request));

        $pushNotifications = PushNotification::orderBy('id', 'DESC')->get();

        return view('admin.push_notifications.index')
            ->with('pushNotifications', $pushNotifications);
    }

    /**
     * Show the form for creating a new PushNotification.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.push_notifications.create');
    }

    /**
     * Store a newly created PushNotification in storage.
     *
     * @param CreatePushNotificationRequest $request
     *
     * @return Response
     */
    public function store(CreatePushNotificationRequest $request)
    {
        $input = $request->all();

//        $pushNotification = $this->pushNotificationRepository->create($input);

        $pushNotifi = new PushNotification();
        $pushNotifi->title = $request->title;
        $pushNotifi->detail = $request->detail;
        $sDate = new Carbon($request->time);
        $sDate->toDateTimeString();
        $pushNotifi->time = $sDate;
        $pushNotifi->save();

        Flash::success('Push notification added successfully!');

        return redirect(route('admin.pushNotifications.index'));
    }

    /**
     * Display the specified PushNotification.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $pushNotification = $this->pushNotificationRepository->findWithoutFail($id);

        if (empty($pushNotification)) {
            Flash::error('Push Notification not found');

            return redirect(route('admin.pushNotifications.index'));
        }

        return view('admin.push_notifications.show')->with('pushNotification', $pushNotification);
    }

    /**
     * Show the form for editing the specified PushNotification.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pushNotification = $this->pushNotificationRepository->findWithoutFail($id);

        if (empty($pushNotification)) {
            Flash::error('Push Notification not found');

            return redirect(route('admin.pushNotifications.index'));
        }

        return view('admin.push_notifications.edit')->with('pushNotification', $pushNotification);
    }

    /**
     * Update the specified PushNotification in storage.
     *
     * @param  int $id
     * @param UpdatePushNotificationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePushNotificationRequest $request)
    {
        $pushNotification = $this->pushNotificationRepository->findWithoutFail($id);

        if (empty($pushNotification)) {
            Flash::error('Push Notification not found');

            return redirect(route('admin.pushNotifications.index'));
        }
        $pushNotifi = PushNotification::find($id);

        $pushNotifi->title = $request->title;
        $pushNotifi->detail = $request->detail;
        $sDate = new Carbon($request->time);
        $sDate->toDateTimeString();
        $pushNotifi->time = $sDate;
        $pushNotifi->save();
//        $pushNotification = $this->pushNotificationRepository->update($request->all(), $id);

        Flash::success('Push Notification updated successfully!');

        return redirect(route('admin.pushNotifications.index'));
    }

    /**
     * Remove the specified PushNotification from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $pushNotification = $this->pushNotificationRepository->findWithoutFail($id);

        if (empty($pushNotification)) {
            Flash::error('Push Notification not found');

            return redirect(route('admin.pushNotifications.index'));
        }

        $this->pushNotificationRepository->delete($id);

        Flash::success('Push Notification deleted successfully!');

        return redirect(route('admin.pushNotifications.index'));
    }
}
