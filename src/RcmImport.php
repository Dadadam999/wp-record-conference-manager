<?php

namespace rcm;

class RcmImport
{
      private $args = [
         'slug' => '',
         'title' => '',
         'role' => '',
         'url' => '',
      ];

      private $nonce = [
        'action' => 'rcmImportFileNonce-action',
        'name' => 'rcmImportFileNonce',
      ];

      public function __construct( $args )
      {
          $this->args = $args;

          add_action('admin_menu', function()
          {
              add_submenu_page(
                  $this->args['url'],
                  $this->args['title'],
                  $this->args['title'],
                  $this->args['role'],
                  $this->args['slug'],
                  array($this, 'render')
              );
          });

          $this->callback();
      }

      function render()
      {
          ob_start();
          include str_replace( '/', DIRECTORY_SEPARATOR, WP_PLUGIN_DIR . '/wp-record-conference-manager/src/Template/RcmImportView.php' );
          echo ob_get_clean();
      }

      private function callback()
      {
          add_action('plugins_loaded', function()
          {
              if( !isset( $_POST[ $this->nonce[ 'name' ] ] ) || !isset( $_FILES['rcm-import-file'] ) )
                  return;


              $file = $_FILES['rcm-import-file']['tmp_name'];

              if ( $file )
              {
                  $handle = fopen( $file, 'r' );

                  if ( $handle )
                  {
                      try
                      {
                          $delimiter = ';'; // Указываем разделитель
                          $headers = array_map( 'sanitize_key', fgetcsv( $handle, 0, $delimiter ) ); // Указываем разделитель

                          while ( ( $data = fgetcsv( $handle, 0, $delimiter ) ) !== false )
                          {
                              $post_data = array_combine( $headers, $data );

                              $post_id = wp_insert_post( array(
                                  'post_title' => $post_data[ 'title' ],
                                  'post_type' => 'rcm_conference',
                                  'post_status' => 'publish',
                              ));

                              update_post_meta( $post_id, 'event_id', $post_data[ 'event_id' ] );
                              update_post_meta( $post_id, 'hall', $post_data[ 'hall' ] );
                              update_post_meta( $post_id, 'speaker', $post_data[ 'speaker' ] );
                              update_post_meta( $post_id, 'number', $post_data[ 'number' ] );
                              update_post_meta( $post_id, 'start_date', $post_data[ 'start_date' ] );
                              update_post_meta( $post_id, 'end_date', $post_data[ 'end_date' ] );
                              update_post_meta( $post_id, 'url', $post_data[ 'url' ] );
                              update_post_meta( $post_id, 'symposium', $post_data[ 'symposium' ] );
                          }

                          fclose( $handle );
                          echo 'Импорт успешен';
                      }
                      catch( Exception $e )
                      {
                          echo 'Error ' . $e;
                          return;
                      }
                  }
              }
          });
      }
}
