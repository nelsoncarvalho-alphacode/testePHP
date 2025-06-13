<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Request;

class SortableLink
{
    public static function render($field, $title)
    {
        $direction = Request::input('direction');
        $current = Request::input('order');
        
        $newDirection = ($current == $field && $direction == 'asc') ? 'desc' : 'asc';
        $icon = ($current == $field) ? ($direction == 'asc' ? '↑' : '↓') : '';
        
        $query = Request::except(['order', 'direction']);
        $query['order'] = $field;
        $query['direction'] = $newDirection;
        
        $url = url()->current() . '?' . http_build_query($query);
        
        return "<a href='$url'>$title $icon</a>";
    }
}