<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateFaqsRequest;
use App\Http\Requests\Admin\UpdateFaqsRequest;
use App\Repositories\Admin\FaqsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class FaqsController extends AppBaseController
{
    /** @var  FaqsRepository */
    private $faqsRepository;

    public function __construct(FaqsRepository $faqsRepo)
    {
        $this->faqsRepository = $faqsRepo;
    }

    /**
     * Display a listing of the Faqs.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->faqsRepository->pushCriteria(new RequestCriteria($request));
        $faqs = $this->faqsRepository->all();

        return view('admin.faqs.index')
            ->with('faqs', $faqs);
    }

    /**
     * Show the form for creating a new Faqs.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.faqs.create');
    }

    /**
     * Store a newly created Faqs in storage.
     *
     * @param CreateFaqsRequest $request
     *
     * @return Response
     */
    public function store(CreateFaqsRequest $request)
    {
        $input = $request->all();

        $faqs = $this->faqsRepository->create($input);

        Flash::success('Faqs saved successfully.');

        return redirect(route('admin.faqs.index'));
    }

    /**
     * Display the specified Faqs.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $faqs = $this->faqsRepository->findWithoutFail($id);

        if (empty($faqs)) {
            Flash::error('Faqs not found');

            return redirect(route('admin.faqs.index'));
        }

        return view('admin.faqs.show')->with('faqs', $faqs);
    }

    /**
     * Show the form for editing the specified Faqs.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $faqs = $this->faqsRepository->findWithoutFail($id);

        if (empty($faqs)) {
            Flash::error('Faqs not found');

            return redirect(route('admin.faqs.index'));
        }

        return view('admin.faqs.edit')->with('faqs', $faqs);
    }

    /**
     * Update the specified Faqs in storage.
     *
     * @param  int              $id
     * @param UpdateFaqsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFaqsRequest $request)
    {
        $faqs = $this->faqsRepository->findWithoutFail($id);

        if (empty($faqs)) {
            Flash::error('Faqs not found');

            return redirect(route('admin.faqs.index'));
        }

        $faqs = $this->faqsRepository->update($request->all(), $id);

        Flash::success('Faqs updated successfully.');

        return redirect(route('admin.faqs.index'));
    }

    /**
     * Remove the specified Faqs from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $faqs = $this->faqsRepository->findWithoutFail($id);

        if (empty($faqs)) {
            Flash::error('Faqs not found');

            return redirect(route('admin.faqs.index'));
        }

        $this->faqsRepository->delete($id);

        Flash::success('Faqs deleted successfully.');

        return redirect(route('admin.faqs.index'));
    }
}
