<?php


class Social_Warfare_AffiliateWP extends Social_Warfare_Addon {
    public function __construct() {
        $this->name          = 'Social Warfare - AffiliateWP';
        $this->key           = 'affiliatewp';
        $this->product_id    = 114264;
        $this->version       = SWAW_VERSION;
        $this->core_required = SWAW_CORE_VERSION_REQUIRED;
        $this->filepath      = SWAW_PLUGIN_FILE;

		parent::__construct();

        if ( $this->is_registered ) {
            add_filter( 'swp_link_shortening', array( $this, 'append_affiliate_id_to_links' ) , 500, 1 );
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


	/**
	 * Add this object to the registrations filter.
	 *
	 * @since  2.1.0 | 02 OCT 2018 | Created
	 * @param  array $addons An array of addon objects.
	 * @return array         The modified array.
	 *
	 */
	public function add_self( $addons ) {

		$addons[] = $this;

		return $addons;
	}
}
