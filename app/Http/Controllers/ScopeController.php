<?php

namespace App\Http\Controllers;

use App\Child;
use App\Http\Requests\ScopeRequest;
use App\Permission;
use App\Scope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScopeController extends Controller
{
    public function __counstruct()
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
        $scopes = Scope::with('skills') -> get();
        return $scopes;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this -> authorize('scope_create');
        return view('scopes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScopeRequest $request)
    {
        //validate on ScopeRequest
        $this->authorize('scope_create');

        $photo_path = $request -> file('photo') -> store('photosOfscopes');
        $scope = new Scope($request -> all());
        $scope -> photo_path = $photo_path;

        $scope->save();

        //show popup
        flash()->success('Create Scope', 'creation was successful');

        //redirect
        return redirect('scopes/'.$scope->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($scope)
    {
        $scope = Scope::where('id',$scope)->with('skills')->firstOrFail();
        return $scope;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this -> authorize('scope_edit');
        $scope = Scope::where('id',$id) -> firstOrFail();

        //TODO : construct view (scopes.edit)
        return view('scopes.edit',compact('scope'));
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
        $this -> authorize('scope_edit');

        $scope = Scope::where('id',$id)->firstOrFail();
        $scope -> update($request->all());

        return $scope;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('scope_delete');

        $scope = Scope::where('id',$id)->firstOrFail();
        Storage::delete($scope->photo_path);
        $scope->delete();

        return redirect(route('skills.index'));
    }
}
