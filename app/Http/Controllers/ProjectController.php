<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $types = Project::where('is_published', true)
            ->select('type')
            ->distinct()
            ->get();

        return view('projects.index', compact('types'));
    }

    public function type(string $type)
    {
        abort_unless(in_array($type, ['building', 'interior']), 404);

        $projects = Project::where('type', $type)
            ->where('is_published', true)
            ->get();

        abort_if($projects->isEmpty(), 404);

        return view('projects.type', compact('projects', 'type'));
    }
}
