<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 leading-tight">
            {{ __('Personality Trait Scores') }}
        </h2>
    </x-slot>
  
    <div class="pb-12 pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
                <div class="col-lg-6">
                    <div class="p-6 text-gray-900 bg-white overflow-hidden shadow-sm sm:rounded-lg">
      
                        <div class="pageContent">
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
                                <form id="testScoreForm" method="POST">
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
    
                                    <div class="btn-submit-wrapper mb-3">
                                        <button type="submit" class="submitScore btn btn-primary">Submit</button>
                                    </div>
                                    
    
                                    
    
                                    
    
                                </form>
                            </div>
                        </div>
    
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="p-6 text-gray-900 bg-white overflow-hidden shadow-sm sm:rounded-lg">
      
                        <div class="pageContent">
                            <div class="chart-container">
                                <input type="hidden" name="studentID" id="studentID" value="{{Auth::user()->id}}">
                                <canvas id="personalityChart"></canvas>
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

        let personalityChartInstance = null
        function initPersonalityChart() {
            var studentID = $('#studentID').val();
            $.ajax({
              type: "GET",
              url: "/personality-test-results/get-test-results/"+studentID,
              contentType: false,
              processData: false,
              success: function (response){        
                var ctx = $("#personalityChart")[0].getContext("2d");        
                if (personalityChartInstance !== null) {
                    personalityChartInstance.destroy(); // Destroy the previous chart
                }
                
                personalityChartInstance = new Chart(ctx, {
                    type: "bar",
                    data: {
                        labels: ["Openness", "Conscientiousness", "Extraversion", "Agreeableness", "Neuroticism"],
                        datasets: [{
                            label: "Score",
                            data: response.testResults,
                            backgroundColor: "rgba(54, 162, 235, 0.7)",
                            borderColor: "rgba(54, 162, 235, 1)",
                            borderWidth: 1
                        }]
                    },
                    options: {
                        indexAxis: "y", // Horizontal bar chart
                        scales: {
                            x: {
                                beginAtZero: true,
                                max: 100,
                                ticks: {
                                    stepSize: 10
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false // Hides the legend
                            }
                        }
                    }
                });

              }

          });

        }

        $(document).ready(function () {
            initPersonalityChart();
        });

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

                            initPersonalityChart();

                            $('.submitScore').prop('disabled', false);
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
    
    </script>
    
    @endsection
  
    
  </x-app-layout>
  