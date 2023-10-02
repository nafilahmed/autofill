@extends('layouts.dashboard')

@section('content')
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous"> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q==" crossorigin="anonymous"
  referrerpolicy="no-referrer" />
  <style>
    .bootstrap-select .dropdown-toggle .filter-option-inner-inner{
        color: #c3c7ce;
        background-color: #fff;
    }

    .bootstrap-select>.dropdown-toggle.bs-placeholder{
        background-color: #fff;
    }
    .dropdown .bootstrap-select .show-tick .dropup{
        width: 100%;
    }
    .bootstrap-select[class*=col-] .dropdown-toggle{
        background-color: #fff;
    }
  </style>

<div class="content-header row">
    <div class="content-header-left col-md-4 col-12 mb-2">
        <h3 class="content-header-title">Clients</h3>
    </div>
    <div class="content-header-right col-md-8 col-12">
        <div class="breadcrumbs-top float-md-right">
            <div class="breadcrumb-wrapper mr-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Clients
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content-body">
    <!-- User List section start -->
    <section id="webiste-list">
        <!-- Basic Tables start -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Clients</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><button class="btn btn-primary" id="add-btn" >Add New Client</button></li>
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Client name</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $key => $value)
                                        <tr>
                                            <th scope="row">{{$value['id']}}</th>
                                            <td>{{$value['name']}}</td>
                                            <td>{{$value['email']}}</td>
                                            <td><i data-id="{{$value['id']}}" class="edit-form la la-edit"></i></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Basic Tables end -->
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Name:</label>
                        <input type="text" class="form-control col-sm-10" id="name" placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="email">Email:</label>
                        <input type="text" class="form-control col-sm-10" id="email" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="password">Password:</label>
                        <input type="password" class="form-control col-sm-10" id="password" placeholder="Enter password">
                    </div>  
                    <div class="form-group">
                    <label class="control-label col-sm-2" for="website">Website:</label>
                        <select name="website" id="website"  class="selectpicker form-control col-sm-10" multiple aria-label="size 3 select example">
                            @foreach($websites as $website)
                                <option value="{{ $website->id }}">{{ $website->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="alert" style="display: none;"></div>
            <div class="modal-footer">
                <button class="btn btn-primary" post-action="edit" id="save-btn" >Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

@endsection

@section('page-level-script')
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js" integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    id = 0;
    $(document).on("click", '#add-btn', function (e) {

        $('#name').val(' ');
        $('#email').val(' ');
        $('#password').val('');
        $('#website').val('');
        $('.modal-title').text('Add Client');

        $('#editModal').modal('show');
        $('#save-btn').attr('post-action','add');
    });

    $(document).on("click", '.edit-form', function (e) {
        $('.modal-title').text('Update Client');
        $('#save-btn').attr('post-action','add');
        $('#save-btn').attr('post-action','edit');

        $('#editModal').modal('show');
        
        id = $(this).attr('data-id');

        $.ajax({
            type: 'GET',
            url: "<?php echo e(URL::to('/clients')); ?>/"+id,
            success: function (data) {
                $('#name').val(data.data.user.name);
                $('#email').val(data.data.user.email);
                // selectpicker
                
                $("#website").val(data.data.website);
                $("#website").selectpicker("refresh");

                $('#password').val('');

            }, error: function (data) {

                $(".alert").html('some thing went worng');
            }
        });
    });


    $(document).on("click", '#save-btn', function (e) {

        if ($(this).attr('post-action') == "edit") {
            $.ajax({
                type: 'PUT',
                url: "<?php echo e(URL::to('/clients')); ?>/"+id,
                data: {
                    name: $('#name').val(),
                    email: $('#email').val(),
                    password: $('#password').val(),
                    website: $('#website').val()
                },
                success: function (data) {
                    if(data.status_code == 200){
                        $(".alert").removeClass("alert-danger");
                        $(".alert").addClass("alert-success");
                        $(".alert").html(data.message);

                    }else{
                        $(".alert").removeClass("alert-success");
                        $(".alert").addClass("alert-danger");
                        var errorString = '<ul>';
                        $.each( data.message, function( key, value) {
                            errorString += '<li>' + value + '</li>';
                        });
                        errorString += '</ul>';
                        $(".alert").html(errorString);
                    }
                    $(".alert").show();
                }, error: function (data) {

                    $(".alert").html('some thing went worng');
                }                
            });

        }else{

            $.post("<?php echo e(URL::to('/clients')); ?>", 
            {
                name: $('#name').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                website: $('#website').val()
            },
            function(data,status){

                if(data.status_code == 200){
                    $(".alert").removeClass("alert-danger");
                    $(".alert").addClass("alert-success");
                    $(".alert").html(data.message);
                }else{
                    $(".alert").removeClass("alert-success");
                    $(".alert").addClass("alert-danger");
                    var errorString = '<ul>';
                    $.each( data.message, function( key, value) {
                        errorString += '<li>' + value + '</li>';
                    });
                    errorString += '</ul>';
                    $(".alert").html(errorString);
                }
                
                $(".alert").show();
            });

            setTimeout(function(){
                location.reload(true);
            }, 2000);
        }
        
    });

    $('#editModal').on('hidden.bs.modal', function () {
        $(".alert").hide();
        $('#name').val(' ');
        $('#email').val('');
        // $('#password').val();
        $(".alert").html('');
        $(".alert").removeClass("alert-danger");
        $(".alert").removeClass("alert-success");
    });

</script>

@endsection



