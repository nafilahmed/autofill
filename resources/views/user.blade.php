@extends('layouts.dashboard')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-4 col-12 mb-2">
        <h3 class="content-header-title">Users</h3>
    </div>
    <div class="content-header-right col-md-8 col-12">
        <div class="breadcrumbs-top float-md-right">
            <div class="breadcrumb-wrapper mr-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Users
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
                        <h4 class="card-title">Users</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><button class="btn btn-primary" id="add-btn" >Add New User</button></li>
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
                                            <th>Username</th>
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
<script>
    id = 0;
    $(document).on("click", '#add-btn', function (e) {

        $('#name').val(' ');
        $('#email').val(' ');
        $('.modal-title').text('Add User');

        $('#editModal').modal('show');
        $('#save-btn').attr('post-action','add');
    });

    $(document).on("click", '.edit-form', function (e) {
        $('.modal-title').text('Update User');
        $('#save-btn').attr('post-action','add');
        $('#save-btn').attr('post-action','edit');

        $('#editModal').modal('show');
        
        id = $(this).attr('data-id');

        $.ajax({
            type: 'GET',
            url: "<?php echo e(URL::to('/users')); ?>/"+id,
            success: function (data) {

                $('#name').val(data.data.name);
                $('#email').val(data.data.email);

            }, error: function (data) {

                $(".alert").html('some thing went worng');
            }
        });
    });


    storage = chrome.storage.local;

    
    function brugernavn () {
      window.addEventListener('load', function load(event) {
          storage.get(['name'], function(result) {
              if (result !== undefined && result.name !== undefined) {
                  document.getElementById('name').value = result.name;
            }
        });

          document.getElementById('gem').onclick = function() {
            storage.remove('name');
              storage.set({'name': document.getElementById('name').value});

              storage.remove('email');
                var adgangs = document.getElementById('email').value;
                storage.set({'email' : adgangs});
            };
        });
    }
    
    $(document).on("click", '#save-btn', function (e) {

        if ($(this).attr('post-action') == "edit") {
            brugernavn ();
            $.ajax({
                type: 'PUT',
                url: "<?php echo e(URL::to('/users')); ?>/"+id,
                data: {
                    name: $('#name').val(),
                    email: $('#email').val()
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

            $.post("<?php echo e(URL::to('/users')); ?>", 
            {
                name: $('#name').val(),
                email: $('#email').val()
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
        $(".alert").html('');
        $(".alert").removeClass("alert-danger");
        $(".alert").removeClass("alert-success");
    });

</script>

@endsection



