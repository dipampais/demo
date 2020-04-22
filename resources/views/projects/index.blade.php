@extends('layouts.app')
@section('content')





<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Project Listing</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('projects.create') }}"> Create New Project</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Title</th>
            <th>Description</th>
            <th>Category</th>
            <th>Status</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($projects as $project)
        <?php   
            $category = \DB::table('category')->where('id',$project->category_id)->first();
            $categoryName = $category->name;
        ?>
        <tr>
            <td>{{ $project->id }}</td>
            <td>{{ $project->title }}</td>
            <td>{{ $project->description }}</td>
            <td>{{ $categoryName }}</td>
            <td>{{ $project->status }}</td>
            <td>
                <form action="{{ route('projects.destroy',$project->id) }}" method="POST">
  
                    <!-- <a class="btn btn-info" href="{{ route('projects.show',$project->id) }}">Show</a> -->

                    <a class="btn btn-primary" href="{{ url('projects/edit',$project->id) }}">Edit</a>
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="hdn_id" value="{{ $project->id}}" />
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>      
@endsection