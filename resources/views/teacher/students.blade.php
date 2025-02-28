<x-app-layout>
    @section('sidebar-links')
        <li class="nav-item">
        <a href="/dashboard" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
            Dashboard
            </p>
        </a>
        </li>

        {{-- Subjects --}}
        <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-solid fa-book"></i>
            <p>
                Subjects
                <i class="right fas fa-angle-left"></i>
            </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="/subjects" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Manage Subjects
                </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="/pre-requisites" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Pre-requisites
                </p>
                </a>
            </li>
            </ul>
        </li>

        <li class="nav-item">
            <a href="/students" class="nav-link active-link">
                <i class="nav-icon fas fa-users"></i>
              <p>
                Manage Students
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/enlistment" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
              <p>
                Enlistment
              </p>
            </a>
          </li>

        @if (Auth::user()->hasrole('superadministrator'))
          <li class="nav-item">
            <a href="/academicterm" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
              <p>
                Academic Term
              </p>
            </a>
          </li>
        @endif
    @endsection

    @section('page-name')
        Manage Students
    @endsection

    @section('breadcrumb')
        <li class="breadcrumb-item active">Manage Students</li>
    @endsection

    @section('page-content')
        {{-- Modals --}}

        {{-- Add Subject Modal --}}
        <div class="modal fade" id="add-new-subject">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Subject</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <form id="addSubjectForm" method="POST">
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <input type="text" name="subjectCode" required class="form-control" id="subjectCode" placeholder="Subject Code">
                                <label for="subjectCode">Subject Code</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" name="description" required class="form-control" id="description" placeholder="Description">
                                <label for="description">Description</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="number" name="units" required class="form-control" id="units" placeholder="Units">
                                <label for="units">Units</label>
                            </div>
                            
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="saveSubject" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
            <!-- /.modal -->


        {{-- Edit Modal --}}
        <div class="modal fade" id="edit-subject">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Subject</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <form id="editSubjectForm" method="POST">
                        <input type="hidden" name="subject_id_edit" id="subject_id_edit">
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <input type="text" name="subjectCode" required class="form-control" id="subjectCodeEdit" placeholder="Subject Code">
                                <label for="subjectCodeEdit">Subject Code</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" name="description" required class="form-control" id="descriptionEdit" placeholder="Description">
                                <label for="descriptionEdit">Description</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="number" name="units" required class="form-control" id="unitsEdit" placeholder="Units">
                                <label for="unitsEdit">Units</label>
                            </div>
                            
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary updateSubject">Save Changes</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
            <!-- /.modal -->


        {{-- Delete Modal --}}
        <div class="modal fade" id="delete-subject">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Subject</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body text-center">
                        <input type="hidden" name="subject_id_delete" id="subject_id_delete">
                        <h2>Are you sure?</h2>
                        <p>You are about to delete this subject. This action cannot be undone.</p>

                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="deleteSubject" class="btn btn-danger">Delete</button>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
            <!-- /.modal -->

        {{-- Import Subject Modal --}}
        <div class="modal fade importStudents" id="import-students">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Import Students</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <form id="importStudentForm" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="input-group mb-3">
                                <input type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" class="form-control" name="importFile" id="importFile">
                                <label class="input-group-text" for="importFile">Import File</label>
                            </div>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="import" class="btn btn-success">Import</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
            <!-- /.modal -->
        {{-- End Modals --}}

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">List of Students</h3>

                        <button type="button" data-target="#add-new-student" class="btn btn-sm btn-primary float-right" data-toggle="modal">
                            <i class="nav-icon fas fa-solid fa-plus"></i>
                            <span>Add New</span>
                        </button>

                        <button type="button" data-target="#import-students" class="btn btn-sm btn-success float-right me-2" data-toggle="modal">
                            <i class="nav-icon fas fa-solid fa-file-import"></i>
                            <span>Import</span>
                        </button>
                        
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="studentsTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Year Level</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="students_tbody">
                                {{-- Table Content --}}
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Year Level</th>
                                    <th>Action</th>
                                </tr>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            
        </div>
        
    @endsection

@section('scripts')
<script>
    function fetchStudents(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "GET",
            url: "/students/fetch-students",
            dataType: "json",
            success: function (response){
                $('#students_tbody').html('');

                if(response.status == 200){

                    var counter = 0;
                    $.each(response.students, function(key, student){
                        if(student.student_id != null){
                            counter += 1;
                            var yearLvl = '';

                            if(student.year_level == 1){
                                yearLvl = '1st Year';
                            }else if(student.year_level == 2){
                                yearLvl = '2nd Year';
                            }else if(student.year_level == 3){
                                yearLvl = '3rd Year';
                            }else if(student.year_level == 4){
                                yearLvl = '4th Year';
                            }
                            $('#students_tbody').append('<tr>\
                                <td>'+counter+'</td>\
                                <td>'+student.student_id+'</td>\
                                <td>'+student.name+'</td>\
                                <td>'+student.email+'</td>\
                                <td>'+yearLvl+'</td>\
                                <td>\
                                    <Button type="button" value="'+student.id+'" class="editStudentBtn btn btn-sm btn-primary">\
                                        <i class="fas fa-pen"></i>\
                                    </Button>\
                                    <Button type="button" value="'+student.id+'" class="deleteStudentBtn btn btn-sm btn-danger">\
                                        <i class="fas fa-trash"></i>\
                                    </Button>\
                                </td>\
                            </tr>')
                        }
                    });

                    if(response.students.length == 0){
                        $('#students_tbody').append('<tr>\
                                <td colspan="10">\
                                    <div class="imgCont">\
                                        <div class="imgEmpty d-flex justify-content-center align-items-center flex-column" style="height: calc(100% - 120px);">\
                                            <img src="{{ url("images/empty.png") }}" alt="" style="height: 150px;">\
                                            <p class="mt-2 fw-bold fs-4" style="color: #7777;">No Records</p>\
                                        </div>\
                                    </div>\
                                </td>\
                            </tr>');
                    }else{
                        if ( $.fn.dataTable.isDataTable( '#studentsTable' ) ) {
                            table = $('#studentsTable').DataTable();
                        }
                        else {
                            $("#studentsTable").DataTable({
                                "responsive": true, "lengthChange": false, "autoWidth": false,
                                "buttons": ["csv","pdf", "print"]
                                }).buttons().container().appendTo('#studentsTable_wrapper .col-md-6:eq(0)');

                            }
                        }

                        
                        
                    }


                }

                

        });

    }

    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    fetchStudents();

    $(function () {
        $.validator.setDefaults({
            submitHandler: function () {
                $('#import').text('');

                $('#import').prop('disabled', true);

                $('#import').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Importing...');

                let formdata = new FormData($('#importStudentForm')[0]);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "/students/import-students",
                    data: formdata,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function (response){
                        
                        $('#importFile').val('');
                        $('#import').text('Save');


                        fetchStudents();

                        Toast.fire({
                            icon: 'success',
                            title: response.message,
                        })

                        $('#import').prop('disabled', false);
                        $('#import-students').modal('hide');
                    }

                });
            }
        });
        $('#importStudentForm').validate({
            rules: {
                importFile: {
                    required: true,
                },
            },
            messages: {
                importFile: {
                    required: "Please choose an excel file",
                    accept: "Please choose a valid excel file"
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.input-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });


</script>
@endsection
  
  
  </x-app-layout>