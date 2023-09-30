@extends('layouts.dashboard')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-4 col-12 mb-2">
        <h3 class="content-header-title">Icons</h3>
    </div>
    <div class="content-header-right col-md-8 col-12">
        <div class="breadcrumbs-top float-md-right">
            <div class="breadcrumb-wrapper mr-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Icons
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content-body">
    <!-- Website List section start -->
    <section id="webiste-list">
        <!-- Basic Tables start -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Websites</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><button class="btn btn-primary" id="add-btn" >Add New Website</button></li>
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
                                            <th>Name</th>
                                            <th>Url</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($websites as $key => $value)
                                        <tr>
                                            <th scope="row">{{$value['id']}}</th>
                                            <td>{{$value['name']}}</td>
                                            <td>{{$value['url']}}</td>
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
                        <label class="control-label col-sm-2" for="url">URL:</label>
                        <input type="text" class="form-control col-sm-10" id="url" placeholder="Enter url">
                    </div>                    
                </div>
            </div>
            <div class="alert" style="display: none;"></div>
            <div class="modal-footer">
                <button class="btn btn-primary" post-action="" id="save-btn" >Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

@endsection

@section('page-level-script')
<script>
    var id = 0;
    $(document).on("click", '#add-btn', function (e) {
        $('#name').val(' ');
        $('#url').val(' ');
        $('.modal-title').text('Add Website');

        $('#editModal').modal('show');
        $('#save-btn').attr('post-action','add');
    });

    $(document).on("click", '.edit-form', function (e) {
        $('.modal-title').text('Update Website');
        $('#save-btn').attr('post-action','add');
        $('#save-btn').attr('post-action','edit');

        $('#editModal').modal('show');
        
        id = $(this).attr('data-id');
        $.ajax({
            type: 'GET',
            url: "<?php echo e(URL::to('/websites')); ?>/"+id,
            success: function (data) {

                $('#name').val(data.data.name);
                $('#url').val(data.data.url);

            }, error: function (data) {

                $(".alert").html('some thing went worng');
            }
        });
    });
    
    $(document).on("click", '#save-btn', function (e) {

        if ($(this).attr('post-action') == "edit") {

            $.ajax({
                type: 'PUT',
                url: "<?php echo e(URL::to('/websites')); ?>/"+id,
                data: {
                    name: $('#name').val(),
                    url: $('#url').val()
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

            $.post("<?php echo e(URL::to('/websites')); ?>", 
            {
                name: $('#name').val(),
                url: $('#url').val()
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
        }

        setTimeout(function(){
            location.reload(true);
        }, 2000);
        
    });

    $('#editModal').on('hidden.bs.modal', function () {
        $(".alert").hide();
        $('#name').val('');
        $('#url').val('');
        $(".alert").html('');
        $(".alert").removeClass("alert-danger");
        $(".alert").removeClass("alert-success");
    });

</script>

@endsection



