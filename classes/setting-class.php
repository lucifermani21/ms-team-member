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
	public function MS_plugin_setting_page()
	{
		?>
		<div class="wrap">
			<h1></h1>
			<form method="post" action="options.php">
				
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