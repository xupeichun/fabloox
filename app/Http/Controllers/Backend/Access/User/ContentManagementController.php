<?php

namespace App\Http\Controllers\Backend\Access\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Access\User\Content;

class ContentManagementController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function viewPolicy()
    {

        try {
            $contentObj = Content::first();
            if (isset($contentObj)) {
                $data = $contentObj->policy;
                return view('backend.access.contents.policy', compact('data'));
            } else {
                $data = null;
                return view('backend.access.contents.policy', compact('data'));
            }
        } catch (\Exception $exp) {
            return redirect()->back()->with('status', $exp->getMessage());
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addPolicy(Request $request)
    {
        /*                $this->validate(
                            $request,
                            [
                                'policy' => 'required'
                            ]
                        );*/
        try {
            if (isset($request)) {

                $contentObj = Content::first();

                if (isset($contentObj)) {
                    $contentPolicy = $contentObj;
                    $contentPolicy->policy = $request->policy;
                    if ($contentPolicy->save()) {
                        return redirect()->back()->with('flash_success', 'Content updated successfully!');
                    } else {

                        return redirect()->back()->with('flash_danger', 'Content not updated');;
                    }
                } else {
                    $content = new Content;
                    $content->policy = $request->policy;

                    if ($content->save()) {

                        return redirect()->back()->with('flash_success', 'Content updated successfully!');
                    } else {
                        return redirect()->back()->with('flash_danger', 'Content could not Updated');
                    }
                }
            }
        } catch (\Exception $exp) {
            return redirect()->back()->with('flash_danger', $exp->getMessage());
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function viewTerms()
    {
        try {
            $contentObj = Content::first();
            if (isset($contentObj)) {
                $data = $contentObj->terms;
                return view('backend.access.contents.terms', compact('data'));
            } else {
                $data = null;
                return view('backend.access.contents.terms', compact('data'));
            }
        } catch (\Exception $exp) {
            return redirect()->back()->with('status', $exp->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addTerms(Request $request)
    {
        try {
            if (isset($request)) {

                $contentObj = Content::first();

                if (isset($contentObj)) {
                    $contentPolicy = $contentObj;
                    $contentPolicy->terms = $request->terms;
                    if ($contentPolicy->save()) {
                        return redirect()->back()->with('flash_success', 'Content updated successfully!');
                    } else {

                        return redirect()->back()->with('flash_danger', 'Content not Updated');;
                    }
                } else {
                    $content = new Content;
                    $content->terms = $request->terms;

                    if ($content->save()) {

                        return redirect()->back()->with('flash_success', 'Content updated successfully!');
                    } else {
                        return redirect()->back()->with('flash_danger', 'Content could not Updated');
                    }
                }
            }
        } catch (\Exception $exp) {
            return redirect()->back()->with('flash_danger', $exp->getMessage());
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function viewFaqs()
    {
        try {
            $contentObj = Content::first();
            if (isset($contentObj)) {
                $data = $contentObj->faqs;
                return view('backend.access.contents.faqs', compact('data'));
            } else {
                $data = null;
                return view('backend.access.contents.faqs', compact('data'));
            }
        } catch (\Exception $exp) {
            return redirect()->back()->with('status', $exp->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addFaqs(Request $request)
    {
        try {
            if (isset($request)) {

                $contentObj = Content::first();

                if (isset($contentObj)) {
                    $contentPolicy = $contentObj;
                    $contentPolicy->faqs = $request->faqs;
                    if ($contentPolicy->save()) {
                        return redirect()->back()->with('flash_success', 'Content updated successfully!');
                    } else {

                        return redirect()->back()->with('flash_danger', 'Content not Updated');;
                    }
                } else {
                    $content = new Content;
                    $content->faqs = $request->faqs;

                    if ($content->save()) {

                        return redirect()->back()->with('flash_success', 'Content updated successfully!');
                    } else {
                        return redirect()->back()->with('flash_danger', 'Content could not Updated');
                    }
                }
            }
        } catch (\Exception $exp) {
            return redirect()->back()->with('flash_danger', $exp->getMessage());
        }
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function viewInfo()
    {
        try
        {
            $contentObj = Content::first();
            if (isset($contentObj))
            {
                $data = $contentObj->info;
                return view('backend.access.contents.help', compact('data'));
            }else{
                $data = null;
                return view('backend.access.contents.help', compact('data'));
            }
        }catch (\Exception $exp){
            return redirect()->back()->with('status', $exp->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addInfo(Request $request)
    {
        try {
            if (isset($request)) {

                $contentObj = Content::first();

                if (isset($contentObj)) {
                    $contentPolicy = $contentObj;
                    $contentPolicy->info = $request->info;
                    if ($contentPolicy->save()) {
                        return redirect()->back()->with('flash_success', 'Content updated successfully!');
                    } else {

                        return redirect()->back()->with('flash_danger', 'Content not Updated');;
                    }
                } else {
                    $content = new Content;
                    $content->info = $request->info;

                    if ($content->save()) {

                        return redirect()->back()->with('flash_success', 'Content updated successfully!');
                    } else {
                        return redirect()->back()->with('flash_danger', 'Content could not Updated');
                    }
                }
            }
        } catch (\Exception $exp) {
            return redirect()->back()->with('flash_danger', $exp->getMessage());
        }
    }

    public function viewAbout()
    {
        try {
            $contentObj = Content::first();
            if (isset($contentObj)) {
                $data = $contentObj->about;
                return view('backend.access.contents.about', compact('data'));
            } else {
                $data = null;
                return view('backend.access.contents.about', compact('data'));
            }
        } catch (\Exception $exp) {
            return redirect()->back()->with('status', $exp->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addAbout(Request $request)
    {
        try {
            if (isset($request)) {

                $contentObj = Content::first();

                if (isset($contentObj)) {
                    $contentAbout = $contentObj;
                    $contentAbout->about = $request->about;
                    if ($contentAbout->save()) {
                        return redirect()->back()->with('flash_success', 'Content updated successfully!');
                    } else {

                        return redirect()->back()->with("flash_danger', 'Content could not Updated");
                    }
                } else {
                    $content = new Content;
                    $content->about = $request->about;

                    if ($content->save()) {

                        return redirect()->back()->with('flash_success', 'Content updated successfully!');
                    } else {
                        return redirect()->back()->with('flash_danger', 'Content could not Updated');
                    }
                }
            }
        } catch (\Exception $exp) {
            return redirect()->back()->with('flash_danger', $exp->getMessage());
        }
    }
}
