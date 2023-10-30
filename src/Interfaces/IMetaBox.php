<?php
namespace rcm\Interfaces;

interface IMetaBox
{
    public function add( $name, $title, $type, $size, $position );
    public function callback( $post );
    public function save( $post_id );
}
