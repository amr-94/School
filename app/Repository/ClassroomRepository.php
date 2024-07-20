<?php

namespace App\Repository;

use App\Interfaces\ClassroomInterface;
use App\Models\Classroom;
use Exception;

class ClassroomRepository implements ClassroomInterface
{
    public function index()
    {
        return Classroom::with('grade')->get();
    }

    public function store($request)
    {
        try {
            $classrooms = [];

            foreach ($request->classrooms as $classroomData) {
                $classroom = Classroom::create([
                    'name' => [
                        'ar' => $classroomData['name'],
                        'en' => $classroomData['name_en'],
                    ],
                    'grade_id' => $classroomData['grade_id'],
                ]);

                $classroom->load('grade');
                $classrooms[] = $classroom;
            }

            return response()->json(['success' => true, 'message' => 'Classrooms created successfully', 'classrooms' => $classrooms]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function update($request, $id)
    {
        // $validatedData = $request->validate([
        //     'classrooms.*.name' => 'required|string',
        //     'classrooms.*.name_en' => 'required|string',
        //     'classrooms.*.grade_id' => 'required|integer|exists:grades,id'
        // ]);
        try {
            $classrooms = [];

            foreach ($request->classrooms as $classroomData) {
                $classroom = Classroom::findOrFail($id);
                $classroom->update([
                    'name' => [
                        'ar' => $classroomData['name'],
                        'en' => $classroomData['name_en'],
                    ],
                    'grade_id' => $classroomData['grade_id'],
                ]);

                $classroom->load('grade');
                $classrooms[] = $classroom;
            }


            return response()->json(['success' => true, 'message' => 'Classroom updated successfully.', 'classroom' => $classroom]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $classroom = Classroom::findOrFail($id);
            $classroom->delete();

            return response()->json(['success' => true, 'message' => 'Classroom deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while deleting the classroom: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        return Classroom::with('grade')->findOrFail($id);
    }

    public function getClassroomsByGradeId($gradeId)
    {
        return Classroom::where('grade_id', $gradeId)->get();
    }
}