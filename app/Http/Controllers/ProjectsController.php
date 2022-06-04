<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use App\Project;
use App\Http\Resources\Project as ProjectResource;
use App\Http\Resources\ProjectCollection;
use Illuminate\View\View;

class ProjectsController extends Controller
{

    /**
     * Show the projects page.
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $projects_query = Project::query();
        $projects = $projects_query->get();

        return view('projects')
            ->with('title_prefix', 'Projects')
            ->with('projects', $projects);
    }
}
