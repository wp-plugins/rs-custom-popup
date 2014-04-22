<?php
class RSCustomPopup {

	const VERSION = '1.0.0';
	protected $plugin_slug = 'rs-custom-popup';
	protected static $instance = null;

	private function __construct() {

		global $wpdb;
		global $rscustompopup_db_version;

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'display_plugin_view_page'));

		/* Define custom functionality.
		 * Refer To http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */
		add_action( 'rscustompopup', array( $this, 'action_method_name' ) );
		add_filter( 'rscustompopup', array( $this, 'filter_method_name' ) );


	}

	public static function display_plugin_view_page(){
		include_once('class-rs-custom-popup-sql.php');
		$myPopup = new MyPopup;
		include("views/public.php");
	}

	/**
	 * Return the plugin slug.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if(null == self::$instance){
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 * $network_wide boolean for WPMU
	 */
	public static function activate($network_wide) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if($network_wide){

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();
				}

				restore_current_blog();

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 * $network_wide boolean for WPMU
	 */
	public static function deactivate($network_wide){

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

				}

				restore_current_blog();

			} else {
				self::single_deactivate();
			}

		} else {
			self::single_deactivate();
		}

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 */
	public function activate_new_site($blog_id){

		if (1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();
	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col( $sql );

	}

	private static function single_activate() {
		// We need to install the table 
		global $rscustompopup_db_version;
		global $wpdb;
   		$table_name = $wpdb->prefix . "rs_custom_popup";
      
   		$sql = "CREATE TABLE $table_name (
  		`rscustompopup_id` int(11) NOT NULL AUTO_INCREMENT,
  		`rscustompopup_image` varchar(255) NOT NULL,
  		`rscustompopup_url` varchar(255) NOT NULL,
  		`rscustompopup_pages` varchar(255) NOT NULL,
  		`rscustompopup_background_colour` varchar(255) NOT NULL,
  		`rscustompopup_text_colour` varchar(255) NOT NULL,
  		`rscustompopup_use_cookie` int(1) NOT NULL,
  		PRIMARY KEY (`rscustompopup_id`)
		);";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		add_option( "rscustompopup_db_version", $rscustompopup_db_version );
	}

	private static function single_deactivate() {
		// We need to remove any tables here
		global $wpdb;
		$table_name = $wpdb->prefix."rs_custom_popup";
		//Delete any options that's stored also?
		delete_option('rscustompopup_db_version');
		$wpdb->query("DROP TABLE IF EXISTS $table_name");
	}

	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );

	}

	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'assets/css/public.css', __FILE__ ), array(), self::VERSION );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'assets/js/public.js', __FILE__ ), array( 'jquery' ), self::VERSION );
	}

	/**
	 * NOTE:  Actions are points in the execution of a page or process
	 *        lifecycle that WordPress fires.
	 *
	 *        Actions:    http://codex.wordpress.org/Plugin_API#Actions
	 *        Reference:  http://codex.wordpress.org/Plugin_API/Action_Reference
	 *
	 * @since    1.0.0
	 */
	public function action_method_name() {
		// Define your action hook callback here
	}

	/**
	 * NOTE:  Filters are points of execution in which WordPress modifies data
	 *        before saving it or sending it to the browser.
	 *
	 *        Filters: http://codex.wordpress.org/Plugin_API#Filters
	 *        Reference:  http://codex.wordpress.org/Plugin_API/Filter_Reference
	 *
	 * @since    1.0.0
	 */
	public function filter_method_name() {
		// Define your filter hook callback here
	}

}
