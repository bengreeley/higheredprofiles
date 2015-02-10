<?php
class ProfileInfo_Shortcodes {
	public function __construct() {
		// Shortcode Registration...
		ProfileInfo_Shortcodes::register_shortcodes();	
		
		// Hook for content output...
		add_filter( 'the_title', array( $this, 'title_classof'), 10 , 2 );		// If relevant, add clas year with profile name (students, alumni)
		add_filter( 'the_content', array( $this, 'add_profile_details') );		// If outputting content for post type, then prepend with profile information
	}
	
	public function display_profile($atts) {
		$return = '';
		
		// Extract attributes...
		extract( shortcode_atts( array(
			'count' => '1',
			'title' => '',
			'showimage' => true,
			'includeexcerpt' => false,
			'random' => true				
		), $atts, 'output-profile' ) );
		
		ob_start();

		$orderby = 'date';
			
		if( filter_var($random, FILTER_VALIDATE_BOOLEAN) === true ) {
			$orderby = 'rand';
		}
				
		if( strlen( $title )) {
			echo '<h4 class="widgettitle">'.$title.'</h4>';
		}

		$profiles = new WP_Query(array(
									'post_type' => 'profile',
									'orderby' => $orderby,
									'posts_per_page' => intval( $count )
								));

		if( $profiles->have_posts() ) {
			
			echo '<ul class="profile-list">';
			
			while ( $profiles->have_posts() ) {
				$profiles->the_post();
				
				$returnArray = $this->getProfileFields();
				$returnArray['name'] = $this->appendClassYear( $returnArray );
				
				echo '<li class="clearfix">';
				
				if( $showimage !== "false" && $showimage !== false) {
					if ( has_post_thumbnail() ) {
						echo '<a href="'. get_the_permalink() . '">';
						echo the_post_thumbnail( 'thumbnail',
									array( 'class' => 'pull-right' ));
						echo '</a>';
					}
				}

				echo '<a href="'. get_the_permalink() . '">' . '<strong class="profile-name">'.$returnArray['name'] . '</strong></a>';
				
				echo $this->getProfileMajorMinor( $returnArray['profileType'], $returnArray['major'], $returnArray['minor']);
				
				if( $includeexcerpt !== "false" && $includexcerpt !== false) {
					// Output excerpt...
					echo '<div class="profile-excerpt">'. wp_trim_words( get_the_excerpt(), 40) .'</div>';
				}
				
				echo '<a href="'.get_the_permalink().'">Full Profile&nbsp;></a>';
				
				echo '</li>';
			}
			echo '</ul>';
		}
		else {
			echo '<em>No profiles found</em>';
		}
		
		$return = ob_get_contents();
		ob_end_clean();
		return $return;	
	}
	
	public function getProfileMajorMinor( $profileType, $major, $minor ) {
		$return = '';

		if( strtolower( $profileType ) == 'student' || strtolower( $profileType ) == 'alumni' ) {
			if( strlen( $major ) || strlen( $minor )) {
				
				$return .= '<div class="profile-mm-holder">';
				
				if( strlen( $major ) ) {
					$return .= '<div class="profile-major">'. '<span>Major:</span> ' . $major . '</div>';				
				}			
				
				if( strlen( $minor ) ) {
					$return .= '<div class="profile-minor">'. '<span>Minor:</span> ' . $minor . '</div>';
				}
				
				$return .= '</div>';
			}
		}
		
		return $return;
	}
	
	public function getProfileUserTitle( $returnArray ) {
		$return = '';
		
		if( strlen( $returnArray['profileUserTitle'] )) {
			
			$return .= '<div class="profile-title-holder">';				
			$return .= $returnArray['profileUserTitle'];				
			$return .= '</div>';
		}
		
		return $return;
	}
		
	public function register_shortcodes() {		
		add_shortcode( 'output-profile', array( $this, 'display_profile') );	
		
	}
	
	/*
		If viewing a profile, output the relevant fields...
	*/
	public function add_profile_details( $content ) {
		if( get_post_type() == 'profile' && !is_admin() && is_single() ) {
			
			$returnArray = $this->getProfileFields();
			
			$content = 	$this->getProfileUserTitle($returnArray) . 
						$this->getProfileMajorMinor( $returnArray['profileType'], $returnArray['major'], $returnArray['minor']) . 
						$content;
		}
		
		return $content;
	}
	
	public function title_classof( $title, $id ) {
		
		if( get_post_type() == 'profile' && !is_admin() && $id == get_the_ID()) {
			$returnArray = $this->getProfileFields();		
			$title = $this->appendClassYear( $returnArray );
			
		}
		
		return $title;
	}
	
	/* 
		Returns array of profile fields for additional values...	
	*/
	private function getProfileFields($id = null) {
		global $post;
		
		$additionalFields = array(
						'name' => $post->post_title,
						'classYear' => get_field( 'class_year', $post->ID ),
						'profileType' => get_field( 'profile_type', $post->ID ),
						'major' => get_field( 'profile_major', $post->ID ),
						'minor' => get_field( 'minor', $post->ID ),
						'profileUserTitle' => get_field( 'profile_usertitle', $post->ID )
		);
		
		return $additionalFields;		
	}
	
	/*
		Given an array of name, class year and profile type (getProfileFields()), will append the class year to the name and return as string.
	*/
	public function appendClassYear( $returnArray ) {
		
		if( !isset($returnArray) ) {
			return '';	
		}

		if( strtolower( $returnArray['profileType'] ) == 'student' || strtolower( $returnArray['profileType'] ) == 'alumni' ) {
			// Check for class year. If class year set, append to name
			if( strlen( $returnArray['classYear'] ) ) {
				
				if(strlen($returnArray['classYear']) == 2 && is_numeric($returnArray['classYear']) ) {
					$returnArray['name'] .= " '" . $returnArray['classYear'];
				}

				if( strlen($returnArray['classYear']) >= 4 ) {
					$returnArray['name'] .= " '" . substr($returnArray['classYear'], -2);
				}				
			}	
		}
		
		return $returnArray['name'];
	}	
		
}