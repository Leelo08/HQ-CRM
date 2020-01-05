@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Employee Table</h3>
                            @can('create', App\Employee::class)
                            <div class="card-tools">
                                <a href="{{ route('employee.create') }}" class="btn btn-primary btn-block">Add employee <i class="fas fa-user-plus"></i></a>
                            </div>
                            @endcan
                    </div>
                    <div class="card-body table-responsive p-3">
                        <table id = "employee_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="25%">Lastname</th>
                                    <th width="25%">Firtname</th>
                                    <th width="30%">Email</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection

@section('script')
<script type="text/javascript">
$(document).ready(function(){
            $('#employee_table').DataTable({
                processing:true,
                serverSide:true,
                ajax: {
                    url: "{{ route('employee.index') }}",
                },
                columns: [
                    {
                        data: 'lastname',
                        name: 'lastname',
                    },
                    {
                        data: 'firstname',
                        name: 'firstname',
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                    }
                ]
            });

            $(document).on('click', '.show', function(){
                var id = $(this).attr('id');
                window.location.href = "/employee/" + id; 
                })
        });
</script>
@endsection
