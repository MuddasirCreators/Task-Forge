<?php

namespace App\Http\Controllers;

use App\Actions\Projects\ArchiveProject;
use App\Actions\Projects\CreateProject;
use App\Actions\Projects\DeleteProject;
use App\Actions\Projects\GetProjectDetails;
use App\Actions\Projects\GetProjectFormData;
use App\Actions\Projects\GetProjects;
use App\Actions\Projects\RestoreProject;
use App\Actions\Projects\UpdateProject;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

use App\Models\Project;

use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;


class ProjectController extends Controller
{


    public function index(
        GetProjects $getProjects
    ) {

        Gate::authorize(
            'viewAny',
            Project::class
        );


        $projects = $getProjects->handle(
            auth()->user()
        );


        return view(
            'projects.index',
            compact('projects')
        );
    }




    public function create(
        GetProjectFormData $getProjectFormData
    ) {

        Gate::authorize(
            'create',
            Project::class
        );


        return view(
            'projects.create',
            $getProjectFormData->handle()
        );
    }




    public function store(
        StoreProjectRequest $request,
        CreateProject $createProject
    ) {

        Gate::authorize(
            'create',
            Project::class
        );


        $createProject->handle(
            $request->validated(),
            auth()->id(),
            $request->validated('member_ids') ?? []
        );


        return redirect()
            ->route('projects.index')
            ->with(
                'success',
                'Project created successfully.'
            );
    }




    public function show(
        Project $project,
        GetProjectDetails $getProjectDetails
    ) {

        Gate::authorize(
            'view',
            $project
        );


        $project = $getProjectDetails->handle(
            $project
        );


        return view(
            'projects.show',
            compact('project')
        );
    }




    public function edit(
        Project $project,
        GetProjectFormData $getProjectFormData
    ) {

        Gate::authorize(
            'update',
            $project
        );


        return view(
            'projects.edit',
            array_merge(
                $getProjectFormData->handle(),
                [
                    'project'=>$project
                ]
            )
        );
    }




    public function update(
        UpdateProjectRequest $request,
        Project $project,
        UpdateProject $updateProject
    ) {

        Gate::authorize(
            'update',
            $project
        );


        try {

            $updateProject->handle(
                $project,
                $request->validated(),
                $request->validated('member_ids') ?? []
            );


        } catch (ValidationException $e) {


            return back()
                ->withInput()
                ->withErrors(
                    $e->errors()
                );
        }



        return redirect()
            ->route('projects.index')
            ->with(
                'success',
                'Project updated successfully.'
            );
    }




    public function archive(
        Project $project,
        ArchiveProject $archiveProject
    ) {

        Gate::authorize(
            'archive',
            $project
        );


        try {

            $archiveProject->handle(
                $project
            );


        } catch (\Exception $e) {


            return redirect()
                ->route('projects.index')
                ->with(
                    'error',
                    $e->getMessage()
                );
        }



        return redirect()
            ->route('projects.index')
            ->with(
                'success',
                'Project archived successfully.'
            );
    }




    public function restore(
        Project $project,
        RestoreProject $restoreProject
    ) {

        Gate::authorize(
            'restore',
            $project
        );


        try {

            $restoreProject->handle(
                $project
            );


        } catch (ValidationException $e) {


            return redirect()
                ->route('projects.index')
                ->with(
                    'error',
                    $e->errors()['project'][0]
                    ??
                    'Project restore failed.'
                );
        }



        return redirect()
            ->route(
                'projects.index',
                [
                    'archived'=>true
                ]
            )
            ->with(
                'success',
                'Project restored successfully.'
            );
    }




    public function destroy(
        Project $project,
        DeleteProject $deleteProject
    ) {

        Gate::authorize(
            'delete',
            $project
        );


        $result = $deleteProject->handle(
            $project
        );


        return redirect()
            ->route('projects.index')
            ->with(
                $result['success']
                    ? 'success'
                    : 'error',
                $result['message']
            );
    }

}