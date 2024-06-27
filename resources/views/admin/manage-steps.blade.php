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
                <!-- <div class="user-table-filter">
                    <form action="{{ route('admin.store.manage.steps') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $step->id ?? ''}}">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Select Form Step</label> 
                                    <select class="form-select" name="form_type">
                                        <option value="">-- Select --</option>
                                        <option value="four_step" @if(isset($step->post_type) && $step->post_type == 'four_step') selected @endif> Four Step </option>
                                        <option value="five_step" @if(isset($step->post_type) && $step->post_type == 'five_step') selected @endif> Five Step </option>
                                        <option value="seven_step" @if(isset($step->post_type) && $step->post_type == 'seven_step') selected @endif> Seven Step </option>
                                        <option value="eight_step" @if(isset($step->post_type) && $step->post_type == 'eight_step') selected @endif> Eight Step </option>
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
                                    <a class="btn btn-primary" href="{{ route('admin.manage.steps') }}">Reset</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div> -->
                @include('common.msg')
                <div class="user-table">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>Step name </th>
                            <th>Step number</th>
                            <th>Items Number</th>
                            <th>Action</th>
                        </tr>
                        @forelse($postss as $key => $post)
                            <tr>
                                <td><div class="table-text-info"><div class="table-info-text">
                                     @if($key == 'four_step')
                                        Current Status
                                     @elseif($key == 'five_step')
                                        Health Concerns
                                     @elseif($key == 'seven_step')
                                        Previous Diets
                                     @elseif($key == 'eight_step')
                                        What Didn’t Work for You?
                                     @endif
                                    </div></div></td>
                                <td><div class="table-text-info"><div class="table-info-text"> 
                                    @if($key == 'four_step')
                                        Step 4
                                     @elseif($key == 'five_step')
                                        Step 5
                                     @elseif($key == 'seven_step')
                                        Step 7
                                     @elseif($key == 'eight_step')
                                        Step 8
                                     @endif  
                                    </div></div></td>
                                <td><div class="table-text-info"><div class="table-info-text"> {{count($postss[$key])}} </div></div></td>
                                
                                <td>
                                    <a href="{{ route('admin.manage.viewsteps', $key) }}" class="view-btn"><i class="las la-eye"></i> View </a>
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