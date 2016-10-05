<?php

return array(

    'name' => 'widget/droide-wkmap',

    'main' => 'YOOtheme\\Widgetkit\\Widget\\Widget',

    'config' => array(

        'name'  => 'droide-wkmap',
        'label' => 'Droide Mapa',
        'core'  => true,
        'icon'  => 'plugins/widgets/droide-wkmap/widget.svg',
        'view'  => 'plugins/widgets/droide-wkmap/views/widget.php',
        'item'  => array('title', 'content', 'media'),
        'fields' => array(
            array('name' => 'location')
        ),
        'settings' => array(
            'width'                   => 'auto',
            'height'                  => 400,
            'callback'                => 1,
            'maptypeid'               => 'roadmap',
            'maptypecontrol'          => false,
            'mapctrl'                 => true,
            'zoom'                    => 9,
            'marker'                  => 2,
            'marker_icon'             => '',
            'markercluster'           => false,
            'popup_max_width'         => 300,
            'zoomwheel'               => true,
            'draggable'               => true,
            'directions'              => false,
            'disabledefaultui'        => false,

            'styler_invert_lightness' => false,
            'styler_hue'              => '',
            'styler_saturation'       => 0,
            'styler_lightness'        => 0,
            'styler_gamma'            => 0,

            'media'                   => true,
            'image_width'             => 'auto',
            'image_height'            => 'auto',
            'media_align'             => 'top',
            'media_width'             => '1-2',
            'media_breakpoint'        => 'medium',
            'media_border'            => 'none',
            'media_overlay'           => 'icon',
            'overlay_animation'       => 'fade',
            'media_animation'         => 'scale',

            'title'                   => true,
            'content'                 => true,
            'social_buttons'          => true,
            'title_size'              => 'h3',
            'text_align'              => 'left',
            'link'                    => true,
            'link_style'              => 'button',
            'link_text'               => 'Leia mais',

            'link_target'             => false,
            'class'                   => ''
        )

    ),

    'events' => array(

        'init.site' => function($event, $app) {
            JLoader::register('Ferramentas', JPATH_LIBRARIES . '/Ferramentas.php');
            if ($app['config']->get('googlemapseapikey')) {
              $keymp = $app['config']->get('googlemapseapikey');

              $callback = '&callback=nextMap';

              Ferramentas::SetJsfile('https://maps.googleapis.com/maps/api/js?key='.$keymp.$callback,'BODY_END','async defer');
              //$app['styles']->add('uikit-tooltip', 'https://cdnjs.cloudflare.com/ajax/libs/uikit/2.26.3/css/components/tooltip.min.css', array('uikit'));
                //$app['scripts']->add('googlemapsapi', 'GOOGLE_MAPS_API_KEY = "'.$app['config']->get('googlemapseapikey').'";', array(), 'string');
                //$app['scripts']->add('widgetkit-droide-wkmap', 'plugins/widgets/droide-wkmap/assets/marker-helper.js');
            }

            // $app['scripts']->add('widgetkit-droide-wkmap', 'plugins/widgets/droide-wkmap/assets/maps.js', array('uikit'));
            // $app['scripts']->add('widgetkit-marker', 'plugins/widgets/droide-wkmap/assets/marker-helper.js');
        },

        'init.admin' => function($event, $app) {
            $app['angular']->addTemplate('droide-wkmap.edit', 'plugins/widgets/droide-wkmap/views/edit.php', true);

            if ($app['config']->get('googlemapseapikey')) {
                $app['scripts']->add('googlemapsapi', 'GOOGLE_MAPS_API_KEY = "'.$app['config']->get('googlemapseapikey').'";', array(), 'string');
            }
        }

    )

);
