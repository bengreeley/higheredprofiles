<?php

class ProfileInfo {
	protected $loader;
	protected $plugin_name;
	protected $version;

	public function __construct() {
		$this->plugin_name = 'profileinfo';
		$this->version = '1.0.0';
		
		$this->define_admin_hooks();		
		$this->define_public_hooks();
	}

	private function define_admin_hooks() {
		// Widgets...
		require_once plugin_dir_path( __FILE__ ) . '../admin/class-profileinfo-widgets.php';
		$ProfileInfoWidget = new ProfileInfo_Widget();
		add_action( 'widgets_init', array($ProfileInfoWidget, 'register_profileinfo_widget') );
	}

	private function define_public_hooks() {
		// CSS...
		wp_register_style( 'profilecss', plugins_url('../css/profileinfo.css',__FILE__));	
		wp_enqueue_style('profilecss');
				
		// Post type and fields...
		require_once plugin_dir_path( __FILE__ ) . 'class-profileinfo-posttypes.php';
		new ProfileInfo_PostTypes();
		
		// Shortcodes and display...
		require_once plugin_dir_path( __FILE__ ) . '../public/class-profileinfo-shortcodes.php';
		new ProfileInfo_Shortcodes();
		
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_version() {
		return $this->version;
	}
	
	
	
}