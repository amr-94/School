<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\GradeRequest;
use App\Repository\GradeRepository;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    protected $gradeRepository;

    public function __construct(GradeRepository $gradeRepository)
    {
        $this->gradeRepository = $gradeRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.grades.index', [
            'grades' => $this->gradeRepository->index()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('dashboard.grades.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GradeRequest $request)
    {
        try {
            $grade = $this->gradeRepository->store($request);

            return response()->json([
                'success' => true,
                'message' => 'Grade created successfully',
                'data' => $grade
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('dashboard.grade.show', [
            'grade' => $this->gradeRepository->show($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('dashboard.grades.edit', [
            'grade' => $this->gradeRepository->edit($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GradeRequest $request, $id)
    {
        try {
            $grade = $this->gradeRepository->update($request, $id);

            return response()->json([
                'success' => true,
                'message' => 'Grade updated successfully',
                'data' => $grade
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->gradeRepository->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Grade deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
}
