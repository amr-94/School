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
            $classroom = Classroom::create([
                'name' => [
                    'ar' => $request->name,
                    'en' => $request->name_en,
                ],
                'grade_id' => $request->grade_id,
            ]);

            $classroom->load('grade');

            return response()->json(['success' => true, 'message' => 'Classroom created successfully', 'classroom' => $classroom]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function update($request, $id)
    {
        try {
            $classroom = Classroom::findOrFail($id);
            $classroom->update([
                'name' => [
                    'ar' => $request->name,
                    'en' => $request->name_en,
                ],
                'grade_id' => $request->grade_id,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Classroom created successfully',
                'classroom' => $classroom,
            ]);
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
