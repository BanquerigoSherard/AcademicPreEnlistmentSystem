<x-app-layout>
  @section('sidebar-links')
    <li class="nav-item">
      <a href="/dashboard" class="nav-link active-link">
          <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
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
    </li> --}}

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
        <a href="/teachers" class="nav-link">
          <i class="nav-icon fas fa-users"></i>
          <p>Teacher Accounts</p>
        </a>
      </li>
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

    <div class="row my-4">
      <div class="col-lg-12">
        <Button id="downloadAllReports" class="editTeacherBtn btn btn-sm btn-primary">
          <span>Download All Reports</span>
          <i class="fas fa-download"></i>
      </Button>
      </div>
    </div>

    
    <div class="row">
      {{-- Statistics Cards --}}
      <div class="col-lg-3">
        <div class="small-box bg-warning">
          <div class="inner">
            {{-- <h3>{{ $pendingEnrollments }}</h3> --}}
            <h3>{{ $pending }}</h3>
            <p>Pending Enlistment</p>
          </div>
          <div class="icon">
            <i class="fas fa-hourglass-half"></i>
          </div>
          <a href="/enlistment" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
          <a href="/students" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="small-box bg-primary">
          <div class="inner">
            {{-- <h3>{{ $totalSubjects }}</h3> --}}
            <h3>{{$totalSubjects}}</h3>
            <p>Subjects</p>
          </div>
          <div class="icon">
            <i class="fas fa-book"></i>
          </div>
          <a href="/subjects" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
            <!-- Filters for Year Level & Course -->
            <div style="display: flex; gap: 15px; margin-bottom: 20px;">
              <div>
                  <label for="yearLevelFilter">Filter by Year Level:</label>
                  <select id="yearLevelFilter" class="form-select" style="width: 200px;">
                      <option value="all">All Year Levels</option>
                      <option value="1">1st Year</option>
                      <option value="2">2nd Year</option>
                      <option value="3">3rd Year</option>
                      <option value="4">4th Year</option>
                  </select>
              </div>

              <div>
                  <label for="courseFilter">Filter by Course:</label>
                  <select id="courseFilter" class="form-select" style="width: 250px;">
                      <option value="all">All Courses</option>
                      @foreach($courses as $course)
                          <option value="{{ $course->id }}">{{ $course->abbreviation }}</option>
                      @endforeach
                  </select>
              </div>
            </div>

            <!-- Enlistment Chart -->
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
              <div>
                  <label for="courseFilterInPie">Filter by Course:</label>
                  <select id="courseFilterInPie" class="form-select" style="width: 250px;">
                      <option value="all">All Courses</option>
                      @foreach($courses as $course)
                          <option value="{{ $course->id }}">{{ $course->abbreviation }}</option>
                      @endforeach
                  </select>
              </div>
              <div id="chartContainer">
                <canvas id="yearLevelChart"></canvas>
              </div>
              
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
        let ctx1 = $('#enlistmentChart')[0].getContext('2d');
        let enlistmentChart;

        // Function to fetch and update chart based on filters
        function updateChart(yearLevel, course) {
            $.ajax({
                url: "{{ route('fetchEnlistmentData') }}",
                type: "GET",
                data: { year_level: yearLevel, course_id: course },
                success: function (response) {
                    let enlisted = response.studentsEnlisted;
                    let notEnlisted = response.studentsNotEnlisted;

                    // Destroy previous chart if it exists
                    if (enlistmentChart) {
                        enlistmentChart.destroy();
                    }

                    // Create new chart with updated data
                    enlistmentChart = new Chart(ctx1, {
                        type: 'bar',
                        data: {
                            labels: ['Enlisted', 'Not Enlisted'],
                            datasets: [{
                                label: 'Students',
                                data: [enlisted, notEnlisted],
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
                },
                error: function (error) {
                    console.log("Error fetching data:", error);
                }
            });
        }

        // Initial load (Show all year levels and all courses)
        updateChart("all", "all");

        // Event listener for filters
        $('#yearLevelFilter, #courseFilter').on('change', function () {
            let selectedYear = $('#yearLevelFilter').val();
            let selectedCourse = $('#courseFilter').val();
            updateChart(selectedYear, selectedCourse);
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
        
        var ctx = $("#yearLevelChart")[0].getContext("2d");

        if (!ctx) {
            console.error("yearLevelChart not found in the DOM.");
            return;
        }

        var yearLevelChart = null;
        var isFetching = false;
        function fetchYearLevelData(courseId) {
            if (isFetching) return;
            isFetching = true;

            $.ajax({
                url: "/fetch-year-level-data",
                method: "GET",
                data: { course_id: courseId },
                dataType: "json",
                success: function (response) {

                    // Prevent infinite loops due to invalid data
                    if (!response.yearLevelCounts || response.yearLevelCounts.length === 0) {
                        console.error("No data for chart!");
                        isFetching = false;
                        return;
                    }

                    // Destroy existing chart properly before creating a new one
                    if (yearLevelChart) {
                        yearLevelChart.destroy();
                        $("#yearLevelChart").remove(); // Remove old canvas
                        $("#chartContainer").append('<canvas id="yearLevelChart"></canvas>'); // Re-add canvas
                        ctx = $("#yearLevelChart")[0].getContext("2d");
                    }

                    // Create new chart
                    yearLevelChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: ['First Year', 'Second Year', 'Third Year', 'Fourth Year'],
                            datasets: [{
                                data: response.yearLevelCounts,
                                backgroundColor: ['#4CAF50', '#FF9800', '#2196F3', '#F44336'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { position: 'top' }
                            }
                        }
                    });

                    isFetching = false; // Allow next request
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching year level data:", error);
                    isFetching = false; // Prevent getting stuck in a loop
                }
            });
        }

        // Listen for changes in the course filter dropdown
        $("#courseFilterInPie").off("change").on("change", function () {
            fetchYearLevelData($(this).val());
        });

        // Initial Load with "all" courses
        fetchYearLevelData("all");
      });

      // Download Functions

      $(document).ready(function () {
      // Function to download the full dashboard as PDF
      $('#downloadAllReports').click(function () {
        // Create a new jsPDF instance
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
 
        // Add a title
        doc.setFontSize(18);
        doc.text('Dashboard Reports', 10, 10);
        doc.setFontSize(12);
        doc.text('Generated on: ' + new Date().toLocaleString(), 10, 20);

        // Add Current School Year and Semester
        doc.text('Current S.Y. ' + '{{ $academicTerm->school_year }}', 10, 30);
        doc.text('Semester: ' + '{{ $academicTerm->semester }}', 10, 40);

        // Add Pending Enlistment Statistics
        doc.text('Pending Enlistment: ' + '{{ $pending }}', 10, 50);

        // Adding the charts: Convert canvas to image and add it to PDF
        const enlistmentChartCanvas = document.getElementById('enlistmentChart');
        if (enlistmentChartCanvas) {
          const chartImage = enlistmentChartCanvas.toDataURL('image/png');
          doc.addPage();
          doc.text('Student Enlistment Chart', 10, 10);
          doc.addImage(chartImage, 'PNG', 10, 20, 180, 100);
        }

        const yearLevelChartCanvas = document.getElementById('yearLevelChart');
        if (yearLevelChartCanvas) {
          const yearLevelChartImage = yearLevelChartCanvas.toDataURL('image/png');
          doc.addPage();
          doc.text('Student Distribution Per Year Level', 10, 10);
          doc.addImage(yearLevelChartImage, 'PNG', 10, 20, 180, 100);
        }

        // Add Pass/Fail Table using html2pdf (convert table to PDF)
        const passFailTable = document.getElementById('passFailTable');
        if (passFailTable) {
          doc.addPage();
          doc.text('Pass/Fail Data', 10, 10);
          
          // Now convert the table to PDF using html2pdf
          html2pdf()
            .from(passFailTable)        // Convert the table to PDF
            .toPdf()
            .get('pdf')
            .then(function (pdf) {
              // Save the generated PDF
              pdf.save('dashboard-reports.pdf');
            });
        } else {
          // If no pass/fail table is found, we can still save the rest
          doc.save('dashboard-reports.pdf');
        }

        
      });
    });
      

    </script>
  @endsection

</x-app-layout>