<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudy;

class ProgramStudyController extends Controller
{
    public function index()
    {
        return view('programs.index', [
            'programs' => ProgramStudy::active()->get(),
        ]);
    }

    public function show(string $slug)
    {
        $program = ProgramStudy::where('slug', $slug)->firstOrFail();

        return view('programs.show', [
            'program' => $program,
            'related' => ProgramStudy::active()->whereKeyNot($program->id)->take(3)->get(),
        ]);
    }
}
