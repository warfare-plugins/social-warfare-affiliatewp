<?php
if ( !class_exists( 'Social_Warfare_Addon' ) ) :
    if ( !defined( 'SWP_PLUGIN_DIR' ) ) :
        $message = 'Please install and activate Social Warfare before activating Social Warfare - AffiliateWP.';
        trigger_error( $message, E_WARNING );
    endif;

    require_once( SWP_PLUGIN_DIR . '/lib/Social_Warfare_Addon.php' );
endif;

class Social_Warfare_AffiliateWP extends Social_Warfare_Addon {
    public function __construct() {
        $this->name = 'Social Warfare - AffiliateWP';
        $this->key = 'affiliatewp';
        $this->product_id = 114264;
        $this->version = '2.0.0';
        $this->core_required = '3.0.0';

        parent::__construct();

        if ( $this->is_registered ) {
            add_filter( 'swp_link_shortening', [$this, 'append_affiliate_id_to_links'], 500, 1 );
        }
    }

    /**
     * Adds affiliate links to the share buttons.
     *
     * @since  1.0.0
     * @access public
     * @param  Array $buttons An array of information about the buttons being generated
     * @return Array $buttons The modified array of information about the buttons being generated
     *
     */
    public function append_affiliate_id_to_links( $buttons ) {
          // Check if the AffiliateWP plugin is installed
          if ( function_exists('affwp_is_affiliate') ) {

              // Check if the current user is logged in and is an affiliate
              if ( ! ( is_user_logged_in() && affwp_is_affiliate() ) ) {
                  return $buttons;
              }

              // Append referral parameter and affiliate ID to sharing links in Social Warfare
              $buttons['url'] = add_query_arg( affiliate_wp()->tracking->get_referral_var(), affwp_get_affiliate_id(), $buttons['url'] );
          }


        // Return the modified array
        return $buttons;
    }
}
