<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Academic Pre-Enlistment System</title>
    <script src="{{ asset('js/jsPDF.js') }}"></script>
    <script src="{{ asset('js/html2canvas.min.js') }}"></script>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

</head>

<style>
    *{
        padding: 0;
        margin: 0;
    }

    .card{
        padding: 0;
    }

    #passFailTable, 
    #passFailTable th, 
    #passFailTable td {
        border: 1px solid #999 !important;
    }

    #passFailTable {
        border-collapse: collapse;
        width: 100%;
    }

    .pdf-export {
        font-size: 12px; /* or try 10px if content is still overflowing */
        line-height: 1.4;
        max-width: 675px;
    }

    .pdf-export {
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .card-header {
        background-color: #ededed !important;
    }


</style>
<body>

    {{-- <div class="alert alert-warning text-center">If the download did not start <a href="#" onclick="Convert_HTML_To_PDF()">Click Here</a></div> --}}

    <div id="countdown-alert" class="alert alert-warning text-center">
        The download will begin in <span id="countdown-timer">5</span> seconds.
        <br>
    </div>

    <div class="container pdf-export mt-3">
        <div id="page1">
            <div class="header" style="display: flex; align-items: center; justify-content: space-around;">
                <div class="logo">
                    <img style="height: 100px; width: 100px;" src="{{ url("images/ccsLogo.png") }}" alt="School Logo">
                </div>

                <div class="header-content" style="font-family: 'Times New Roman', Times, serif; text-align: center;">
                    <div class="schoolName" style="font-size: 15pt; font-weight: bold;">Western Mindanao State University</div>
                    <div class="schoolName" style="font-size: 13pt; font-weight: bold;">College of Computing Studies</div>
                    <div class="schoolAdd">Zamboanga City</div>
                </div>

                <div class="logo">
                    <img style="height: 100px; width: 100px;" src="{{ url("images/wmsuLogo.png") }}" alt="School Logo">
                </div>
            </div>

            <h4 class="text-center">Download Reports</h4>
            <h5 id="filename" class="d-none">Reports</h5>

            <div class="cardsReport mt-2">
                <div class="row">
                    <div class="col-6">
                        <h5 id="cards" class="fw-bold">Pending Enlistment: <span class="fw-normal">{{ $pending }}</span></h5>
                    </div>

                    <div class="col-6">
                        <h5 id="cards" class="fw-bold">Total Teachers: <span class="fw-normal">{{ $totalTeachers }}</span></h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <h5 id="cards" class="fw-bold">Total Students: <span class="fw-normal">{{ $totalStudents }}</span></h5>
                    </div>

                    <div class="col-6">
                        <h5 id="cards" class="fw-bold">Total Subjects: <span class="fw-normal">{{ $totalSubjects }}</span></h5>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Student Enlistment Chart</h5>
                    </div>
                    <div class="card-body">
                        <!-- Enlistment Chart -->
                        <canvas id="enlistmentChart" style="width:400px; height:200px;"></canvas>

                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Student Distribution Per Year Level</h5>
                    </div>
                    <div class="card-body">
                        <div id="chartContainer">
                        <canvas id="yearLevelChart"></canvas>
                        </div>
                        
                    </div>
                </div>
            </div>

        </div>

        <div id="page3">
            <div class="row mt-3" style="page-break-after: always;">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Enlisted Students</h5>
                    </div>
                    <div class="card-body">
                        <!-- Enlistment Chart -->
                        <div id="chartContainerEnlistedStudents">
                        <canvas id="enlistedStudents"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Pass/Fail Table</h5>
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


        <div style="margin-top: 35px;"> 
        </div>

    </div>

    
    
</body>
</html>


<script>
    $(document).ready(function () {
        // let ctx1 = $('#enlistmentChart')[0].getContext('2d');
        let ctx1 = $('#enlistmentChart');
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
                            maintainAspectRatio: true,
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

        fetchYearLevelData("all");

        // Enlisted Students Functions
        var enlistedChart;

        function fetchEnlistedStudentsData() {
            var semester = "all";

            $.ajax({
                url: "{{ route('enlisted-students') }}",
                type: "GET",
                data: { semester: semester },
                success: function(response) {
                    updateLineChart(response.labels, response.data);
                },
                error: function(xhr) {
                    console.error("Failed to fetch chart data", xhr);
                }
            });
        }

        function updateLineChart(labels, data) {
            var ctx = document.getElementById('enlistedStudents').getContext('2d');

            if (enlistedChart) {
                enlistedChart.destroy();
            }
            
            enlistedChart = new Chart(ctx, {
                type: 'line',  // Use line chart
                data: {
                    labels: labels, // This will be the number of students on the x-axis
                    datasets: [{
                        label: 'Students',  // Label for the dataset
                        data: data,  // This will be the school years on the y-axis
                        fill: false,  // No fill for the line
                        borderColor: '#4BC0C0',  // Line color
                        tension: 0.4,  // Line curve tension
                        borderWidth: 2  // Line thickness
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'School Year'  // Label for x-axis
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Number of Students'  // Label for y-axis
                            }
                        }
                    }
                }
            });
        }

        fetchEnlistedStudentsData();

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
            paging: false,
            searching: false,
            ordering: true,
            responsive: true,
            info: false,
            language: {
                searchPlaceholder: "Search subjects...",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ subjects",
                emptyTable: "No data available"
            }
        });
    });

    function Convert_HTML_To_PDF() {
        const element = document.querySelector('.pdf-export'); // The element to convert to PDF

        // Set CSS to handle page breaks
        const style = `
            @media print {
                .pdf-export {
                    page-break-before: always;
                    page-break-after: always;
                    page-break-inside: avoid;
                }
                .pdf-export * {
                    page-break-inside: avoid;
                }

                /* Add table-specific styles */
                .pdf-export table {
                    width: 100%;
                    table-layout: fixed;
                    page-break-before: auto;
                    page-break-after: auto;
                    page-break-inside: auto;
                }

                .pdf-export table tr {
                    page-break-inside: avoid;
                    break-inside: avoid;
                }

                .pdf-export table td, .pdf-export table th {
                    page-break-inside: avoid;
                    break-inside: avoid;
                }

                /* Ensure block-level elements like paragraphs or lists break properly */
                .pdf-export p, .pdf-export ul, .pdf-export ol {
                    page-break-after: always;
                }
            }
        `;
        
        // Apply custom styles to the document
        const styleSheet = document.createElement("style");
        styleSheet.type = "text/css";
        styleSheet.innerText = style;
        document.head.appendChild(styleSheet);
        var filename = document.getElementById("filename").innerHTML;
        var date = new Date().toDateString();

        // Generate PDF with html2pdf
        html2pdf()
        .from(element)
        .set({
            margin: 10,  // Set margin in mm (can be adjusted)
            filename: filename + ' - ' + date +'.pdf'
        })
        .save();
    }

    // Countdown logic
    let countdownTime = 5; // Countdown starts from 5 seconds
    const countdownDisplay = document.getElementById("countdown-timer");

    function startCountdown() {
        const interval = setInterval(function() {
            countdownDisplay.innerText = countdownTime; // Update the countdown timer
            countdownTime--; // Decrease countdown by 1 second

            if (countdownTime < 0) {
                clearInterval(interval); // Stop the countdown when it reaches 0
                Convert_HTML_To_PDF(); // Automatically trigger the PDF download
                document.getElementById("countdown-alert").innerHTML = `
                    <span>If the download doesn't start, <a href="#" onclick="Convert_HTML_To_PDF()">Click Here</a></span>
                `;
            }
        }, 1000); // Update every second
    }

    // Wait for the page to load and start the countdown
    window.onload = function() {
        startCountdown(); // Start the countdown when the page loads
    };

</script>