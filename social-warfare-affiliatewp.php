<?php
/**
 * Plugin Name: Social Warfare - AffiliateWP
 * Plugin URI:  http://warfareplugins.com
 * Description: A plugin to that transforms all shared links on the Social Warfare buttons across your site into affiliate links for logged in affiliates.
 * Version:     2.0.0
 * Author:      Warfare Plugins
 * Author URI:  http://warfareplugins.com
 * Text Domain: social-warfare
 */

defined( 'WPINC' ) || die;
define( 'SWAW_CORE_VERSION_REQUIRED', '3.0.0' );
define( 'SWAW_PLUGIN_FILE', __FILE__ );
define( 'SWAW_PLUGIN_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'SWAW_PLUGIN_DIR', dirname( __FILE__ ) );

add_action('plugins_loaded' , 'initialize_social_warfare_affiliatewp' , 20 );

function initialize_social_warfare_affiliatewp() {
	if( defined('SWP_VERSION') && version_compare( SWP_VERSION, SWAW_CORE_VERSION_REQUIRED ) >= 0 ):
		require_once SWAW_PLUGIN_DIR . '/Social_Warfare_AffiliateWP.php';
        $addon = new Social_Warfare_AffiliateWP();
        add_filter( 'swp_registrations', [$addon, 'add_self'] );
	endif;
}
