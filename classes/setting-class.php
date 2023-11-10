<?php 
class MS_PLUGIN_SETTINGS extends MS_TEAM_MEMBERS
{
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
				array( 
					$this, 'MS_plugin_setting_page'
				),
			5
		);
		add_submenu_page(
			'edit.php?post_type='.$this->post_type.'',
			$this->shortcode_link,
			'Shortcodes', 
			'manage_options',
			$this->shortcode_link, 
				array( 
					$this, 'MS_plugin_shortcode_page'
				),
			6
		);
	}

	public function ms_settings_init()
	{
		add_settings_section(
			'sample_page_setting_section',
			__( 'Custom settings', MS_TEAMM_SETTING_TEXT_DOMAIN ),
			'',
			$this->setting_link
		);
		add_settings_field(
			'my_setting_field',
			__( 'My custom setting field', MS_TEAMM_SETTING_TEXT_DOMAIN ),
			[ $this, 'my_setting_markup' ],
			$this->setting_link,
			'sample_page_setting_section'
		);
		register_setting( $this->setting_link, 'my_setting_field' );
	}

	function my_setting_markup() {
		?>
		<label for="my_setting_field"><?php _e( 'My Input', MS_TEAMM_SETTING_TEXT_DOMAIN ); ?></label>
		<input type="checkbox" id="my_setting_field" name="my_setting_field">
		<?php
	}

	public function MS_plugin_setting_page()
	{
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Welcome to my custom admin page.', MS_TEAMM_SETTING_TEXT_DOMAIN ); ?></h1>
			<form method="POST" action="options.php">
				<?php
				settings_fields( $this->setting_link );
				do_settings_sections( $this->setting_link );
				submit_button( 'Submit Settings' );
				?>
			</form>
		</div>
		<?php 
	}
	
	public function MS_plugin_shortcode_page()
	{
		require_once plugin_dir_path( __FILE__ ) . '../inc/plugin-shortcodes.php';
	}
}
$obj = new MS_PLUGIN_SETTINGS;
$obj->ms_setting_hooks();