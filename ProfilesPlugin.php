<?php
	
/*
 * Plugin Name:       Highered Profiles - Student/Faculty/Staff/Alumni Profile functionality
 * Plugin URI:        http://www.bengreeley.com/menufromsite
 * Description:       Allows users to create profiles with name, associated information and headshot and output in lists, shortcode or widgets.
 * Version:           1.0.0
 * Author:            Ben Greeley
 * Author URI:        http://www.bengreeley.com
 */
 
 /*  
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

function activate_profileinfo() {
	require_once plugin_dir_path( __FILE__ ) . 'inc/class-profileinfo-activator.php';
	ProfileInfo_Activator::activate();
}

register_activation_hook( __FILE__, 'activate_profileinfo' );

function deactivate_profileinfo() {
	require_once plugin_dir_path( __FILE__ ) . 'inc/class-profileinfo-deactivator.php';
	ProfileInfo_Deactivator::deactivate();
}

register_deactivation_hook( __FILE__, 'deactivate_profileinfo' );

require plugin_dir_path( __FILE__) . 'inc/class-profileinfo.php';

new ProfileInfo();