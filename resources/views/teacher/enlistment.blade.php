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
                  <button type="button" class="addNewSubject btn btn-sm btn-primary d-none">Add Subject</button>
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
                                  <Button type="button" value="'+student.id+'" class="addSubj float-right btn btn-sm btn-primary">\
                                        Selected Subjects\
                                    </Button>\
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

                Toast.fire({
                    icon: 'success',
                    title: response.message,
                })
                
                $('.saveSubjects').prop('disabled', false);
            }

        });


    });

    fetchStudents();

</script>

    
    @endsection
  
  
  </x-app-layout>