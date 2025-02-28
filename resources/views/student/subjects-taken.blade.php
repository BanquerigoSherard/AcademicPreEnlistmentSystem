<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 leading-tight">
            {{ __('Subjects') }}
        </h2>
    </x-slot>
  
    <div class="pb-12 pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
  
                    <div class="pageContent">
                    
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-secondary">
                                    <div class="card-header">
                                      <h3 class="card-title">1st Year : 1st Sem</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="subjectsTable" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Code</th>
                                                    <th>Description</th>
                                                    <th>Units</th>
                                                    <th>Grade</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @php
                                                $counter = 0;
                                                @endphp
                                                @foreach ($subjects as $subject)
                                                @php
                                                $myGrade = '';
                                                $counter++;
                                                $totalUnits = (int)$subject->lec_units + (int)$subject->lab_units;
                                                @endphp
                                                @foreach ($grades as $grade)
                                                    @if ($grade->subject_id == $subject->id)
                                                        @php
                                                        $myGrade = $grade->grade;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                    <tr>
                                                        <td>{{$counter}}</td>
                                                        <td>{{ $subject->subject_code }}</td>
                                                        <td>{{ $subject->description }}</td>
                                                        <td>Lec: {{$subject->lec_units}} Lab: {{$subject->lab_units}}<br>Total: {{$totalUnits}}</td>
                                                        <td>
                                                            {{ $myGrade }}
                                                        </td>
                                                    </tr> 
                                                @endforeach
                                            </tbody>

                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Code</th>
                                                    <th>Description</th>
                                                    <th>Units</th>
                                                    <th>Grade</th>
                                                </tr>
                                                </tr>
                                            </tfoot>
          
                                    </div>
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
  
    </script>
    
    @endsection
  
    
  </x-app-layout>
  