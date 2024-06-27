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
                    <h4 class="heading-title">Add Manage Home Page Videos</h4>
                </div>
            </div>
        </div>
        <div class="user-data-section">
            <div class="user-list-item">
                <div class="user-table-filter">
                    <form action="{{ route('admin.store.manage.videos') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $step->id ?? ''}}">
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
                                        <option value="2" @if(isset($step->status) && $step->status == '2') selected @endif> Inactive </option>
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
                                    <a class="backbuttonmanagevides" href="{{ route('admin.manage.videos') }}">Back</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div> 
                
                @include('common.msg')
            </div>
            {{-- <div class="pagination-list-info mt-3 pull-right">{{$subscribe_members->appends(Request::except('page'))->links()}}</div> --}}
        </div>
    </div>
@endsection