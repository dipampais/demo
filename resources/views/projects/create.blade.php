
@extends('layouts.app')
@section('content')
<div class="customDivAddProject">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left display-inline">
            <h2 class="clsAddProject">Add New Project</h2>
            <a class="btn btn-primary mb-3 mt-3" href="{{ route('projects.index') }}"> Back</a>
        </div>
    </div>
</div>
   
@if($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
   
<form action="{{ route('projects.store') }}" method="POST">
    @csrf
  
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Title:</strong>
                <input type="text" name="title" class="form-control" placeholder="Title">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Description:</strong>
                <textarea class="form-control" style="height:150px" name="description" placeholder="Description"></textarea>
            </div>
        </div>
		<div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Category:</strong>
                <select name="category_id">
                    <option selected value>Please select</option>
					<option value="1">Chemical</option>
					<option value="2">Electrical</option>
					<option value="3">Mechanical</option>
				</select>
            </div>
        </div>
		
		<div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Status:</strong>
                <select name="status">
                    <option selected value>Please select</option>
					<option value="1">Pending</option>
					<option value="2">In Progress</option>
					<option value="3">Completed</option>
				</select>
            </div>
        </div>
		
		
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
   
</form>
</div>
@endsection
<style>
 .customDivAddProject {
    width: 80%;
    margin-left: 10%;
}
a.btn.btn-primary {
    width: 218px;
}
.pull-left.display-inline {
    display: inline;
}
h2.clsAddProject {
    width: 250px;
}
</style>