<script type="text/javascript"> 
          google_api_map_init(); 
          function google_api_map_init(){ 
            var map; 
            var coordData = new google.maps.LatLng(parseFloat(30.205198), parseFloat(-81.613825)); 
            var markCoord1 = new google.maps.LatLng(parseFloat(30.205198), parseFloat(-81.613825));
            var marker; 

            var markerIcon = { 
                url: "images/gmap_marker.png", 
                size: new google.maps.Size(42, 65), 
                origin: new google.maps.Point(0,0), 
                anchor: new google.maps.Point(21, 70) 
            }; 
            function initialize() { 
              var mapOptions = { 
                zoom: 12, 
                center: coordData, 
                scrollwheel: false, 
              } 
 
              var contentString = "<div></div>"; 
              var infowindow = new google.maps.InfoWindow({ 
                content: contentString, 
                maxWidth: 200 
              }); 
               
              var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions); 
              
              marker = new google.maps.Marker({ 
                map:map, 
                position: markCoord1, 
                icon: markerIcon
              });


            google.maps.event.addDomListener(window, 'resize', function() {

              map.setCenter(coordData);

              var center = map.getCenter();
            });
          }

            google.maps.event.addDomListener(window, "load", initialize); 

          } 
</script>