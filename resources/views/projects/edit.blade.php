@extends('projects.layout')
@section('content')

<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Project</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('projects.index') }}"> Back</a>
            </div>
        </div>
    </div>
   
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  
    <form action="{{ route('projects.update',$list->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="hdn_id" value="{{ $list->id}}" />
        <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Title:</strong>
                <input value='{{$list->title}}' type="text" name="title" class="form-control" placeholder="Title">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Description:</strong>
                <textarea class="form-control" style="height:150px" name="description" placeholder="Description">{{$list->description}}</textarea>
            </div>
        </div>
		<div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Category:</strong>
                <select name="category_id">
                <option selected value>Please select</option>
                @foreach($category as $cat)
                    <option value="{{ $cat->id }}" {{$cat->id == $list->category_id  ? 'selected' : ''}}>{{ $cat->name }}</option>
			    @endforeach
                </select>
            </div>
        </div>
		
		<div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Status:</strong>
                <select name="status">
                    <option selected value>Please select</option>
					<option value="1" {{$list->status=="Pending"?'selected' : ''}}>Pending</option>
					<option value="2" {{$list->status=="In Progress"?'selected' : ''}}>In Progress</option>
					<option value="3" {{$list->status=="Completed"?'selected' : ''}}>Completed</option>
				</select>
            </div>
        </div>
		
		
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
   
    </form>
@endsection