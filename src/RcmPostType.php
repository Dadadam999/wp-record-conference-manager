<?php
namespace rcm;

class RcmPostType
{
    private $args = [
       'name' => '',
       'title' => '',
       'icon' => '',
       'role' => '',
       'supports' => [],
       'position' => 0
    ];

    private $url;

    public function __construct( $args )
    {
        $this->args = $args;
        $this->url = '/edit.php?post_type=' . $this->args['name'];
        $this->initType();
        $this->initMenu();
    }

    public function getUrl() : string
    {
       return $this->url;
    }

    private function initType()
    {
        add_action('init', function()
        {
           register_post_type(
                $this->args['name'],
                [
                    'public' => true,
                    'label'  => $this->args['title'],
                    'menu_icon' => $this->args['icon'],
                    'supports' => $this->args['supports'],
                    'show_in_menu' => $this->url,
                    'menu_position' => $this->args['position']
                ]
            );
        });
    }

    private function initMenu()
    {
        add_action('admin_menu', function()
        {
            add_menu_page(
                $this->args['title'],
                $this->args['title'],
                $this->args['role'],
                $this->url,
                '',
                $this->args['icon'],
                $this->args['position']
            );
        });
    }
}
