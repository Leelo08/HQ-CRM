@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Company Table</h3>
                            <div class="card-tools">
                            @can('create', App\Company::class)
                                <a href="{{ route('company.create') }}" class="btn btn-primary btn-block">Add company <i class="fas fa-plus"></i></a>
                            @endcan
                            </div>
                    </div>
                    <div class="card-body table-responsive p-3">
                        <table id = "company_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="40%">Name</th>
                                    <th width="40%">Email</th>
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
            $('#company_table').DataTable({
                processing:true,
                serverSide:true,
                ajax: {
                    url: "{{ route('company.index') }}",
                },
                columns: [
                    {
                        data: 'name',
                        name: 'name',
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
                window.location.href = "/company/" + id; 
                })
        });
</script>
@endsection
