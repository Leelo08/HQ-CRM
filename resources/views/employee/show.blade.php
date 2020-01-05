@extends('layouts.master')

@section('content')
<div class="container">
    <!-- Main content -->
        <div class="row">
          <div class="col-md-6">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">

                <h3 class="profile-username text-center">{{ $employee->firstname }} {{ $employee->lastname }}</h3>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Email : </b> <a class="float-bottom"> {{ $employee->email}} </a>
                  </li>
                  <li class="list-group-item">
                    <b>Company : </b> <a class="float-bottom">{{ $employee->company->name }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Phone number : </b> <a class="float-bottom">{{ $employee->phone }}</a>
                  </li>
                </ul>
                @can('update', App\Employee::findOrFail($employee->id))
                <a href="{{ route('employee.edit', ['employee' => $employee]) }}" class="btn btn-success btn-block"><b><i class="fas fa-edit"></i> Edit</b></a>
                @endcan
                @can('delete', App\Employee::findOrFail($employee->id))
                <a  href="#" class="btn btn-danger btn-block" onclick="deleteEmployee( {{ $employee->id }} );"><i class="fa fa-trash"></i><b> Delete</b></a>
                @endcan
              </div>
            </div>
            <!-- End Profile Image -->
          </div>
          <!-- /.col -->
        </div>
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
            Are you sure you want to delete this employee?
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
function deleteEmployee(id)
{
  $('#confirmModal').modal('show');
  $('#ok_button').text('Yes');

  $('#ok_button').click(function(){
                $.ajax({
                    url:"/employee/destroy/"+id,
                    beforeSend:function(){
                        $('#ok_button').text('Deleting..');
                    },
                    success:function(data)
                    {
                      setTimeout(() => {
                            $('#confirmModal').modal('hide');
                            window.location.href = "/employee"; 
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