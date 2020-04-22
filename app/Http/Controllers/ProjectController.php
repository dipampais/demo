<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
   
    public function index()
    {
        $projects = Project::latest()->paginate(5);
        $data['projects'] = $projects;
        return view('projects.index',$data);
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