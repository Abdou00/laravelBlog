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
