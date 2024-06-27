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
                <div class="user-table-filter">
                    <form action="{{ route('admin.store.manage.steps') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $step->id ?? ''}}">
                        <div class="row g-2">
                            <input type="hidden" name="form_type" value="{{$viewsteps}}">
                            {{-- 
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
                            --}}
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
                                    <a class="btn btn-primary" href="{{url('manage-steps-view/'.$viewsteps)}}">Back</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @include('common.msg')
            </div>
        </div>
    </div>
@endsection