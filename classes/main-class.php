<?php
class MS_TEAM_MEMBERS
{
	public $meta_fields_array = array(
		[
			'field_name' => 'Position',
			'field_type' => 'text',
			'field_id' => 'memeber_position',
			'desc' => 'Add your position on the Team.',
			'placeholder' => 'Manager'
		],
		[
			'field_name' => 'Email Address',
			'field_type' => 'email',
			'field_id' => 'email',
			'desc' => 'Add your email address.',
			'placeholder' => 'info@domain.com'
		],
		[
			'field_name' => 'Phone Number',
			'field_type' => 'tel',
			'field_id' => 'phone',
			'desc' => 'Add your Phone number.',
			'placeholder' => '0123456789'
		],
		[
			'field_name' => 'Mobile Number',
			'field_type' => 'tel',
			'field_id' => 'mobile',
			'desc' => 'Add your Mobile number.',
			'placeholder' => '0123456789'
		],
		[
			'field_name' => 'Facebook',
			'field_type' => 'url',
			'field_id' => 'fb',
			'desc' => 'Add your Facebook account URL link.',
			'placeholder' => 'htps://www.Facebook.com'
		],
		[
			'field_name' => 'Twitter',
			'field_type' => 'url',
			'field_id' => 'tw',
			'desc' => 'Add your Twitter account URL link.',
			'placeholder' => 'htps://www.Twitter.com'	
		],
		[
			'field_name' => 'Instagram',
			'field_type' => 'url',
			'field_id' => 'in',
			'desc' => 'Add your Instagram account URL link.',
			'placeholder' => 'htps://www.Instagram.com'	
		],
		[
			'field_name' => 'YouTube',
			'field_type' => 'url',
			'field_id' => 'yt',
			'desc' => 'Add your YouTube account URL link.',
			'placeholder' => 'htps://www.YouTube.com'
		],
		[
			'field_name' => 'Pinterest',
			'field_type' => 'url',
			'field_id' => 'pint',
			'desc' => 'Add your Pinterest account URL link.',
			'placeholder' => 'htps://www.pinterest.com'	
		],
	);
	public $post_type_name  = "Team Member";
	public $post_taxonomy_name  = "Profile Type";
	public $post_type  = "team-member";
	public $taxonomy   = "member-category";
    public $shortcode  = "team_members";
	public $tabsshortcode  = "team_membertabs";    
    public $setting_link  = "ms_team_mebers_setting";
    public $shortcode_link  = "ms_team_mebers_shortcode";
	
	public function __construct()	
	{
		     
	}
	
	public function MS_hooks(){
		add_action( 'admin_head', array( $this, 'MS_admin_meta_fields_CSS' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'MS_add_bootstrap5' ) );
		add_action( 'init', array( $this, 'ms_register_custom_post_type' ) );
		add_action( 'add_meta_boxes', array( $this, 'ms_teammember_register_meta_box' ) );
        add_action( 'save_post', array( $this, 'ms_teammember_register_meta_box_save' ) );
		add_shortcode( $this->shortcode, array( $this, 'MS_shortcode_function' ) );
	}
	
	public function MS_add_bootstrap5()
	{
		$plugin_URL = MS_TEAMM_EDITING__URL.'inc/plugin-app.css';
        $version = filemtime( MS_TEAMM_EDITING__DIR.'inc/plugin-app.css' );
		wp_register_style( 'plguin-app_css', $plugin_URL, array(), $version, 'all' );
		wp_enqueue_style( 'plguin-app_css' );

        /*$enable_woo_theme_bootstrap5 = get_option( 'woo_theme_bootstrap5' );
        if( $enable_woo_theme_bootstrap5 == 'yes' ){
            $version = '5.3.2';
            wp_enqueue_script( 'MS_bootstrap_bundle', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/'.$version.'/js/bootstrap.bundle.min.js', array(), $version, array( 'in_footer'  => true ) );	        
            wp_register_style( 'MS_bootstrap_css', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/'.$version.'/css/bootstrap.min.css', array(), $version, 'all' );
            wp_enqueue_style( 'MS_bootstrap_css' );
        }*/
    }
	
	public function MS_admin_meta_fields_CSS()
	{
		echo "
		<style type='text/css'>
			.main_meta_box_fields table.admin_table,
			.main_meta_box_fields th,
			.main_meta_box_fields td{border: 1px solid #000000;border-collapse: collapse;}
			.main_meta_box_fields label {font-size: 0.9rem;font-weight:600;}
			.main_meta_box_fields td{padding: 5px 10px 5px 10px;}
		</style>";
	}
	
	function ms_register_custom_post_type(){
        $args = array(
            'labels'             => array(
				'name'                  => _x( $this->post_type_name, 'Post type general name', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'singular_name'         => _x( $this->post_type_name, 'Post type singular name', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'menu_name'             => _x( $this->post_type_name, 'Admin Menu text', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'name_admin_bar'        => _x( $this->post_type_name, 'Add New on Toolbar', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'add_new'               => __( 'Add New', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'add_new_item'          => __( 'Add New '.$this->post_type_name.'', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'new_item'              => __( 'New '.$this->post_type_name.'', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'edit_item'             => __( 'Edit '.$this->post_type_name.'', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'view_item'             => __( 'View '.$this->post_type_name.'', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'all_items'             => __( 'All '.$this->post_type_name.'s', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'search_items'          => __( 'Search '.$this->post_type_name.'', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'parent_item_colon'     => __( 'Parent '.$this->post_type_name.':', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'not_found'             => __( 'No '.$this->post_type_name.' found.', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'not_found_in_trash'    => __( 'No '.$this->post_type_name.' found in Trash.', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'featured_image'        => _x( ''.$this->post_type_name.' Image', '', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'set_featured_image'    => _x( 'Set '.$this->post_type_name.' image', '', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'remove_featured_image' => _x( 'Remove '.$this->post_type_name.' image', '', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'use_featured_image'    => _x( 'Use as '.$this->post_type_name.' image', '', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'archives'              => _x( ''.$this->post_type_name.' archives', '', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'insert_into_item'      => _x( 'Insert into '.$this->post_type_name.'', '', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'uploaded_to_this_item' => _x( 'Uploaded to this '.$this->post_type_name.'', '', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'filter_items_list'     => _x( 'Filter '.$this->post_type_name.' list', '', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'items_list_navigation' => _x( ''.$this->post_type_name.' list navigation', '', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'items_list'            => _x( ''.$this->post_type_name.' list', '', MS_TEAMM_SETTING_TEXT_DOMAIN ),
			),
            'description'        => ''.$this->post_type_name.' custom post type.',
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'menu_icon'          => 'dashicons-id-alt',
            'rewrite'            => array( 'slug' => $this->post_type ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 21,
            'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields', ), 
            'show_in_rest'       => true
        );          
		register_post_type( $this->post_type, $args );
        $args = array(
            'labels' => array(
				'name'              => _x( $this->post_taxonomy_name, 'taxonomy general name', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'singular_name'     => _x( $this->post_taxonomy_name, 'taxonomy singular name', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'search_items'      => __( 'Search '.$this->post_taxonomy_name.'', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'all_items'         => __( 'All '.$this->post_taxonomy_name.'s', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'view_item'         => __( 'View '.$this->post_taxonomy_name.'', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'parent_item'       => __( 'Parent '.$this->post_taxonomy_name.'', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'parent_item_colon' => __( 'Parent '.$this->post_taxonomy_name.':', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'edit_item'         => __( 'Edit '.$this->post_taxonomy_name.'', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'update_item'       => __( 'Update '.$this->post_taxonomy_name.'', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'add_new_item'      => __( 'Add New '.$this->post_taxonomy_name.'', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'new_item_name'     => __( 'New '.$this->post_taxonomy_name.' Name', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'not_found'         => __( 'No '.$this->post_taxonomy_name.' Found', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'back_to_items'     => __( 'Back to '.$this->post_taxonomy_name.'', MS_TEAMM_SETTING_TEXT_DOMAIN ),
				'menu_name'         => __( $this->post_taxonomy_name, MS_TEAMM_SETTING_TEXT_DOMAIN ),
			),
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => $this->taxonomy ),
            'show_in_rest'      => true,
        );    
        register_taxonomy( $this->taxonomy, $this->post_type, $args );
        flush_rewrite_rules();  
    }	
	public function ms_teammember_register_meta_box()
	{
		add_meta_box( 
            'team_member_extra', 
            __( 'Team Member Extra Fields', '' ), 
            [ $this, 'MS_callback_function' ], 
            $this->post_type , 
            'advanced', 
            'default',
        );
	}
	
	public function MS_callback_function( $post )
	{
		?>
		<div class="main_meta_box_fields">
			<table class="admin_table" style="width:100%">
				<tbody>
					<?php foreach( $this->meta_fields_array as $k => $vlaue ):
					get_post_meta( $post->ID, $vlaue['field_id'], true );?>
					<tr>
						<td style="width:22%;"><label for="<?php echo $vlaue['field_id'];?>" title="<?php echo $vlaue['desc'];?>"><?php echo $vlaue['field_name'];?></label></td>
						<td><input type="<?php echo $vlaue['field_type'];?>" id="<?php echo $vlaue['field_id'];?>" name="team_<?php echo $vlaue['field_id'];?>" value="<?php echo ( get_post_meta( $post->ID, 'team_'.$vlaue['field_id'], true ) ) != '' ? get_post_meta( $post->ID, 'team_'.$vlaue['field_id'], true ) : '';?>" placeholder="<?php echo $vlaue['placeholder'];?>" style="width: 100%;"></td>
					</tr>
					<?php endforeach;?>
				</tbody>
			</table>
		</div>
		<?php 
	}	
	public function ms_teammember_register_meta_box_save( $post_id )
	{
		foreach( $this->meta_fields_array as $k => $vlaue ){
			$save_value = 'team_'.$vlaue['field_id'];
			if ( isset( $_POST[ $save_value ] ) )
				update_post_meta( $post_id, $save_value, $_POST[ $save_value ] );
		}
	}		
	
	public function MS_shortcode_function( $args )
	{
		$options = array( 'post_type' => $this->post_type, 'posts_per_page' => 9 );
		if(isset($args['profile']) && $args['profile'] != ""){
			$options['tax_query'] = array(
				array(
					'taxonomy' => $this->taxonomy,
					'terms' => $args['profile'],
					'field' => 'slug',
					'operator' => 'IN'
				)
			);
		};
		$html = '';	
		$id = get_the_ID();
		$query = new WP_Query( $options );
		if($query->have_posts()):
		$html = '<div class="overflow-hidden"><div class="row justify-content-center">';
		while ($query->have_posts()): $query->the_post(); global $post;
		//var_dump( $post );
		$team_post_title = get_the_title();
		$team_post_content = get_the_content();
		$img_class = 'rounded-circle mx-auto d-inline-block shadow-sm';
		$img_demo = MS_TEAMM_EDITING__URL.'inc/img/avatar.png';
		$member_img = get_the_post_thumbnail_url( $post->ID, 'thumbnail' );
		$team_memeber_position = get_field( 'team_memeber_position' );
		$team_email = get_field( 'team_email' );
		$team_phone = get_field( 'team_phone' );
		$team_mobile = get_field( 'team_mobile' );
		$team_fb = get_field( 'team_fb' );
		$team_tw = get_field( 'team_tw' );
		$team_in = get_field( 'team_in' );
		$team_yt = get_field( 'team_yt' );
		$team_pint = get_field( 'team_pint' );
		$html .= '		
		<div class="col-md-4">
		<div class="card border-0 shadow-lg pt-5 my-5 position-relative">
		<div class="card-body p-4">
		<div class="member-profile position-absolute w-100 text-center">';		
		if( has_post_thumbnail() ):
		$html .= '<img class="'.$img_class.'" src="'.$member_img.'" alt="'.$team_post_title.'">';
		else:
		$html .= '<img class="'.$img_class.'" src="'.$img_demo.'" alt="'.$team_post_title.'">';
		endif;
		$html .= '</div><div class="card-text pt-1"><h5 class="member-name mb-0 text-center text-primary font-weight-bold">'.$team_post_title.'</h5>';
		if( !empty( $team_memeber_position ) ):
		$html .= '<div class="mb-3 text-center">'.$team_memeber_position.'</div>';
		endif;
		$html .= '<div>'.$team_post_content.'</div>
		</div>
		</div>
		<div class="card-footer theme-bg-primary border-0 text-center">';
		if( ( !empty( $team_email ) ) || ( !empty( $team_mobile ) ) || ( !empty( $team_phone ) ) || ( !empty( $team_fb ) ) || ( !empty( $team_tw ) ) || ( !empty( $team_yt ) ) || ( !empty( $team_in ) ) || ( !empty( $team_pint ) ) ):
		$html .= '<ul class="social-list list-inline mb-0 mx-auto">';
		if( !empty( $team_email ) ):
		$html .= '	<li class="list-inline-item">
			<a class="text-dark" href="mailto:'.$team_email.'" target="_blank"><i class="fa-solid fa-envelope"></i></a>
		</li>';
		endif;if( !empty( $team_mobile ) ):
		$html .= '	<li class="list-inline-item">
			<a class="text-dark" href="tel:'.$team_mobile.'" target="_blank"><i class="fa-solid fa-mobile-screen"></i></a>
		</li>';
		endif;if( !empty( $team_phone ) ):
		$html .= '<li class="list-inline-item">
			<a class="text-dark" href="tel:'.$team_phone.'" target="_blank"><i class="fa-solid fa-phone"></i></a>
		</li>';
		endif;if( !empty( $team_fb ) ):
		$html .= '<li class="list-inline-item">
			<a class="text-dark" href="'.$team_fb.'" target="_blank"><i class="fa-brands fa-square-facebook"></i></a>
		</li>';
		endif;if( !empty( $team_tw ) ):
		$html .= '<li class="list-inline-item">
			<a class="text-dark" href="'.$team_tw.'" target="_blank"><i class="fa-brands fa-square-twitter"></i></a>
		</li>';
		endif;if( !empty( $team_yt ) ):
		$html .= '<li class="list-inline-item">
			<a class="text-dark" href="'.$team_yt.'" target="_blank"><i class="fa-brands fa-youtube"></i></a>
		</li>';
		endif;if( !empty( $team_in ) ):
		$html .= '<li class="list-inline-item">
			<a class="text-dark" href="'.$team_in.'" target="_blank"><i class="fa-brands fa-square-instagram"></i></a>
		</li>';
		endif;if( !empty( $team_pint ) ):
		$html .= '<li class="list-inline-item">
			<a class="text-dark" href="'.$team_pint.'" target="_blank"><i class="fa-brands fa-square-pinterest"></i></a>
		</li>';
		endif;
		$html .= '</ul>';
		endif;
		$html .= '</div>
		</div>
		</div>';
		endwhile;
		$html .= '</div></div>';
		else:
		$html .= '<p>Coming Soon...</p>';
		endif;
		$html .= '<div class="text-center">'.bootstrap_pagination($query, false).'</div>';
		wp_reset_postdata();
		return $html;
	}
}