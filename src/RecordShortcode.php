<?php
namespace rcm;

class RecordShortcode
{
    public function __construct()
    {
        add_shortcode('conference_list', function($atts)
        {
            $atts = shortcode_atts(array(
                'event_id' => '',
            ), $atts);

            $event_id = intval( $atts['event_id'] );

            $args = array(
                'post_type' => 'rcm_conference',
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'meta_query' => array(),
            );

            if ( $event_id )
            {
                $args['meta_query'][] = array(
                    'key' => 'event_id',
                    'value' => $event_id,
                    'compare' => '=',
                    'type' => 'NUMERIC',
                );
            }

            $query = new \WP_Query( $args );

            if ($query->have_posts())
            {
                $output = '<div class="rmc-conference-wrapper">';

                while ($query->have_posts())
                {
                    $query->the_post();
                    $title = get_the_title();
                    $post_id = get_the_ID();
                    $speaker = get_post_meta(get_the_ID(), 'speaker', true);
                    $url = get_post_meta(get_the_ID(), 'url', true);
                    $hall = get_post_meta(get_the_ID(), 'hall', true);
                    $number = get_post_meta(get_the_ID(), 'number', true);
                    $start_date = get_post_meta(get_the_ID(), 'start_date', true);
                    $end_date = get_post_meta(get_the_ID(), 'end_date', true);
                    $symposium = get_post_meta(get_the_ID(), 'symposium', true);

                    $attribute = [
                        'width' => '100%',
                        'height' => '650',
                        'src' => $url,
                        'frameborder' => '0',
                        'allow' => 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share',
                        'allowfullscreen' => 'true',
                    ];

                    $attribute_string = '';

                    foreach ($attribute as $key => $value) {
                        $attribute_string .= $key . '="' . $value . '" ';
                    }

                    $iframe = '<iframe ' . $attribute_string . ' ></iframe>';

                    ob_start();
                    include str_replace( '/', DIRECTORY_SEPARATOR, WP_PLUGIN_DIR . '/wp-record-conference-manager/src/Template/ConferenceView.php' );
                    echo ob_get_clean();
                }

                $output .= '</div>';

                wp_reset_postdata();

                return $output;
            }

            return 'Конференции не найдены.';
        });

        add_shortcode('conference_menu', function($atts)
        {
            $atts = shortcode_atts(array(
                'event_id' => '',
            ), $atts);

            $event_id = intval( $atts['event_id'] );

            $args = array(
                'post_type' => 'rcm_conference',
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'meta_query' => array(),
            );

            if ( $event_id )
            {
                $args['meta_query'][] = array(
                    'key' => 'event_id',
                    'value' => $event_id,
                    'compare' => '=',
                    'type' => 'NUMERIC',
                );
            }

            $query = new \WP_Query( $args );

            if ($query->have_posts())
            {
                $output = '<div id="rmc-menu-wrapper" class="rmc-menu-wrapper">';
                $output .= '<ul class="rmc-menu">';

                while ($query->have_posts())
                {
                    $query->the_post();
                    $title = get_the_title();
                    $post_id = get_the_ID();

                    ob_start();
                    include str_replace( '/', DIRECTORY_SEPARATOR, WP_PLUGIN_DIR . '/wp-record-conference-manager/src/Template/ConferenceMenuItemView.php' );
                    $output .=  ob_get_clean();
                }

                $output .= '</ul>';
                $output .= '</div>';

                wp_reset_postdata();

                return $output;
            }

            return 'Конференции не найдены.';
        });
    }
}
