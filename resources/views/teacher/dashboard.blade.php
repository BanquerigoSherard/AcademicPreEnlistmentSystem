<x-app-layout>
  @section('sidebar-links')
    <li class="nav-item">
      <a href="/dashboard" class="nav-link active-link">
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
    Dashboard
  @endsection

  @section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
  @endsection

  @section('page-content')
    <div class="row">
      <div class="col-lg-3">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{ $totalTeachers }}</h3>

            <p>Teachers</p>
          </div>
          <div class="icon">
            <i class="fas fa-solid fa-users"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{ $totalStudents }}</h3>
  
              <p>Students</p>
            </div>
            <div class="icon">
              <i class="fas fa-solid fa-users"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>



    </div>


  @endsection


</x-app-layout>