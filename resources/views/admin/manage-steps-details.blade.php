@extends('layouts.app')

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/users.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/payment.css') }}">
@endpush

@section('content')
    <div class="main-panel">
        <div class="heading-section">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h4 class="heading-title">Manage Step Forms</h4>
                </div>
            </div>
        </div>
        <div class="user-data-section">
            <div class="user-list-item">
                {{--<div class="user-table-filter">
                    <form action="{{ route('admin.store.manage.steps') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $step->id ?? ''}}">
                        <div class="row g-2">
                            <input type="hidden" name="form_type" value="{{$viewsteps}}">
                        
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Select Form Step</label> 
                                    <select class="form-select" name="form_type">
                                        <option value="">-- Select --</option>
                                        <option value="four_step" @if(isset($viewsteps) && $viewsteps == 'four_step') selected @endif> Four Step </option>
                                        <option value="five_step" @if(isset($viewsteps) && $viewsteps == 'five_step') selected @endif> Five Step </option>
                                        <option value="seven_step" @if(isset($viewsteps) && $viewsteps == 'seven_step') selected @endif> Seven Step </option>
                                        <option value="eight_step" @if(isset($viewsteps) && $viewsteps == 'eight_step') selected @endif> Eight Step </option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Gender Type</label> 
                                    <select class="form-select" name="gender_type">
                                        <option value="A" @if(isset($step->gender_type) && $step->gender_type == 'A') selected @endif> All </option>
                                        <option value="M" @if(isset($step->gender_type) && $step->gender_type == 'M') selected @endif> Male </option>
                                        <option value="F" @if(isset($step->gender_type) && $step->gender_type == 'F') selected @endif> FeMale </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control" placeholder="Title" value="{{ $step->title ?? ''}}" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Image</label>
                                    <input type="file" name="image" class="form-control" value="" />
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group mt-4">
                                    <button class="btn-Search" type="submit">Submit</button>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group mt-4">
                                    <a class="btn btn-primary" href="{{url('manage-steps-view/'.$viewsteps)}}">Reset</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div> --}}
                @include('common.msg')
                <div class="user-table">
                <form action="">
                <div class="row mb-2">
                 <div class="col-md-4">
                    <div class="form-group">
                        <label>Gender Type</label> 
                            <select class="form-select" name="gendertype">
                                <option >Select Gender</option>
                                <option value="A" @if(isset($url['gendertype']) && $url['gendertype'] == 'A') selected @endif> All </option>
                                <option value="M" @if(isset($url['gendertype']) && $url['gendertype'] == 'M') selected @endif> Male </option>
                                <option value="F" @if(isset($url['gendertype']) && $url['gendertype'] == 'F') selected @endif> Female </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Title" value="{{ $url['title'] ?? ''}}" />
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group mt-4">
                            <button class="btn-Search" type="submit">Search</button>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group mt-4">
                            <a class="btn-reset" href="{{url('manage-steps-view/'.$viewsteps)}}">Reset</a>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group mt-4">
                            <a class="btn-addstepform" href="{{url('add-stepform-view/'.$viewsteps)}}">Add Step form</a>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group mt-4">
                            <a class="backbuttonmanagevides" href="{{url('manage-steps')}}">Back</a>
                        </div>
                    </div>

                    </div>
                </form>

                    
                
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>Title</th>
                            <th>Form Step</th>
                            <th>Gender Type</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                        @forelse($posts as $post)
                            <tr>
                                <td><div class="table-text-info"><div class="table-info-text"> {{ $post->title }} </div></div></td>
                                <td><div class="table-text-info"><div class="table-info-text">  
                                    @if($post->post_type == 'four_step') 
                                        Fourth step
                                    @elseif($post->post_type == 'five_step')
                                        Fifth step
                                    @elseif($post->post_type == 'seven_step')
                                        Seventh step
                                    @elseif($post->post_type == 'eight_step')
                                        Eighth step
                                    @else
                                    
                                    @endif

                                    <!-- {{ ucfirst(str_replace('_', '', $post->post_type)) }}  -->
                                 </div></div></td>
                                <td><div class="table-text-info"><div class="table-info-text"> 
                                @if($post->gender_type == 'M')
                                    Male
                                @elseif($post->gender_type == 'F')
                                    Female
                                @else
                                    All
                                @endif
                                 </div></div></td>
                                <td>
                                    @if(!empty($post->image_url))
                                        <div class="user-table-info">
                                            <div class="user-table-media">
                                                <img src=" {{ asset($post->image_url) }}">
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <!-- <a href="{{ route('admin.manage.steps', $post->id) }}" class="btn-edit-sm"> <i class="fa fa-edit"></i> </a> -->
                                    <a href="{{url('add-stepform-view/'.$viewsteps.'/'.$post->id)}}" class="btn-edit-sm"> <i class="fa fa-edit"></i> </a>
                                    <a href="{{ route('admin.delete.manage.steps', $post->id) }}" class="btn-delete-sm delete-admin" onclick="return confirm('Are you sure you want to remove this.?')"> <i class="fa fa-trash"></i> </a>
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="4">No Data</td>
                        </tr>
                        @endforelse
                    </table>
                </div>
            </div>
            {{-- <div class="pagination-list-info mt-3 pull-right">{{$subscribe_members->appends(Request::except('page'))->links()}}</div> --}}
        </div>
    </div>
@endsection