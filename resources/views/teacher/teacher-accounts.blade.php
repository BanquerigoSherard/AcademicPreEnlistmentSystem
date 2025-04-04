<x-app-layout>
    @section('sidebar-links')
        <li class="nav-item">
            <a href="/dashboard" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="/subjects" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>Subjects</p>
            </a>
          </li>
        {{-- Subjects --}}
        {{-- <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-solid fa-book"></i>
                <p>Subjects <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="/subjects" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Manage Subjects</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/pre-requisites" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pre-requisites</p>
                    </a>
                </li>
            </ul>
        </li> --}}

        <li class="nav-item">
            <a href="/students" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>Manage Students</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="/enlistment" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>Enlistment</p>
            </a>
        </li>

        @if (Auth::user()->hasrole('superadministrator'))
        <li class="nav-item">
            <a href="/teachers" class="nav-link active-link">
                <i class="nav-icon fas fa-users"></i>
                <p>Teacher Accounts</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/academicterm" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>Academic Term</p>
            </a>
        </li>
        @endif
    @endsection

    @section('page-name')
        Manage Teacher Accounts
    @endsection

    @section('breadcrumb')
        <li class="breadcrumb-item active">Manage Teacher Accounts</li>
    @endsection

    @section('page-content')
        {{-- Modals --}}
        <div class="modal fade" id="add-new-teacher" tabindex="-1" aria-labelledby="addNewTeacherModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addNewTeacherModalLabel">Add New Teacher</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="addTeacherForm">
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="teacher_name" name="name" placeholder="Name" required>
                                <label for="teacher_name">Name</label>
                            </div>
        
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="teacher_email" name="email" placeholder="Email" required>
                                <label for="teacher_email">Email</label>
                            </div>

                            <p class="text-muted"><small>Note: Password is auto generated.</small></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="saveTeacher">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Edit Teacher Modal -->
        <div class="modal fade" id="edit-teacher" tabindex="-1" aria-labelledby="editTeacherModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTeacherModalLabel">Edit Teacher</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editTeacherForm">
                        <div class="modal-body">
                            <input type="hidden" id="teacher_id" name="teacher_id">

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="edit_teacher_name" name="name" placeholder="Teacher Name" required>
                                <label for="edit_teacher_name">Teacher Name</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="edit_teacher_email" name="email" placeholder="Teacher Email" required>
                                <label for="edit_teacher_email">Teacher Email</label>
                            </div>

                            <p class="text-muted"><small>Note: Password remains unchanged.</small></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary updateTeacher">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Teacher Modal -->
        <div class="modal fade" id="delete-teacher">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Teacher</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body text-center">
                        <h2>Are you sure?</h2>
                        <p>You are about to delete this teacher. This action cannot be undone.</p>
                        <input type="hidden" id="teacherIdToDelete">
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="deleteTeacher" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Add your modal structure here for editing teachers -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">List of Teachers</h3>

                        <button type="button" class="btn btn-sm btn-primary float-right addNewTeacherBtn">
                            <i class="nav-icon fas fa-solid fa-plus"></i>
                            <span>Add New</span>
                        </button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="teachersTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="teachers_tbody">
                                {{-- Table Content --}}
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Action</th>
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
        function fetchTeachers() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "GET",
                url: "/teachers/fetch-teachers",
                dataType: "json",
                success: function (response) {
                    $('#teachers_tbody').html('');

                    if (response.status == 200) {
                        var counter = 0;
                        $.each(response.teachers, function (key, teacher) {
                            counter += 1;
                            var department = teacher.department || 'N/A';
                            $('#teachers_tbody').append('<tr>\
                                <td>' + counter + '</td>\
                                <td>' + teacher.name + '</td>\
                                <td>' + teacher.email + '</td>\
                                <td>\
                                    <Button type="button" value="' + teacher.id + '" class="viewTeacherBtn btn btn-sm btn-warning">\
                                        <i class="fas fa-eye"></i>\
                                    </Button>\
                                    <Button type="button" value="' + teacher.id + '" class="editTeacherBtn btn btn-sm btn-primary">\
                                        <i class="fas fa-pen"></i>\
                                    </Button>\
                                    <Button type="button" value="' + teacher.id + '" class="deleteTeacherBtn btn btn-sm btn-danger">\
                                        <i class="fas fa-trash"></i>\
                                    </Button>\
                                </td>\
                            </tr>');
                        });

                        if (response.teachers.length == 0) {
                            $('#teachers_tbody').append('<tr>\
                                <td colspan="6">\
                                    <div class="imgCont">\
                                        <div class="imgEmpty d-flex justify-content-center align-items-center flex-column" style="height: calc(100% - 120px);">\
                                            <img src="{{ url("images/empty.png") }}" alt="" style="height: 150px;">\
                                            <p class="mt-2 fw-bold fs-4" style="color: #7777;">No Records</p>\
                                        </div>\
                                    </div>\
                                </td>\
                            </tr>');
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

        fetchTeachers();

        $(document).on('click', '.addNewTeacherBtn', function () {
            $('#add-new-teacher').modal('show');
        });

        $(function () {
            // Form validation
            $('#addTeacherForm').validate({
                submitHandler: function () {
                    // Disable the submit button and show loading spinner
                    $('#saveTeacher').text('');
                    $('#saveTeacher').prop('disabled', true);
                    $('#saveTeacher').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

                    let formdata = new FormData($('#addTeacherForm')[0]);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: "POST",
                        url: "/teachers/save-teacher",
                        data: formdata,
                        dataType: "json",
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            console.log(response.errors);
                            
                            $('#teacher_name').val('');
                            $('#teacher_email').val('');

                            $('#saveTeacher').text('Save');
                            $('#saveTeacher').prop('disabled', false);

                            // Close the modal
                            $('#add-new-teacher').modal('hide');

                            Swal.fire({
                                title: response.message,
                                text: "Password: "+response.password,
                                icon: "success"
                            });

                            fetchTeachers();
                        }
                    });
                },
                rules: {
                    teacher_name: {
                        required: true,
                    },
                    teacher_email: {
                        required: true,
                        email: true
                    }
                },
                messages: {
                    teacher_name: {
                        required: "Please enter the teacher's name",
                    },
                    teacher_email: {
                        required: "Please enter the teacher's email",
                        email: "Please enter a valid email address"
                    }
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
    
        $(document).on('click', '.editTeacherBtn', function (e) {
            e.preventDefault();

            var teacherID = $(this).val();

            $('#teacherIdEdit').val(teacherID);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "GET",
                url: "/teachers/edit-teacher/" + teacherID,
                success: function (response) {
                    if (response.status == 200) {
                        $('#teacher_id').val(response.teacher.id);
                        $('#edit_teacher_name').val(response.teacher.name);
                        $('#edit_teacher_email').val(response.teacher.email);
                    }
                }
            });

            $('#edit-teacher').modal('show');
        });

        $(function () {
            $.validator.setDefaults({
                submitHandler: function () {
                    $('.updateTeacher').text('');
                    $('.updateTeacher').prop('disabled', true);
                    $('.updateTeacher').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

                    let formdata = new FormData($('#editTeacherForm')[0]);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: "POST", 
                        url: "/teachers/update-teacher",
                        data: formdata,
                        dataType: "json",
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if (response.status === 200) {
                                Toast.fire({
                                    icon: 'success',
                                    title: response.message,
                                });

                                $('#edit_teacher_name').val('');
                                $('#edit_teacher_email').val('');

                                $('.updateTeacher').text('Save Changes');

                                fetchTeachers();
                                $('.updateTeacher').prop('disabled', false);
                                $('#edit-teacher').modal('hide');
                            }
                        },
                        error: function (xhr) {
                            console.log(xhr.responseText); 
                        }
                    });
                }
            });

            $('#editTeacherForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                    }
                },
                messages: {
                    name: {
                        required: "Please enter the teacher's name",
                    },
                    email: {
                        required: "Please enter the teacher's email address",
                    }
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
  
        $(document).on('click', '.deleteTeacherBtn', function () {
            var teacherID = $(this).val();
            $('#teacherIdToDelete').val(teacherID);
            $('#delete-teacher').modal('show');
        });

        $('#deleteTeacher').click(function () {
            var teacherID = $('#teacherIdToDelete').val();

            $('#deleteTeacher').text('');
            $('#deleteTeacher').prop('disabled', true);
            $('#deleteTeacher').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "DELETE",
                url: "/teachers/delete-teacher/" + teacherID,
                success: function (response) {
                    if (response.status === 200) {
                        Toast.fire({
                            icon: "success",
                            title: response.message,
                        });

                        $('#delete-teacher').modal('hide');
                        $('#deleteTeacher').text('Delete');
                        $('#deleteTeacher').prop('disabled', false);
                        fetchTeachers();
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

    </script>
    @endsection
</x-app-layout>
