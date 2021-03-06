<?php

namespace App\Http\Controllers;

use App\Http\Requests\SkillRequest;
use App\Photo;
use App\Scope;
use App\Skill;
use App\User;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SkillController extends Controller
{
    public function __construct()
    {
        //$this->middleware
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skills = Skill::with('photos')->get();
        return $skills;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this -> authorize('skill_create');

        $scopes = Scope::all();
        return view('skills.create',compact('scopes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SkillRequest $request)
    {
        //validate on SkillRequest
        $this -> authorize('skill_create');

        $scope = Scope::where('id',$request->scope)->firstOrFail();
        $user = auth()->user();

        $skill = new Skill($request->all());

        $scope->skills()->save($skill);
        $user->skills()->save($skill);

        $skill->save();

        //show popup
        flash()->success('Create Skill', 'creation was successful');

        //redirect
        return redirect("skills/".$skill->id."/addPhoto");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($skill)
    {
        $skill = Skill::where('id',$skill)->with('photos')->firstOrFail();
        return $skill;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this -> authorize('skill_edit');
        $skill = Skill::where('id',$id)->firstOrFail();

        return view('skills.edit',compact(['skill']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //TODO: handling changing Scope and add or delete photo to a skill
        $this -> authorize('skill_edit');

        $skill = Skill::where('id',$id)->fistOrFail();
        $skill->update($request->all());

        flash()->success('Update Skill','Skill updated successfully');
        return redirect()->route('skills.show',$skill->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('skill_delete');

        $skill = Skill::where('id',$id)->firstOrFail();
        $photos = $skill->photos;
        foreach ($photos as $photo)
        {
            Storage::delete($photo->photo_path);
            $photo->delete();
        }
        $skill->delete();

        return redirect(route('skills.index'));
    }

    public function addPhoto($id,Request $request)
    {
        $this->authorize('skill_edit');

        $photo_path = $request->file('file')->store('photosOfskills');
        $photo = new Photo(['photo_path'=>$photo_path]);
        $skill = Skill::where('id',$id)->firstOrFail();
        $skill -> photos() -> save($photo);
        $photo->save();

        return $skill;
    }

    public function addPhotoPage($id,Request $request)
    {
        $this->authorize('skill_edit');

        $skill = Skill::where('id',$id)->firstOrFail();
        return view('skills.addPhoto',compact('skill'));
    }

}
