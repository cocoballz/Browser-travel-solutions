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
                <h1 class="h2">información del clima</h1>
                <div class="btn-toolbar mb-3 mb-md-0">
                    <div class="btn-group me-2">
                        <select id="set_city" class="form-select form-select-lg mb-3"
                                aria-label=".form-select-lg example" onchange="new_city();">
                            <option value="0" selected>Selecione una ciudad</option>
                            @forelse($datos as $dato)
                                <option value="{{$dato->token_api}}">{{$dato->nombre}}</option>
                            @empty
                                <option value="0" selected>sin datos que mostrar</option>
                            @endforelse
                        </select>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 ">

                    <!-- <canvas class="my-4 w-100 chartjs-render-monitor" id="myChart" width="1283" height="541" style="display: block; height: 722px; width: 1711px;"></canvas>-->
                    <div id='map' style='width: 600px; height: 400px;'></div>

                </div>

                <div class="col-md-6">


                    <h2>Información actualizada
                        <div id="api_name_city"></div>
                    </h2>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                            <tr>
                                <th>Humedad</th>
                                <th>presión</th>
                                <th>visibilidad</th>
                                <th>Temperatura</th>
                                <th>Estado</th>
                            </tr>
                            </thead>
                            <tbody id="api_info_city">

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </main>
    </div>
</div>


<script> //Script para la api del mapa en mapbox
    //L.map('mapid').setView([4.708430,-74.211546], 13);
    mapboxgl.accessToken = 'pk.eyJ1IjoiY29jb2JhbGx6IiwiYSI6ImNraHozYzVlcjBwYmgzMGtiMHQwYTFoYmwifQ.Mb0djzsumqQXDOmq3TKs3w';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [-74.07635165721842, 4.599288759216435], // starting position [lng, lat]
        zoom: 12
    });
    var marker = new mapboxgl.Marker().setLngLat([-74.07635165721842, 4.599288759216435])
        .addTo(map);


    //map.flyTo({center: [-90.96, -0.47],})

    marker.setDraggable(true);

    function marcador() {
        var lngLat = marker.getLngLat();
        console.log(lngLat);
    }

</script>

<script>//script para generar la peticion ajax al cambiar la ciudad

    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-center",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }


    function new_city() {

        var ciduad;
        ciudad = document.getElementById("set_city").value;

        console.log(ciudad);
        if (ciudad == 0) {
            toastr["error"]("Por Favor Seleciona una Ciudad!");
            map.flyTo({center: [-74.07635165721842, 4.599288759216435], zoom: 12,});
            $('#api_info_city').html("<tr><td></td><td></td><td></td><td></td><td></td></tr>");
            //map.flyTo({center: [-75.48203129430225, 42.79446303644522],}); // New york

            //map.flyTo({center: [lng, lat],});
        } else {

            $.ajax({ // Peticion Ajax para consultar la infromacion de la ciudad desde la API de yahoo
                url: '{{ route('maps')}}' + '?_token=' + '{{ csrf_token() }}',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    city: ciudad
                },

                success: function (data) {

                    // var ser = JSON.stringify (data.json_info);
                   toastr.options = {
                                        "closeButton": true,
                                        "debug": false,
                                        "newestOnTop": false,
                                        "progressBar": true,
                                        "positionClass": "toast-bottom-right",
                                        "preventDuplicates": false,
                                        "onclick": null,
                                        "showDuration": "300",
                                        "hideDuration": "1000",
                                        "timeOut": "5000",
                                        "extendedTimeOut": "1000",
                                        "showEasing": "swing",
                                        "hideEasing": "linear",
                                        "showMethod": "fadeIn",
                                        "hideMethod": "fadeOut"
                                      }
                    toastr["success"]("Exito al consultar")
                    var info = data.json_info;
                    console.log(info);
                    $('#api_name_city').html(info.location.city + '(' + info.location.region + ') - ' + info.location.country);
                    map.flyTo({center: [info.location.long, info.location.lat], zoom: 10,});
                    var marker = new mapboxgl.Marker().setLngLat([info.location.long, info.location.lat]).addTo(map);
                    marker.setDraggable(false);
                    $('#api_info_city').html("<tr><td>" + info.current_observation.atmosphere.humidity + "%  </td><td> " + info.current_observation.atmosphere.pressure + "  milibar </td><td> " + info.current_observation.atmosphere.visibility + " Km </td><td> " + info.current_observation.condition.temperature + " Celsius </td><td> " + info.current_observation.condition.text + "  </td></tr>");
                },
            });

        }
    }

</script>

@include('partials._footer')
