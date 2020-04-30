<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

  
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
    <!-- <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" defer></script> -->
    

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" rel="stylesheet">
    
    <!-- <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet"> -->
    <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">


<script>
    var tempDatatable;
    $(document).ready(function() {
        fetchData();
        $('.showHideProfile').toggle();
        $(document).on('click','.toggleDiv',function() {
            $('.showHideProfile').toggle('slow');
        });
        
        $(document).on("click",".btnSearchData",function() {
            tempDatatable.clear().draw(true);
            var textBoxValue = $('.txtSearch').val();
            var dropdownVal = $('.searchColumn').val();
            fetchData(textBoxValue, dropdownVal);
                // tempDatatable
                // .columns(dropdownVal)
                // .search(textBoxValue)
                // .clear()
                // .draw();
          
        });

    });
    function fetchData(searchVal='', searchBy = ''){
        
        tempDatatable = $('#tableProjects').DataTable({
            processing: true,
            serverSide: true,
            aaSorting: [],
            ajax: { 
                url : "{{ url('projectAjaxDatatableData') }}",
                data:{  search_value : searchVal, search_by : searchBy }
            },
            columns: [
                    { data: 'id', name: 'id' },
                    { data: 'title', name: 'title' },
                    { data: 'description', name: 'description' },
                    { data: 'category_name', name: 'category_name' },
                    { data: 'status', name: 'status' },
                    { data:'action', name : 'action' },
            ],
            columnDefs: [{
                'targets': [5], 
                'orderable': false,
            }],
            drawCallback: function( settings ) {
                //console.log(settings);
            },
            initComplete: function () {
                this.api().on( 'draw', function () {
                    //alert( 'draw' );
                });
            },
            fnInitComplete: function(oSettings, json) {                            
                oSettings.fnDrawCallback = alert('redraw');
            },
            destroy: true,
            dom: 'lrtip',
            sPaginationType: "full_numbers",
            bFilter: true,
            bPaginate: true,
            bJQueryUI: true,  // ThemeRoller-stöd
            bLengthChange: false,
            bFilter: true,
            bSort: true,
            bInfo: true,
            bAutoWidth: true,
            bProcessing: true,
            iDisplayLength: 10,
        });

    }
    function deleteRecord(id){
        var result = confirm("Are you sure you want to delete?");
        if (result) {
            $.ajax({
               type:'POST',
               url:'/deleteRecord',
               data: { '_token' :  '<?php echo csrf_token() ?>',
                       'id'     :  id 
                     },
               success:function(data) {
                  if(data.data.success)
                  {
                    $(".text-center").after('<div class="textsucess">'+data.data.success+'</div>');
                    tempDatatable.ajax.reload();
                    setTimeout(function(){ 
                        $('.textsucess').remove(); 
                    }, 5000);
                  }
                  
               }
            });
        }
    }
</script>


</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="#">
                    {{ config('app.name', 'Laravel') }}
                </a>

                <?php 
                if (Auth::check()) { ?>
                   <!-- <a href="{{route('projects')}}">Projects</a> -->
                <?php }
                ?>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">

                    </ul>
                    <ul class="navbar-nav ml-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                        
                        
                        <ul>
                            <?php 
                                if(request()->segment(count(request()->segments()))!="dashboard") {
                            ?>
                                    <li><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <?php } ?>    
                                <li><a href="{{route('projects')}}">Projects</a></li>
                                <li><a href="{{route('projectAjaxDatatable')}}">Projects Ajax</a></li>
                                <li><a href="{{ route('editProfile') }}">Profile</a></li>
                                <li>
                                    <a href="{{route('logout')}}" 
                                       onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">Logout</a>
                                </li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                        </ul>
                            
                        
                            <!-- <div class="toggleDiv">
                                <li class="nav-item dropdown">
                                    <a  class="">
                                        Profile <span class="caret"></span>
                                    </a>
                                </li>
                            </div> 
                            <div class="card showHideProfile">
                                <img class="imgClass" src="{{ URL::to('/') }}/images/<?php //echo Auth::user()->profilePhoto; ?>" style="width:100%">
                                <a href="{{ route('editProfile') }}">Edit Profile</a>
                                <h5 class="displayName">Welcome {{ Auth::user()->name }}</h5>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                            </div>  -->


                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @yield('scripts')
</body>
</html>







<style>
.showHideProfile {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 300px;
  margin: auto;
  text-align: center;
  font-family: arial;
}

.title {
  color: grey;
  font-size: 18px;
}

button {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
  font-size: 18px;
}

a {
  text-decoration: none;
  font-size: 22px;
  color: black;
}

button:hover, a:hover {
  opacity: 0.7;
}
img.imgClass {
    width: 150px !important;
    border: 1px solid #671d79;
}
.dropdown-item:focus, .dropdown-item {
    color: #16181b;
    text-decoration: none;
    background-color: #f8f9fa;
    border: 1px solid #671d79;
}



ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  /* background-color: #333333; */
}

li {
  float: left;
}

li a {
  display: block;
  color: white;
  text-align: center;
  padding: 16px;
  text-decoration: none;
}

li a:hover {
  background-color: #111111;
} 
ul.navbar-nav.ml-auto {
    background-color: #333;
}  
.textsucess {
    text-align: center;
    font-size: 20px;
    color: red;
    border: 0. solid;
    /* width: 259px; */
}
.dataTables_wrapper .dataTables_filter {
    float: center;
    text-align: right;
}
label.pull-right {
    display: inline-block;
    margin-right: 15px;
}
.pull-right {
    display: inline-block;
}
.pull-right.dropdown {
    margin-right: 15px;
}
.pull-right.searchButton {
    width: 110px;
    padding-right: 10px;
}
.customContent {
    display: inline-block;
    float: right;
    margin-bottom: 10px;
}  
.pull-right.search {
    margin-right: 15px;
}
.dataTables_wrapper .dataTables_length {
    float: none;
}
div#tableProjects_filter {
    visibility: hidden;
    display: none;
}
</style>