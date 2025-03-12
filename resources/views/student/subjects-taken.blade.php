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
                                @php
                                    $SY = "";
                                    $SEM = "";
                                    $counter = 0;
                                @endphp
                            
                                <div class="row">
                                    @foreach ($grades->sortByDesc('id') as $grade)
                                        @php 
                                            $counter++; 
                                            $currentSY = $grade->school_year;
                                            $currentSEM = $grade->semester;
                                        @endphp
                            
                                        {{-- Check if the school year or semester has changed --}}
                                        @if ($currentSY != $SY || $currentSEM != $SEM)
                                            {{-- Close previous col-lg-6 if not the first iteration --}}
                                            @if ($counter > 1)
                                                </tbody>
                                                </table>
                                                </div> {{-- Close gradeWrapper --}}
                                                </div> {{-- Close col-lg-6 --}}
                                            @endif
                            
                                            {{-- Start a new column for new School Year and Semester --}}
                                            <div class="col-lg-6">
                                                <div class="gradeWrapper">
                                                    @if ($currentSEM == 1)
                                                        @php $sem = "1st Semester" @endphp
                                                    @else
                                                        @php $sem = "2nd Semester" @endphp
                                                    @endif
                                                    <h5>SY {{ $currentSY }} ({{ $sem }})</h5>
                                                    <table class="table table-bordered">
                                                        <thead class="table-secondary">
                                                            <tr>
                                                                <th>Code</th>
                                                                <th>Description</th>
                                                                <th>Grade</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                        @endif
                            
                                        {{-- Store the current school year and semester for the next iteration --}}
                                        @php
                                            $SY = $currentSY;
                                            $SEM = $currentSEM;
                                        @endphp
                            
                                        {{-- Display subject details --}}
                                        @foreach ($subjects as $subject)
                                            @if ($grade->subject_id == $subject->id)
                                                <tr>
                                                    <td>{{ $subject->subject_code }}</td>
                                                    <td>{{ $subject->description }}</td>
                                                    <td>{{ $grade->grade }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                            
                                    @endforeach
                            
                                    {{-- Close last col-lg-6 and table properly --}}
                                    @if ($counter > 0)
                                            </tbody>
                                        </table>
                                    </div> {{-- Close gradeWrapper --}}
                                </div> {{-- Close col-lg-6 --}}
                                    @endif
                                </div> {{-- Close row --}}
                              
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
  