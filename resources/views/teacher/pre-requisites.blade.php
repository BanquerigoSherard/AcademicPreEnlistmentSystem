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
            <a href="/subjects" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Manage Subjects
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/test" class="nav-link active-link">
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
      Pre-requisites
    @endsection
  
    @section('breadcrumb')
    <li class="breadcrumb-item"><a class="text-success" href="/subjects">Subjects</a></li>
      <li class="breadcrumb-item active">Pre-requisites</li>
    @endsection

    @section('styles')
      
    <link rel="stylesheet" type="text/css" href="{{ asset('css/tree/tree.css') }}">
    <link href="{{ asset('css/tree/treeBootstrap.css') }}" rel="stylesheet">
    <script src="{{ asset('css/tree/treeBootstrapJS.css') }}"></script>
    <script src="{{ asset('css/tree/treeBootstrapJ.css') }}"></script>

    @endsection
  
    @section('page-content')
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-header">
                <h3 class="card-title">Subjects</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body overflow-auto">
              <div class="container-tree" style="width: max-content">
                <div class="row-tree">
                  <div class="tree">
                      <ul>
                          <li>
                              <a href="#">Parent</a>
                              <ul>
                                  <li>
                                      <a href="#">Child</a>
                                      <ul>
                                          <li>
                                              <a href="#">Grand Child</a>
                                          </li>

                                          <li>
                                            <a href="#">Grand Child</a>
                                          </li>
                                      </ul>
                                  </li>
                                  <li>
                                      <a href="#">Child</a>
                                      <ul>
                                          <li><a href="#">Grand Child</a></li>
                                          <li>
                                              <a href="#">Grand Child</a>
                                              <ul>
                                                  <li>
                                                      <a href="#">Great Grand Child</a>
                                                       <ul>
                                                        <li>
                                                          <a href="#">Great Grand Child</a>
                                                          
                                                        </li>
                                                       </ul>
                                                  </li>
                                                  <li>
                                                      <a href="#">Great Grand Child</a>
                                                  </li>
                                                  <li>
                                                      <a href="#">Great Grand Child</a>
                                                  </li>
                                                  <li>
                                                      <a href="#">Great Grand Child</a>
                                                  </li>
                                                  <li>
                                                      <a href="#">Great Grand Child</a>
                                                  </li>
                                                  <li>
                                                      <a href="#">Great Grand Child</a>
                                                  </li>
                                                  <li>
                                                    <a href="#">Child</a>
                                                    <ul>
                                                      <li>
                                                          <a href="#">Grand Child</a>
                                                      </li>
            
                                                      <li>
                                                        <a href="#">Child</a>
                                                        <ul>
                                                            <li>
                                                                <a href="#">Grand Child</a>
                                                            </li>
                  
                                                            <li>
                                                              <a href="#">Child</a>
                                                              <ul>
                                                                  <li>
                                                                      <a href="#">Grand Child</a>
                                                                  </li>
                        
                                                                  <li>
                                                                    <a href="#">Grand Child</a>
                                                                  </li>
                                                              </ul>
                                                            </li>
                                                        </ul>
                                                      </li>
                                                    </ul>
                                                  </li>
                                              </ul>
                                          </li>
                                          <li>
                                            <a href="#">Child</a>
                                            <ul>
                                              <li>
                                                  <a href="#">Grand Child</a>
                                              </li>
    
                                              <li>
                                                <a href="#">Grand Child</a>
                                              </li>
                                          </ul>
                                          </li>
                                          <li><a href="#">Grand Child</a></li>
                                          <li><a href="#">Grand Child</a></li>
                                          <li><a href="#">Grand Child</a></li>
                                          <li><a href="#">Grand Child</a></li>
                                          <li><a href="#">Grand Child</a></li>
                                          <li><a href="#">Grand Child</a></li>
                                          
                                      </ul>
                                  </li>
                              </ul>
                          </li>
                      </ul>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
        </div>
            
          
          
        </div>
      </div>
    @endsection
  
  
  </x-app-layout>