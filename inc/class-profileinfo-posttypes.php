<?php
/**
* ProfileInfo PostTypes Class
*/
class ProfileInfo_PostTypes {
	public function __construct() {
		add_action( 'init', array($this, 'create_profile_posttype' ));
		add_action( 'init', array($this, 'create_profile_fields' ));
	}
	
	public function create_profile_posttype() {
		if( !post_type_exists('profile') ) {
			register_post_type( 'profile',
				array(
					'labels' => array(
						'name' => __( 'Profiles' ),
						'singular_name' => __( 'Profile' ),
						'add_new_item'  => __( 'Add New Profile', 'profileinfo' ),
						'edit_item'          => __( 'Edit Profile', 'your-plugin-textdomain' ),
						'view_item'          => __( 'View Profile', 'your-plugin-textdomain' ),
					),
					'public' => true,
					'has_archive' => true,
					'menu_icon' => 'dashicons-id-alt',
					'rewrite' => array('slug' => 'profiles'),
					'supports' => array(
										'thumbnail',
										'revisions',
										'editor',
										'title'
									)
				)
			);
		}
	}
	
	public function create_profile_fields() {
		if( function_exists('register_field_group') ):
			register_field_group(array (
				'key' => 'group_54b697cac2492',
				'title' => 'Additional Profile Information',
				'fields' => array (
					array (
						'key' => 'field_54b69804fa015',
						'label' => 'Profile Type',
						'name' => 'profile_type',
						'prefix' => '',
						'type' => 'select',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => 0,
						'choices' => array (
							'Alumni' => 'Alumni',
							'Student' => 'Student',
							'Faculty' => 'Faculty',
							'Staff' => 'Staff',
						),
						'default_value' => array (
							'Student'
						),
						'allow_null' => 0,
						'multiple' => 0,
						'ui' => 0,
						'ajax' => 0,
						'placeholder' => '',
						'disabled' => 0,
						'readonly' => 0,
					),
					array (
						'key' => 'field_54bff3a5d7282',
						'label' => 'Title',
						'name' => 'profile_usertitle',
						'prefix' => '',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
						'readonly' => 0,
						'disabled' => 0,
					),
					array (
						'key' => 'field_54b697d7fa013',
						'label' => 'Class Year',
						'name' => 'class_year',
						'prefix' => '',
						'type' => 'text',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_54b69804fa015',
									'operator' => '==',
									'value' => 'Alumni',
								),
							),
							array (
								array (
									'field' => 'field_54b69804fa015',
									'operator' => '==',
									'value' => 'Student',
								),
							),
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
						'readonly' => 0,
						'disabled' => 0,
					),
					array (
						'key' => 'field_54b697effa014',
						'label' => 'Major',
						'name' => 'profile_major',
						'prefix' => '',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_54b69804fa015',
									'operator' => '==',
									'value' => 'Alumni',
								),
							),
							array (
								array (
									'field' => 'field_54b69804fa015',
									'operator' => '==',
									'value' => 'Student',
								),
							),
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
						'readonly' => 0,
						'disabled' => 0,
					),
					array (
						'key' => 'field_54bfd514e8dc2',
						'label' => 'Minor',
						'name' => 'profile_minor',
						'prefix' => '',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array (
							array (
								array (
									'field' => 'field_54b69804fa015',
									'operator' => '==',
									'value' => 'Alumni',
								),
							),
							array (
								array (
									'field' => 'field_54b69804fa015',
									'operator' => '==',
									'value' => 'Student',
								),
							),
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
						'readonly' => 0,
						'disabled' => 0,
					),
				),
				'location' => array (
					array (
						array (
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'profile',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'acf_after_title',
				'style' => 'seamless',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
			));
			
			endif;
	}
}