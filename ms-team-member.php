<?php 
/**
* Plugin Name: Team Members Profile
* Plugin URI: https://github.com/lucifermani21/ms-team-member.git
* Description: WordPress simple Team Members Profile plugin with Bootstrap 5 support, easy to use with help of shortcodes.
* Version: 1.0.2
* Author: Manpreet Singh
**/

if ( ! defined( 'ABSPATH' ) ) {
     die;
}
define( 'MS_TEAMM_SETTING_VERSION', '1.0.2' );
define( 'MS_TEAMM_SETTING_TEXT_DOMAIN', 'ms-team_members' );
define( 'MS_TEAMM_DIR__NAME', dirname( __FILE__ ) );
define( 'MS_TEAMM_EDITING__URL', plugin_dir_url( __FILE__ ) );
define( 'MS_TEAMM_EDITING__DIR', plugin_dir_path( __FILE__ ) );
define( 'MS_TEAMM_SETTING_PLUGIN', __FILE__ );
define( 'MS_TEAMM_SETTING_PLUGIN_BASENAME', plugin_basename( MS_TEAMM_SETTING_PLUGIN ) );

include_once( 'classes/main-class.php' );
include_once( 'classes/setting-class.php' );

$obj = new MS_PLUGIN_SETTINGS;

$obj->MS_hooks();
$obj->ms_setting_hooks();
