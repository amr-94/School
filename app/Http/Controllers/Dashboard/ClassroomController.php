<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassroomRequest;
use App\Models\Grade;
use App\Repository\ClassroomRepository;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    protected $classroomRepository;

    public function __construct(ClassroomRepository $classroomRepository)
    {
        $this->classroomRepository = $classroomRepository;
    }

    public function index()
    {
        $grades = Grade::all();
        $classrooms = $this->classroomRepository->index();
        return view('dashboard.classroom.index', compact('classrooms', 'grades'));
    }

    public function store(ClassroomRequest $request)
    {
        return $this->classroomRepository->store($request);
    }

    public function show($id)
    {
        $classroom = $this->classroomRepository->show($id);
        return response()->json(['success' => true, 'classroom' => $classroom]);
    }

    public function edit($id)
    {
        $classroom = $this->classroomRepository->show($id);
        return response()->json(['success' => true, 'classroom' => $classroom]);
    }

    public function update(ClassroomRequest $request, $id)
    {
        return $this->classroomRepository->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->classroomRepository->delete($id);
    }

    public function getClassroomsByGradeId($gradeId)
    {
        $classrooms = $this->classroomRepository->getClassroomsByGradeId($gradeId);
        return view('dashboard.classroom.index', compact('classrooms'));
    }
}
