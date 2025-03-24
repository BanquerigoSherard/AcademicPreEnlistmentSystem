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

   <div class="modal fade" id="personality-trait-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Personality Trait Score</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="testScoreForm" method="POST">
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="alert alert-warning" role="alert">
                        Please submit your "Personality Trait Scores"
                    </div>

                    <h4 class="fs-4 fw-bold">Your Personality Trait Scores</h4>
                    <p>This Big Five assessment measures your scores on five major dimensions of personality: Openness, Conscientiousness, Extraversion, Agreeableness, and Neuroticism (sometimes abbreviated OCEAN).</p>
                    
                    <a href="https://www.idrlabs.com/big-five-types/test.php" target="_blank" class="text-primary text-decoration-underline">
                        Click here to take the personality test <br>
                    </a>
                    <a href="https://www.idrlabs.com/big-five-types/test.php" target="_blank"><span class="text-primary">https://www.idrlabs.com/big-five-types/test.php</span></a>
                </div>

                <div class="row">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" required name="openness" min=1 max=100 class="form-control" id="openness" placeholder="Score">
                                <label for="openness">Openness</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" required name="conscientiousness" min=1 max=100 class="form-control" id="conscientiousness" placeholder="Score">
                                <label for="conscientiousness">Conscientiousness</label>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" required name="extraversion" min=1 max=100 class="form-control" id="extraversion" placeholder="Score">
                                <label for="extraversion">Extraversion</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" required name="agreeableness" min=1 max=100 class="form-control" id="agreeableness" placeholder="Score">
                                <label for="agreeableness">Agreeableness</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" required name="neuroticism" min=1 max=100 class="form-control" id="neuroticism " placeholder="Score">
                                <label for="neuroticism ">Neuroticism </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="submitScore" class="submitScore btn btn-primary">Submit</button>
            </div>
            </form>

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
                    <div class="col-12 d-flex justify-content-end">
                            {{-- <div class="input-group me-2" style="width: 252px;">
                                <label class="input-group-text" for="inputGroupSelect01">Year Level</label>
                                <select class="form-select" id="inputGroupSelect01">
                                    <option selected>Select Year Level</option>
                                    <option value="1">1st</option>
                                    <option value="2">2nd</option>
                                    <option value="3">2rd</option>
                                    <option value="3">4th</option>
                                </select>
                            </div> --}}
                          
                            @if (Auth::user()->current_subjects_status == 0)
                            <button type="button" id="addSubjBtn" data-toggle="modal" class="btn btn-sm btn-primary float-right">
                                <i class="nav-icon fas fa-solid fa-plus"></i>
                                <span>Add Subject</span>
                            </button>
                            @endif
                        
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
                                <form id="addGradesForm" method="POST" class="needs-validation" novalidate>
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
                                         $isNotTakenOrFailedCounter = 0;
                                        @endphp

                                        @if (Auth::user()->current_subjects_status == 3)
                                            <tr class="text-center">
                                                <td colspan="10">Your subject grades have been locked and moved to the GRADES tab.</td>
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
                                                                    <input type="text" list="grade-values" value="{{ $myGrade }}" class="form-control grade" name="grades[]" placeholder="Grade">
                                                                    <datalist id="grade-values">
                                                                        <option value="1.00">
                                                                        <option value="1.25">
                                                                        <option value="1.75">
                                                                        <option value="2.00">
                                                                        <option value="2.25">
                                                                        <option value="2.75">
                                                                        <option value="3.00">
                                                                        <option value="5.00">
                                                                        <option value="DRP">
                                                                        <option value="UW">
                                                                        <option value="AW">
                                                                        <option value="INC">
                                                                    </datalist>
                                                                    <label class="text-secondary">Grade</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @else
                                                    @php
                                                        $bgColor = '';
                                                        $pre_requisites = explode(',', $subject->pre_requisites);
                                                        $failedSubj = [];
                                                        $subjGrade = '';
                                                    @endphp
                                                    @foreach ($allSubjects as $allSubject)
                                                        @if (in_array($allSubject->subject_code, $pre_requisites))
                                                            @foreach ($grades as $grade)
                                                                @if ($allSubject->id == $grade->subject_id && $grade->student_id == Auth::user()->id && $grade->status == 1)
                                                                    @if ((int)$grade->grade > 3.0 || $grade->grade == "INC" || $grade->grade == "DRP" || $grade->grade == "AW" || $grade->grade == "UW")
                                                                        @php
                                                                        $bgColor = 'table-danger';
                                                                        array_push($failedSubj, $allSubject->subject_code);
                                                                        $subjGrade = $grade->grade;
                                                                        @endphp
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        
                                                    @endforeach
                                                    @php
                                                    $failedSubjStr = implode(',', $failedSubj);
                                                    $isAlreadyTaken = false;
    
                                                    // Check if the subject has already been taken and passed
                                                    foreach ($grades as $grade) {
                                                        if ($grade->subject_id == $subject->id && $grade->student_id == Auth::user()->id) {
                                                            if ((int)$grade->grade <= 3.0 && $grade->status == 1) {
                                                                $isAlreadyTaken = true;
                                                                break;
                                                            }
                                                        }
                                                    }

                                                    if(!$isAlreadyTaken){
                                                        $isNotTakenOrFailedCounter += 1;
                                                    }
                                                    
                                                    @endphp
                                                    {{-- <tr class="tRow {{$bgColor}}">
                                                        <td>{{$counter}}</td>
                                                        <td>{{ $subject->subject_code }}</td>
                                                        <td>
                                                            {{ $subject->description }}
                                                        </td>
                                                        <td>Lec: {{$subject->lec_units}} Lab: {{$subject->lab_units}}<br>Total: {{$totalUnits}}</td>
                                                        <td>
                                                            @if ($bgColor != '')
                                                                @if ($subjGrade == "DRP")
                                                                    You dropped <span class="badge text-bg-warning">{{$failedSubjStr}}</span>
                                                                @elseif($subjGrade == "INC")
                                                                    You are INC in <span class="badge text-bg-warning">{{$failedSubjStr}}</span>
                                                                @elseif($subjGrade == "AW" || $subjGrade == "UW")
                                                                    You withdrew from the subject <span class="badge text-bg-warning">{{$failedSubjStr}} (Grade:{{$subjGrade}})</span>
                                                                @else
                                                                    You failed <span class="badge text-bg-warning">{{$failedSubjStr}} (Grade:{{$subjGrade}})</span>
                                                                @endif
                                                            @else
                                                                <div class="custom-control custom-checkbox">
                                                                    <label class="checkbox">
                                                                    <input type="checkbox" checked name="subjectsSelected[]" value="{{ $subject->id }}"></label>
                                                                </div>
                                                            @endif
                                                            
                                                        </td>
                                                    </tr>  --}}
                                                    <tr class="tRow {{$bgColor}}">
                                                        <td>{{$counter}}</td>
                                                        <td>{{ $subject->subject_code }}</td>
                                                        <td>{{ $subject->description }}</td>
                                                        <td>Lec: {{$subject->lec_units}} Lab: {{$subject->lab_units}}<br>Total: {{$totalUnits}}</td>
                                                        <td>
                                                            @if ($isAlreadyTaken)
                                                                <span class="badge text-bg-success">Already Taken</span>
                                                            @elseif ($bgColor != '')
                                                                @if ($subjGrade == "DRP")
                                                                    You dropped <span class="badge text-bg-warning">{{$failedSubjStr}}</span>
                                                                @elseif($subjGrade == "INC")
                                                                    You are INC in <span class="badge text-bg-warning">{{$failedSubjStr}}</span>
                                                                @elseif($subjGrade == "AW" || $subjGrade == "UW")
                                                                    You withdrew from the subject <span class="badge text-bg-warning">{{$failedSubjStr}} (Grade:{{$subjGrade}})</span>
                                                                @else
                                                                    You failed <span class="badge text-bg-warning">{{$failedSubjStr}} (Grade:{{$subjGrade}})</span>
                                                                @endif
                                                            @else
                                                                <div class="custom-control custom-checkbox">
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" checked name="subjectsSelected[]" value="{{ $subject->id }}">
                                                                    </label>
                                                                </div>
                                                            @endif
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
                                @if (Auth::user()->current_subjects_status == 0 && $isNotTakenOrFailedCounter > 0)
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

        let isValid = true;
        let allowedValues = ["1", "1.0", "1.00", "1.25", "1.75", "2", "2.0", "2.00", "2.25", "2.75", "3", "3.0",  "3.00", "5", "5.0",  "5.00", "DRP", "UW", "AW", "INC"];

        $(".grade").each(function () {
            if($(this).val() != ""){
                let inputValue = $(this).val().trim();

                if(inputValue == 1){
                    $(this).val("1.00");
                }else if(inputValue == 2){
                    $(this).val("2.00");
                }else if(inputValue == 3){
                    $(this).val("3.00");
                }else if(inputValue == 5){
                    $(this).val("5.00");
                }
                if (!allowedValues.includes(inputValue)) {
                    if ($(this).closest('.form-floating').find(".invalid-feedback").length > 0) {
                        $(this).closest('.form-floating').find(".invalid-feedback").last().remove();
                    }
                    $(this).closest('.form-floating').append("<div class='invalid-feedback d-block'>Please enter a valid grade.</div>");
                    isValid = false;
                }else{
                    $(this).closest('.form-floating').find(".invalid-feedback").last().remove();
                }
            }
            
        });

        if(!isValid){
            Toast.fire({
                icon: 'warning',
                title: "Please enter a valid grade",
            })
        }

        if (isValid) {
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
        }
    });

    // Lock Grades
    $(document).ready(function () {
        let personalitySubmitted = localStorage.getItem("personalitySubmitted") === "true";

        $(document).on('click', '.lockGradesBtn', function (e) {
            e.preventDefault();

            if (!personalitySubmitted) {
                $('#personality-trait-modal').modal('show');
            } else {
                $('#lock-grades-modal').modal('show');
            }
        });

        // Handle Personality Trait Submission
        $(function () {
            $.validator.setDefaults({
                submitHandler: function () {
                    $('.submitScore').text('');

                    $('.submitScore').prop('disabled', true);

                    $('.submitScore').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...');

                    let formdata = new FormData($('#testScoreForm')[0]);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: "POST",
                        url: "/student/submit-test-score",
                        data: formdata,
                        dataType: "json",
                        contentType: false,
                        processData: false,
                        success: function (response){
                            $('.submitScore').text('Submit');

                            Toast.fire({
                                icon: 'success',
                                title: response.message,
                            })

                            $('.submitScore').prop('disabled', false);

                            personalitySubmitted = true;
                            localStorage.setItem("personalitySubmitted", "true");
                            $('#personality-trait-modal').modal('hide');

                            setTimeout(() => {
                                $('#lock-grades-modal').modal('show');
                            }, 500);
                        }

                    });
                }
            });
            $('#testScoreForm').validate({
                rules: {
                    openness: {
                        required: true,
                    },
                    conscientiousness: {
                        required: true,
                    },
                    extraversion: {
                        required: true,
                    },
                    agreeableness: {
                        required: true,
                    },
                    neuroticism: {
                        required: true,
                    },
                },
                messages: {
                    openness: {
                        required: "Please enter you score for 'Openness'",
                        min: "The minimum score is 1",
                        max: "The maximum score is 100",
                    },
                    conscientiousness: {
                        required: "Please enter you score for 'Conscientiousness'",
                        min: "The minimum score is 1",
                        max: "The maximum score is 100",
                    },
                    extraversion: {
                        required: "Please enter you score for 'Extraversion'",
                        min: "The minimum score is 1",
                        max: "The maximum score is 100",
                    },
                    agreeableness: {
                        required: "Please enter you score for 'Agreeableness'",
                        min: "The minimum score is 1",
                        max: "The maximum score is 100",
                    },
                    neuroticism: {
                        required: "Please enter you score for 'Neuroticism'",
                        min: "The minimum score is 1",
                        max: "The maximum score is 100",
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

        // Lock Grades Submission
        $(document).on('click', '#lockGrades', function (e) {
            e.preventDefault();

            $('#lockGrades').text('');

            $('#lockGrades').prop('disabled', true);

            $('#lockGrades').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Locking...');

            $.ajax({
                type: "GET",
                url: "/student/lock-grades",
                contentType: false,
                processData: false,
                success: function (response) {
                    if(response.status == 200){
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });

                        $('#lock-grades-modal').modal('hide');
                        $(".pageContent").load(location.href + " .pageContent");

                        $('#lockGrades').text('Lock Grades').prop('disabled', false);

                    }else if(response.status == 400){
                        $('#lockGrades').text('Lock Grades').prop('disabled', false);

                        Toast.fire({
                            icon: 'error',
                            title: response.message
                        });
                    }
                    
                }
            });
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
