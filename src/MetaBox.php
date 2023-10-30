<?php
namespace rcm;

class MetaBox
{
    public function __construct()
    {
        // Добавление метабокса
        add_action('add_meta_boxes', array($this, 'add_meta_box'));

        add_action( 'do_meta_boxes', function()
        {
            remove_meta_box('pageparentdiv', 'rmc_conference', 'side');
            remove_meta_box('us_page_settings', 'rmc_conference', 'side');
            remove_meta_box('postimagediv', 'rmc_conference', 'side');
            remove_meta_box('us_seo_settings', 'rmc_conference', 'normal');
            remove_meta_box('us_portfolio_settings', 'rmc_conference', 'normal');
        });

        // Сохранение данных метабокса
        add_action('save_post', array($this, 'save_meta_box'));
    }

    public function add_meta_box()
    {
        add_meta_box(
            'conference_details',
            'Conference Details',
            array($this, 'render_meta_box'),
            'rmc_conference',
            'normal',
            'default'
        );
    }

    public function render_meta_box($post)
    {
        wp_nonce_field('conference_details_nonce', 'conference_details_nonce');

        $event_id = get_post_meta($post->ID, 'event_id', true);
        $hall = get_post_meta($post->ID, 'hall', true);
        $speaker = get_post_meta($post->ID, 'speaker', true);
        $number = get_post_meta($post->ID, 'number', true);
        $start_date = get_post_meta($post->ID, 'start_date', true);
        $end_date = get_post_meta($post->ID, 'end_date', true);
        $url = get_post_meta($post->ID, 'url', true);
        $symposium = get_post_meta($post->ID, 'symposium', true);
        ?>

        <table>
            <tr>
                <th><label for="event_id">ID мероприятия:</label></th>
                <td><input type="number" name="event_id" id="event_id" value="<?php echo esc_attr($event_id); ?>"></td>
            </tr>
            <tr>
                <th><label for="hall">Зал:</label></th>
                <td><input type="number" name="hall" id="hall" value="<?php echo esc_attr($hall); ?>"></td>
            </tr>
            <tr>
                <th><label for="speaker">Докладчик:</label></th>
                <td><input type="text" name="speaker" id="speaker" value="<?php echo esc_attr($speaker); ?>"></td>
            </tr>
            <tr>
                <th><label for="number">Номер:</label></th>
                <td><input type="text" name="number" id="number" value="<?php echo esc_attr($number); ?>"></td>
            </tr>

            <tr>
                <th><label for="number">Симпозиум:</label></th>
                <td><input type="text" name="symposium" id="symposium" value="<?php echo esc_attr($symposium); ?>"></td>
            </tr>

            <tr>
                <th><label for="start_date">Дата начала:</label></th>
                <td><input type="datetime-local" name="start_date" id="start_date" value="<?php echo esc_attr($start_date); ?>"></td>
            </tr>
            <tr>
                <th><label for="end_date">Дата конца:</label></th>
                <td><input type="datetime-local" name="end_date" id="end_date" value="<?php echo esc_attr($end_date); ?>"></td>
            </tr>
            <tr>
                <th><label for="url">URL видео (Youtube):</label></th>
                <td><input type="text" name="url" id="url" value="<?php echo esc_attr($url); ?>"></td>
            </tr>
        </table>
        <?php
    }

    public function save_meta_box($post_id)
    {
        if (!isset($_POST['conference_details_nonce']) || !wp_verify_nonce($_POST['conference_details_nonce'], 'conference_details_nonce')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        $fields = array('event_id', 'hall', 'speaker', 'number', 'symposium', 'start_date', 'end_date', 'url');

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
}
