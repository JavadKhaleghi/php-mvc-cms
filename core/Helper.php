<?php

namespace Core;

class Helper
{
    public static function dd($data = [], $die = true)
    {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";

        if($die) {
            die;
        }
    }

    public static function isCurrentPage($page)
    {
        global $url;
        
        if(! empty($page) && strpos($page, ':id') > -1) {
            $test = str_replace(':id', '', $page);

            return strpos($url, $page) > -1;
        }

        return $page == $url;
    }

    public static function menuActiveClass($page, $class = '')
    {
        $activeMenu = self::isCurrentPage($page);

        return $activeMenu ? $class . ' active' : $class;
    }

    public static function menuItem($path, $label, $dropDown = false)
    {
        $activeMenu = self::isCurrentPage($path);
        $activeClass = self::menuActiveClass($path, 'nav-item');
        $linkClass = $dropDown ? 'dropdown-item' : 'nav-link';
        $linkClass .= $activeClass && $dropDown ? ' active' : '';
        $path = ROOT . $path;
        $html = "<li class=\"{$activeClass}\">";
        $html .= "<a class=\"{$linkClass}\" href=\"{$path}\">{$label}</a>";
        $html .= "</li>";

        return $html;
    }
}