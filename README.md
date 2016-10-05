# droide-wkMap

Extensão para widgetkit do yootheme, criada para ajudar a extender a librarie do google ````new google.maps````

VocÊ consegue recuperar o mapa da extensao usando:
````javascript
//recupera o map object
window.droidemap
````
Desta maneira podemos ajustar o problema de carragar mapa no modal ou elementos ocultos:

````javascript

$('[data-uk-switcher]').on('show.uk.switcher', function(event, area){
    Events = event;
    areas = area;
    if(areas.context.innerText == 'Contato')
    {
      google.maps.event.trigger(window.droidemap, 'resize');
      window.mapClick();
    }
});

````

O sistema atua no evento load e clique para carregar o mapa.
desabilitando o callback na administrator do widget, você pode utilizar a função ``` window.mapClick();``` e garregar o mapa apartir do seu evento.
