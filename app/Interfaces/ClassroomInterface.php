<?php

namespace App\Interfaces;

interface ClassroomInterface
{
    public function index();
    public function store($request);
    public function update($request, $id);
    public function delete($id);
    public function edit($id);
    public function show($id);
    public function getClassroomsByGradeId($gradeId);
}