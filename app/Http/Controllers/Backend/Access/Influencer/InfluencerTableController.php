<?php

namespace App\Http\Controllers\Backend\Access\Influencer;

use App\Models\Access\Influencer\Influencer_video;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\User\ManageUserRequest;
use App\Repositories\Backend\Access\Influencer\InfluencerRepository;
use Yajra\Datatables\Facades\Datatables;

class InfluencerTableController extends Controller
{

    protected $influencer;


    public function __construct(InfluencerRepository $influencer)
    {
        $this->influencer = $influencer;

    }

    public function getAll(ManageUserRequest $request)
    {
        $cat = $this->influencer->allActive();
        $counter = 0;
        return Datatables::of($cat)
            /*            ->addColumn('count',function() use ($counter){
                            $counter++;
                            return $counter;
                        })*/
            ->addColumn('action', function ($cat) {
                if (empty($cat->influencerVideos->toArray())) {
                    $editButton = '';
                } else {
                    $editButton = '<a href="influencer/editlinks/' . $cat->id . '" class="btn btn-xs btn-success addLinks " data-id="' . $cat->id . '" >Edit videos</button>';
                }
                return '<a href="influencer/' . $cat->id . '/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a> <button id="cat-deactivate-' . $cat->id . '" class="btn btn-xs btn-warning deactivateButton" data-id="' . $cat->id . '"><i class="glyphicon glyphicon-pause "></i> Deactivate</button> <button id="cat-delete-' . $cat->id . '" class="btn btn-xs btn-danger btn-delete deleteButton" data-id="' . $cat->id . '" data-remote="edit"><i class="glyphicon glyphicon-trash "></i> Delete</button>' /*<button class="btn btn-xs btn-info addLinks " data-id="' . $cat->id . '" >Add videos</button>*/
                    ;
            })->addIndexColumn()
            ->make(true);
    }

    public
    function allDeactvated(ManageUserRequest $request)
    {
        $cat = $this->influencer->allDeactive();

        return Datatables::of($cat)
            ->addColumn('action', function ($cat) {
                return '<a href="' . $cat->id . '/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a> <button  id="cat-activate-' . $cat->id . '" class="btn btn-xs btn-success activateButton" data-id="' . $cat->id . '"><i class="glyphicon glyphicon-play"></i> Activate</button> <button id="cat-delete-' . $cat->id . '" class="btn btn-xs btn-danger btn-delete deleteButton" data-id="' . $cat->id . '" data-remote="edit"><i class="glyphicon glyphicon-trash "></i> Delete</button>';
            })->addIndexColumn()
            /*
            ->addColumn('extra', function () {
                return '<button>asdas</button>>';
            })*/
            ->make(true);
    }

    public
    function deactivateView(ManageUserRequest $request)
    {
        return view('backend.access.influencer.deactivatedInfluencer');
    }

    public
    function deactivateItem(ManageUserRequest $request)
    {

        $this->influencer->deactiveItem($request->id);
    }

    public
    function activateItem(ManageUserRequest $request)
    {

        $this->influencer->activeItem($request->id);
    }


    public function addVideoLinks(Request $request)
    {
        $result = validator($request->all(), [
            'influencer_id' => 'required',
            'url.*' => 'required|url',
        ]);
        if ($result->fails()) {
            $errors = [];
            if ($result->errors()->has('url.*')) {

                array_push($errors, ["Please enter valid URL"]);
            }
            if ($result->errors()->has('link_id')) {
                array_push($errors, ["Product ID is Required"]);
            }
            return response()->json(["status" => 401, "data" => $errors]);
        }

        $result = $this->YoutubeVideoById($request->input('url'));
        if ($result['status'] == 200) {
            foreach ($result['videos'] as $key => $value) {
                $linkModel = new Influencer_video();
                $linkModel->influencer_id = (int)$request->influencer_id;
                $linkModel->url = $value['videoLink'];
                $linkModel->thumbnail = $value['image'];
                $linkModel->video_name = $value['name'];
                $linkModel->video_description = $value['description'];
                $linkModel->save();
            }
            return response()->json(["status" => 200, "data" => "Record added successfully!"]);
        } elseif ($result['status'] == 204) {
            return response()->json(["status" => 401, "data" => ['Unable to find videos']]);
        }
    }

    public
    function editVideoLinks($id)
    {
        try {
            $result = Influencer_video::where('influencer_id', $id)->get();
            if (!$result->isEmpty()) {
                return view('backend.access.influencer.editLink', compact('result'));
            } else {
                return redirect()->route('admin.access.influencer.index');
            }
        } catch (Exception $exception) {
            return redirect()->route('admin.access.influencer.index');
        }
    }

    public
    function updateVideoLinks(Request $request)
    {
//        dd($request);
        try {
            $result = validator($request->all(), [
                'link_id' => 'min:1',
                'url' => 'array|required',
                'url.*' => 'required|url|min:1',
                'id.*' => 'required|string|min:1',
            ]);
            if ($result->fails()) {

                return redirect()->back()->withErrors($result);
            }

            for ($i = 0; $i < count($request->url); $i++) {
                if ($request->id[$i] != "") {
                    $productVideo = Influencer_video::find($request->id[$i]);
                    $productVideo->url = $request->url[$i];
                    $productVideo->save();
                } else {
                    return redirect()->back()->withFlashError('Error updating links');
                }
            }


            return redirect()->route('admin.access.product.index')->withFlashSuccess('Video Link updated successfully!');
        } catch (Exception $exception) {
            return redirect()->route('admin.access.product.index');
        }
    }

    public
    function deleteVideoLinks(Request $request)
    {

        try {
            if (isset($request->id) && $request->id != "") {
                $result = Influencer_video::find($request->id);
                if (isset($result)) {
                    $result->delete();
                    return response()->json(["status" => 200, "message" => "Link deleted successfully!"]);
                } else {
                    return response()->json(["status" => 401, "message" => "Link deleted successfully!"]);
                }
            }

        } catch (Exception $exception) {
            return redirect()->route('admin.access.product.index');
        }
    }

}
