<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=gb18030">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/css.css') }}">
  <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/_all-skins.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/jquery-jvectormap.css') }}">
  <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">
  <link rel="stylesheet" href="{{ asset('css/bootstrap-timepicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/bootstrap3-wysihtml5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/loading.css') }}">
  <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
  <script src="js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
    body {
      color: #566787;
      font-family: 'Varela Round', sans-serif;
      font-size: 12px;
    }
  </style>
  @yield('style')

</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <header class="main-header">
      <a href="#" class="logo">

        @if( Auth::user()->id_unity == 1)
        <span class="logo-mini"><b>RAU</b></span>
        <span class="logo-lg"><b>RAU</b>RA</span>
        @elseif(Auth::user()->id_unity == 2)
        <span class="logo-mini"><b>SAN</b></span>
        <span class="logo-lg"><b>SAN</b> RAFAEL</span>
        @elseif(Auth::user()->id_unity == 3)
        <span class="logo-mini"><b>PUC</b></span>
        <span class="logo-lg"><b>PUC</b>AMARCA</span>
        @elseif(Auth::user()->id_unity == 4)
        <span class="logo-mini"><b>PIS</b></span>
        <span class="logo-lg"><b>PIS</b>CO</span>
        @else
        <span class="logo-mini"><b>IGH</b></span>
        <span class="logo-lg"><b>IGH</b>PERU</span>
        @endif

      </a>

      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">


            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="{{ asset('img/contrata.png') }}" class="user-image" alt="User Image">
                <span class="hidden-xs">{{ Auth::user()->name }} {{ Auth::user()->firstlastname }}</span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="{{ asset('img/contrata.png') }}" class="img-circle" alt="User Image">

                  <p>
                    {{ Auth::user()->name }}
                    <small>{{ Auth::user()->email }}</small>
                  </p>
                </li>

                <li class="user-footer">
                  <div class="pull-left">
                    <a href="{{ route('edit_user_company', Auth::id()) }}" class="btn btn-success"><i class="fa fa-cog" aria-hidden="true"></i> Perfil</a>
                  </div>
                  <div class="pull-right">
                    <a href="{{ route('logout') }}" class="btn btn-danger btn-block" onclick="event.preventDefault();
document.getElementById('logout-form').submit();">
                      <i class="fa fa-power-off" aria-hidden="true"></i> Salir
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                    </form>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="{{ asset('img/contrata.png') }}" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>{{ Auth::user()->name }} {{ Auth::user()->firstlastname }}</p>
            <a href="#"><i class="fa fa-circle text-success"></i>online</a>
          </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->

        @role('admin-general')
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">ADMINISTRADOR</li>
          <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> <span>Inicio</span></a></li>
          @can('inscriptions.index')
          <li><a href="{{route('inscriptions.index')}}"><i class="fa fa-pencil-square-o"></i> <span>Programación Cursos</span></a></li>
          @endcan
         
          @can('fotocheck.index')
          <li><a href="#"><i class="fa fa-check-square-o"></i> <span>Revision de Fotocheck</span></a></li>
          @endcan

          @can('participants.index')
          <li><a href="{{route('search-participant')}}"><i class="fa fa-check-circle-o"></i> <span>Buscar Participante</span></a></li>
          @endcan

          <li class="treeview">
            <a href="#">
              <i class="fa fa-line-chart"></i> <span>Reportes</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @if(Auth::user()->id_unity == 4)
              <li><a href="{{ route('list_course') }}"><i class="fa fa-usd" aria-hidden="true"></i> <span>Lista de Cursos</span></a></li>
              @endif
              @if(Auth::id() <> 2683 && Auth::id() <> 4141 && Auth::id() <> 14078 && Auth::id() <> 1097 && Auth::id() <> 14179 && Auth::id() <> 14180 && Auth::id() <> 7053)

                            <li><a href="{{ route('report_company') }}"><i class="fa fa-usd" aria-hidden="true"></i> <span>Reporte por empresa</span></a></li>
                            <li><a href="{{ route('daily_report_required') }}"><i class="fa fa-usd" aria-hidden="true"></i> <span>Status Contrata</span></a></li>
                            <li><a href="{{ route('status_company') }}"><i class="fa fa-usd" aria-hidden="true"></i> <span>Status Compañia</span></a></li>
                            @endif
            </ul>
          </li>

          <li class="header">COMPAÑIA PARTICIPANTE</li>
          <li><a href="{{ route('list_participants') }}"><i class="fa fa-users" aria-hidden="true"></i> <span>Participantes</span></a></li>

          @if(Auth::id() <> 2683 && Auth::id() <> 4141 && Auth::id() <> 14078 && Auth::id() <> 1097 && Auth::id() <> 14179 && Auth::id() <> 14180 && Auth::id() <> 7053)

                        <li><a href="{{url('/inscription')}}"><i class="fa fa-pencil-square-o"></i> <span>Inscripcíon</span></a></li>
                        <li><a href="{{url('/details')}}"><i class="fa fa-list-ul"></i> <span>Detalle Inscripción</span></a></li>
                        @endif
                        
                        <li class="header">CONFIGURACION</li>
                        @can('companies.index')
                        <li><a href="{{route('companies.index')}}"><i class="fa fa-building-o"></i> <span>Empresas</span></a></li>
                        @endcan

                        @can('type_courses.index')
                        @if(Auth::id() <> 2683 && Auth::id() <> 4141 && Auth::id() <> 14078 && Auth::id() <> 1097 && Auth::id() <> 14179 && Auth::id() <> 14180 && Auth::id() <> 7053)

                                      <li><a href="{{ route('type_courses.index')}}"><i class="fa fa-bookmark-o"></i> <span>Tipo Cursos</span></a></li>
                                      @endif

                                      @endcan

                                      @can('courses.index')
                                      <li><a href="{{route('courses.index')}}"><i class="fa fa-book"></i> <span>Cursos</span></a></li>
                                      @endcan

                                      <!--@can('roles.index')
                          <li><a href="{{ route('roles.index') }}"><i class="fa fa-users" aria-hidden="true"></i> <span>Roles</span></a></li>
                                      @endcan
              -->
                                      <!--@can('users.index')
                          <li><a href="{{ route('users.index') }}"><i class="fa fa-user-o"></i> <span>Usuarios</span></a></li>
                                      @endcan-->
                                      @if(Auth::user()->id_unity==3)
                      <li><a href="{{route('fotochecks.list')}}"><i class="fa fa-address-card"></i> <span>Fotocheck</span></a></li>
                                      @endif
            
        </ul>
        @endrole

        @role('facilitador' )
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">FACILITADORES</li>
          <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> <span>Inicio</span></a></li>

          <li><a href="{{route('inscriptions.index')}}"><i class="fa fa-pencil-square-o"></i> <span>Programación Cursos</span></a></li>

        </ul>
        @endrole
        @role('admin-cont')
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">CONTRATISTA</li>
          <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> <span>Inicio</span></a></li>
          <li><a href="{{route('search_participant_contrata')}}"><i class="fa fa-search-minus"></i> <span>Buscar Participante</span></a></li>
          <li><a href="{{ route('list_participants') }}"><i class="fa fa-users" aria-hidden="true"></i> <span>Participantes</span></a></li>
          <li><a href="{{url('/inscription')}}"><i class="fa fa-pencil-square-o"></i> <span>Inscripcíon</span></a></li>
          <li><a href="{{url('/details')}}"><i class="fa fa-list-ul"></i> <span>Detalle Inscripción</span></a></li>

          <li class="treeview">
            <a href="#">
              <i class="fa fa-line-chart"></i> <span>Reportes</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ route('required_courses') }}"><i class="fa fa-usd" aria-hidden="true"></i> <span>Reporte cursos obligatorio</span></a></li>
              <li><a href="{{ route('report_participants') }}"><i class="fa fa-user" aria-hidden="true"></i> <span>Reporte Participantes</span></a></li>
            </ul>
          </li>


          @if(false)
          <li><a href="{{url('/all-um')}}"><i class="fa fa-list-ul"></i> <span>Inicio</span></a></li>
          <li><a href="{{url('/raura')}}"><i class="fa fa-list-ul"></i> <span>Raura</span></a></li>
          <li><a href="{{url('/san-rafael')}}"><i class="fa fa-list-ul"></i> <span>San Rafael</span></a></li>
          <li><a href="{{url('/pucamarca')}}"><i class="fa fa-list-ul"></i> <span>Pucamarca</span></a></li>
          @endif
        </ul>
        @endrole


        @role('facturacion')
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">FACTURACIÓN</li>
          <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> <span>Inicio</span></a></li>
          <li><a href="{{ route('companies_um', 1) }}"><i class="fa fa-dashboard"></i> <span>Raura</span></a></li>
          <li><a href="{{ route('companies_um', ['id' => 2]) }}"><i class="fa fa-dashboard"></i> <span>San Rafael</span></a></li>
          <li><a href="{{ route('companies_um', ['id' => 3]) }}"><i class="fa fa-dashboard"></i> <span>Pucamarca</span></a>
          
          <li><a href="{{route('company_contacts')}}"><i class="fa fa-building-o"></i> <span>Empresas</span></a></li>
          <li><a href="{{route('company_detail')}}"><i class="fa fa-building-o"></i> <span>Detalle empresas</span></a></li>
          <li><a href="{{route('reportedp')}}"><i class="fa fa-building-o"></i> <span>Reporte EDP</span></a></li>
          <li><a href="{{route('pending_payment_report')}}"><i class="fa fa-building-o"></i> <span>Reporte Pendientes de pago</span></a></li>
        </ul>
        @endrole

        @role('super-sis' )
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">PANEL</li>
          <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> <span>Inicio</span></a></li>
          <li><a href="{{route('centroMedico')}}"><i class="fa fa-pencil-square-o"></i> <span>Registro Notas</span></a></li>
          <li><a href="{{route('medical_center')}}"><i class="fa fa-user-md" aria-hidden="true"></i> <span>Programación Médica</span></a></li>
          <li><a href="#"><i class="fa fa-cloud-download" aria-hidden="true"></i> <span>Formato Excel</span></a></li>
        </ul>
        @endrole
      </section>
    </aside>

    <div class="content-wrapper">
      <div class="loader-page"></div>
      @yield('content')
    </div>
    <footer class="main-footer" style="font-size: 10px">
      <div class="pull-right hidden-xs">
        <b>Version</b> 1.0.0
      </div>
      <strong>Copyright &copy; 2019 <a href="https://www.ighgroup.com/peru.html" target="_black">INVERITAS GLOBAL HOLDINGS PERU</a>.</strong> All rights
      reserved.
    </footer>

  </div>
  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/jquery.sparkline.min.js') }}"></script>
  <script src="{{ asset('js/jquery-jvectormap-1.2.2.min.js') }}"></script>
  <script src="{{ asset('js/jquery-jvectormap-world-mill-en.js') }}"></script>
  <script src="{{ asset('js/jquery.knob.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/moment.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap-timepicker.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap3-wysihtml5.all.min.js') }}"></script>
  <script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>
  <script src="{{ asset('js/select2.full.min.js') }}"></script>
  <script src="{{ asset('js/fastclick.js') }}"></script>
  <script src="{{ asset('js/adminlte.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
  <script src="{{ asset('js/demo.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/clipboard@2/dist/clipboard.min.js"></script>
  @yield('script')

</body>

</html>