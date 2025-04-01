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
            <a href="/teacheraccounts" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
              <p>Teacher Accounts</p>
            </a>
          </li>
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
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Subject</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <form id="addSubjectForm" method="POST">
                        <div class="modal-body">
                            <div class="row mb-2">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-9"> 
                                            <div class="prospectusSelect">
                                                <div class="form-floating prospectusSelectInner">
                                                    <select name="prospectus" required class="form-select" id="selectProspectusVersion" aria-label="Floating label select example">
                                                    <option value="" selected>Select Version</option>
                                                    @foreach ($prospectus as $pros)
                                                        <option value="{{ $pros->id }}">{{ $pros->version }}</option>
                                                    @endforeach
                                                    </select>
                                                    <label for="selectProspectusVersion">Select Prospectus Version*</label>
                                                </div>
                                            </div>
        
                                            
                                        </div>
            
                                        <div class="col-3">
                                            <button title="Add New Version" class="btn btn-primary h-100 w-100 addNewPros">Add New</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-9">
                                            <div class="coursesSelect">
                                                <div class="form-floating coursesSelectInner">
                                                    <select name="course" required class="form-select" id="selectCourse" aria-label="Floating label select example">
                                                      <option value="" selected>Select Course</option>
                                                      @foreach ($courses as $course)
                                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                                      @endforeach
                                                    </select> 
                                                    <label for="selectCourse">Select Course*</label>
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-3">
                                            <button title="Add New Course" class="btn btn-primary h-100 w-100 addNewCourse">Add New</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">
                                    <div class="form-floating">
                                        <input type="text" name="subject_code" required class="form-control" id="subject_code" placeholder="Subject Code">
                                        <label for="subject_code">Subject Code*</label>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-floating">
                                        <input type="text" name="description" required class="form-control" id="description" placeholder="Description">
                                        <label for="description">Description*</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="lec_units" required class="form-control" id="lec_units" placeholder="lec_units">
                                        <label for="lec_units">Lecture Units*</label>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="lab_units" required class="form-control" id="lab_units" placeholder="lab_units">
                                        <label for="lab_units">Lab Units*</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="multiSelect mb-2">
                                        <label>Pre-requisites</label>
                                        <select class="selectpicker form-control" name="pre_requisites[]" id="pre-requisites" data-live-search="true" title="Select Subject" data-hide-disabled="true" data-actions-box="true" multiple>
                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->subject_code }}">{{ $subject->subject_code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-3 ms-2">
                                        <div class="col-12">
                                            <label class="form-label">Is this a core subject?</label>
                                            <div class="form-check form-switch ms-3">
                                                <input class="form-check-input" type="checkbox" id="is_core_subject" name="is_core_subject" value="1">
                                                <label class="form-check-label" for="is_core_subject">Yes, this is a core subject</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating">
                                        <select name="year_lvl" required class="form-select" id="year_lvl" aria-label="Floating label select example">
                                          <option value="" selected>Select year level</option>
                                          <option value="1">1st</option>
                                          <option value="2">2nd</option>
                                          <option value="3">3rd</option>
                                          <option value="4">4th</option>
                                        </select>
                                        <label for="year_lvl">Select year level*</label>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-floating">
                                        <select name="semester" required class="form-select" id="semester" aria-label="Floating label select example">
                                          <option value="" selected>Select semester</option>
                                          <option value="1">1st</option>
                                          <option value="2">2nd</option>
                                          <option value="3">Summer</option>
                                        </select>
                                        <label for="semester">Select semester*</label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
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
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="multiSelect mb-2">
                                        <label>Pre-requisites</label>
                                        <select class="selectpicker form-control" name="pre_requisites[]" id="pre_requisites_edit" data-live-search="true" title="Select Subject" data-hide-disabled="true" data-actions-box="true" multiple>
                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->subject_code }}">{{ $subject->subject_code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="row mb-3 ms-2">
                                        <div class="col-12">
                                            <label class="form-label">Is this a core subject?</label>
                                            <div class="form-check form-switch ms-3">
                                                <input class="form-check-input" type="checkbox" id="is_core_subject_edit" name="is_core_subject" value="1">
                                                <label class="form-check-label" for="is_core_subject_edit">Yes, this is a core subject</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                  <option value="3">Summer</option>
                                </select>
                                <label for="semesterEdit">Select semester</label>
                            </div>
                            
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary updateSubject">Save Changes</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        {{-- Delete Subject Modal --}}
        <div class="modal fade" id="delete-subject">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Subject</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body text-center">
                        <input type="hidden" name="subject_id_delete" id="subject_id_delete">
                        <h2>Are you sure?</h2>
                        <p>You are about to delete this subject. This action cannot be undone.</p>

                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="deleteSubject" class="btn btn-danger">Delete</button>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        {{-- Import Subject Modal --}}
        <div class="modal fade importSubjects" id="import-subjects-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Import Subjects</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
 
                            <div class="row mb-2">
                                <div class="col-9"> 
                                    <div class="prospectusSelect">
                                        <div class="form-floating prospectusSelectInnerImport import-inputs">
                                            <select name="prospectus" required class="form-select" id="selectProspectusVersionImport" aria-label="Floating label select example">
                                              <option value="" selected>Select Version</option>
                                              @foreach ($prospectus as $pros)
                                                <option value="{{ $pros->id }}">{{ $pros->version }}</option>
                                              @endforeach
                                            </select>
                                            <label for="selectProspectusVersionImport">Select Prospectus Version*</label>
                                        </div>
                                    </div>
                            
                                </div>
    
                                <div class="col-3">
                                    <button title="Add New Version" class="btn btn-primary h-100 w-100 addNewPros">Add New</button>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-9">
                                    <div class="coursesSelect">
                                        <div class="form-floating coursesSelectInnerImport import-inputs">
                                            <select name="course" required class="form-select" id="selectCourseImport" aria-label="Floating label select example">
                                            <option value="" selected>Select Course</option>
                                            @foreach ($courses as $course)
                                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                                            @endforeach
                                            </select> 
                                            <label for="selectCourseImport">Select Course*</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-3">
                                    <button title="Add New Course" class="btn btn-primary h-100 w-100 addNewCourse">Add New</button>
                                </div>
                            </div>

                            <div class="input-group import-inputs mb-3">
                                <input type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" class="form-control" name="importFile" id="importFile">
                                <label class="input-group-text" for="importFile">Import File</label>
                            </div>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="import" class="btn btn-success">Import</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        {{-- Prospectus Ver Modal --}}
        <div class="modal fade" id="prospectus-version-modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Prospectus</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <form id="addProsForm" method="POST">
                                    <input type="hidden" name="pros_id" id="pros_id" value="0">
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <div class="form-floating">
                                                <input type="text" name="pros_version" required class="form-control" id="pros_version" placeholder="Subject Code">
                                                <label for="pros_version">Version*</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-5">
                                            <div class="form-floating">
                                                <input type="text" name="effectivity" required class="form-control" id="effectivity" placeholder="Subject Code">
                                                <label for="effectivity">Effectivity*</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <button type="submit" id="savePros" class="btn btn-primary h-100 w-100">Save</button>
                                        </div>
                                    </div>
                                    
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Prospectus Versions</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="prosTable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Version</th>
                                            <th>Effectivity</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="pros_tbody">
                                        {{-- Table Content --}}
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Version</th>
                                            <th>Effectivity</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
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

        {{-- Delete Prospectus Modal --}}
        <div class="modal fade" id="delete-prospectus-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Prospectus</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body text-center">
                        <h2>Are you sure?</h2>
                        <p>You are about to delete this version. This action cannot be undone.</p>

                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="deleteProspectus" class="btn btn-danger">Delete</button>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        {{-- Courses Modal --}}
        <div class="modal fade" id="courses-modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Courses</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <form id="addCourseForm" method="POST">
                                    <input type="hidden" name="course_save_id" id="course_save_id" value="0">
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <div class="form-floating">
                                                <input type="text" name="course_name" required class="form-control" id="course_name" placeholder="Select Course">
                                                <label for="course_name">Name*</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-5">
                                            <div class="form-floating">
                                                <input type="text" name="course_abbr" required class="form-control" id="course_abbr" placeholder="Select Course">
                                                <label for="course_abbr">Abbreviation*</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <button type="submit" id="saveCourse" class="btn btn-primary h-100 w-100">Save</button>
                                        </div>
                                    </div>
                                    
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Courses</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="coursesTable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Abbreviation</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="courses_tbody">
                                        {{-- Table Content --}}
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Abbreviation</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
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

        {{-- Delete Course Modal --}}
        <div class="modal fade" id="delete-course-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Course</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body text-center">
                        <h2>Are you sure?</h2>
                        <p>You are about to delete this course. This action cannot be undone.</p>

                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="deleteCourse" class="btn btn-danger">Delete</button>
                    </div>

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

                        <button type="button" class="btn btn-sm btn-primary float-right addSubjBtn">
                            <i class="nav-icon fas fa-solid fa-plus"></i>
                            <span>Add New</span>
                        </button>

                        <button type="button" data-target="#import-subjects" class="importSubjBtn btn btn-sm btn-success float-right me-2" data-toggle="modal">
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

    $(document).on('click', '.addSubjBtn', function (e) {
        $('#add-new-subject').modal('show');
    });

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

                        fetchSubjects();

                        $('#add-new-subject').modal('hide');

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
                    var selectedSem3 = '';

                    if(response.subject.semester == 1){
                        selectedSem1 = 'selected';
                    }else if(response.subject.semester == 2){
                        selectedSem2 = 'selected';
                    }else if(response.subject.semester == 3){
                        selectedSem3 = 'selected';
                    }

                    $('#semesterEdit').append('<option '+selectedSem1+' value="1">1st</option>\
                                            <option '+selectedSem2+' value="2">2nd</option>\
                                            <option '+selectedSem3+' value="3">Summer</option>');


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

                    if (response.subject.is_core_subject == 1) {
                        $('#is_core_subject_edit').prop('checked', true);
                    } else {
                        $('#is_core_subject_edit').prop('checked', false);
                    }
                    

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

    $(document).on('click', '.importSubjBtn', function (e) {
        $('#import-subjects-modal').modal('show');
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
                        $('#selectProspectusVersionImport').val('');
                        $('#selectCourseImport').val('');
                        $('#importFile').val('');
                        $('#import').text('Save');
                        


                        fetchSubjects();

                        Toast.fire({
                            icon: 'success',
                            title: response.message,
                        })

                        $('#import').prop('disabled', false);
                        $('#import-subjects-modal').modal('hide');
                    }

                });
            }
        });
        $('#importSubjectForm').validate({
            rules: {
                prospectus: {
                    required: true,
                },
                course: {
                    required: true,
                },
                importFile: {
                    required: true,
                },
            },
            messages: {
                prospectus: {
                    required: "Please select prospectus version",
                },
                course: {
                    required: "Please select course",
                },
                importFile: {
                    required: "Please choose an excel file",
                    accept: "Please choose a valid excel file"
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.import-inputs').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });

    // CRUD Functions for Prospectus
    function fetchPros(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "GET",
            url: "/subjects/fetch-prospectus",
            dataType: "json",
            success: function (response){
                $('#pros_tbody').html('');

                if(response.status == 200){
                    
                    var counter = 0;
                    $.each(response.prospectus, function(key, pros){
                        counter += 1;
                        $('#pros_tbody').append('<tr>\
                                <td>'+counter+'</td>\
                                <td data-version="'+pros.version+'">'+pros.version+'</td>\
                                <td data-effectivity="'+pros.effectivity+'">'+pros.effectivity+'</td>\
                                <td data-id="'+pros.id+'">\
                                    <Button type="button" value="'+pros.id+'" class="deleteProsBtn btn btn-sm btn-danger">\
                                        <i class="fas fa-trash"></i>\
                                    </Button>\
                                </td>\
                            </tr>')
                    });
                    

                    if(response.prospectus.length == 0){
                        $('#pros_tbody').append('<tr>\
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
                        if ( $.fn.dataTable.isDataTable( '#prosTable' ) ) {
                            table = $('#prosTable').DataTable();
                        }
                        else {
                            $("#prosTable").DataTable({
                                "responsive": true, "lengthChange": false, "autoWidth": false,
                                "buttons": ["csv","pdf", "print"]
                                }).buttons().container().appendTo('#prosTable_wrapper .col-md-6:eq(0)');

                            }
                        }

                        
                        
                    }

                }

                

        });

    }

    $(document).on('click', '.addNewPros', function (e) {
        e.preventDefault();
        $('#pros_id').val("0");
        fetchPros();
        $('#prospectus-version-modal').modal('show');
    });

    $(function () {
        $.validator.setDefaults({
            submitHandler: function () {
                $('#savePros').text('');

                $('#savePros').prop('disabled', true);

                $('#savePros').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

                let formdata = new FormData($('#addProsForm')[0]);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "/subjects/save-pros",
                    data: formdata,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function (response){
                        $('#pros_version').val('');
                        $('#effectivity').val('');
                        $('#savePros').text('Save');

                        fetchPros();

                        Toast.fire({
                            icon: 'success',
                            title: response.message,
                        })

                        $(".prospectusSelect").load(location.href + " .prospectusSelectInner");
                        $(".prospectusSelect").load(location.href + " .prospectusSelectInnerImport");


                        $('#savePros').prop('disabled', false);
                    }

                });
            }
        });
        $('#addProsForm').validate({
            rules: {
                pros_version: {
                    required: true,
                },
                effectivity: {
                    required: true,
                },
            },
            messages: {
                pros_version: {
                    required: "Please input prospectus version",
                },
                effectivity: {
                    required: "Please input effectivity",
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

    $(document).on('click', '#prosTable tbody tr', function (e) {
        e.preventDefault();

        var data = { version: '', effectivity: '', id: '' };
        
        $(this).children('td').each(function() {
            var id = $(this).data('id');
            if (id) {
                data.id = id;
            } 

            var version = $(this).data('version');
            if (version) {
                data.version = version;
            }
            
            var effectivity = $(this).data('effectivity');
            if (effectivity) {
                data.effectivity = effectivity;
            }      
        });
        
        $('#pros_id').val(data.id);
        $('#pros_version').val(data.version);
        $('#effectivity').val(data.effectivity);

    });

    $(document).on('click', '.deleteProsBtn', function (e) {
        e.preventDefault();
        $('#deleteProspectus').val($(this).val());
        $('#delete-prospectus-modal').modal('show');
    });

    $(document).on('click', '#deleteProspectus', function (e) {
        e.preventDefault();

        $('#deleteProspectus').text('');

        $('#deleteProspectus').prop('disabled', true);

        $('#deleteProspectus').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...');


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var prosID = $(this).val();

        $.ajax({
            type: "GET",
            url: "/subjects/delete-prospectus/"+prosID,
            success: function (response){
                if(response.status == 200){
                    Toast.fire({
                        icon: 'success',
                        title: response.message,
                    })

                    $('#deleteProspectus').text('Delete');

                    $('#deleteProspectus').prop('disabled', false);
                    $('#delete-prospectus-modal').modal('hide');

                    $('#pros_id').val("0");
                    $('#pros_version').val("");
                    $('#effectivity').val("");

                    $(".prospectusSelect").load(location.href + " .prospectusSelect");
                    $(".prospectusSelect").load(location.href + " .prospectusSelectInnerImport");

                    fetchPros();
                }
            }
        });

    });

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

                        $(".coursesSelect").load(location.href + " .coursesSelectInner");
                        $(".coursesSelect").load(location.href + " .coursesSelectInnerImport");

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

                    $(".coursesSelect").load(location.href + " .coursesSelectInner");
                    $(".coursesSelect").load(location.href + " .coursesSelectInnerImport");

                    fetchCourses();
                }
            }
        });

    });

</script>
@endsection
  
  
  </x-app-layout>