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
                    <h4 class="heading-title">Manage Home Page Videos</h4>
                </div>
            </div>
        </div>
        <div class="user-data-section">
            <div class="user-list-item">
                <!-- <div class="user-table-filter">
                    <form action="{{ route('admin.store.manage.videos') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="post_id" value="{{ $step->id ?? ''}}">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control" placeholder="Title" value="{{ $step->title ?? ''}}" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Video</label>
                                    <input type="file" name="image" class="form-control" value="" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Status</label> 
                                    <select class="form-select" name="status">
                                        <option value="">-- Select --</option>
                                        <option value="1" @if(isset($step->status) && $step->status == '1') selected @endif> Active </option>
                                        <option value="0" @if(isset($step->status) && $step->status == '0') selected @endif> DeActive </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group mt-4">
                                    <button class="btn-Search" type="submit">Submit</button>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group mt-4">
                                    <a class="btn btn-primary" href="{{ route('admin.manage.videos') }}">Reset</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div> -->
                
                @include('common.msg')
                <div class="user-table">
                    <a href="{{url('addmanagevides')}}" class="btn-addvideobutton">Add Videos</a>
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>Title</th>
                            <th>Video</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @forelse($posts as $post)
                            <tr>
                                <td><div class="table-text-info"><div class="table-info-text"> {{ $post->title }} </div></div></td>
                                <td>
                                    @if(!empty($post->image_url))
                                        <video width="360" height="180" controls>
                                            <source src="{{ asset($post->image_url) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @endif
                                </td>
                                <td>
                                    <div class="table-text-info">
                                        <div class="table-info-text">
                                            @if($post->status == 1)
                                                Active
                                            @else
                                                Inactive
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ url('addmanagevides/'.$post->id) }}" class="btn-edit-sm"><i class="fa fa-edit"></i> </a>
                                    <!-- <a href="{{ route('admin.manage.videos', $post->id) }}" class="btn-edit-sm"><i class="fa fa-edit"></i> </a> -->
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