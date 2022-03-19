<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectInfos;
use App\Traits\File;
use App\Traits\Res;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{

    use File, Res;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('projects.index');
        Carbon::setLocale('ar');
        $projects = Project::latest();
        if($request->name) {
            $projects = $projects->where('name', 'like', '%' . $request->name . '%');
        }
        $projects = $projects->paginate(10);
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('projects.create');
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('projects.create');
        preg_match_all('!https?://\S+!', $request->location, $matches);
        if(count($matches[0]) > 0) {
            $request->location = $matches[0][0];
        }
        $validator_array = [
            'name' => 'required',
            'photos' => 'required',
            'description' => 'required'
        ];
        $validator_array_msgs = [
            'name.required' => 'الأسم مطلوب',
            'photos.required' => 'الصور مطلوبة',
            'description.required' => 'الوصف مطلوب'
        ];
        if(isset($request->infos)) {
            if($request->infos) {
                $validator_array['infos.*.round'] = 'required';
                $validator_array['infos.*.rooms'] = 'required';
                $validator_array['infos.*.price'] = 'required';
                $validator_array['infos.*.price'] = 'regex:/^\d+(\.\d{1,2})?$/';
                $validator_array['infos.*.status'] = ['required'];
                $validator_array_msgs['infos.*.round.required'] = 'الدور مطلوب ';
                $validator_array_msgs['infos.*.rooms.required'] = 'عدد الشقق مطلوب ';
                $validator_array_msgs['infos.*.price.required'] = 'السعر مطلوب ';
                $validator_array_msgs['infos.*.price.regex'] = 'السعر يجب ان يكون رقم';
                $validator_array_msgs['infos.*.status.required'] = 'الحالة مطلوبة ';
                $validator_array_msgs['infos.*.status.in'] = 'يجب أختيار حالة من الحالات المحددة';
            }
        }
        $validator = Validator::make($request->all(), $validator_array, $validator_array_msgs);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all())->with('error', 'يوجد خطأ ما');
        }
        $creation = [
            'name' => $request->name,
            'buildings' => $request->buildings,
            'units' => $request->units,
            'available_units' => $request->available_units,
            'description' => $request->description,
            'location' => $request->location,
            'location_features' => $request->location_features,
            'viewed_number' => $request->viewed_number
        ];
        if($request->active) {
            $creation['active'] = 1;
        } else {
            $creation['active'] = 0;
        }
        $photos = [];
        if($request->has('photos')) {
            foreach ($request->file('photos') as $photo) {
                $photos[] = $this->uploadFiles($photo, $this->projectsPath);
            }
            $creation['photos'] = json_encode($photos);
        }
        if($request->has('file')) {
            $creation['file'] = $this->uploadFile($request, $this->projectsPath, 'file');
        }
        $project = Project::create($creation);
        if(isset($request->infos)) {
            if($request->infos) {
                foreach ($request->infos as $info) {
                    $projectInfoCreation = [
                        'project_id' => $project->id,
                        'round' => $info['round'],
                        'rooms' => $info['rooms'],
                        'description' => $info['description'],
                        'space' => $info['space'],
                        'features' => $info['features'],
                        'price' => $info['price'],
                        'status' => $info['status']
                    ];
                    $info_photos = [];
                    if(isset($info['photos'])) {
                        foreach ($info['photos'] as $photo) {
                            $info_photos[] = $this->uploadFiles($photo, $this->projectsPath);
                        }
                        $projectInfoCreation['photos'] = json_encode($info_photos);
                    }
                    ProjectInfos::create($projectInfoCreation);
                }
            }
        }
        return redirect()->back()->with('success', 'تم انشاء المشروع بنجاح');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $this->authorize('projects.edit');
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $this->authorize('projects.edit');
        preg_match_all('!https?://\S+!', $request->location, $matches);
        if(count($matches[0]) > 0) {
            $request->location = $matches[0][0];
        }
        $validator_array = [
            'name' => 'required',
            'description' => 'required'
        ];
        $validator_array_msgs = [
            'name.required' => 'الأسم مطلوب',
            'description.required' => 'الوصف مطلوب'
        ];
        if(isset($request->infos)) {
            if($request->infos) {
                $validator_array['infos.*.round'] = 'required';
                $validator_array['infos.*.rooms'] = 'required';
                $validator_array['infos.*.price'] = 'required';
                $validator_array['infos.*.price'] = 'regex:/^\d+(\.\d{1,2})?$/';
                $validator_array['infos.*.status'] = ['required'];
                $validator_array_msgs['infos.*.round.required'] = 'الدور مطلوب ';
                $validator_array_msgs['infos.*.rooms.required'] = 'عدد الشقق مطلوب ';
                $validator_array_msgs['infos.*.price.required'] = 'السعر مطلوب ';
                $validator_array_msgs['infos.*.price.regex'] = 'السعر يجب ان يكون رقم';
                $validator_array_msgs['infos.*.status.required'] = 'الحالة مطلوبة ';
                $validator_array_msgs['infos.*.status.in'] = 'يجب أختيار حالة من الحالات المحددة';
            }
        }
        $validator = Validator::make($request->all(), $validator_array, $validator_array_msgs);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all())->with('error', 'يوجد خطأ ما');
        }
        $updateTable = [
            'name' => $request->name,
            'buildings' => $request->buildings,
            'units' => $request->units,
            'available_units' => $request->available_units,
            'description' => $request->description,
            'location' => $request->location,
            'location_features' => $request->location_features,
            'viewed_number' => $request->viewed_number
        ];
        if($request->active) {
            $updateTable['active'] = 1;
        } else {
            $updateTable['active'] = 0;
        }
        $photos = [];
        if($request->has('file')) {
            $updateTable['file'] = $this->uploadFile($request, $this->projectsPath, 'file');
            if(file_exists($project->file)) {
                $file = last(explode('/', $project->file));
                if(in_array($file, scandir(dirname($project->file)))) {
                    unlink($project->file);
                }
            }
        }
        if($request->has('photos')) {
            $photos = [];
            // Remove Current Photo
            if($project->photos) {
                $this->removePhotos($project);
            }
            // Upload New Photos
            foreach ($request->file('photos') as $photo) {
                $photos[] = $this->uploadFiles($photo, $this->projectsPath);
            }
            // return json_encode($photos);
            $updateTable['photos'] = json_encode($photos);
        }
        $project->update($updateTable);
        if(isset($request->infos)) {
            if($request->infos) {
                foreach ($request->infos as $info) {
                    if($project->infos->count() > 0) {
                        if(isset($info['id'])) {
                            $currentProject = $project->infos->where('id', $info['id'])->first();
                        } else {
                            $currentProject = '';
                        }
                    } else {
                        $currentProject = '';
                    }
                    $info_photos = [];
                    if(isset($info['photos'])) {
                        foreach ($info['photos'] as $photo) {
                            $info_photos[] = $this->uploadFiles($photo, $this->projectsPath);
                        }
                    }
                    if($currentProject) {
                        $currentProject->update([
                            'round' => $info['round'],
                            'rooms' => $info['rooms'],
                            'description' => $info['description'],
                            'space' => $info['space'],
                            'features' => $info['features'],
                            'price' => $info['price'],
                            'status' => $info['status']
                        ]);
                        if(isset($info['photos'])) {
                            if(json_decode($currentProject->photos) !== null) {
                                foreach (json_decode($currentProject->photos) as $photo) {
                                    if(file_exists($photo)) {
                                        unlink($photo);
                                    }
                                }
                            }
                            $currentProject->update([
                                'photos' => json_encode($info_photos)
                            ]);
                        }
                    } else {
                        $projectInfoCreation = [
                            'project_id' => $project->id,
                            'round' => $info['round'],
                            'rooms' => $info['rooms'],
                            'description' => $info['description'],
                            'space' => $info['space'],
                            'features' => $info['features'],
                            'price' => $info['price'],
                            'status' => $info['status']
                        ];
                        if(count($info_photos) > 0) {
                            $projectInfoCreation['photos'] = json_encode($info_photos);
                        }
                        ProjectInfos::create($projectInfoCreation);
                    }
                }
            }
        }
        return redirect()->back()->with('info', 'تم تعديل المشروع بنجاح');
    }


    public function removePhotos(Project $project) {
        foreach (json_decode($project->photos) as $photo) {
            if(file_exists($photo)) {
                unlink($photo);
            }
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $this->authorize('projects.destroy');
        if(file_exists($project->file)) {
            $file = last(explode('/', $project->file));
            if(in_array($file, scandir(dirname($project->file)))) {
                unlink($project->file);
            }
        }
        if($project->photos) {
            $this->removePhotos($project);
        }
        if(count($project->infos) > 0) {
            foreach ($project->infos as $info) {
                foreach (json_decode($info['photos']) as $photo) {
                    if(file_exists($photo)) {
                        unlink($photo);
                    }
                }
            }
        }
        Project::destroy($project->id);
        return redirect()->back()->with('success', 'تمت ازالة ' . $project->name . ' بنجاح');
    }


    public function removeInfo(Request $request) {
        $projectInfo = ProjectInfos::where(['id' => $request->info_id, 'project_id' => $request->project_id])->first();
        if($projectInfo) {
            $projectInfo->delete();
            if($projectInfo['photos']) {
                foreach (json_decode($projectInfo['photos']) as $photo) {
                    if(file_exists($photo)) {
                        unlink($photo);
                    }
                }
            }
            return $this->sendRes('تمت ازالة الدور بنجاح', true);
        } else {
            return $this->sendRes('', false);
        }
    }
}
