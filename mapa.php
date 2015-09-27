<?php
require_once 'database.php';

if(isset($_POST['tipo_local'])){
    $tipo_local= $_POST['tipo_local'];
    
    $db = new Database();
    $mis_locales = $db->mostrarLocales($tipo_local);
    //var_dump($mis_locales);
    ?>

    <!DOCTYPE html>
    <html>
      <head>
        <title>Simple Map</title>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <meta charset="utf-8">
        <style>
          html, body, #map-canvas {
            height: 100%;
            margin: 10px 35px 0 20px;
            padding: 0px
          }
        </style>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
        <script>
        var map;
        var geocoder;

        function initialize() {
          geocoder = new google.maps.Geocoder();   // Inicializa la funcion Geocoder() -> geolocalizacion en el GEOCODING
          var myLatlng = new google.maps.LatLng(40.948076,-5.619511);  // Santa Marta de Tormes Salamanca

          var mapOptions = {
            zoom: 14,
            center: myLatlng
          };
          map = new google.maps.Map(document.getElementById('map-canvas'),
              mapOptions);

        // Al inicializar cargamos los datos resultantes de la consulta a la BBDD 
        <?php
         foreach($mis_locales as $local){
              echo "var address = \"".$local['direccion']."\";";   // Incluimos los datos del array PHP en una variable Javascript
        ?>

           // Cargamos el mapa
        geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({          // Debo crear la variable VAR aqui porque quiero un marcador para cada uno de los registros
                    map: map,
                    position: results[0].geometry.location,             // IMP no olvidar poner la coma
                    title: <?php echo "'".$local['nombre']."'"; ?>      // AL ultimo no se le pone coma
                }); 

                // Aqui colocamos el codigo del INFO WINDOW
                var contentString = <?php echo "'".$local['nombre']."'"; ?> ;  // Aqui podriamos poner un html con lo que queramos (img,tables,etc)
                var infowindow = new google.maps.InfoWindow({
                    content:  contentString                        // Para que cuando hagamos click en el marcador aparezca la info del nombre
                });
                // Evento que llama al INFO WINDOW 
                google.maps.event.addListener(marker, 'click', function() {
                  infowindow.open(map,marker);
                });

            } else {
              alert('Geocode was not successful for the following reason: ' + status);
            }
          });

        <?php
             }  // Cierra el bucle FOREACH
         ?>
        }

        google.maps.event.addDomListener(window, 'load', initialize);

        </script>
      </head>
      <body>
        <div id="map-canvas" style="height:75%; width:90%; "></div>
      </body>
    </html>
<?php
    }   // Cierre del IF
    else{
        echo "<h3>Debe seleccionar un tipo de local</h3>";
    }
?>