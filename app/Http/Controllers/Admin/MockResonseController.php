<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateMockResonseRequest;
use App\Http\Requests\Admin\UpdateMockResonseRequest;
use App\Repositories\Admin\MockResonseRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class MockResonseController extends AppBaseController
{
    /** @var  MockResonseRepository */
    private $mockResonseRepository;

    public function __construct(MockResonseRepository $mockResonseRepo)
    {
        $this->mockResonseRepository = $mockResonseRepo;
    }

    /**
     * Display a listing of the MockResonse.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->mockResonseRepository->pushCriteria(new RequestCriteria($request));
        $mockResonses = $this->mockResonseRepository->all();

        return view('admin.mock_resonses.index')
            ->with('mockResonses', $mockResonses);
    }

    /**
     * Show the form for creating a new MockResonse.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.mock_resonses.create');
    }

    /**
     * Store a newly created MockResonse in storage.
     *
     * @param CreateMockResonseRequest $request
     *
     * @return Response
     */
    public function store(CreateMockResonseRequest $request)
    {
        $input = $request->all();

        $mockResonse = $this->mockResonseRepository->create($input);

        Flash::success('Mock Resonse saved successfully.');

        return redirect(route('admin.mockResonses.index'));
    }

    /**
     * Display the specified MockResonse.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $mockResonse = $this->mockResonseRepository->findWithoutFail($id);

        if (empty($mockResonse)) {
            Flash::error('Mock Resonse not found');

            return redirect(route('admin.mockResonses.index'));
        }

        return view('admin.mock_resonses.show')->with('mockResonse', $mockResonse);
    }

    /**
     * Show the form for editing the specified MockResonse.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $mockResonse = $this->mockResonseRepository->findWithoutFail($id);

        if (empty($mockResonse)) {
            Flash::error('Mock Resonse not found');

            return redirect(route('admin.mockResonses.index'));
        }

        return view('admin.mock_resonses.edit')->with('mockResonse', $mockResonse);
    }

    /**
     * Update the specified MockResonse in storage.
     *
     * @param  int              $id
     * @param UpdateMockResonseRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMockResonseRequest $request)
    {
        $mockResonse = $this->mockResonseRepository->findWithoutFail($id);

        if (empty($mockResonse)) {
            Flash::error('Mock Resonse not found');

            return redirect(route('admin.mockResonses.index'));
        }

        $mockResonse = $this->mockResonseRepository->update($request->all(), $id);

        Flash::success('Mock Resonse updated successfully.');

        return redirect(route('admin.mockResonses.index'));
    }

    /**
     * Remove the specified MockResonse from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $mockResonse = $this->mockResonseRepository->findWithoutFail($id);

        if (empty($mockResonse)) {
            Flash::error('Mock Resonse not found');

            return redirect(route('admin.mockResonses.index'));
        }

        $this->mockResonseRepository->delete($id);

        Flash::success('Mock Resonse deleted successfully.');

        return redirect(route('admin.mockResonses.index'));
    }
}
