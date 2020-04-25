@extends('layouts.app')

@section('content')



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>
                @if(!empty($error))
                <div class="alert alert-danger"> {{ $error }}</div>
                @endif
                @if(!empty($success))
                <div class="alert alert-success"> {{ $success }}</div>
                @endif
                <div class="card-body">

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                    <form method="POST" action="{{ route('updateProfile') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ? old('name') : $data->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ? old('email') : $data->email }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  autocomplete="new-password">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="gender" class="col-md-4 col-form-label text-md-right">Gender</label>
                        
                            <div class="form-check">
                                <label class="form-check-label"><input type="radio" class="form-check-input" name="gender" value="0" {{$data->gender==0?'checked':''}}>Male</label>
                            </div>

                            <div class="form-check">
                                <label class="form-check-label"><input type="radio" class="form-check-input" name="gender" value="1" {{$data->gender==1?'checked':''}}>Female</label>
                            </div>
                        </div>


                
                        <div class="form-group row">
                            @if(!file_exists($profileImageFullPath))
                            <div class="col-md-12">
                                <img width="200px" class="img-responsive hover" id="uploadedImage" src="{{ URL::to('/') }}/images/noImage.png" />
                            </div>
                            @else
                            <div class="col-md-12">
                                <img width="200px" class="img-responsive hover" id="uploadedImage" src="{{ URL::to('/') }}/images/<?php echo Auth::user()->profilePhoto; ?>" />
                            </div>
                            @endif
                        </div>    



                        <div class="fileUpload form-group row">
                            <label for="profilePhoto" class="col-md-4 col-form-label text-md-right">{{ __('Profile Photo') }}</label>
                            <div class="form-check">
                                <input id="uploadFileType" onchange="file_upload();" type="file" name="profilePhoto" class="form-control">
                            </div>
                            
                            <div class="form-check">
                                <button type="submit" class="btn btn-success">Upload</button>
                            </div>
                        </div>


                         
                        <div class="row">
                            <div class="col-md-12" style="height:50px;"></div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Edit') }}
                                </button>
                            </div>
                        </div>

                        <input type="hidden" name="userId" value="{{$data->id}}" />

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
img#uploadedImage {
    align-items: center;
    margin-left: 244px;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    function file_upload(){
        
        $('.img_success').remove();
            $('.img').remove();
            $('.img_size').remove();
            var imgpath = document.getElementById('uploadFileType').value;
            //console.log(imgpath);
            if (imgpath == "") {
                return false;
            } else {
                //alert();
                var arr1 = new Array;
                arr1 = imgpath.split("\\");
                var len = arr1.length;
                var img1 = arr1[len - 1];
                var filext = img1.substring(img1.lastIndexOf(".") + 1);
                var size = parseFloat(document.getElementById('uploadFileType').files[0].size / 1024).toFixed(2);                
                if (filext == "jpg" || filext == "png" || filext == "jpeg" || filext == "gif") {
                    setTimeout(function () {
                        var input = document.getElementById('uploadFileType');
                        var file = input.files[0];
                        if (/^image/.test(file.type)) {
                            var reader = new FileReader();
                            reader.readAsDataURL(file);
                            reader.onloadend = function () {
                                $(".img-responsive").attr('src', this.result);
                                $(".img-responsive").css("background-image", "");
                            }
                        }
                        $(".fileUpload").after("<div class='col-md-12'><div class='error img_success' style='margin-left: 230px;font-weight:bold;'>Image has been uploaded successfully</div></div>");
                    }, 1000);
                    setTimeout(function () {
                        if ($('.img_success').length > 0) {
                            $('.img_success').remove();
                        }
                    }, 7000);
                    return false;
                } else {
                    setTimeout(function () {
                        $(".fileUpload").after("<div class='col-md-12'><div class='error img' style='margin-left: 230px;font-weight:bold; color: red;'>Please upload image file only</div></div>");
                    }, 1000);
                    setTimeout(function () {
                        if ($('.img').length > 0) {
                            $('.img').remove();
                        }
                    }, 7000);
                    //$(".fileUpload").replaceWith('<input type="file" name="photo" placeholder="Upload Photo" id="uploadImage" onchange="Customer.file_upload();">');
                    return false;
                }
            }
    }
</script>