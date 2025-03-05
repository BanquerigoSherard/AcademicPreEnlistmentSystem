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

        {{-- Add Student Modal --}}
        <div class="modal fade" id="add-new-student">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Student</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <form id="addStudentForm" method="POST">
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <input type="text" name="student_id" required class="form-control" id="student_id" placeholder="Student ID">
                                <label for="student_id">Student ID</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" name="name" required class="form-control" id="name" placeholder="Name">
                                <label for="name">Name</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="email" name="email" required class="form-control" id="email" placeholder="Email">
                                <label for="email">Email</label>
                            </div>

                            <div class="row mb-2">
                                <div class="col-9">
                                    <div class="form-floating">
                                        <select name="course" required class="form-select" id="selectCourse" aria-label="Floating label select example">
                                          <option value="" selected>Select Course</option>
                                          @foreach ($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                                          @endforeach
                                        </select>
                                        <label for="selectCourse">Select Course</label>
                                    </div>
                                </div>

                                <div class="col-3">
                                    <button title="Add New Course" class="btn btn-primary h-100 w-100">Add New</button>
                                </div>
                            </div>

                            <div class="form-floating">
                                <select name="year_lvl" required class="form-select" id="selectyear_lvl" aria-label="Floating label select example">
                                  <option value="" selected>Select Year Level</option>
                                    <option value="1">1st Year</option>
                                    <option value="2">2nd Year</option>
                                    <option value="3">3rd Year</option>
                                    <option value="4">4th Year</option>
                                </select>
                                <label for="selectCourse">Select Year Level</label>
                            </div>
                            
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="saveStudent" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
            <!-- /.modal -->


        {{-- Edit Student Modal --}}
        <div class="modal fade" id="edit-student">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Student</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <form id="editStudentForm" method="POST">
                        <input type="hidden" name="studentIdEdit" id="studentIdEdit">
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <input type="text" name="student_id" required class="form-control" id="student_id_edit" placeholder="Student ID">
                                <label for="student_id_edit">Student ID</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" name="name" required class="form-control" id="name_edit" placeholder="Name">
                                <label for="name_edit">Name</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="email" name="email" required class="form-control" id="email_edit" placeholder="Email">
                                <label for="email_edit">Email</label>
                            </div>

                            <div class="row mb-2">
                                <div class="col-9">
                                    <div class="form-floating">
                                        <select name="course" required class="form-select" id="selectCourseEdit" aria-label="Floating label select example">
                                          <option value="" selected>Select Course</option>
                                          @foreach ($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                                          @endforeach
                                        </select>
                                        <label for="selectCourseEdit">Select Course</label>
                                    </div>
                                </div>

                                <div class="col-3">
                                    <button title="Add New Course" class="btn btn-primary h-100 w-100">Add New</button>
                                </div>
                            </div>

                            <div class="form-floating">
                                <select name="year_lvl" required class="form-select" id="selectyear_lvl_edit" aria-label="Floating label select example">
                                  <option value="" selected>Select Year Level</option>
                                    <option value="1">1st Year</option>
                                    <option value="2">2nd Year</option>
                                    <option value="3">3rd Year</option>
                                    <option value="4">4th Year</option>
                                </select>
                                <label for="selectyear_lvl_edit">Select Year Level</label>
                            </div>
                            
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary updateStudent">Save Changes</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
            <!-- /.modal -->


        {{-- Delete Student Modal --}}
        <div class="modal fade" id="delete-student">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Student</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body text-center">
                        <h2>Are you sure?</h2>
                        <p>You are about to delete this student. This action cannot be undone.</p>

                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="deleteStudent" class="btn btn-danger">Delete</button>
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

                        <button type="button" class="btn btn-sm btn-primary float-right addNewStudBtn">
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

    $(document).on('click', '.addNewStudBtn', function (e) {
        $('#add-new-student').modal('show');
    });

    $(function () {
        $.validator.setDefaults({
            submitHandler: function () {
                $('#saveStudent').text('');

                $('#saveStudent').prop('disabled', true);

                $('#saveStudent').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

                let formdata = new FormData($('#addStudentForm')[0]);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "/students/save-student",
                    data: formdata,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function (response){
                        $('#student_id').val('');
                        $('#name').val('');
                        $('#email').val('');
                        $('#course').val('');
                        $('#year_lvl').text('Save');

                        fetchStudents();

                        $('#add-new-student').modal('hide');

                        Swal.fire({
                            title: response.message,
                            text: "Password: "+response.password,
                            icon: "success"
                        });

                        $('#saveStudent').prop('disabled', false);
                    }

                });
            }
        });
        $('#addStudentForm').validate({
            rules: {
                student_id: {
                    required: true,
                },
                name: {
                    required: true,
                },
                email: {
                    required: true,
                },
                course: {
                    required: true
                },
                year_lvl: {
                    required: true
                }
            },
            messages: {
                student_id: {
                    required: "Student ID is required",
                },
                name: {
                    required: "Please enter your name",
                },
                email: {
                    required: "Please enter your email address",
                },
                course: {
                    required: "Please select a course",
                },
                year_lvl: {
                    required: "Please select year level",
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-floating').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });

    $(document).on('click', '.editStudentBtn', function (e) {
        e.preventDefault();

        var studentID = $(this).val();

        $('#studentIdEdit').val(studentID);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "GET",
            url: "/students/edit-student/"+studentID,
            success: function (response){
                if(response.status == 200){
                    $('#student_id_edit').val(response.student.student_id);
                    $('#name_edit').val(response.student.name);
                    $('#email_edit').val(response.student.email);

                    $('#selectCourseEdit').html('');
                    $.each(response.courses, function(key, course){
                        if(response.student.course_id == course.id){
                            $('#selectCourseEdit').append('<option selected value="'+course.id+'">'+course.name+'</option>');
                        }else{
                            $('#selectCourseEdit').append('<option value="'+course.id+'">'+course.name+'</option>');
                        }

                    });
                    
                    $('#selectyear_lvl_edit').html('');
                    var selected1 = '';
                    var selected2 = '';
                    var selected3 = '';
                    var selected4 = '';
                    if(response.student.year_level == 1){
                        selected1 = 'selected';
                    }else if(response.student.year_level == 2){
                        selected2 = 'selected';
                    }else if(response.student.year_level == 3){
                        selected3 = 'selected';
                    }else if(response.student.year_level == 4){
                        selected4 = 'selected';
                    }

                    $('#selectyear_lvl_edit').append('<option '+selected1+' value="1">1st</option>\
                                        <option '+selected2+' value="2">2nd</option>\
                                        <option '+selected3+' value="3">3rd</option>\
                                        <option '+selected4+' value="4">4th</option>');

                }
            }
        });

        $('#edit-student').modal('show');
    });

    $(function () {
        $.validator.setDefaults({
            submitHandler: function () {
                $('.updateStudent').text('');

                $('.updateStudent').prop('disabled', true);

                $('.updateStudent').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

                let formdata = new FormData($('#editStudentForm')[0]);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "/students/update-student",
                    data: formdata,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function (response){
                        $('#student_id_edit').val('');
                        $('#name_edit').val('');
                        $('#email_edit').val('');
                        // $("#selectCourseEdit" ).selectable( "refresh" );
                        // $("#selectyear_lvl_edit" ).selectable( "refresh" );
                        
                        
                        $('.updateStudent').text('Save Changes');

                        fetchStudents();

                        Toast.fire({
                            icon: 'success',
                            title: response.message,
                        })

                        $('.updateStudent').prop('disabled', false);
                        $('#edit-student').modal('hide');
                    }

                });
            }
        });
        $('#editStudentForm').validate({
            rules: {
                student_id: {
                    required: true,
                },
                name: {
                    required: true,
                },
                email: {
                    required: true,
                },
                course: {
                    required: true
                },
                year_lvl: {
                    required: true
                }
            },
            messages: {
                student_id: {
                    required: "Student ID is required",
                },
                name: {
                    required: "Please enter your name",
                },
                email: {
                    required: "Please enter your email address",
                },
                course: {
                    required: "Please select a course",
                },
                year_lvl: {
                    required: "Please select year level",
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-floating').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });

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

    $(document).on('click', '.deleteStudentBtn', function (e) {
        e.preventDefault();

        var studentID = $(this).val();

        $('#deleteStudent').val(studentID);

        $('#delete-student').modal('show');
    });

    $(document).on('click', '#deleteStudent', function (e) {
        e.preventDefault();

        $('#deleteStudent').text('');

        $('#deleteStudent').prop('disabled', true);

        $('#deleteStudent').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...');


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var studentID = $(this).val();

        $.ajax({
            type: "GET",
            url: "/students/delete-student/"+studentID,
            success: function (response){
                if(response.status == 200){
                    Toast.fire({
                        icon: 'success',
                        title: response.message,
                    })

                    $('#deleteStudent').text('Delete');

                    $('#deleteStudent').prop('disabled', false);
                    $('#delete-student').modal('hide');

                    fetchStudents();
                }
            }
        });

    });
</script>
@endsection
  
  
  </x-app-layout>