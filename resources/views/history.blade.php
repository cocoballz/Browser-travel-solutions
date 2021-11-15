@include('partials._header')
@include('partials._nav')

<div class="container-fluid">
    <div class="row">
        <main class="col-md-12 ms-sm-auto col-lg-12 px-md-4">
            <div class="chartjs-size-monitor">
                <div class="chartjs-size-monitor-expand">
                    <div class=""></div>
                </div>
                <div class="chartjs-size-monitor-shrink">
                    <div class=""></div>
                </div>
            </div>
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Historial de consultas del clima</h1>

            </div>
            <div class="row">

                <div class="col-md-10 offset-md-1">


                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Ciudad</th>
                                <th>Datos</th>
                                <th>Fecha</th>
                                <th>Tiempo</th>
                            </tr>
                            </thead>
                            <tbody >

@forelse($datos as $dato)
<tr>
<td>{{$dato->loop}}</td>
<td>{{$dato->city}} </td>
<td><small>{{$dato->json_responsive}} </small></td>
<td>{{$dato->created_at}} </td>
<td>{{$dato->created_at->difffOrHumans()}} </td>

</tr>

@empty
@endforelse


                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </main>
    </div>
</div>

@include('partials._footer')
