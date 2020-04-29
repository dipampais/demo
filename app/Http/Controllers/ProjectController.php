<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Datatables;

class ProjectController extends Controller
{
   
    public function index()
    {
        $projects = Project::orderBy('id', 'desc')->get();
        $data['projects'] = $projects;
        return view('projects.index',$data);
    }


    public function indexAjax()
    {
        return view('projects.indexAjax');
    }


    public function indexAjaxData(){
        
        $projects = \DB::table('projects')->join('category', 'category.id', '=', 'projects.category_id')->select('projects.id', 'projects.title', 'projects.description', 'projects.description','category.name as category_name','projects.status')->orderBy('projects.id', 'desc')->get();
        
        return datatables()->of($projects)
            ->addColumn('action', function ($project) {
                $urlEdit = url("projects/edit",$project->id);
                $urlDelete = url("projects/edit",$project->id);
                return "<a href='".$urlEdit."' class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit</a>"."&nbsp;"."<a href='#' onClick='deleteRecord(".$project->id.")' class='btn btn-danger'><i class='fa fa-trash-alt'></i> Delete</a>";
            })
            ->make(true);

        //return datatables()->of($projects)->make(true);
    }


    public function deleteRecord(){
        $data = array();
        if(isset(request()->id))
        {
            $response = Project::where('id', request()->id)->delete();
            if($response){
                $data['success'] = "Record Deleted Sucessfully";
            }
            else {
                $data['error'] = "There is some issue, please try again";
            }
        }
        
        return response()->json(array('data'=> $data), 200);
    }
    
    public function create()
    {
        return view('projects.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'status' => 'required',
        ]);
  
        Project::create($request->all());
   
        return redirect()->route('projects.index')->with('success','Project created successfully.');
    }

    
    public function show(Project $projects)
    {
        return view('projects.show',compact('project'));
    }

    
    
    public function edit($id)
    {   
        $data = [];
        $data['list'] = \DB::table('projects')->where('id',$id)->first();
        $data['category'] = \DB::table('category')->get();
        return view('projects.edit',$data);
    }

    
    
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'status'  => 'required',
        ]);
        
        $id = $request->hdn_id;
        
        $update = [
            'title'=>$request->title,
            'description'=>$request->description,
            'category_id'=>$request->category_id,
            'status'=>$request->status,
        ];
      
        \DB::table('projects')->where('id',$id)->update($update);
        return redirect()->route('projects.index')->with('success','Project updated successfully');
    }

    
    public function destroy(Request $request)
    {
        
        $id = $request->hdn_id;
        Project::destroy($id);
        return redirect()->route('projects.index')->with('success','Project deleted successfully');
    }

}