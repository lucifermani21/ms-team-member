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
		while ($query->have_posts()): $query->the_post();
		$team_post_title = get_the_title();
		$team_post_position = get_the_title();
		$team_post_content = get_the_content();
		$img_class = 'rounded-circle mx-auto d-inline-block shadow-sm';
		$img_demo = MS_TEAMM_EDITING__URL.'inc/img/avatar.png';
		$tema_post_img = get_the_post_thumbnail( 'full', [ 'class' => $img_class, 'alt' => $team_post_title ] );
		$html .= '		
		<div class="col-md-4">
		<div class="card border-0 shadow-lg pt-5 my-5 position-relative">
		<div class="card-body p-4">
		<div class="member-profile position-absolute w-100 text-center">';		
		if( has_post_thumbnail() ):
			$tema_post_img;
		else:
		$html .= '<img class="'.$img_class.'" src="'.$img_demo.'" alt="'.$team_post_title.'">';
		endif;
		$html .= '</div>
		<div class="card-text pt-1">
		<h5 class="member-name mb-0 text-center text-primary font-weight-bold">'.$team_post_title.'</h5>
		<div class="mb-3 text-center">'.$team_post_position.'</div>
		<div>'.$team_post_content.'</div>
		</div>
		</div>
		<div class="card-footer theme-bg-primary border-0 text-center">
		<ul class="social-list list-inline mb-0 mx-auto">
			<li class="list-inline-item"><a class="text-dark" href="#"><svg class="svg-inline--fa fa-linkedin-in fa-w-14 fa-fw" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="linkedin-in" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"></path></svg><!-- <i class="fab fa-linkedin-in fa-fw"></i> Font Awesome fontawesome.com --></a></li>
			<li class="list-inline-item"><a class="text-dark" href="#"><svg class="svg-inline--fa fa-twitter fa-w-16 fa-fw" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="twitter" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path></svg><!-- <i class="fab fa-twitter fa-fw"></i> Font Awesome fontawesome.com --></a></li>
			<li class="list-inline-item"><a class="text-dark" href="#"><svg class="svg-inline--fa fa-medium fa-w-14 fa-fw" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="medium" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M0 32v448h448V32H0zm372.2 106.1l-24 23c-2.1 1.6-3.1 4.2-2.7 6.7v169.3c-.4 2.6.6 5.2 2.7 6.7l23.5 23v5.1h-118V367l24.3-23.6c2.4-2.4 2.4-3.1 2.4-6.7V199.8l-67.6 171.6h-9.1L125 199.8v115c-.7 4.8 1 9.7 4.4 13.2l31.6 38.3v5.1H71.2v-5.1l31.6-38.3c3.4-3.5 4.9-8.4 4.1-13.2v-133c.4-3.7-1-7.3-3.8-9.8L75 138.1V133h87.3l67.4 148L289 133.1h83.2v5z"></path></svg><!-- <i class="fab fa-medium fa-fw"></i> Font Awesome fontawesome.com --></a></li>
		</ul>
		</div>
		</div>
		</div>		
		';
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