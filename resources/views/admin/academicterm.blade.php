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
        <a href="/enlistment" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
          <p>
            Enlistment
          </p>
        </a>
      </li>
  
      @if (Auth::user()->hasrole('superadministrator'))
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
      <div class="row">

        <div class="col-6">
            <div class="card card-secondary">
                <div class="card-header">
                  <h3 class="card-title">Set Academic Year</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form id="setacademictermform" method="POST">

                        <div class="row">
                            <div class="col-sm-6">
                            <!-- select -->
                                <div class="form-group">
                                    <label>School Year</label>
                                    <input type="text" value="{{ $academicTerm->school_year }}" name="schoolyear" placeholder="School Year" id="schoolyear" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Select Semester</label>
                                    <select name="semester" id="semester" class="form-control" required>
                                      @if ($academicTerm->semester == '1')
                                        <option selected value="1">1st Semester</option>
                                        <option value="2">2nd Semester</option>
                                      @else
                                        <option value="1">1st Semester</option>
                                        <option selected value="2">2nd Semester</option>
                                      @endif
                                    
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group float-right">
                            <button type="submit" class="btn btn-success setAY">Save</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="col-6 settingsContent">
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
  
  
    @endsection


    @section('scripts')
    <script>
       var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });


      $(function () {
          $.validator.setDefaults({
              submitHandler: function () {
                  $('.setAY').text('');

                  $('.setAY').prop('disabled', true);

                  $('.setAY').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

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
                      success: function (response){
                          $('.setAY').text('Save');

                          Toast.fire({
                              icon: 'success',
                              title: response.message,
                          })
                          $('.setAY').prop('disabled', false);
                      }

                  });
              }
          });
          $('#setacademictermform').validate({
              rules: {
                  schoolyear: {
                      required: true,
                  },
                  semester: {
                      required: true,
                  },
              },
              messages: {
                schoolyear: {
                      required: "Please provide a valid school year",
                  },
                  semester: {
                      required: "Please select a semester",
                  },
              },
              errorElement: 'span',
              errorPlacement: function (error, element) {
                  error.addClass('invalid-feedback');
                  element.closest('.form-group').append(error);
              },
              highlight: function (element, errorClass, validClass) {
                  $(element).addClass('is-invalid');
              },
              unhighlight: function (element, errorClass, validClass) {
                  $(element).removeClass('is-invalid');
              }
          });
      });

      $(document).on('click', '#activateGrade', function (e) {
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
              }

          });
      });

      $(document).on('click', '#deactivateGrade', function (e) {
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
              }

          });
      });
</script>

    
    @endsection
  
  
  </x-app-layout>