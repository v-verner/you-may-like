<?php
/*
 Plugin Name:   You May Like
 Plugin URI:    https://vverner.com/you-may-like
 Description:   A simple plugin that recommends content based on previous user views. For more information about the plugin, visit <a href="https://vverner.com/plugin-para-recomendacao-de-posts-you-may-like/" target="_blank">this link.</a>.
 Author:        VVerner
 Version:       1
 Author URI:    https://vverner.com
 License:       GPL v2 or later
 License URI:   https://www.gnu.org/licenses/gpl-2.0.html
 Text Domain:   you-may-like
 Domain Path:   /languages

 You May Like is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 2 of the License, or
 any later version.

 You May Like is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with You May Like. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 */


define( 'YML_PATH', plugin_dir_path( __FILE__ ) );
define( 'YML_URL', plugin_dir_url( __FILE__ ) );


include(YML_PATH . "/admin/yml-admin.php");

include(YML_PATH . "/public/yml-public.php");
include(YML_PATH . "/public/yml-shortcodes.php");