<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-lg text-gray-800 leading-tight">
          {{ __('Subjects') }}
      </h2>
  </x-slot>

 
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
                <div class="modal-body">
                    <div class="multiSelect mb-2">
                        <label>Subjects</label>
                        <select required class="selectpicker form-control" name="subjects[]" id="subject" data-live-search="true" title="Please select subject" data-hide-disabled="true" multiple>
                            @foreach ($allSubjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->subject_code }} - {{ $subject->description }}</option>
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

   <div class="modal fade" id="lock-grades-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Lock Grades</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body text-center">
                <h2>Are you sure?</h2>
                <p>You are about to lock your grades. This action cannot be undone.</p>

            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="lockGrades" class="btn btn-primary">Lock Grades</button>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

{{-- End Modals --}}

  <div class="pb-12 pt-6">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg my-3 p-3">
                <div class="row">
                    <div class="col-3">
                        <h1><span class="text-bold">Name:</span> {{ Auth::user()->name }}</h1>
                    </div>

                    <div class="col-3">
                        <h1><span class="text-bold">Student ID:</span> {{ Auth::user()->student_id }}</h1>
                    </div>

                    <div class="col-3">
                        <h1><span class="text-bold">Course:</span> {{ $course->abbreviation }}</h1>
                    </div>

                    <div class="col-3">
                        @if (Auth::user()->year_level == "1")
                            <h1><span class="text-bold">Year Level:</span> 1st</h1>

                        @elseif (Auth::user()->year_level == "2")
                            <h1><span class="text-bold">Year Level:</span> 2nd</h1>
                        @elseif (Auth::user()->year_level == "3")
                            <h1><span class="text-bold">Year Level:</span> 3rd</h1>
                        @elseif (Auth::user()->year_level == "4")
                            <h1><span class="text-bold">Year Level:</span> 4th</h1>
                        @endif
                        
                    </div>
                </div>
            </div>
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900">

                @if (Auth::user()->current_subjects_status == 0)
                <div class="row mb-2">
                    <div class="col-12">
                            <button type="button" id="addSubjBtn" data-toggle="modal" class="btn btn-sm btn-primary float-right">
                                <i class="nav-icon fas fa-solid fa-plus"></i>
                                <span>Add Subject</span>
                            </button>
                    </div>
                </div>
                @endif

                <div class="pageContent">
                 
                <div class="row">
                    <div class="col-12">
                        <div class="card m-0">
                            <div class="card-header">
                                <h3 class="card-title">List of Subjects</h3>

                                <div class="academicTermInfo float-right d-flex">
                                    <h1 class="me-2"><span class="text-bold">S.Y.</span> {{ $academicTerm->school_year }}</h1>
                                    @if ($academicTerm->semester == '1')
                                        <h1><span class="text-bold">Semester:</span> 1st</h1>
                                    @elseif($academicTerm->semester == '2')
                                        <h1><span class="text-bold">Semester:</span> 2nd</h1>
                                    @endif
                                    
                                </div>
                                
                                
                            </div>
                            <!-- /.card-header -->
                            @if (Auth::user()->current_subjects_status == 2 && $academicTerm->grade_status == "Activated")
                                <form id="addGradesForm" method="POST">
                            @else
                                <form id="addSubjectsForm" method="POST">
                            @endif
                            
                            <div class="card-body overflow-auto">
                                <table id="studentsTable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Code</th>
                                            <th>Description</th>
                                            <th>Units</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="subjects_tbody">
                                        {{-- Table Content --}}
                                        @php
                                         $counter = 0;
                                         $subj_ids = explode(',', Auth::user()->current_subjects);
                                         
                                        @endphp

                                        @if (Auth::user()->current_subjects_status == 3)
                                            <tr class="text-center">
                                                <td colspan="10">Your subject grades have been locked and moved to the subjects taken tab.</td>
                                            </tr>
                                        @else
                                            @foreach ($subjects as $subject)
                                                @php
                                                $counter++;
                                                $totalUnits = (int)$subject->lec_units + (int)$subject->lab_units;
                                                    $checked = "";
                                                @endphp
                                                @foreach ($subj_ids as $subj_id)
                                                    @if ($subj_id == $subject->id)
                                                        @php
                                                            $checked = "checked";
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                @if (Auth::user()->current_subjects_status == 1)
                                                    @if ($checked == "checked")
                                                        <tr>
                                                            <td>{{$counter}}</td>
                                                            <td>{{ $subject->subject_code }}</td>
                                                            <td>{{ $subject->description }}</td>
                                                            <td>Lec: {{$subject->lec_units}} Lab: {{$subject->lab_units}}<br>Total: {{$totalUnits}}</td>
                                                            <td>
                                                                <span class="text-warning">PENDING</span>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @elseif (Auth::user()->current_subjects_status == 2 && $academicTerm->grade_status == "Deactivated")
                                                    @if ($checked == "checked")
                                                        <tr>
                                                            <td>{{$counter}}</td>
                                                            <td>{{ $subject->subject_code }}</td>
                                                            <td>{{ $subject->description }}</td>
                                                            <td>Lec: {{$subject->lec_units}} Lab: {{$subject->lab_units}}<br>Total: {{$totalUnits}}</td>
                                                            <td>
                                                                <span class="text-success">APPROVED</span>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @elseif (Auth::user()->current_subjects_status == 2 && $academicTerm->grade_status == "Activated")
                                                    @if ($checked == "checked")
                                                        <tr>
                                                            <td>{{$counter}}</td>
                                                            <td>{{ $subject->subject_code }}</td>
                                                            <td>{{ $subject->description }}</td>
                                                            <td>Lec: {{$subject->lec_units}} Lab: {{$subject->lab_units}}<br>Total: {{$totalUnits}}</td>
                                                            <td>
                                                                @php
                                                                    $myGrade = '';
                                                                @endphp
                                                                @foreach ($grades as $grade)
                                                                    @if($grade->subject_id == $subject->id)
                                                                        @php
                                                                            $myGrade = $grade->grade;
                                                                        @endphp
                                                                    @endif
                                                                @endforeach
                                                                <input type="hidden" name="subjectIDs[]" value="{{ $subject->id }}">
                                                                <div class="form-floating" style="width: 100px">
                                                                    <input type="number" value="{{ $myGrade }}" min="1" max="5" class="form-control grade" name="grades[]" placeholder="Grade" pattern="1\.0\1\.25\1\.75\2\.0">
                                                                    <label class="text-secondary">Grade</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @else
                                                    <tr class="tRow">
                                                        <td>{{$counter}}</td>
                                                        <td>{{ $subject->subject_code }}</td>
                                                        <td>{{ $subject->description }}</td>
                                                        <td>Lec: {{$subject->lec_units}} Lab: {{$subject->lab_units}}<br>Total: {{$totalUnits}}</td>
                                                        <td>
                                                            {{-- @if($subject->pre_requisites != '')
                                                                @php
                                                                    $preReqs = explode(',', $subject->pre_requisites);
                                                                    $bgColor = "";
                                                                    $gradee = '';
                                                                @endphp
                                                                @foreach ($allSubjects as $allSubject)
                                                                    @php
                                                                    $input = true;
                                                                    @endphp
                                                                    @foreach ($preReqs as $preReq)
                                                                        @if ($allSubject->subject_code == $preReq)
                                                                            @foreach ($grades as $grade)
                                                                                @if ($grade->subject_id == $allSubject->id)
                                                                                    @if ((int)$grade->grade > 3.0)
                                                                                        @php
                                                                                        $bgColor = "bg-danger";
                                                                                        $input = false;
                                                                                        $checked = "";
                                                                                        $gradee = $allSubject->id;
                                                                                        
                                                                                        @endphp
                                                                                        <span>Pre-requisite</span><span class="badge text-bg-danger">Test</span>
                                                                                    @else
                                                                                    <div class="custom-control custom-checkbox">
                                                                                        <label class="checkbox">
                                                                                            <input type="checkbox" checked name="subjectsSelected[]" value="{{ $subject->id }}"></label>
                                                                                    </div>
                                                                                    @endif
                                                                                    
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    @endforeach
                        
                                                                @endforeach  
                                                            @endif --}}

                                                            <div class="custom-control custom-checkbox">
                                                                <label class="checkbox">
                                                                    <input type="checkbox" checked name="subjectsSelected[]" value="{{ $subject->id }}"></label>
                                                            </div>
                                                        </td>
                                                    </tr> 
                                                @endif
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Code</th>
                                            <th>Description</th>
                                            <th>Units</th>
                                            <th>Action</th>
                                        </tr>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                @if (Auth::user()->current_subjects_status == 0)
                                    <div class="float-right">
                                        <button type="submit" value="{{Auth::user()->id}}" class="saveSubjects btn btn-sm btn-success">Save Subjects</button>
                                    </div> 
                                @elseif (Auth::user()->current_subjects_status == 2 && $academicTerm->grade_status == "Activated")
                                    <div class="float-right">
                                        <button type="button" class="lockGradesBtn btn btn-sm btn-primary">Lock Grades</button>
                                        <button type="submit" value="{{Auth::user()->id}}" class="saveGrades btn btn-sm btn-success">Save Grades</button>   
                                    </div> 
                                @endif 
                            </div>
                            </form>
                        </div>
                    </div>
                    
                </div>

                </div>
                      


              </div>
          </div>
      </div>
  </div>



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
                $('.saveSubjects').text('Save Subjects');

                Toast.fire({
                    icon: 'success',
                    title: response.message,
                })

                $(".pageContent").load(location.href + " .pageContent");
                
                $('.saveSubjects').prop('disabled', false);
            }

        });
    });

    // Save Grade
    $(document).on('click', '.saveGrades', function (e) {
        e.preventDefault();

        $('.saveGrades').text('');

        $('.saveGrades').prop('disabled', true);

        $('.saveGrades').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

        let formdata = new FormData($('#addGradesForm')[0]);

        var stud_id = $('.saveGrades').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "/student/save-grades",
            data: formdata,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (response){
                $('.saveGrades').text('Save Grades');

                if(response.status == 200){
                    Toast.fire({
                        icon: 'success',
                        title: response.message,
                    })
                }else{
                    Toast.fire({
                        icon: 'error',
                        title: response.message,
                    })

                    
                }
            

                $(".pageContent").load(location.href + " .pageContent");
                
                $('.saveGrades').prop('disabled', false);
            }

        });
    });

    // Lock Grades
    $(document).on('click', '.lockGradesBtn', function (e) {
        e.preventDefault();

        $('#lock-grades-modal').modal('show');
    });

    $(document).on('click', '#lockGrades', function (e) {
          $.ajax({
              type: "GET",
              url: "/student/lock-grades",
              contentType: false,
              processData: false,
              success: function (response){
                  Toast.fire({
                      icon: 'success',
                      title: response.message,
                  })

                  $('#lock-grades-modal').modal('hide');
                  $(".pageContent").load(location.href + " .pageContent");
              }

          });
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

                        $(".pageContent").load(location.href + " .pageContent");

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
  </script>
  
  @endsection

  
</x-app-layout>
