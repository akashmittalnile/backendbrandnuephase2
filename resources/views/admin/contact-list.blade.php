
@extends('layouts.app')
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('admin/css/users.css') }}"> 
@endpush

@section('content')
<div class="main-panel">
    <div class="heading-section">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h4 class="heading-title">Contact Us</h4>
            </div>
        </div>
    </div>
    <div class="user-data-section">
        <div class="user-list-item">
            <div class="user-table-filter">
                <form action="">
                    <div class="row g-2">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Name / Email</label>
                                <input type="text" name="n" class="form-control" placeholder="Name / Email" value="{{request()->n}}" />
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="form-group mt-4">
                                <button class="btn-Search">Search</button>
                                <a href="{{ route('admin.contact.list') }}" class="btn-Reset">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @include('common.msg')
            <div class="user-table">
                <table>
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contactlist as $row)
                        <tr>
                            <td>
                                <div class="user-table-info">
                                    <div class="user-table-value">
                                        <h2>{{$row->first_name ?? ''}}</h2>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="table-text-info">
                                    <div class="table-info-heading">{{$row->last_name}}</div>
                                </div>
                            </td>
                            <td>
                                <div class="table-text-info">
                                    <div class="forms-text">{{$row->email}}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="table-text-info">
                                    <div class="table-info-staus"> {{$row->phone}} </div>
                                </div>
                            </td>

                            <td>
                                <div class="table-text-info">
                                    <div class="table-info-heading">{{$row->message}}</div>
                                </div>
                            </td>

                            <td>
                                <a href="javascript:void(0)" data-url="{{ route('admin.contact.delete',$row) }}" class="text-danger delete-user btn-delete-sm"><i class="la la-trash"></i></b></a><br>

                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td><div class="text-center text-success">No Data Available</div></td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="pagination-list-info mt-3 pull-right">{{$contactlist->appends(Request::except('page'))->links()}}</div>
    </div>
</div>
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('admin/css/payment.css') }}">
@endpush

@push('js')
<script src="{{asset('plugins/js/sweetalert.min.js')}}"></script>

<script>
    $(document).on('click','.delete-user',function(e){
            const url = $(this).data('url');
            if(url){
                swal({
                    title:"Are you sure?",
                    // text: "You won't be able to revert this",
                    //icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((isConfirmed) => {
                    if(isConfirmed){
                        $('.please-wait').show();
                        $.ajax({
                            type:'delete',
                            url : url,
                            data: {},
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            success: function(res){
                                if(res.status==true){
                                    window.location.reload();
                                }else{
                                    alert(res.msg);
                                }
                                $('.please-wait').hide();
                            }
                        });
                    }
                });
            }
        });
</script>

@endpush
