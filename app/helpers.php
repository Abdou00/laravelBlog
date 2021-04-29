<?php
    use Illuminate\Support\Facades\Route;

    if (!function_exists('currentRouteActive')) {
        function currentRouteActive(...$routes): string
        {
            foreach ($routes as $route) {
                if(Route::currentRouteName($route)) return 'active';
            }
        }
    }

    if (!function_exists('currentChildActive')) {
        function currentChildActive($children): string
        {
            foreach ($children as $child) {
                if(Route::currentRouteName($child['route'])) return 'active';
            }
        }
    }

    if (!function_exists('menuOpen')) {
        function menuOpen($children): string
        {
            foreach ($children as $child) {
                if(Route::currentRouteName($child['route'])) return 'menu-open';
            }
        }
    }

    if (!function_exists('isRole')) {
        function isRole($role): string
        {
            return auth()->user()->role === $role;
        }
    }

    if (!function_exists('getImage')) {
        function getImage($post, $thumbs = false): string
        {
            $url = "storage/photos/{$post->user_id}";

            if ($thumbs) $url .= '/thumbs';

            return asset('{$url}/{$post->image}');
        }
    }

    if (!function_exists('currentRoute')) {
        function currentRoute($route): string
        {
            return Route::currentRouteName($route) ? ' class=current' : '';
        }
    }

    if (!function_exists('formatDate')) {
        function formatDate($date) {
            return ucfirst(utf8_encode($date->formatLocalized('%d %B %Y')));
        }
    }
