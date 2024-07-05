<?php

namespace app\Interfaces;

use App\Http\Requests\GradeRequest;
use GuzzleHttp\Psr7\Request;

interface GradeInterface
{
    public function index();
    public function store($request);
    public function show($id);
    public function edit($id);
    public function update($request, $id);
    public function delete($id);
}
