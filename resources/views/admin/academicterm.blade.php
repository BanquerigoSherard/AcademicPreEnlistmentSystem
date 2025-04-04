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
      </li> --}}
  
      <li class="nav-item">
        <a href="/students" class="nav-link">
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
        <a href="/teacheraccounts" class="nav-link">
          <i class="nav-icon fas fa-users"></i>
          <p>Teacher Accounts</p>
        </a>
      </li>
        <li class="nav-item">
          <a href="/academicterm" class="nav-link active-link">
              <i class="nav-icon fas fa-book"></i>
            <p>
              Academic Term
            </p>
          </a>
        </li>
      @endif
      
    @endsection
  
    @section('page-name')
      Academic Term
    @endsection
  
    @section('breadcrumb')
      <li class="breadcrumb-item active">Academic Term</li>
    @endsection
  
    @section('page-content')
    {{-- Modals --}}
    {{-- Set Academic Term Confirmation --}}
    <div class="modal fade" id="set-AY-confirm">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title">Set Academic Term</h4>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              
              <div class="modal-body text-center">
                  <h2>Are you sure?</h2>
                  <p>You are about to set the academic term.</p>
                  <p class="">This will affect all students enrolled in the current term. Make sure that all students submitted their grades.</p>

              </div>

              <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="confirmSetAY btn btn-success">Save</button>
              </div>

          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    {{-- Activate Grade Confirmation --}}
    <div class="modal fade" id="activate-grade-modal">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title">Activate Grade</h4>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              
              <div class="modal-body text-center">
                  <h2>Are you sure?</h2>
                  <p>You are about to activate the grade input.</p>
              </div>

              <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                  <button type="submit" id="activateGradeConfirm" class="activateGradeConfirm btn btn-success">Activate</button>
              </div>

          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    {{-- Deactivate Grade Confirmation --}}
    <div class="modal fade" id="deactivate-grade-modal">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title">Deactivate Grade</h4>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              
              <div class="modal-body text-center">
                  <h2>Are you sure?</h2>
                  <p>You are about to deactivate the grade input.</p>
                  <p>Make sure all student inputted their grades.</p>
              </div>

              <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                  <button type="submit" id="deactivateGradeConfirm" class="deactivateGradeConfirm btn btn-success">Deactivate</button>
              </div>

          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    {{-- End Modals --}}
      <div class="row">
        <div class="col-lg-6">
          <div class="curr_academic_term">
            <div class="row">
              <div class="col-lg-6">
                <h4>Current S.Y. <span class="text-bold">{{ $academicTerm->school_year }}</span></h4>
              </div>
              <div class="col-lg-6">
                @if ($academicTerm->semester == '1')
                  <h4>Semester: <span class="text-bold">1st</span></h4>
                @elseif ($academicTerm->semester == '2')
                  <h4>Semester: <span class="text-bold">2nd</span></h4>
                @else
                  <h4>Semester: <span class="text-bold">Summer</span></h4>
                @endif
                
              </div>
            </div>
            
          </div>
        </div>
      </div>
      <div class="row">

        <div class="col-lg-6">  
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Set Academic Year</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form id="setacademictermform" method="POST">

                  <div class="setAcads">
                    <div class="row">
                        <div class="col-sm-6">
                        <!-- select -->
                            {{-- <div class="form-group">
                                <label>School Year</label>
                                <input type="text" value="{{ $academicTerm->school_year }}" name="schoolyear" placeholder="School Year" id="schoolyear" class="form-control" required>
                            </div> --}}

                            @php
                              $year = date("Y");
                              $prev_year = $year - 1;
                              $nextYr = $year + 1;
                              $lastYr = $year + 2;
                            @endphp

                            <div class="form-group">
                              <label>School Year</label>
                              <div class="row">
                                <div class="col-6">
                                  <select name="schoolyear" id="schoolyear" class="form-control">
                                    <option selected disabled value="">Select School Year</option>
                                    <option value="{{ $prev_year }}">{{ $prev_year }}</option>
                                    <option value="{{ $year }}">{{ $year }}</option>
                                    <option value="{{ $nextYr }}">{{ $nextYr }}</option>
                                    <option value="{{ $lastYr }}">{{ $lastYr }}</option>
                                
                                  </select>
                                </div>

                                <div class="col-1">
                                  <span class="sep d-flex justify-content-center align-items-center h-100">-</span>
                                </div>

                                <div class="col-5">
                                  <input type="text" disabled readonly name="nxtschoolyear" placeholder="School Year" id="nxtschoolyear" class="form-control">
                                </div>
                              </div>
                          
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Select Semester</label>
                                <select name="semester" id="semester" class="form-control" required>
                                  @if ($academicTerm->semester == '1')
                                    <option selected value="1">1st Semester</option>
                                    <option value="2">2nd Semester</option>
                                    <option value="3">Summer</option>
                                  @elseif ($academicTerm->semester == '2')
                                    {{-- <option value="1">1st Semester</option> --}}
                                    <option selected value="2">2nd Semester</option>
                                    <option value="3">Summer</option>
                                  @else
                                    {{-- <option value="1">1st Semester</option> --}}
                                    {{-- <option value="2">2nd Semester</option> --}}
                                    <option selected value="3">Summer</option>
                                  @endif
                                
                                </select>
                            </div>
                        </div>
                    </div>
                  </div>

                  <div class="form-group float-right">
                      <button type="submit" class="btn btn-success saveAyConfirm">Save</button>
                  </div>

                </form>
            </div>
          </div>

            
        </div>

        
        <div class="col-lg-6">
          <div class="settingsContent">
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Settings</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="formWrapper mx-4">
                  <div class="form-check form-switch">
                    @if ($academicTerm->grade_status == "Deactivated")
                      <input class="form-check-input" type="checkbox" role="switch" id="activateGrade">
                      <label class="form-check-label" for="activateGrade">Activate Grade Input</label>
                    @elseif ($academicTerm->grade_status == "Activated")
                      <input class="form-check-input" type="checkbox" role="switch" id="deactivateGrade" checked>
                      <label class="form-check-label" for="activateGrade">Deactivate Grade Input</label>
                    @endif
                    
                    
                  </div>
                </div>
              </div>
          </div>
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

      $("#schoolyear").change(function(){
        var curr_sy = $(this).val();
        var nxt_sy = parseInt(curr_sy) + 1;
        $('#nxtschoolyear').val(nxt_sy.toString());
      }); 

      $(function () {
        $.validator.setDefaults({
            submitHandler: function (form) {
                $('#set-AY-confirm').modal('show');

                $('.confirmSetAY').off('click').on('click', function () {
                    $('.confirmSetAY').text('').prop('disabled', true)
                        .append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

                    let formdata = new FormData($('#setacademictermform')[0]);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: "POST",
                        url: "/academicyear/set-academicterm",
                        data: formdata,
                        dataType: "json",
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            $('.confirmSetAY').text('Save').prop('disabled', false);

                            if(response.status == 403){
                              Swal.fire({
                                title: response.message,
                                html: `
                                    <p>The following students have not submitted their grades:</p>
                                    <div style="max-height: 110px; overflow-y: auto;">
                                        <ul style="text-align:left; padding-left: 20px;">
                                            ${response.students.map(student => `<li>${student.student_id} - ${student.name}</li>`).join('')}
                                        </ul>
                                    </div>
                                `,
                                icon: "warning"
                            });


                            }else{
                              Toast.fire({
                                  icon: 'success',
                                  title: response.message,
                              });
                            }

                            $(".curr_academic_term").load(location.href + " .curr_academic_term");
                            $(".setAcads").load(location.href + " .setAcads");
                            
                            $('#set-AY-confirm').modal('hide');
                        },
                        error: function (xhr) {
                            $('.confirmSetAY').text('Save').prop('disabled', false);
                            alert("An error occurred. Please try again.");
                        }
                    });
                });
            }
        });

        $('#setacademictermform').validate({
            rules: {
                semester: {
                    required: true,
                },
            },
            messages: {
                semester: {
                    required: "Please select a semester",
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            }
        });
      });


      $(document).on('click', '#activateGrade', function (e) {
        e.preventDefault();
        $('#activate-grade-modal').modal('show');
      });
    
      $(document).on('click', '#activateGradeConfirm', function (e) {
        $('#activateGradeConfirm').text('').prop('disabled', true).append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Activating...');
          $.ajax({
              type: "GET",
              url: "/academicterm/activate-grade",
              contentType: false,
              processData: false,
              success: function (response){
                  Toast.fire({
                      icon: 'success',
                      title: response.message,
                  })

                  $(".settingsContent").load(location.href + " .settingsContent");
                  $('#activateGradeConfirm').text('Activate').prop('disabled', false);
                  $('#activate-grade-modal').modal('hide');
              }

          });
      });

      $(document).on('click', '#deactivateGrade', function (e) {
        e.preventDefault();
        $('#deactivate-grade-modal').modal('show');
      });

      $(document).on('click', '#deactivateGradeConfirm', function (e) {
        $('#deactivateGradeConfirm').text('').prop('disabled', true).append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deactivating...');
          $.ajax({
              type: "GET",
              url: "/academicterm/deactivate-grade",
              contentType: false,
              processData: false,
              success: function (response){
                  Toast.fire({
                      icon: 'success',
                      title: response.message,
                  })

                  $(".settingsContent").load(location.href + " .settingsContent");
                  $('#deactivateGradeConfirm').text('Deactivate').prop('disabled', false);
                  $('#deactivate-grade-modal').modal('hide');
              }

          });
      });
</script>

    
    @endsection
  
  
  </x-app-layout>