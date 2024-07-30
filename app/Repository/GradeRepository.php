<?php

namespace app\Repository;

use App\Interfaces\GradeInterface;
use App\Models\Grade;

class GradeRepository implements GradeInterface
{
    public function index()
    {
        return Grade::all();
    }

    public function store($request)
    {


        $grade = Grade::create(
            [
                'name' => [
                    'ar' => $request->name,
                    'en' => $request->name_en,
                ],
                'notes' => $request->notes,
            ]
        );
        return $grade;
    }

    public function show($id)
    {
        return Grade::find($id);
    }

    public function edit($id)
    {
        return Grade::find($id);
    }

    public function update($request, $id)
    {
        $grade = Grade::find($id);
        $grade->update([
            'name' => [
                'ar' => $request->name,
                'en' => $request->name_en,
            ],
            'notes' => $request->notes,
        ]);
        return $grade;
    }


    public function delete($id)
    {
        return Grade::find($id)->delete();
    }
}