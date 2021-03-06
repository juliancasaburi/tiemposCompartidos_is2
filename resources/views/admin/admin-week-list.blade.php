@extends('layouts.admin-dashboard-layout')

@section('title', '- Admin Dashboard - Listado de semanas')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/datatables/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/datatables/css/buttons.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('libs//datatables/css/select.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/datatables/css/fixedHeader.bootstrap4.css') }}">
@endsection

@section('content')
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
    @include('layouts.partials.admin-sidebar')
    <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="container-fluid  dashboard-content">
                <!-- ============================================================== -->
                <!-- pageheader  -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">Admin Dashboard</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href={{ url('admin/dashboard') }} class="breadcrumb-link">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Semanas</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Ver listado</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end pageheader  -->
                <!-- ============================================================== -->

                <!-- ============================================================== -->
                <!-- Alerts  -->
                <!-- ============================================================== -->
                @if(session()->has('alert-success'))
                    <div class="alert alert-success alert-dismissible" data-expires="10000">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        {{ session()->get('alert-success') }}
                    </div>
                @elseif (session()->has('alert-danger'))
                    <div class="alert alert-danger alert-dismissible" data-expires="10000">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        {{ session()->get('alert-danger') }}
                    </div>
                @elseif ($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- ============================================================== -->
                <!-- End Alerts  -->
                <!-- ============================================================== -->

                <div class="row">
                    <!-- ============================================================== -->
                    <!-- weeks table  -->
                    <!-- ============================================================== -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Listado de semanas</h5>
                            <div class="card-body">
                                <input class="form-control" id="tableSearch" type="text" placeholder="Buscar">
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first" id="table">
                                        <thead>
                                        <tr>
                                            <th>Índice</th>
                                            <th>ID</th>
                                            <th>Estado</th>
                                            <th>Propiedad</th>
                                            <th>Fecha</th>
                                            <th>Modificar</th>
                                            <th>Eliminar</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($weeks as $w)
                                            <tr>
                                                <td>{{ $loop->index }}</td>
                                                <td>
                                                    <a href="{{ url('admin/dashboard/week-info?id=').$w->id }}" class="btn-outline-primary">{{ $w->id }}
                                                        <br>
                                                        <i class="fas fa-search-plus"></i>+INFO</a>
                                                </td>
                                                <td>
                                                    @if($w->activeAuction)
                                                        <i class="fas fa-gavel fa-fw fa-sm"></i>Subasta Creada
                                                        <p class="text-muted">{{$w->activeAuction->state()}}</p>
                                                    @elseif($w->activeHotSale)
                                                        <i class="fas fa-fire fa-fw fa-sm"></i>HotSale Creada
                                                        <p class="text-muted">{{$w->activeHotsale->state()}}</p>
                                                    @else
                                                        <p>Libre</p>
                                                    @endif
                                                </td>
                                                <td><a href="{{ url($propertyURL.$w->property->id) }}">{{ $w->property->nombre}}</a></td>
                                                <td>{{ $w->fecha }}</td>
                                                <td><button class="btn-outline-primary pt-2 pb-2" id="modifyWeekButton" data-toggle="modal" data-target="#modifyWeekModal" data-wid="{{ $w->id }}" data-wdate="{{ $w->fecha }}" data-wpropertyname="{{$w->property->nombre}}">
                                                        <i class="fas fa-calendar-alt"></i>Modificar
                                                    </button></td>
                                                <td><button class="btn-outline-danger pt-2 pb-2" id="deleteWeekButton" data-toggle="modal" data-target="#deleteWeekModal" data-wid="{{ $w->id }}" data-wdate="{{ $w->fecha }}" data-wpropertyname="{{$w->property->nombre}}">
                                                        <i class="fas fa-trash"></i>Eliminar
                                                    </button></td>
                                                <td>
                                                    @if(!$w->activeAuction && !$w->activeHotsale && !$w->reservation)
                                                        <button class="btn-outline-brand pt-2 pb-2" id="hotsaleWeekButton" data-toggle="modal" data-target="#hotsaleWeekModal" data-wid="{{ $w->id }}" data-wdate="{{ $w->fecha }}" data-wpropertyname="{{$w->property->nombre}}">
                                                            <i class="fas fa-fire"></i>Publicar en Hotsale
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>Índice</th>
                                            <th>ID</th>
                                            <th>Estado</th>
                                            <th>Propiedad</th>
                                            <th>Fecha</th>
                                            <th>Modificar</th>
                                            <th>Eliminar</th>
                                            <th></th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end weeks table  -->
                    <!-- ============================================================== -->
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper -->
    <!-- ============================================================== -->

    <!-- Delete week Modal -->
    <div class="modal fade" id="deleteWeekModal" tabindex="-1" role="dialog" aria-labelledby="deleteWeekModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteWeekModalLabel">Desea eliminar la semana?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="weekPropertyText">aa</p>
                    <p id="weekDateText">aa</p>
                    <form id="deleteWeekForm" action="{{ route('admin.deleteWeek') }}" role="form" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" id="id" value="">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                    <button type="button" id="btn-deleteWeek" class="btn btn-primary" onclick="deleteWeekForm_submit()">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Delete week Modal -->

    <!-- Modify week Modal -->
    <div class="modal fade" id="modifyWeekModal" tabindex="-1" role="dialog" aria-labelledby="modifyWeekModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modifyWeekModalLabel">Modificar semana</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="modifyWeekPropertyText">-</p>
                    <p id="modifyWeekDateText">-</p>
                    <form id="modifyWeekForm" action="{{ route('admin.modifyWeek') }}" role="form" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" id="id" value="">
                        Fecha nueva (Debe ser lunes):
                        <input type="date" class="form-control" id="fecha_nueva" name="fecha_nueva">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                    <button type="button" id="btn-modifyWeek" class="btn btn-primary" onclick="modifyWeekForm_submit()">Modificar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End modify week Modal -->

    <!-- Hotsale week Modal -->
    <div class="modal fade" id="hotsaleWeekModal" tabindex="-1" role="dialog" aria-labelledby="hotsaleWeekModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hotsaleWeekModalLabel">Desea publicar la semana en HotSale?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="hotsaleWeekPropertyText">-</p>
                    <p id="hotsaleWeekDateText">-</p>
                    <form id="hotsaleWeekForm" action="{{ route('admin.hotsaleWeek') }}" role="form" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" id="id" value="">
                        <label for="fecha_inicio">Fecha inicio: </label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio"><br>
                        <label for="fecha_fin" style="margin-top: 15px">Fecha fin: </label>
                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin"><br>
                        <label for="precio" style="margin-top: 15px">Precio: </label>
                        <input type="number" class="form-control" id="precio" name="precio" step="0.01">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                    <button type="button" id="btn-hotsaleWeek" class="btn btn-primary" onclick="hotsaleWeekForm_submit()">Publicar en hotsales</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Hotsale week Modal -->
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            $("#tableSearch").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#table tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>

    <script> // Delete Week
        // Fill week id for request
        $('#deleteWeekModal').on('show.bs.modal', function (event) {
            var id = $(event.relatedTarget).data('wid');
            var date = $(event.relatedTarget).data('wdate');
            var property = $(event.relatedTarget).data('wpropertyname');
            document.getElementById("weekPropertyText").innerHTML = "Propiedad: ".concat(property);
            document.getElementById("weekDateText").innerHTML = "Fecha: ".concat(date);
            $(event.currentTarget).find('input[name="id"]').attr('value',id);
        });

        // Submit form
        function deleteWeekForm_submit() {
            $('#deleteWeekButton').attr('disabled','disabled');
            $('#deleteWeekModal').modal('hide');
            document.getElementById("deleteWeekForm").submit();
        }
    </script>

    <script> // Modify Week
        // Fill week id for request
        $('#modifyWeekModal').on('show.bs.modal', function (event) {
            var id = $(event.relatedTarget).data('wid');
            var date = $(event.relatedTarget).data('wdate');
            var property = $(event.relatedTarget).data('wpropertyname');
            document.getElementById("modifyWeekPropertyText").innerHTML = "Propiedad: ".concat(property);
            document.getElementById("modifyWeekDateText").innerHTML = "Fecha actual: ".concat(date);
            $(event.currentTarget).find('input[name="id"]').attr('value',id);
        });

        // Submit form
        function modifyWeekForm_submit(){
            $('#modifyWeekButton').attr('disabled','disabled');
            $('#modifyWeekModal').modal('hide');
            document.getElementById("modifyWeekForm").submit();
        }
    </script>

    <script> // Hotsale Week
        // Fill week id for request
        $('#hotsaleWeekModal').on('show.bs.modal', function (event) {
            var id = $(event.relatedTarget).data('wid');
            var date = $(event.relatedTarget).data('wdate');
            var property = $(event.relatedTarget).data('wpropertyname');
            document.getElementById("hotsaleWeekPropertyText").innerHTML = "Propiedad: ".concat(property);
            document.getElementById("hotsaleWeekDateText").innerHTML = "Fecha: ".concat(date);
            $(event.currentTarget).find('input[name="id"]').attr('value',id);
        });

        // Submit form
        function hotsaleWeekForm_submit() {
            $('#hotsaleWeekButton').attr('disabled','disabled');
            $('#hotsaleWeekModal').modal('hide');
            document.getElementById("hotsaleWeekForm").submit();
        }
    </script>
@endsection