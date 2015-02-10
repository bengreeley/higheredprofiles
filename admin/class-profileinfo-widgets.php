<?php
/*
	Widgets for Profile plugin
	---------------------------------
	Description: Displays widget on a sidebar. Will retrieve a certain number of profiles and will randomize or show most recent.
	Author: Ben Greeley (bgreeley@colby.edu)	
*/
class ProfileInfo_Widget extends WP_Widget {

	function __construct() {
		
		
		parent::__construct(
			'ProfileInfo_widget', // Base ID
			'Profile', // Name
			array( 'description' => __( 'Displays profiles in a widgetized area', 'text_domain' ) )
		);
	}
	
	/* Widget front-end display... */
	public function widget( $args, $instance ) {
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		$count = $instance['count'];
		$showimage = $instance['showimage'];
		$includeexcerpt = $instance['includeexcerpt'];
		$random = $instance['random'];

		if($count<0 || !is_numeric($count))
			$count = 1;
		
		echo $args['before_widget'];
		
		echo do_shortcode('[output-profile count='.$count.' title="'.$title.'" showimage="'.$showimage.'" includeexcerpt="'.$includeexcerpt.'" random="'.$random.'"]');
		
		echo $args['after_widget'];
		
	}

	// Back-end Widget form...
	public function form( $instance ) {
		
		$defaults = array(
							'count' => '1',
							'random' => true,
							'includeexcerpt' => true,
							'showimage' => true,
							'title' => 'Profiles');
		
		$instance = wp_parse_args((array) $instance,$defaults);
		
		if (isset( $instance[ 'count' ] ) ) {
			$count = $instance[ 'count' ];
		}
		else {
			$count = 1;
		}
		
		if (isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = '';
		}
		?>
		<p>
		
		<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		<br />
		
		<label for="<?php echo $this->get_field_name( 'count' ); ?>"><?php _e( 'Limit:' ); ?></label> 		
		<select id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" class="widefat">
				<?php for($i=1;$i<10;$i++){?>
				<option <?php if ( $i == $instance['count'] ) echo 'selected="selected"'; ?>><?php echo $i;?></option>
				<?php
				}?>
		</select>
		
		<input class="checkbox" type="checkbox" <?php checked($instance['includeexcerpt'], true) ?> id="<?php echo $this->get_field_id('includeexcerpt'); ?>" name="<?php echo $this->get_field_name('includeexcerpt'); ?>" /> 
		<label for="<?php echo $this->get_field_id('includeexcerpt'); ?>"><?php _e(' Include Excerpt'); ?></label><br />
		
		<input class="checkbox" type="checkbox" <?php checked($instance['random'], true) ?> id="<?php echo $this->get_field_id('random'); ?>" name="<?php echo $this->get_field_name('random'); ?>" /> 
		<label for="<?php echo $this->get_field_id('random'); ?>"><?php _e(' Randomize results'); ?></label><br />

		
		<input class="checkbox" type="checkbox" <?php checked($instance['showimage'], "true") ?> id="<?php echo $this->get_field_id('showimage'); ?>" name="<?php echo $this->get_field_name('showimage'); ?>" /> 
		<label for="<?php echo $this->get_field_id('showimage'); ?>"><?php _e(' Show Image'); ?></label>		
		
		</p>
		<?php 
	}

	// Widget update...
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';
		$instance['includeexcerpt'] = $new_instance['includeexcerpt']!="";
		$instance['random'] = $new_instance['random'] != "";
		$instance['showimage'] = ($new_instance['showimage'] != "" ? 'true':'false');
		
		return $instance;
	}
	
	// Registration...
	public function register_profileinfo_widget() {		
		register_widget( 'ProfileInfo_Widget' );
	}
}
?>