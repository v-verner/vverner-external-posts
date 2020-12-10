<?php defined('ABSPATH') || exit('No direct script access allowed');

class ExternalPostsShortcode
{
    public $ID;

    private const META = [
        'style'     => 'text',
        'per_page'  => 'int',
        'col_lg'    => 'int',
        'col_sm'    => 'int',
        'classes'   => 'text',
        'display'   => 'text',
    ];

    public function __construct(int $id)
    {
        $this->ID = $id;
    }

    public function __get(string $prop)
    {
        $meta = get_post_meta($this->ID, 'vvep-' . $prop, true);
        return ($meta) ? $meta : null;
    }

    public function __set(string $prop, $value)
    {
        update_post_meta($this->ID, 'vvep-' . $prop, $value);
    }

    public function __toString()
    {
        $code = '[vvep-grid id="'. $this->ID .'"]';
        return $code;
    }
}