<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    // Отримання списку проєктів із пагінацією
    public function index(Request $request)
    {
        $projects = Project::query();

        if ($request->query('include') === 'tasks') {
            $projects->with('tasks');
        }

        $projects = $projects->paginate(10);

        return ProjectResource::collection($projects);
    }

    public function store(StoreProjectRequest $request)
    {
        $project = Project::create($request->validated());

        return (new ProjectResource($project))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Request $request, Project $project)
    {
        if ($request->query('include') === 'tasks') {
            $project->load('tasks');
        }

        return new ProjectResource($project);
    }

    public function update(
        UpdateProjectRequest $request,
        Project $project
    ) {
        $project->update($request->validated());

        return new ProjectResource($project->refresh());
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return response()->noContent();
    }
}
