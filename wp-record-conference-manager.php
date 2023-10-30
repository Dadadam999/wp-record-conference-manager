<?php
/*
Plugin Name: WP Record Conference Manager
Description: Plugin for managing conference records in WordPress.
Version: 1.0
Author: Bogdanov Andrey
*/

if (!defined('ABSPATH'))
    exit;

require_once( plugin_dir_path(__FILE__) . 'autoload.php' );

use rcm\RcmPostType;
use rcm\MetaBox;
use rcm\RecordShortcode;
use rcm\RcmImport;

$argsType = [
   'name' => 'rcm_conference',
   'title' => 'Записи конференций',
   'icon' => 'dashicons-calendar-alt',
   'role' => 'manage_options',
   'supports' => [ 'title', 'page-attributes' ],
   'position' => 9
];


$post_type = new RcmPostType( $argsType );
$meta_box = new MetaBox();

$argsImport = [
   'slug' => 'rcm_import',
   'title' => 'Импорт мероприятий',
   'role' => 'manage_options',
   'url' => $post_type->getUrl(),
];

$import = new RcmImport( $argsImport );
$shortcode = new RecordShortcode();

add_action('wp_enqueue_scripts', function()
{
    wp_enqueue_style( 'rcm-styles', str_replace( '/', DIRECTORY_SEPARATOR, plugins_url('wp-record-conference-manager/css/styles.css') ) );
});
