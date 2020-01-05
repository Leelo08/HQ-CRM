@extends('layouts.master')

@section('content')
<div class="container">
    <!-- Main content -->
        <div class="row">
          <div class="col-md-3">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{ asset('storage/'.$company->image) }}"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{ $company->name }}</h3>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Email : </b> <a class="float-bottom"> {{ $company->email}} </a>
                  </li>
                  <li class="list-group-item">
                    <b>Website : </b> <a class="float-bottom">{{ $company->website }}</a>
                  </li>
                </ul>
                @can('update', App\Company::findOrFail($company->id))
                <a href="{{ route('company.edit', ['company' => $company]) }}" class="btn btn-success btn-block"><b><i class="fas fa-edit"></i> Edit</b></a>
                @endcan
                @can('delete', App\Company::findOrFail($company->id))
                <a  href="#" class="btn btn-danger btn-block" onclick="deleteCompany( {{ $company->id }} );"><i class="fa fa-trash"></i><b> Delete</b></a>
                @endcan
              </div>
            </div>
            <!-- End Profile Image -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-3">
                <h3 class="card-title">Employees Table</h3>

                @can('create', App\Company::class)
                <form action="{{ route('import', $company->id) }}" method="POST" enctype="multipart/form-data">
                
                <input type="file" name="file" class="form-control">
                <div>{{ $errors->first('file') }}</div>
                @csrf
                <br>
                <button class="btn btn-success">Import Employees Data</button>
                @endcan
                @can('create', App\Company::class)
                <a class="btn btn-warning" href="{{ route('export', $company->id) }}">Export Employees Data</a>
                @endcan
            </form>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <!-- Post -->
                    <div class="post">
                        <div class="card-body table-responsive p-3">
                            <table id = "employees_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="20%">Name</th>
                                        <th width="20%">Email</th>
                                        <th width="20%">Phone number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($company->employees as $employee)
                                    <tr class="item{{$employee->id}}">
                                        <td>{{$employee->lastname}}, {{$employee->firstname}}</td>
                                        <td>{{$employee->email}}</td>
                                        <td>{{$employee->phone}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.post -->
                  </div>
                  <!-- /.tab-pane -->
                </div>
                  <!-- /.tab-pane -->
               </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- / col -->
        </div>
        <!-- /.row -->
</div>
 <!-- Modal -->
 <div class="modal fade" id="confirmModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            Are you sure you want to delete this company?
        </div>
        <div class="modal-footer">
            <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">Okay</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        </div>
        </div>
    </div>
    </div>
<!-- ./wrapper -->
@endsection

@section('script')
<script type="text/javascript">
$(document).ready(function() {
    $('#employees_table').DataTable({
    });
});

function deleteCompany(id)
{
  $('#confirmModal').modal('show');
  $('#ok_button').text('Yes');

  $('#ok_button').click(function(){
                $.ajax({
                    url:"/company/destroy/"+id,
                    beforeSend:function(){
                        $('#ok_button').text('Deleting..');
                    },
                    success:function(data)
                    {
                      setTimeout(() => {
                            $('#confirmModal').modal('hide');
                            window.location.href = "/company"; 
                            toast.fire({
                                    icon: 'success',
                                    title: 'Delete successfully'
                                    })
                        }, 2000);
                    }
                });
            });
}
</script>
@endsection