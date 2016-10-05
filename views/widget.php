<style type="text/css">
 #load-map { height: 250px; width: 100%;}
</style>
<?php
$map_id  = uniqid('wk-map');
$markers = array();
$width   = $settings['width']  == 'auto' ? 'auto'  : ((int)$settings['width']).'px';
$height  = $settings['height'] == 'auto' ? '300px' : ((int)$settings['height']).'px';
$latLong = [];
// Markers
foreach ($items as $i => $item) {

    if (isset($item['location']) && $item['location']) {


        $latLong[] = ['lat'=>$item['location']['lat'],'long'=>$item['location']['lng']];
        $marker = array(
            'lat'     => $item['location']['lat'],
            'lng'     => $item['location']['lng'],
            'title'   => $item['title'],
            'icon'    =>'',
            'content' => ''
        );

        if($item['media2']){
        $marker['icon'] = Juri::base().$item['media2'];
        }

        if (($item['title'] && $settings['title']) ||
            ($item['content'] && $settings['content']) ||
            ($item['media'] && $settings['media'])) {
                $marker['content'] = $app->convertUrls($this->render('plugins/widgets/' . $widget->getConfig('name')  . '/views/_content.php', compact('item', 'settings')));
        }

        $markers[] = $marker;
    }
}
$settings['markers'] = json_encode($markers);

$styles = [
  [
    'stylers'=>[ ['hue'=> $settings['styler_hue'] ], ['saturation'=> $settings['styler_saturation']  ],  ]
  ], // featureType
  [
    'featureType'=>'road',
     'elementType'=>'geometry',
     'stylers'=> [
      ['lightness'=>  $settings['styler_lightness']],
      ['visibility'=> "simplified"]
    ]
  ],  // featureType
  [
    'featureType'=>"road",
    'elementType'=> 'labels',
    'stylers'=> [
      ['visibility'=> "simplified"]
    ]
  ] // road
];

$styles = json_encode($styles);

?>

<div class="" id="load-map">

</div>

<script type="text/javascript">
window.droidemap = 'vazio';

function GetMap()
{
  var callback = <?=$settings['callback']?>;
  var markers = <?=$settings['markers']?>;
    window.droidemap = new google.maps.Map(document.getElementById('load-map'), {
              center: {lat: <?=$latLong[0]['lat']?>, lng: <?=$latLong[0]['long']?>},
              //scrollwheel: false,
              zoom: <?=$settings['zoom']?>
            });

      window.droidemap.setOptions({styles: <?=$styles;?>});

      var infowindow = new google.maps.InfoWindow();

     jQuery.each(markers, function(index, mark){


      if(mark.icon){
        var pinIcon = new google.maps.MarkerImage(
           mark.icon,
           null, /* size is determined at runtime */
           null, /* origin is 0,0 */
           null, /* anchor is bottom center of the scaled image */
           new google.maps.Size(50, 50)
       );
     }else{
        var pinIcon = new google.maps.MarkerImage(
           "http://maps.google.com/mapfiles/marker.png",
           null, /* size is determined at runtime */
           null, /* origin is 0,0 */
           null, /* anchor is bottom center of the scaled image */
           null
       );
     }
           marker = new google.maps.Marker({
            position: new google.maps.LatLng(mark.lat, mark.lng),
            animation: google.maps.Animation.DROP,
            map: window.droidemap,
            icon: pinIcon
          });
          marker.addListener('click', toggleBounce);

          google.maps.event.addListener(marker, 'click', (function(marker, i) {

            return function() {
              infowindow.setContent(mark.content);
              infowindow.open(window.droidemap, marker);
            }
          })(marker, i));

          google.maps.event.addListener(infowindow,'closeclick',function(){
             ///currentMark.setMap(null);
             marker.setAnimation(null);
          });

     });
}

function toggleBounce() {
  if (marker.getAnimation() !== null) {
    marker.setAnimation(null);
  } else {
    marker.setAnimation(google.maps.Animation.BOUNCE);
  }
}

window.mapClick = function()
{
  GetMap();

}


function nextMap()
{
  GetMap();
}



</script>
