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
    <!-- User list section start -->
    <section id="user-list">
        <!-- Basic Tables start -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Users</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <div class="table-responsive">
                            <div class="text-right">
                                <a data-toggle="modal" data-target="#editModal" data-route="{{route('users.show', 0)}}"
                                    class="edit-form btn btn-info btn-min-width mr-1 mb-1">
                                    <span style="color: white;"> New Record </span>
                                </a>
                            </div>
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
                                            <th scope="row">{{$key + 1}}</th>
                                            <td>{{$value->name}} sdfs</td>
                                            <td>{{$value->email}}</td>
                                            <td>
                                                <a data-toggle="modal" data-target="#editModal" data-route="{{route('users.show',$value->id)}}" class="pull-left edit-form" >
                                                    <i class="la la-edit"></i> 
                                                </a>        
                                                <i class="la la-trash"></i>
                                            </td>
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

@endsection
