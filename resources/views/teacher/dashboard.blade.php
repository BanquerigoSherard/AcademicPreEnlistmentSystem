<x-app-layout>
  @section('sidebar-links')
    <li class="nav-item">
      <a href="/dashboard" class="nav-link active-link">
          <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
      </a>
    </li>

    {{-- Subjects --}}
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-book"></i>
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
    </li>

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
        <a href="/academicterm" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
          <p>Academic Term</p>
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
      {{-- Academic Term --}}
      <div class="row mb-3">
        <div class="col-lg-12">
          <div class="curr_academic_term">
            <div class="row text-center">
              <div class="col-lg-6 text-lg-end">
                <h4>Current S.Y. <span class="text-bold">{{ $academicTerm->school_year }}</span></h4>
              </div>
              <div class="col-lg-6 text-lg-start">
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
      {{-- Statistics Cards --}}
      <div class="col-lg-3">
        <div class="small-box bg-warning">
          <div class="inner">
            {{-- <h3>{{ $pendingEnrollments }}</h3> --}}
            <h3>3</h3>
            <p>Pending Enrollments</p>
          </div>
          <div class="icon">
            <i class="fas fa-hourglass-half"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{ $totalTeachers }}</h3>
            <p>Teachers</p>
          </div>
          <div class="icon">
            <i class="fas fa-users"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="small-box bg-secondary">
          <div class="inner">
            <h3>{{ $totalStudents }}</h3>
            <p>Students</p>
          </div>
          <div class="icon">
            <i class="fas fa-users"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="small-box bg-primary">
          <div class="inner">
            {{-- <h3>{{ $totalSubjects }}</h3> --}}
            <h3>T12</h3>
            <p>Subjects</p>
          </div>
          <div class="icon">
            <i class="fas fa-book"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

    </div>

    {{-- Charts Section --}}
    <div class="row mt-4">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Student Enlistment Chart</h3>
          </div>
          <div class="card-body">
            <canvas id="enlistmentChart"></canvas>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pass/Fail Table</h3>
            </div>
            <div class="card-body">
                <table id="passFailTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Passed</th>
                            <th>Failed</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody></tbody> <!-- Data will be filled dynamically -->
                </table>
            </div>
        </div>
    </div>
    
      
    </div>

    <div class="row mt-4">
      {{-- Number of students per year level --}}
      <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Student Distribution Per Year Level</h5>
            </div>
            <div class="card-body">
                <canvas id="yearLevelChart"></canvas>
            </div>
        </div>
      </div>
  

      {{-- Quick Actions --}}
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Quick Actions</h3>
          </div>
          <div class="card-body">
            <a href="/enlistment" class="btn btn-primary">Manage Enlistment</a>
            <a href="/students" class="btn btn-secondary">View Students</a>
            <a href="/subjects" class="btn btn-info">Manage Subjects</a>
          </div>
        </div>
      </div>
    </div>

  @endsection

  @section('scripts')
    <script>
      $(document).ready(function () {
        // Enlistment Chart
        let ctx1 = $('#enlistmentChart')[0].getContext('2d');
        new Chart(ctx1, {
          type: 'bar',
          data: {
            labels: ['Enlisted', 'Not Enlisted'],
            datasets: [{
              label: 'Students',
              data: [{{$studentsEnlisted}}, {{$studentsNotEnlisted}}],
              backgroundColor: ['#28a745', '#dc3545'],
              borderColor: ['#218838', '#c82333'],
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            scales: {
              y: { beginAtZero: true }
            }
          }
        });

        // Pass/Fail Table
        $('#passFailTable').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: '/pass-fail-data',
                type: 'GET',
                dataSrc: ""
            },
            columns: [
                { data: 'subject_code', title: 'Code' },
                { data: 'passed', title: 'Passed' },
                { data: 'failed', title: 'Failed' },
                { data: 'total', title: 'Total' }
            ],
            paging: true,
            searching: true,
            ordering: true,
            lengthMenu: [3, 10, 25, 50],
            responsive: true,
            language: {
                searchPlaceholder: "Search subjects...",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ subjects"
            }
        });




        // Number of students per year level
        var ctx = document.getElementById("yearLevelChart");
        if (!ctx) {
            console.error("yearLevelChart not found in the DOM.");
            return;
        }

        // Sample dummy data for testing
        var yearLevelCounts = {!! json_encode($yearLevelCounts) !!};

        var yearLevelChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['First Year', 'Second Year', 'Third Year', 'Fourth Year'],
                datasets: [{
                    data: yearLevelCounts,
                    backgroundColor: ['#4CAF50', '#FF9800', '#2196F3', '#F44336'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                aspectRatio: 1.0,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
      });

      

    </script>
  @endsection

</x-app-layout>