<?php

namespace App\Http\Controllers\Backend\Access\Brand;

use App\Models\Admin\BrandVideo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\User\ManageUserRequest;
use App\Repositories\Backend\Access\Brand\BrandRepository;
use Yajra\Datatables\Facades\Datatables;

class BrandTableController extends Controller
{

    protected $brand;


    public function __construct(BrandRepository $brand)
    {
        $this->brand = $brand;

    }

    public function getAll(ManageUserRequest $request)
    {
        $cat = $this->brand->allActive();

        return Datatables::of($cat)
            ->addColumn('logo', function ($cat) {
                return '<img width="50" src="' . asset('/') . $cat->logo . '"/>';
            })
            ->addColumn('action', function ($cat) {
                if (empty($cat->brandVideos->toArray())) {
                    $editButton = '';
                } else {
                    $editButton = '<a href="brand/editlinks/' . $cat->id . '" class="btn btn-xs btn-success " data-id="' . $cat->id . '" ><i class="glyphicon glyphicon-edit"></i> Edit videos</button>';
                }
                return '<a href="brand/' . $cat->id . '/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a> <button id="cat-deactivate-' . $cat->id . '" class="btn btn-xs btn-warning deactivateButton" data-id="' . $cat->id . '"><i class="glyphicon glyphicon-pause "></i> Deactivate</button> <button id="cat-delete-' . $cat->id . '" class="btn btn-xs btn-danger btn-delete deleteButton" data-id="' . $cat->id . '" data-remote="edit"><i class="glyphicon glyphicon-trash "></i> Delete</button> <button class="btn btn-xs btn-info addLinks " data-id="' . $cat->id . '" > <i class="glyphicon glyphicon-plus "></i> Add videos</button>' . $editButton;
            })->addIndexColumn()
            ->rawColumns(['logo', 'action'])
            ->make(true);
    }

    public function allDeactvated(ManageUserRequest $request)
    {
        $cat = $this->brand->allDeactive();

        return Datatables::of($cat)
            ->addColumn('logo', function ($cat) {
                return '<img width="50" src="' . asset('/'). $cat->logo . '"/>';
            })
            ->addColumn('action', function ($cat) {
                return '<a href="' . $cat->id . '/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a> <button  id="cat-activate-' . $cat->id . '" class="btn btn-xs btn-success activateButton" data-id="' . $cat->id . '"><i class="glyphicon glyphicon-play "></i> Activate</button> <button id="cat-delete-' . $cat->id . '" class="btn btn-xs btn-danger btn-delete deleteButton" data-id="' . $cat->id . '" data-remote="edit"><i class="glyphicon glyphicon-trash "></i> Delete</button>';
            })->addIndexColumn()
            ->rawColumns(['logo', 'action'])
            ->make(true);
    }

    public function deactivateView(ManageUserRequest $request)
    {
        return view('backend.access.brand.deactivatedBrand');
    }

    public function deactivateBrand(ManageUserRequest $request)
    {

        $this->brand->deactiveBrand($request->id);
    }

    public function activateBrand(ManageUserRequest $request)
    {

        $this->brand->activeBrand($request->id);
    }

    public function deleteBrand(ManageUserRequest $request)
    {

        $this->brand->deleteBrand($request->id);
    }

    public function addVideoLinks(Request $request)
    {
        $result = validator($request->all(), [
            'brand_id' => 'required',
            'url.*' => ['required','url',"regex:/^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/"],
        ]);
        if ($result->fails()) {
            $errors = [];
            if ($result->errors()->has('url.*')) {

                array_push($errors, ["Please enter valid url"]);
            }
            if ($result->errors()->has('link_id')) {
                array_push($errors, ["Product id is Required"]);
            }
            return response()->json(["status" => 401, "data" => $errors]);
        }

        $result = $this->YoutubeVideoById($request->input('url'));
        if ($result['status'] == 200) {
            foreach ($result['videos'] as $key => $value) {
                $brandModel = new BrandVideo();
                $brandModel->brand_id = (int)$request->brand_id;
                $brandModel->videoLink = $value['videoLink'];
                $brandModel->image = $value['image'];
                $brandModel->name = $value['name'];
                $brandModel->description = $value['description'];
                $brandModel->save();
            }
            return response()->json(["status" => 200, "data" => "Record added successfully!"]);
        } elseif ($result['status'] == 204) {
            return response()->json(["status" => 401, "data" => ['Unable to find videos.']]);
        }
    }


    public
    function editVideoLinks($id)
    {
        try {
            $result = BrandVideo::where('brand_id', $id)->get();
            if (!$result->isEmpty()) {
                return view('backend.access.brand.editLink', compact('result'));
            } else {
                return redirect()->route('admin.access.brand.index');
            }
        } catch (Exception $exception) {
            return redirect()->route('admin.access.brand.index');
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
            $result = $this->YoutubeVideoById($request->url);



/*            for ($i = 0; $i < count($request->url); $i++) {
                if ($request->id[$i] != "") {
                    $productVideo = BrandVideo::find($request->id[$i]);
                    $productVideo->videoLink = $request->url[$i];
                    $productVideo->save();
                } else {
                    return redirect()->back()->withFlashError('Error updating links');
                }
            }*/
            if ($result['status'] == 200) {
                if (count($result['videos']) == count($request->url)) {
                    for ($i = 0; $i < count($request->url); $i++) {
                        if ($request->id[$i] != "") {
                            $productVideo = BrandVideo::find($request->id[$i]);
                            $productVideo->videoLink = $result['videos'][$i]['videoLink'];
                            $productVideo->image = $result['videos'][$i]['image'];
                            $productVideo->name = $result['videos'][$i]['name'];
                            $productVideo->description = $result['videos'][$i]['description'];
                            $productVideo->save();
                        } else {
                            return redirect()->back()->withFlashDanger('Error updating links');
                        }
                    }
                } else {
                    $videoIds =$result['videos'];
                    return redirect()->back()->withInput()->withFlashDanger('Could not found videos with this link',$videoIds);

                }

            } else {

                return redirect()->back()->withFlashDanger('No video found with these links');
            }

            return redirect()->route('admin.access.brand.index')->withFlashSuccess('Video Link updated successfully!');
        } catch (Exception $exception) {
            return redirect()->route('admin.access.brand.index');
        }
    }

    public
    function deleteVideoLinks(Request $request)
    {
        try {
            if (isset($request->id) && $request->id != "") {
                $result = BrandVideo::find($request->id);
                if (isset($result) && $result->delete()) {
                    ;
                    return response()->json(["status" => 200, "message" => "Link deleted successfully!"]);
                } else {
                    return response()->json(["status" => 401, "message" => "Error deleting"]);
                }
            }

        } catch (Exception $exception) {
            return redirect()->route('admin.access.brand.index');
        }
    }
}
