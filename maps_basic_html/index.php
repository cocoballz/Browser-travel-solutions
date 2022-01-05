            <!DOCTYPE html>
        <html>
        <head>
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
            <title>información del clima</title>

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="">
            <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
            <meta name="generator" content="Hugo 0.79.0">
            <title>Dashboard Template · Bootstrap v5.0</title>
            <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">

                <!-- Bootstrap core CSS -->
        <link href="https://getbootstrap.com/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

        <!-- Maps -->

        <script src='https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.js'></script>
        <link href='https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.css' rel='stylesheet'>
        <link href='//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css' rel='stylesheet'>
        <link href="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
        <script src='https://code.jquery.com/jquery-3.5.1.min.js'></script>

            <style>
              .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
              }

              @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                  font-size: 3.5rem;
                }
              }
            </style>

            
            <!-- Custom styles for this template -->
            <link href="https://getbootstrap.com/docs/5.0/examples/dashboard/dashboard.css" rel="stylesheet">
          <style type="text/css">/* Chart.js */
        @keyframes chartjs-render-animation{from{opacity:.99}to{opacity:1}}.chartjs-render-monitor{animation:chartjs-render-animation 1ms}.chartjs-size-monitor,.chartjs-size-monitor-expand,.chartjs-size-monitor-shrink{position:absolute;direction:ltr;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1}.chartjs-size-monitor-expand>div{position:absolute;width:1000000px;height:1000000px;left:0;top:0}.chartjs-size-monitor-shrink>div{position:absolute;width:200%;height:200%;left:0;top:0}</style></head>

        </head>
        <body>
            
        <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
          <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Maps Example</a>
          <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        </header>

        <div class="container-fluid">
          <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
              <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">
                    
                    <i class="fa fa-search" aria-hidden="true"></i>
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon-search"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                      Consultar
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                      Historial
                    </a>
                  </li>
                </ul>
              </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
              <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">información del clima</h1>
                <div class="btn-toolbar mb-3 mb-md-0">
                  <div class="btn-group me-2">
                  <select id="set_city" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" onchange = "new_city();">
                    <option value="0" selected>Selecione una ciudad </option>
                    <option value="miami">Miami</option>
                    <option value="orlando">Orlando</option>
                    <option value="NewYork">New York</option>
                  </select>            
                  </div>
                </div>
              </div>
              <div class="row">
              <div class="col-md-6 ">
                  
             <!-- <canvas class="my-4 w-100 chartjs-render-monitor" id="myChart" width="1283" height="541" style="display: block; height: 722px; width: 1711px;"></canvas>-->
             <div id='map' style='width: 600px; height: 400px;'></div>
            
              </div>

              <div class="col-md-5  px-md-2 offset-md-1">

        

                  <h2>Información actualizada <div id="api_name_city"></div> </h2>
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


            <script src="https://getbootstrap.com/docs/5.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

              <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
          
              <!--
              <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
              <script src="https://getbootstrap.com/docs/5.0/examples/dashboard/dashboard.js"></script>
            -->
        </body>
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        </html>

        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



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
        function marcador(){
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


        function new_city(){

            var ciduad;
            ciudad = document.getElementById("set_city").value;

            console.log(ciudad);
            if (ciudad == 0) {
                toastr["error"]("Por Favor Seleciona una Ciudad!");
                map.flyTo({center: [-74.07635165721842, 4.599288759216435],zoom: 12,});
                 $('#api_info_city').html("<tr><td></td><td></td><td></td><td></td><td></td></tr>"); 
                //map.flyTo({center: [-75.48203129430225, 42.79446303644522],}); // New york
            
                //map.flyTo({center: [lng, lat],});
            }else{

                $.ajax({ // Peticion Ajax para consultar la infromacion de la ciudad desde la API de yahoo
                    url:'ajax_new.php',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        city: ciudad,
                    },

                    success: function (data) {
                         
                     // var ser = JSON.stringify (data.json_info);
                      var info = data.json_info;
                      console.log(info);
                      $('#api_name_city').html(info.location.city + '('+ info.location.region +') - ' + info.location.country); 
                        map.flyTo({center: [info.location.long, info.location.lat],zoom: 10,});
                        var marker = new mapboxgl.Marker().setLngLat([info.location.long, info.location.lat]).addTo(map);
                        marker.setDraggable(false);
                        $('#api_info_city').html("<tr><td>"+info.current_observation.atmosphere.humidity+"%  </td><td> "+info.current_observation.atmosphere.pressure+"  milibar </td><td> "+info.current_observation.atmosphere.visibility+" Km </td><td> "+info.current_observation.condition.temperature+" Celsius </td><td> "+info.current_observation.condition.text+"  </td></tr>"); 
                    },
                });

            }
        }

        </script>