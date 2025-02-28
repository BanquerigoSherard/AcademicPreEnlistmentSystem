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
        <li class="nav-item menu-open">
            <a href="#" class="nav-link active-link">
            <i class="nav-icon fas fa-solid fa-book"></i>
            <p>
                Subjects
                <i class="right fas fa-angle-left"></i>
            </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="/subjects" class="nav-link active-link">
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
            <a href="/students" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
              <p>
                Manage Students
              </p>
            </a>

        <li class="nav-item">
            <a href="/enlistment" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                Enlistment
                </p>
            </a>
            </li>
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
        Subjects
    @endsection

    @section('breadcrumb')
        <li class="breadcrumb-item"><a class="text-success" href="/subjects">Subjects</a></li>
        <li class="breadcrumb-item active">Manage Subjects</li>
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
                            <div class="row mb-2">
                                <div class="col-9"> 
                                    <div class="form-floating">
                                        <select name="prospectus" required class="form-select" id="selectProspectusVersion" aria-label="Floating label select example">
                                          <option value="" selected>Select Version</option>
                                          @foreach ($prospectus as $pros)
                                            <option value="{{ $pros->id }}">{{ $pros->version }}</option>
                                          @endforeach
                                        </select>
                                        <label for="selectProspectusVersion">Select Prospectus Version</label>
                                    </div>

                                    
                                </div>
    
                                <div class="col-3">
                                    <button title="Add New Version" class="btn btn-primary h-100 w-100">Add New</button>
                                </div>
                            </div>

                            <div class="row">
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
                            
                            <div class="form-floating mb-3 mt-3">
                                <input type="text" name="subject_code" required class="form-control" id="subject_code" placeholder="Subject Code">
                                <label for="subject_code">Subject Code</label>
                            </div>
 
                            <div class="form-floating mb-3">
                                <input type="text" name="description" required class="form-control" id="description" placeholder="Description">
                                <label for="description">Description</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="number" name="lec_units" required class="form-control" id="lec_units" placeholder="lec_units">
                                <label for="lec_units">Lecture Units</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="number" name="lab_units" required class="form-control" id="lab_units" placeholder="lab_units">
                                <label for="lab_units">Lab Units</label>
                            </div>

                            <div class="multiSelect mb-2">
                                <label>Pre-requisites</label>
                                <select class="selectpicker form-control" name="pre_requisites[]" id="pre-requisites" data-live-search="true" title="Select Subject" data-hide-disabled="true" data-actions-box="true" multiple>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->subject_code }}">{{ $subject->subject_code }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-floating mb-2">
                                <select name="year_lvl" required class="form-select" id="year_lvl" aria-label="Floating label select example">
                                  <option value="" selected>Select year level</option>
                                  <option value="1">1st</option>
                                  <option value="2">2nd</option>
                                  <option value="3">3rd</option>
                                  <option value="4">4th</option>
                                </select>
                                <label for="year_lvl">Select year level</label>
                            </div>

                            <div class="form-floating">
                                <select name="semester" required class="form-select" id="semester" aria-label="Floating label select example">
                                  <option value="" selected>Select semester</option>
                                  <option value="1">1st</option>
                                  <option value="2">2nd</option>
                                </select>
                                <label for="semester">Select semester</label>
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
                            <div class="row mb-2">
                                <div class="col-9"> 
                                    <div class="form-floating">
                                        <select name="prospectus" required class="form-select" id="selectProspectusVersionEdit" aria-label="Floating label select example">
                                          <option value="" selected>Select Version</option>
                                          @foreach ($prospectus as $pros)
                                            <option value="{{ $pros->id }}">{{ $pros->version }}</option>
                                          @endforeach
                                        </select>
                                        <label for="selectProspectusVersionEdit">Select Prospectus Version</label>
                                    </div>

                                    
                                </div>
    
                                <div class="col-3">
                                    <button title="Add New Version" class="btn btn-primary h-100 w-100">Add New</button>
                                </div>
                            </div>

                            <div class="row">
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


                            <div class="form-floating mb-3">
                                <input type="text" name="subject_code" required class="form-control" id="subjectCodeEdit" placeholder="Subject Code">
                                <label for="subjectCodeEdit">Subject Code</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" name="description" required class="form-control" id="descriptionEdit" placeholder="Description">
                                <label for="descriptionEdit">Description</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="number" name="lec_units" required class="form-control" id="lec_units_edit" placeholder="lec_units_edit">
                                <label for="lec_units_edit">Lecture Units</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="number" name="lab_units" required class="form-control" id="lab_units_edit" placeholder="lab_units_edit">
                                <label for="lab_units_edit">Lab Units</label>
                            </div>

                            <div class="multiSelect mb-2">
                                <label>Pre-requisites</label>
                                <select class="selectpicker form-control" name="pre_requisites[]" id="pre_requisites_edit" data-live-search="true" title="Select Subject" data-hide-disabled="true" data-actions-box="true" multiple>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->subject_code }}">{{ $subject->subject_code }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-floating mb-2">
                                <select name="year_lvl" required class="form-select" id="year_lvl_edit" aria-label="Floating label select example">
                                  <option value="" selected>Select year level</option>
                                  <option value="1">1st</option>
                                  <option value="2">2nd</option>
                                  <option value="3">3rd</option>
                                  <option value="4">4th</option>
                                </select>
                                <label for="year_lvl_edit">Select year level</label>
                            </div>

                            <div class="form-floating">
                                <select name="semester" required class="form-select" id="semesterEdit" aria-label="Floating label select example">
                                  <option value="" selected>Select semester</option>
                                  <option value="1">1st</option>
                                  <option value="2">2nd</option>
                                </select>
                                <label for="semesterEdit">Select semester</label>
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
        <div class="modal fade importSubjects" id="import-subjects">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Import Subjects</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <form id="importSubjectForm" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="alert alert-warning" role="alert">
                                Please use this excel template: 
                                <span class="text-primary">
                                    <a href="{{url('excel/ImportSubjects.xlsx')}}" class="text-primary" download>Download Template</a>
                                    <i class="right fas fa-download"></i>
                                </span>
                            </div>

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
                        <h3 class="card-title">List of subjects</h3>

                        <button type="button" data-target="#add-new-subject" class="btn btn-sm btn-primary float-right" data-toggle="modal">
                            <i class="nav-icon fas fa-solid fa-plus"></i>
                            <span>Add New</span>
                        </button>

                        <button type="button" data-target="#import-subjects" class="btn btn-sm btn-success float-right me-2" data-toggle="modal">
                            <i class="nav-icon fas fa-solid fa-file-import"></i>
                            <span>Import</span>
                        </button>
                        
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="subjectsTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Description</th>
                                    <th>Pre-requisites</th>
                                    <th>Units</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="subjects_tbody">
                                {{-- Table Content --}}
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Description</th>
                                    <th>Pre-requisites</th>
                                    <th>Units</th>
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
    function fetchSubjects(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "GET",
            url: "/subjects/fetch-subjects",
            dataType: "json",
            success: function (response){
                $('#subjects_tbody').html('');

                if(response.status == 200){
                    
                    var counter = 0;
                    $.each(response.subjects, function(key, subject){
                        if(subject.pre_requisites == null){
                            var preRequisites = 'None';
                        }else{
                            var preRequisites = subject.pre_requisites;
                        }
                        counter += 1;
                        var totalUnits = parseInt(subject.lec_units) + parseInt(subject.lab_units);
                        $('#subjects_tbody').append('<tr>\
                                <td>'+counter+'</td>\
                                <td>'+subject.subject_code+'</td>\
                                <td>'+subject.description+'</td>\
                                <td>'+preRequisites+'</td>\
                                <td>Lec: '+subject.lec_units+' Lab: '+subject.lab_units+'<br>Total: '+totalUnits+'</td>\
                                <td>\
                                    <Button type="button" value="'+subject.id+'" class="editSubjectBtn btn btn-sm btn-primary">\
                                        <i class="fas fa-pen"></i>\
                                    </Button>\
                                    <Button type="button" value="'+subject.id+'" class="deleteSubjectBtn btn btn-sm btn-danger">\
                                        <i class="fas fa-trash"></i>\
                                    </Button>\
                                </td>\
                            </tr>')

                    });
                    

                    if(response.subjects.length == 0){
                        $('#subjects_tbody').append('<tr>\
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
                        if ( $.fn.dataTable.isDataTable( '#subjectsTable' ) ) {
                            table = $('#subjectsTable').DataTable();
                        }
                        else {
                            $("#subjectsTable").DataTable({
                                "responsive": true, "lengthChange": false, "autoWidth": false,
                                "buttons": ["csv","pdf", "print"]
                                }).buttons().container().appendTo('#subjectsTable_wrapper .col-md-6:eq(0)');

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

    fetchSubjects();


    $(function () {
        $.validator.setDefaults({
            submitHandler: function () {
                $('#saveSubject').text('');

                $('#saveSubject').prop('disabled', true);

                $('#saveSubject').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

                let formdata = new FormData($('#addSubjectForm')[0]);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "/subjects/save-subject",
                    data: formdata,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function (response){
                        $('#subject_code').val('');
                        $('#description').val('');
                        $('#lec_units').val('');
                        $('#lab_units').val('');
                        $('#saveSubject').text('Save');
                        // $('#addSubjectForm').modal('hide');

                        fetchSubjects();

                        console.log(response.test);

                        Toast.fire({
                            icon: 'success',
                            title: response.message,
                        })

                        $('#saveSubject').prop('disabled', false);
                    }

                });
            }
        });
        $('#addSubjectForm').validate({
            rules: {
                prospectus: {
                    required: true,
                },
                subject_code: {
                    required: true,
                },
                description: {
                    required: true,
                },
                lec_units: {
                    required: true
                },
                lab_units: {
                    required: true
                },
                year_lvl: {
                    required: true
                },
                semester: {
                    required: true
                },
            },
            messages: {
                prospectus: {
                    required: "Please select prospectus version",
                },
                course: {
                    required: "Please select course",
                },
                subject_code: {
                    required: "Please provide a valid subject code",
                },
                description: {
                    required: "Please provide a valid description",
                },
                lec_units: {
                    required: "Please provide a valid number of units",
                },
                lab_units: {
                    required: "Please provide a valid number of units",
                },
                year_lvl: {
                    required: "Please select year level",
                },
                semester: {
                    required: "Please select semester",
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

    $(document).on('click', '.editSubjectBtn', function (e) {
        e.preventDefault();

        $('.updateSubject').text('Save Changes');

        var subjectID = $(this).val();

        $('#subject_id_edit').val(subjectID);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "GET",
            url: "/subjects/edit-subject/"+subjectID,
            success: function (response){
                if(response.status == 200){
                    $('#subjectCodeEdit').val(response.subject.subject_code);
                    $('#descriptionEdit').val(response.subject.description);
                    $('#lec_units_edit').val(response.subject.lec_units);
                    $('#lab_units_edit').val(response.subject.lab_units);
                    
                    $('#year_lvl_edit').html('');
                    var selected1 = '';
                    var selected2 = '';
                    var selected3 = '';
                    var selected4 = '';
                    if(response.subject.year_lvl == 1){
                        selected1 = 'selected';
                    }else if(response.subject.year_lvl == 2){
                        selected2 = 'selected';
                    }else if(response.subject.year_lvl == 3){
                        selected3 = 'selected';
                    }else if(response.subject.year_lvl == 4){
                        selected4 = 'selected';
                    }

                    $('#year_lvl_edit').append('<option '+selected1+' value="1">1st</option>\
                                        <option '+selected2+' value="2">2nd</option>\
                                        <option '+selected3+' value="3">3rd</option>\
                                        <option '+selected4+' value="4">4th</option>');

                    $('#semesterEdit').html('');
                    var selectedSem1 = '';
                    var selectedSem2 = '';

                    if(response.subject.semester == 1){
                        selectedSem1 = 'selected';
                    }else if(response.subject.semester == 2){
                        selectedSem2 = 'selected';
                    }

                    $('#semesterEdit').append('<option '+selectedSem1+' value="1">1st</option>\
                                            <option '+selectedSem2+' value="2">2nd</option>');


                    $('#selectProspectusVersionEdit').html('');
                    $.each(response.prospectus, function(key, pros){
                        if(response.subject.prospectus_id == pros.id){
                            $('#selectProspectusVersionEdit').append('<option selected value="'+pros.id+'">'+pros.version+'</option>');
                        }else{
                            $('#selectProspectusVersionEdit').append('<option value="'+pros.id+'">'+pros.version+'</option>');
                        }

                    });

                    $('#selectCourseEdit').html('');
                    $.each(response.courses, function(key, course){
                        if(response.subject.course_id == course.id){
                            $('#selectCourseEdit').append('<option selected value="'+course.id+'">'+course.name+'</option>');
                        }else{
                            $('#selectCourseEdit').append('<option value="'+course.id+'">'+course.name+'</option>');
                        }

                    });

                    var pre_requisites = [];
                    
                    $.each(response.subjects, function(key, subject){
                        if(response.subject.pre_requisites != null){
                            if(response.subject.pre_requisites.includes(subject.subject_code)){
                                pre_requisites.push(subject.subject_code);
                            }
                        }
                    });

                    $('#pre_requisites_edit').selectpicker('val', pre_requisites);

                }
            }
        });

        $('#edit-subject').modal('show');


    });




    

    $(function () {
        $.validator.setDefaults({
            submitHandler: function () {
                $('.updateSubject').text('');

                $('.updateSubject').prop('disabled', true);

                $('.updateSubject').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

                let formdata = new FormData($('#editSubjectForm')[0]);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "/subjects/update-subject",
                    data: formdata,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function (response){
                        $('#subjectCodeEdit').val('');
                        $('#descriptionEdit').val('');
                        $('#unitsEdit').val('');
                        $('.updateSubject').text('Save Changes');

                        fetchSubjects();

                        Toast.fire({
                            icon: 'success',
                            title: response.message,
                        })

                        // console.log(response.errors);
                        

                        $('.updateSubject').prop('disabled', false);
                        $('#edit-subject').modal('hide');
                    }

                });
            }
        });
        $('#editSubjectForm').validate({
            rules: {
                subjectCode: {
                    required: true,
                },
                description: {
                    required: true,
                },
                units: {
                    required: true
                },
            },
            messages: {
                subjectCode: {
                    required: "Please provide a valid subject code",
                },
                description: {
                    required: "Please provide a valid description",
                },
                units: {
                    required: "Please provide a valid number of units",
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


    $(document).on('click', '.deleteSubjectBtn', function (e) {
        e.preventDefault();

        var subjectID = $(this).val();

        $('#subject_id_delete').val(subjectID);

        $('#delete-subject').modal('show');
    });

    $(document).on('click', '#deleteSubject', function (e) {
        e.preventDefault();

        $('#deleteSubject').text('');

        $('#deleteSubject').prop('disabled', true);

        $('#deleteSubject').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...');


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var subjectID = $('#subject_id_delete').val();

        $.ajax({
            type: "GET",
            url: "/subjects/delete-subject/"+subjectID,
            success: function (response){
                if(response.status == 200){
                    Toast.fire({
                        icon: 'success',
                        title: response.message,
                    })

                    $('#deleteSubject').text('Delete');

                    $('#deleteSubject').prop('disabled', false);
                    $('#delete-subject').modal('hide');

                    fetchSubjects();
                }
            }
        });

    });

    $(function () {
        $.validator.setDefaults({
            submitHandler: function () {
                $('#import').text('');

                $('#import').prop('disabled', true);

                $('#import').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Importing...');

                let formdata = new FormData($('#importSubjectForm')[0]);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "/subjects/import-subjects",
                    data: formdata,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function (response){
                        
                        $('#importFile').val('');
                        $('#import').text('Save');


                        fetchSubjects();

                        Toast.fire({
                            icon: 'success',
                            title: response.message,
                        })

                        $('#import').prop('disabled', false);
                        $('#import-subjects').modal('hide');
                    }

                });
            }
        });
        $('#importSubjectForm').validate({
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