<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reports</title>
    <script src="{{ asset('js/jsPDF.js') }}"></script>
    <script src="{{ asset('js/html2canvas.min.js') }}"></script>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

</head>

<style>
    .tick {
    font-size: 18px;
    color: #499354;
    }
    .clear {
        font-size: 18px;
        color: #D22C16;
    }
    .boxer {
    display: table;
    border-collapse: collapse;
    width: 100%;
    }
    .boxer .box-row {
    display: table-row;
    }
    .boxer .box-row:first-child {
    font-weight:bold;
    }
    .boxer .box {
    display: table-cell;
    vertical-align: top;
    border: 1px solid black;
    padding: 5px;
    }
    .boxer .ebay {
    padding:5px 1.5em;
    }
    .boxer .google {
    padding:5px 1.5em;
    }
    .boxer .amazon {
    padding:5px 1.5em;
    }
    .center {
    text-align:center;
    }
    .right {
    float:right;
    }
    .hide {
        border: 0!important;
        background: none;
    }
</style>
<body>

    <div class="alert alert-warning text-center">If the download did not start <a href="#" onclick="Convert_HTML_To_PDF()">Click Here</a></div>


    <div class="container">
        <div class="header"  style="display: flex; align-items: center; justify-content: space-around;">
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

        <div class="content-report">

            <h4 class="text-center">Download Reports</h4>
            <h5 id="cards" class="fw-bold">Pending Enlistment: <span class="fw-normal">40</span></h5>
            <h5 id="cards" class="fw-bold">Total Teachers: <span class="fw-normal">40</span></h5>
            <h5 id="cards" class="fw-bold">Total Students: <span class="fw-normal">40</span></h5>
            <h5 id="cards" class="fw-bold">Total Subjects: <span class="fw-normal">40</span></h5>

            <div style="margin-top: 35px;">

                
            </div>
        </div>
    </div>

    
    
</body>
</html>


<script>
    // window.jsPDF = window.jspdf.jsPDF;
    // var doc = new jsPDF();
        
    // // Source HTMLElement or a string containing HTML.
    // var elementHTML = document.querySelector(".container");
    // var filename = document.getElementById("filename").innerHTML;
    // var date = new Date().toDateString();
    // doc.html(elementHTML, {
    //     callback: function(doc) {
    //         // Save the PDF
    //         doc.save(filename + ' - ' + date +'.pdf');
    //     },
    //     margin: [10, 10, 10, 10],
    //     autoPaging: 'text',
    //     x: 0,
    //     y: 0,
    //     width: 190, //target width in the PDF document
    //     windowWidth: 675, //window width in CSS pixels
    // });

    // Convert HTML content to PDF
    function Convert_HTML_To_PDF() {
        var doc = new jsPDF();
        
        // Source HTMLElement or a string containing HTML.
        var elementHTML = document.querySelector(".container");
        var filename = document.getElementById("filename").innerHTML;
        var date = new Date().toDateString();       
        doc.html(elementHTML, {
            callback: function(doc) {
                // Save the PDF
                doc.save(filename + ' - ' + date +'.pdf');
            },
            margin: [10, 10, 10, 10],
            autoPaging: 'text',
            x: 0,
            y: 0,
            width: 190, //target width in the PDF document
            windowWidth: 675 //window width in CSS pixels
        });
    }
</script>