<?php 
class MS_PLUGIN_SETTINGS extends MS_TEAM_MEMBERS
{
	public $setting_arr = array(		
		[
			'field_name' => 'Bootstrap 5',
			'field_id' => 'bs5',
			'field_type' => 'checkbox',
			'field_desc' => 'If your theme is not using Bootstrap 5, you can enable from here.',
			'field_css' => ''
		],
		[
			'field_name' => 'Heading Font Size',
			'field_id' => 'heading_fs',
			'field_type' => 'number',
			'field_desc' => 'Heading font size in pixels, the default value is "18px".',
			'field_css' => 'width:50px;'
		],
		[
			'field_name' => 'Heading Color',
			'field_id' => 'heading_clr',
			'field_type' => 'color',
			'field_desc' => 'Heading color for the card, the default color is BLACK.',
			'field_css' => ''
		],
		[
			'field_name' => 'Icons Font Size',
			'field_id' => 'icons_fs',
			'field_type' => 'number',
			'field_desc' => 'Icons font size in pixels, the default value is "15px".',
			'field_css' => 'width:50px;'
		],
		[
			'field_name' => 'Icons Color',
			'field_id' => 'icons_clr',
			'field_type' => 'color',
			'field_desc' => 'Heading color for the card, the default color is BLACK.',
			'field_css' => ''
		],
		
	);

    public function __construct()
    {        
		// Empty...
    }

    public function ms_setting_hooks()
    {
        add_action( 'admin_menu', array( $this, 'ms_admin_menu_page') );
		add_action( 'admin_init', array( $this, 'ms_settings_init' ) );
    }
    public function ms_admin_menu_page()
	{
		add_submenu_page(
			'edit.php?post_type='.$this->post_type.'',
			$this->setting_link, 
			'Settings',
			'manage_options', 
			$this->setting_link, 
			[$this, 'MS_plugin_setting_page'],
			5
		);
		add_submenu_page(
			'edit.php?post_type='.$this->post_type.'',
			$this->shortcode_link,
			'Shortcodes', 
			'manage_options',
			$this->shortcode_link, 
			[$this, 'MS_plugin_shortcode_page'],
			6
		);
	}
	
	public function MS_plugin_shortcode_page()
	{
		require_once plugin_dir_path( __FILE__ ) . '../inc/plugin-shortcodes.php';
	}

	public function ms_settings_init()
	{
		foreach( $this->setting_arr as $k => $value ):
			register_setting( $this->setting_link, 'ms_'.$value['field_id'] );
		endforeach;
	}
	public function MS_plugin_setting_page()
	{
		if ( isset( $_GET['settings-updated'] ) ) {
			add_settings_error( 'ms_error_messages', 'ms_error_messages', __( 'Team Members Plugin Settings Saved.', $this->setting_link ), 'updated' );
		}
		settings_errors( 'ms_error_messages' );
		?>
		<div id="MS-plugin" class="wrap">
			<h1><?php esc_html_e( 'Welcome to my custom admin page.', MS_TEAMM_SETTING_TEXT_DOMAIN ); ?></h1>
			<strong>Please check the below custom CSS for setting related to the plugin. You can check description on hover the setting title.</strong>
			<form method="POST" action="options.php">
				<?php settings_fields( $this->setting_link );
				do_settings_sections( $this->setting_link );?>
				<table style="width: 100%;text-align: left;margin-top:2rem;">
					<tboday>
						<?php foreach( $this->setting_arr as $k => $value ):
						$MS_option = get_option( 'ms_'.$value['field_id'] );?>
						<tr>
							<th style="width:15%;padding-bottom: 10px;"><label for="<?php echo 'ms_'.$value['field_id'];?>" title="<?php echo $value['field_desc'];?>"><?php _e( $value['field_name'], MS_TEAMM_SETTING_TEXT_DOMAIN ); ?></label></th>
							<td style="padding-bottom: 10px;">
								<?php if( $value['field_type'] == 'checkbox' ):?>
								<label class="switch">
									<input type="<?php echo $value['field_type'];?>" id="<?php echo 'ms_'.$value['field_id'];?>" name="<?php echo 'ms_'.$value['field_id'];?>[]" value="yes" style="<?php echo $value['field_css']?>" <?php echo is_array( $MS_option ) ? 'checked' : '' ;?> />
									<span class="slider round"></span>
								</label>
								<?php elseif( $value['field_type'] == 'number' ):?>						
									<input type="<?php echo $value['field_type'];?>" id="<?php echo 'ms_'.$value['field_id'];?>" name="<?php echo 'ms_'.$value['field_id'];?>" value="<?php echo isset( $MS_option ) != '' ? $MS_option : '';?>" style="<?php echo $value['field_css']?>" min="10" max="100" />
								<?php else:?>								
									<input type="<?php echo $value['field_type'];?>" id="<?php echo 'ms_'.$value['field_id'];?>" name="<?php echo 'ms_'.$value['field_id'];?>" value="<?php echo isset( $MS_option ) != '' ? $MS_option : '';?>" style="<?php echo $value['field_css']?>" />
								<?php endif;?>
							</td>
						</tr>
						<?php endforeach;?>
					</tboday>
				</table>
				<?php submit_button( 'Submit Settings' );?>
			</form>
		</div>
		<?php
	}
}
$obj = new MS_PLUGIN_SETTINGS;
$obj->ms_setting_hooks();