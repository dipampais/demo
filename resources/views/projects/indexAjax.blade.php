@extends('layouts.appAjax')
@section('content')





<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="text-center">
                <h2>Project Listing</h2>
            </div>
            <div class="text-right pb-4 pr-4">
                <a class="btn btn-success" href="{{ route('projects.create') }}"> Create New Project</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-striped table-bordered tableProjects" id="tableProjects">
        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>Description</th>
                <th>Category</th>
                <th>Status</th>
                <th width="280px">Action</th>
            </tr>
        </thead>
    </table>      
@endsection

@section('scripts')
@endsection