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
        <a href="/students" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
          <p>
            Manage Students
          </p>
        </a>
      </li>
  
      <li class="nav-item">
        <a href="/enlistment" class="nav-link active-link">
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
      Enlistment
    @endsection
  
    @section('breadcrumb')
      <li class="breadcrumb-item active">Enlistment</li>
    @endsection
  
    @section('page-content')
    {{-- Modals --}}
    <div class="modal fade" id="add-subject">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title">Add Subject</h4>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              
              <form id="addSubjectForm" method="POST">
                <input type="hidden" name="studentID" id="studentID">
                  <div class="modal-body">
                      <div class="multiSelect mb-2">
                          <label>Subjects</label>
                          <select required class="selectpicker form-control" name="subjects[]" id="subject" data-live-search="true" title="Please select subject" data-hide-disabled="true" multiple>
                              @foreach ($allSubjects as $subject)
                                  @if ($subject->semester == $academicTerm->semester)
                                      <option value="{{ $subject->id }}">{{ $subject->subject_code }} - {{ $subject->description }}</option>
                                  @endif
                              @endforeach
                          </select>
                      </div>
                  </div>
  
                  <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                      <button type="submit" id="addSubject" class="btn btn-success">Save</button>
                  </div>
              </form>
          </div>
          <!-- /.modal-content -->
      </div>
          <!-- /.modal-dialog -->
    </div>

    {{-- View Student Info Modal --}}
    <div class="modal fade" id="view-student-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Student Information</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <div class="relative">
                        {{-- start --}}
    
                        <div id="content">
                            <div class="container">
                            <section class="bar">
                            <div class="container p-0">
                                <div class="row flex-lg-nowrap">
                                    <div class="col p-0">
                                    
                                        <div class="row">
                                            <div class="col m-0">
                                                <div class="card m-0">
                                                    <div class="card-body">
                                                        <div class="e-profile">
                                                            <div class="row">
                                                                <div class="col-12 col-sm-auto
                                                                        mb-3">
                                                                    <div class="mx-auto" style="width: 140px;">
                                                                        <div class="d-flex justify-content-center align-items-center rounded thumbnail-wrapper" style="height:140px; background-color:rgb(233, 236, 239);">
                                                                            <span style="color:rgb(166, 168, 170); font: bold 85pt Arial;">
                                                                                <i class="nav-icon fas fa-user"></i>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                                                                    <div class="text-center text-sm-left mb-2 mb-sm-0">
                                                                        <div class="tit d-flex">
                                                                            <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap me-2" style="color: #888;">Student ID: </h4><h4 class="pt-sm-2 pb-1 mb-0 text-nowrap" id="selectedStudentId"></h4>
                                                                        </div>
                                                                        
                                                                        <div class="own d-flex">
                                                                            <p class="me-2">Name: </p><p class="mb-0 text-black" id="selectedStudentName"></p>
                                                                        </div>
    
                                                                        <div class="sz d-flex">
                                                                            <p class="me-2">Course: </p><p class="mb-0 text-black" id="selectedStudentCourse"></p>
                                                                        </div>
    
                                                                        <div class="du d-flex">
                                                                            <p class="me-2">Year Level: </p><p class="mb-0 text-black" id="selectedStudentYearLevel"></p>
                                                                        </div>
                                                                        
                                                                        
                                                                        <div class="mt-2">
                                                                            {{-- Buttons --}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="text-center text-sm-right enlistStat">
                                                                        
                                                                    </div>
                                                                </div>
                    
                                                            </div>
    
                                                            {{-- Start --}}
    
                                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                                <li class="nav-item" role="presentation">
                                                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">Details</button>
                                                                </li>
                                                                <li class="nav-item grades-item" role="presentation">
                                                                    <button class="nav-link" id="grades-tab-id" data-bs-toggle="tab" data-bs-target="#grades" type="button" role="tab" aria-controls="grades" aria-selected="false">Grades</button>
                                                                </li>
                                                                <li class="nav-item personality-trait-item" role="presentation">
                                                                    <button class="nav-link" id="personality-trait-tab-id" data-bs-toggle="tab" data-bs-target="#personality-trait" type="button" role="tab" aria-controls="personality-trait" aria-selected="false">Personality Trait Score</button>
                                                                </li>
                                                            </ul>
                                                            <div class="tab-content" id="myTabContent">
                                                                <div class="px-3 pt-3 tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                                                                    
                                                                    <div class="row">
                                                                        <div class="col p-0">
                                                                            <form id="editStudentFormView" method="POST">
                                                                                <input type="hidden" name="studentIdEdit" id="studentIdEditView">
                                                                                <div class="modal-body p-0 viewStudentInfo">
                                                                                    <div class="row">
                                                                                        <div class="col-lg-6">
                                                                                            <div class="form-floating mb-3">
                                                                                                <input type="text" name="student_id" required class="form-control" id="student_id_edit_view" placeholder="Student ID">
                                                                                                <label for="student_id_edit_view">Student ID</label>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-lg-6">
                                                                                            <div class="form-floating mb-3">
                                                                                                <input type="text" name="name" required class="form-control" id="name_edit_view" placeholder="Name">
                                                                                                <label for="name_edit_view">Name</label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    
                                                                                    <div class="form-floating mb-3">
                                                                                        <input type="email" name="email" required class="form-control" id="email_edit_view" placeholder="Email">
                                                                                        <label for="email_edit_view">Email</label>
                                                                                    </div>

                                                                                    <div class="row">
                                                                                        <div class="col-lg-6">
                                                                                            <div class="row mb-2">
                                                                                                <div class="col-9">
                                                                                                    <div class="form-floating coursesSelectView">
                                                                                                        <select name="course" required class="form-select" id="selectCourseEditView" aria-label="Floating label select example">
                                                                                                            <option value="" selected>Select Course</option>
                                                                                                            @foreach ($courses as $course)
                                                                                                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                                                                                                            @endforeach
                                                                                                        </select>
                                                                                                        <label for="selectCourseEditView">Select Course</label>
                                                                                                    </div>
                                                                                                </div>
                                                                
                                                                                                <div class="col-3">
                                                                                                    <button title="Add New Course" class="addNewCourse btn btn-primary h-100 w-100">Add New</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-lg-6">
                                                                                            <div class="form-floating">
                                                                                                <select name="year_lvl" required class="form-select" id="selectyear_lvl_edit_view" aria-label="Floating label select example">
                                                                                                    <option value="" selected>Select Year Level</option>
                                                                                                    <option value="1">1st Year</option>
                                                                                                    <option value="2">2nd Year</option>
                                                                                                    <option value="3">3rd Year</option>
                                                                                                    <option value="4">4th Year</option>
                                                                                                </select>
                                                                                                <label for="selectyear_lvl_edit_view">Select Year Level</label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                        
                                                                                <div class="modal-footer justify-content-between float-right px-0">
                                                                                    <button type="submit" class="btn btn-primary updateStudentView">Save Changes</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                
                                                                </div>
    
                                                                <div class="p-3 tab-pane fade grades-tab" id="grades" role="tabpanel" aria-labelledby="grades-tab">
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <div class="mt-2">
                                                                                <div class="row grade-container"></div>
                                                                  
                                                                                
                                                                                
                                                                            </div>                                                                 
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="p-3 tab-pane fade personality-trait-tab" id="personality-trait" role="tabpanel" aria-labelledby="personality-trait-tab">
                                                                    
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <div class="chart-container">
                                                                                <input type="hidden" name="studentID" id="studentID">
                                                                                <canvas id="personalityChart"></canvas>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                
                                                                </div>
    
                                                            </div>
    
    
                                                            {{-- End --}}
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                                    
                            </section>
                            </div>
                        </div>
                    
                        {{-- end --}}
    
                    </div>

                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    {{-- End Modals --}}
      <div class="row">

        <div class="col-xl-6">
            <div class="card card-secondary">
                <div class="card-header">
                  <h3 class="card-title">Search Student</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body overflow-auto" style="max-height: calc(100vh - 36vh);">
                  <table id="studentsTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Year Level</th>
                        </tr>
                    </thead>
                    <tbody id="students_tbody">
                        {{-- Table Content --}}

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Year Level</th>
                        </tr>
                        </tr>
                    </tfoot>
                  </table>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
          <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Add Subjects</h3>
                <div class="student-info d-flex justify-content-end">
                  <h4 class="card-title student_id" style="margin-right: 10px;">Student No.</h4>
                  <h4 class="card-title student_name">Student Name</h4>
                </div>
              </div>
              <!-- /.card-header -->
              <form id="addSubjectsForm" method="POST">
              <div class="card-body overflow-auto" style="max-height: calc(100vh - 45vh);">
                <table id="subjectsTable" class="table table-bordered table-hover">
                  <thead>
                      <tr>
                          <th>Code</th>
                          <th>Description</th>
                          <th>Units</th>
                          <th>Select</th>
                      </tr>
                  </thead>
                  <tbody id="subjects_tbody">
                      {{-- Table Content --}}

                  </tbody>
                  <tfoot>
                      <tr>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Units</th>
                        <th>Select</th>
                      </tr>
                      </tr>
                  </tfoot>
                </table>  
              </div>

              <div class="card-footer">
                <div class="float-right">
                  <button type="button" id="addSubjBtn" class="addNewSubject btn btn-sm btn-primary d-none">Add Subject</button>
                  <button type="submit" class="saveSubjects btn btn-sm btn-success d-none" style="margin-left: 5px;">Approved & Save Subjects</button>
                </div>  
              </div>
              </form>
          </div>
      </div>
        
  
  
  
      </div>
  
  
    @endsection


  @section('scripts')
  <script>
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    $(document).on('click', '#addSubjBtn', function (e) {
        $('#add-subject').modal('show');
    });

    $(function () {
        $.validator.setDefaults({
            submitHandler: function () {
                $('#addSubject').text('');

                $('#addSubject').prop('disabled', true);

                $('#addSubject').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

                let formdata = new FormData($('#addSubjectForm')[0]);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "/student/add-subject",
                    data: formdata,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function (response){
                        $('#addSubject').text('Save');
                        $('#add-subject').modal('hide');

                        Toast.fire({
                            icon: 'success',
                            title: response.message,
                        })

                        var studentID = $('#studentID').val();
                        fetchSubjects(studentID);

                        $('#addSubject').prop('disabled', false);
                    }

                });
            }
        });
        $('#addSubjectForm').validate({
            rules: {
                subjects: {
                    required: true,
                },
            },
            messages: {
                subjects: {
                    required: "Please select subject",
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.multiSelect').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });

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
                    $.each(response.students, function(key, student){
                        if(student.student_id != null){
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
                                <td>'+student.student_id+'</td>\
                                <td>'+student.name+'</td>\
                                <td>'+yearLvl+'\
                                  <div class="btnWrapper d-flex justify-content-center align-items-center">\
                                  <Button type="button" value="'+student.id+'" class="viewStudentBtn float-right btn btn-sm btn-warning me-2">\
                                        <i class="fas fa-eye"></i>\
                                  </Button>\
                                  <Button type="button" value="'+student.id+'" class="addSubj float-right btn btn-sm btn-primary">\
                                        <i class="fas fa-solid fa-book"></i>\
                                  </Button>\
                                  </div>\
                                </td>\
                            </tr>')
                        }
                    });

                    if ( $.fn.dataTable.isDataTable( '#studentsTable' ) ) {
                        table = $('#studentsTable').DataTable();
                    }else {
                        $("#studentsTable").DataTable({
                            "responsive": true, "lengthChange": false, "autoWidth": false,
                            });
                    }

                        
                        
                    }


                }

                

        });

    }

    function fetchSubjects(id){
      $('#studentID').val(id);
      $('#subjects_tbody').html('');
      $('#subjects_tbody').append('<tr>\
                                <td colspan="7">\
                                    <p class="card-text placeholder-glow">\
                                    <span class="placeholder col-12 rounded" style="height: 30px;"></span>\
                                    </p>\
                                </td>\
                            </tr>\
                            <tr>\
                                <td colspan="7">\
                                    <p class="card-text placeholder-glow">\
                                    <span class="placeholder col-12 rounded" style="height: 30px;"></span>\
                                    </p>\
                                </td>\
                            </tr>\<tr>\
                                <td colspan="7">\
                                    <p class="card-text placeholder-glow">\
                                    <span class="placeholder col-12 rounded" style="height: 30px;"></span>\
                                    </p>\
                                </td>\
                            </tr>\<tr>\
                                <td colspan="7">\
                                    <p class="card-text placeholder-glow">\
                                    <span class="placeholder col-12 rounded" style="height: 30px;"></span>\
                                    </p>\
                                </td>\
                            </tr>');
      
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "GET",
            url: "/enlistment/fetch-subjects/"+id,
            dataType: "json",
            success: function (response){
                $('#subjects_tbody').html('');
                $('.student_id').html('');
                  $('.student_name').html('');

                if(response.status == 200){
                  $('.student_id').append(response.student.student_id);
                  $('.student_name').append(response.student.name);
                    $.each(response.subjects, function(key, subject){
                      if(subject != null){
                        var totalUnits = parseInt(subject.lec_units) + parseInt(subject.lab_units);
                        $('#subjects_tbody').append('<tr>\
                                  <td>'+subject.subject_code+'</td>\
                                  <td>'+subject.description+'</td>\
                                  <td>Lec: '+subject.lec_units+' Lab: '+subject.lab_units+'<br>Total: '+totalUnits+'</td>\
                                  <td>\
                                    <div class="custom-control custom-checkbox">\
                                        <label class="checkbox">\
                                            <input type="checkbox" checked name="subjectsSelected[]" value="'+subject.id+'"></label>\
                                    </div>\
                                  </td>\
                              </tr>')
                      }
                      
                    });

                    if(response.subjects.length == 1){
                        $('#subjects_tbody').append('<tr>\
                                <td colspan="10">\
                                    <div class="imgCont">\
                                        <div class="imgEmpty d-flex justify-content-center align-items-center flex-column" style="height: calc(100% - 120px);">\
                                            <img src="{{ url("images/empty.png") }}" alt="" style="height: 150px;">\
                                            <p class="mt-2 fw-bold fs-4" style="color: #7777;">No Subject Selected</p>\
                                        </div>\
                                    </div>\
                                </td>\
                            </tr>');

                        $('.saveSubjects').addClass('d-none');
                    }else{
                      if ( $.fn.dataTable.isDataTable( '#subjectsTable' ) ) {
                        table = $('#subjectsTable').DataTable();
                      }else {
                          $("#subjectsTable").DataTable({
                              "responsive": true, "lengthChange": false, "autoWidth": false,
                              });
                      }

                      $('.saveSubjects').removeClass('d-none');
                    }

                    
     
                  }


                }

        });

    }

    $(document).on('click', '.addSubj', function (e) {
        e.preventDefault();

        var id = $(this).val();
        fetchSubjects(id);
        $('.saveSubjects').val(id);
        $('.addNewSubject').val(id);
        $('.addNewSubject').removeClass('d-none');

    });

    $(document).on('click', '.saveSubjects', function (e) {
        e.preventDefault();

        $('.saveSubjects').text('');

        $('.saveSubjects').prop('disabled', true);

        $('.saveSubjects').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

        let formdata = new FormData($('#addSubjectsForm')[0]);

        var stud_id = $('.saveSubjects').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "/enlistment/save-subjects/"+stud_id,
            data: formdata,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (response){
                $('.saveSubjects').text('Approved & Save Subjects');

                var studentID = $('#studentID').val();
                fetchSubjects(studentID);

                Toast.fire({
                    icon: 'success',
                    title: response.message,
                })
                
                $('.saveSubjects').prop('disabled', false);
            }

        });


    });

    fetchStudents();

    // Select Courses CRUD Functions
    function fetchCourses(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "GET",
            url: "/subjects/fetch-courses",
            dataType: "json",
            success: function (response){
                $('#courses_tbody').html('');

                if(response.status == 200){
                    
                    var counter = 0;
                    $.each(response.courses, function(key, course){
                        counter += 1;
                        $('#courses_tbody').append('<tr>\
                                <td>'+counter+'</td>\
                                <td data-name="'+course.name+'">'+course.name+'</td>\
                                <td data-abbreviation="'+course.abbreviation+'">'+course.abbreviation+'</td>\
                                <td data-id="'+course.id+'">\
                                    <Button type="button" value="'+course.id+'" class="deleteCourseBtn btn btn-sm btn-danger">\
                                        <i class="fas fa-trash"></i>\
                                    </Button>\
                                </td>\
                            </tr>')
                    });
                    

                    if(response.courses.length == 0){
                        $('#courses_tbody').append('<tr>\
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
                        if ( $.fn.dataTable.isDataTable( '#coursesTable' ) ) {
                            table = $('#coursesTable').DataTable();
                        }
                        else {
                            $("#coursesTable").DataTable({
                                "responsive": true, "lengthChange": false, "autoWidth": false,
                                "buttons": ["csv","pdf", "print"]
                                }).buttons().container().appendTo('#coursesTable_wrapper .col-md-6:eq(0)');

                            }
                        }

                        
                        
                    }

                }

                

        });

    }

    $(document).on('click', '.addNewCourse', function (e) {
        e.preventDefault();
        $('#course_save_id').val("0");
        fetchCourses();
        $('#courses-modal').modal('show');
    });

    $(function () {
        $.validator.setDefaults({
            submitHandler: function () {
                $('#saveCourse').text('');

                $('#saveCourse').prop('disabled', true);

                $('#saveCourse').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

                let formdata = new FormData($('#addCourseForm')[0]);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "/subjects/save-course",
                    data: formdata,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function (response){
                        $('#course_name').val('');
                        $('#course_abbr').val('');
                        $('#saveCourse').text('Save');

                        fetchCourses();

                        Toast.fire({
                            icon: 'success',
                            title: response.message,
                        })

                        $(".coursesSelectAdd").load(location.href + " .coursesSelectAdd");
                        $(".coursesSelectImport").load(location.href + " .coursesSelectImport");
                        $(".coursesSelectEdit").load(location.href + " .coursesSelectEdit");
                        $(".coursesSelectView").load(location.href + " .coursesSelectView");

                        $('#saveCourse').prop('disabled', false);
                    }

                });
            }
        });
        $('#addCourseForm').validate({
            rules: {
                course_name: {
                    required: true,
                },
                course_abbr: {
                    required: true,
                },
            },
            messages: {
                course_name: {
                    required: "Please input course name",
                },
                course_abbr: {
                    required: "Please input course abbreviation",
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

    $(document).on('click', '#coursesTable tbody tr', function (e) {
        e.preventDefault();

        var data = { name: '', abbreviation: '', id: '' };
        
        $(this).children('td').each(function() {
            var id = $(this).data('id');
            if (id) {
                data.id = id;
            } 

            var name = $(this).data('name');
            if (name) {
                data.name = name;
            }
            
            var abbreviation = $(this).data('abbreviation');
            if (abbreviation) {
                data.abbreviation = abbreviation;
            }      
        });
        
        $('#course_save_id').val(data.id);
        $('#course_name').val(data.name);
        $('#course_abbr').val(data.abbreviation);

    });

    $(document).on('click', '.deleteCourseBtn', function (e) {
        e.preventDefault();
        $('#deleteCourse').val($(this).val());
        $('#delete-course-modal').modal('show');
    });

    $(document).on('click', '#deleteCourse', function (e) {
        e.preventDefault();

        $('#deleteCourse').text('');

        $('#deleteCourse').prop('disabled', true);

        $('#deleteCourse').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...');


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var courseID = $(this).val();

        $.ajax({
            type: "GET",
            url: "/subjects/delete-course/"+courseID,
            success: function (response){
                if(response.status == 200){
                    Toast.fire({
                        icon: 'success',
                        title: response.message,
                    })

                    $('#deleteCourse').text('Delete');

                    $('#deleteCourse').prop('disabled', false);
                    $('#delete-course-modal').modal('hide');

                    $('#course_save_id').val("0");
                    $('#course_name').val("");
                    $('#course_abbr').val("");

                    $(".coursesSelectAdd").load(location.href + " .coursesSelectAdd");
                    $(".coursesSelectImport").load(location.href + " .coursesSelectImport");
                    $(".coursesSelectEdit").load(location.href + " .coursesSelectEdit");
                    $(".coursesSelectView").load(location.href + " .coursesSelectView");

                    fetchCourses();
                }
            }
        });

    });

    // Functions for View Student
    let personalityChartInstance = null
    function initPersonalityChart() {
        var studentID = $('#studentID').val();
        $.ajax({
            type: "GET",
            url: "/personality-test-results/get-test-results/"+studentID,
            contentType: false,
            processData: false,
            success: function (response){        
            var ctx = $("#personalityChart")[0].getContext("2d");        
            if (personalityChartInstance !== null) {
                personalityChartInstance.destroy();
            }
            
            personalityChartInstance = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: ["Openness", "Conscientiousness", "Extraversion", "Agreeableness", "Neuroticism"],
                    datasets: [{
                        label: "Score",
                        data: response.testResults,
                        backgroundColor: "rgba(54, 162, 235, 0.7)",
                        borderColor: "rgba(54, 162, 235, 1)",
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: "y", // Horizontal bar chart
                    scales: {
                        x: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                stepSize: 10
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false // Hides the legend
                        }
                    }
                }
            });

            }

        });

    }
    
    $(document).on('click', '.viewStudentBtn', function (e) {
        e.preventDefault();

        var studentID = $(this).val();
        $('#studentID').val(studentID);

        $('#studentIdEditView').val(studentID);

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
                    

                    $('#student_id_edit_view').val(response.student.student_id);
                    $('#name_edit_view').val(response.student.name);
                    $('#email_edit_view').val(response.student.email);

                    $('#selectCourseEditView').html('');
                    var courseVal = '';
                    $.each(response.courses, function(key, course){
                        if(response.student.course_id == course.id){
                            $('#selectCourseEditView').append('<option selected value="'+course.id+'">'+course.name+'</option>');
                            courseVal = course.name;
                            
                        }else{
                            $('#selectCourseEditView').append('<option value="'+course.id+'">'+course.name+'</option>');
                        }

                    });

                    var yearLvl = "";
                    $('#selectyear_lvl_edit_view').html('');
                    var selected1 = '';
                    var selected2 = '';
                    var selected3 = '';
                    var selected4 = '';
                    if(response.student.year_level == 1){
                        selected1 = 'selected';
                        yearLvl = "1st";
                    }else if(response.student.year_level == 2){
                        selected2 = 'selected';
                        yearLvl = "2nd";
                    }else if(response.student.year_level == 3){
                        selected3 = 'selected';
                        yearLvl = "3rd";
                    }else if(response.student.year_level == 4){
                        selected4 = 'selected';
                        yearLvl = "4th";
                    }

                    $('#selectyear_lvl_edit_view').append('<option '+selected1+' value="1">1st</option>\
                                        <option '+selected2+' value="2">2nd</option>\
                                        <option '+selected3+' value="3">3rd</option>\
                                        <option '+selected4+' value="4">4th</option>');


                    $('#selectedStudentId').html(response.student.student_id);
                    $('#selectedStudentName').html(response.student.name);
                    $('#selectedStudentCourse').html(courseVal);
                    $('#selectedStudentYearLevel').html(yearLvl);

                    // <span>Status: </span><span class="badge badge-success enlistStat">Enlisted</span>
                    $('.enlistStat').html("");
                    if(response.student.current_subjects != "" && response.student.current_subjects_status == 3){
                        $('.enlistStat').append('<span>Status: </span><span class="badge badge-success">Enlisted</span>');
                    }else{
                        $('.enlistStat').append('<span>Status: </span><span class="badge badge-warning">???</span>');
                    }


                    let groupedGrades = {};

                    // Group subjects by school year and semester
                    $.each(response.grades, function(key, grade){
                        let sySem = grade.school_year + '-' + grade.semester;

                        if (!groupedGrades[sySem]) {
                            groupedGrades[sySem] = {
                                school_year: grade.school_year,
                                semester: grade.semester,
                                subjects: []
                            };
                        }

                        // Find subject details
                        var subjectCode = '';
                        var subjectDesc = '';
                        $.each(response.subjects, function(k, subject){
                            if(grade.subject_id == subject.id){
                                subjectCode = subject.subject_code;
                                subjectDesc = subject.description;
                            }
                        });

                        // Add subject to the group
                        groupedGrades[sySem].subjects.push({
                            subject_code: subjectCode,
                            description: subjectDesc,
                            grade: grade.grade
                        });
                    });

                    // Now render grouped data
                    let htmlContent = "";
                    $.each(groupedGrades, function(key, group){
                        var semText = group.semester == 1 ? '1st Semester' : '2nd Semester';
                        htmlContent += `
                            <div class="col-lg-6">
                                <div class="gradeWrapper">
                                    <h5>SY ${group.school_year} (${semText})</h5>
                                    <table class="table table-bordered">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th>Code</th>
                                                <th>Description</th>
                                                <th>Grade</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                        `;

                        $.each(group.subjects, function(index, subject){
                            htmlContent += `
                                <tr>
                                    <td>${subject.subject_code}</td>
                                    <td>${subject.description}</td>
                                    <td>${subject.grade}</td>
                                </tr>
                            `;
                        });

                        htmlContent += `</tbody></table></div></div>`;
                    });

                    // Append generated HTML to container
                    $(".grade-container").html(htmlContent); 

                }
            }
        });

        // For Personality Trait
        initPersonalityChart();
        $('#view-student-modal').modal('show');
    });

    $(function () {
        $.validator.setDefaults({
            submitHandler: function () {
                $('.updateStudentView').text('');

                $('.updateStudentView').prop('disabled', true);

                $('.updateStudentView').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

                let formdata = new FormData($('#editStudentFormView')[0]);

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
                        $('.updateStudentView').text('Save Changes');

                        $(".viewStudentInfo").load(location.href + ".viewStudentInfo");

                        Toast.fire({
                            icon: 'success',
                            title: response.message,
                        })

                        $('.updateStudentView').prop('disabled', false);
                    }

                });
            }
        });
        $('#editStudentFormView').validate({
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


</script>

    
    @endsection
  
  
  </x-app-layout>