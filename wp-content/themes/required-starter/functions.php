<?php
/**
 * This makes the child theme work. If you need any
 * additional features or let's say menus, do it here.
 *
 * @return void
 */
function required_starter_themesetup() {

	load_child_theme_textdomain( 'requiredstarter', get_stylesheet_directory() . '/languages' );

	// Register an additional Menu Location
	register_nav_menus( array(
		'meta' => __( 'Meta Menu', 'requiredstarter' )
	) );

	// Add support for custom backgrounds and overwrite the parent backgorund color
	add_theme_support( 'custom-background', array( 'default-color' => 'f7f7f7' ) );
        
        //Add support for the JamesCorne.com implementation hooks
        require_once('includes/hooks.php');

}
add_action( 'after_setup_theme', 'required_starter_themesetup' );


/**
 * With the following function you can disable theme features
 * used by the parent theme without breaking anything. Read the
 * comments on each and follow the link, if you happen to not
 * know what the function is for. Remove the // in front of the
 * remove_theme_support('...'); calls to make them execute.
 *
 * @return void
 */
function required_starter_after_parent_theme_setup() {

	/**
	 * Hack added: 2012-10-04, Silvan Hagen
	 *
	 * This is a hack, to calm down PHP Notice, since
	 * I'm not sure if it's a bug in WordPress or my
	 * bad I'll leave it here: http://wordpress.org/support/topic/undefined-index-custom_image_header-in-after_setup_theme-of-child-theme
	 */
	if ( ! isset( $GLOBALS['custom_image_header'] ) )
		$GLOBALS['custom_image_header'] = array();

	if ( ! isset( $GLOBALS['custom_background'] ) )
		$GLOBALS['custom_background'] = array();

	// Remove custom header support: http://codex.wordpress.org/Custom_Headers
	//remove_theme_support( 'custom-header' );

	// Remove support for post formats: http://codex.wordpress.org/Post_Formats
	//remove_theme_support( 'post-formats' );

	// Remove featured images support: http://codex.wordpress.org/Post_Thumbnails
	//remove_theme_support( 'post-thumbnails' );

	// Remove custom background support: http://codex.wordpress.org/Custom_Backgrounds
	//remove_theme_support( 'custom-background' );

	// Remove automatic feed links support: http://codex.wordpress.org/Automatic_Feed_Links
	//remove_theme_support( 'automatic-feed-links' );

	// Remove editor styles: http://codex.wordpress.org/Editor_Style
	//remove_editor_styles();

	// Remove a menu from the theme: http://codex.wordpress.org/Navigation_Menus
	//unregister_nav_menu( 'secondary' );

}
add_action( 'after_setup_theme', 'required_starter_after_parent_theme_setup', 11 );

/**
 * Add our theme specific js file and some Google Fonts
 * @return void
 */
function required_starter_scripts() {
    
    
        /**
         * Register and enqueue extra libraries
         */
         //jQUery
        wp_enqueue_script('jquery');
        
        /**
         * Add a global varibale for the ajaxurl to loggedout users
         */
    
        wp_localize_script('jquery', 'jamesc', array('ajaxurl', admin_url('admin-ajax.php')));
         
        wp_register_script('zoomooz',
                           get_stylesheet_directory_uri() . '/javascripts/zoomooz/jquery.zoomooz.js',
                           array( 'jquery' ),
                           required_get_theme_version( false ),
                           true
        );
        
        wp_enqueue_script('zoomooz');
        
        wp_register_script('jqcookie',
                           get_stylesheet_directory_uri() . '/javascripts/jquery-cookie/jquery.cookie.js',
                           array( 'jquery' ),
                           required_get_theme_version( false ),
                           true
        );
        
        wp_enqueue_script('jqcookie');
        
	/**
	 * Registers the child-theme.js
	 */        
    
	wp_enqueue_script(
		'child-theme-js',
		get_stylesheet_directory_uri() . '/javascripts/child-theme.js',
		array( 'theme-js' ),
		required_get_theme_version( false ),
		true
	);

	/**
	 * Registers the app.css
	 *
	 * If you don't need it, remove it.
	 * The file is empty by default.
	 */
	wp_register_style(
        'app-css', //handle
        get_stylesheet_directory_uri() . '/stylesheets/app.css',
        array( 'foundation-css' ),	// needs foundation
        required_get_theme_version( false ) //version
  	);
  	wp_enqueue_style( 'app-css' );

	/**
	 * Adding google fonts
	 *
	 * This is the proper code to add google fonts
	 * as seen in TwentyTwelve
	 */
	$protocol = is_ssl() ? 'https' : 'http';
	$query_args = array( 'family' => 'Open+Sans:300,600' );
	wp_enqueue_style(
		'open-sans',
		add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ),
		array(),
		null
	);
}
add_action('wp_enqueue_scripts', 'required_starter_scripts');

/**
 * Overwrite the default continue reading link
 *
 * This function is an example on how to overwrite
 * the parent theme function to create continue reading
 * links.
 *
 * @return string HTML link with text and permalink to the post/page/cpt
 */
function required_continue_reading_link() {
	return ' <a class="read-more" href="'. esc_url( get_permalink() ) . '">' . __( ' Read on! &rarr;', 'requiredstarter' ) . '</a>';
}

/**
 * Overwrite the defaults of the Orbit shortcode script
 *
 * Accepts all the parameters from http://foundation.zurb.com/docs/orbit.php#optCode
 * to customize the options for the orbit shortcode plugin.
 *
 * @param  array $args default args
 * @return array       your args
 */
function required_orbit_script_args( $defaults ) {
	$args = array(
		'animation' 	=> 'fade',
		'advanceSpeed' 	=> 8000,
	);
	return wp_parse_args( $args, $defaults );
}
add_filter( 'req_orbit_script_args', 'required_orbit_script_args' );

//Fix the admin bar stuff

//Add my own WP Logged in CSS

add_action('wp_head', 'jamesc_admin_css');

function jamesc_admin_css() {
        if ( is_user_logged_in() ) {
        ?>
        <style type="text/css">
            body {
                padding-top:28px;
            }
        </style>
        <?php }
}

//Remove the default WP Logged in CSS

add_action('get_header', 'remove_css_head');

function remove_css_head() {
	remove_action('wp_head', '_admin_bar_bump_cb');
}


//Pseudo Code for fetching the office

function theme_office() {
    
    $is_not_mobile = wpmd_is_notphone();
    
    if($is_not_mobile) {
        get_office();
    }
}

add_action('jamesc_before_container', 'theme_office', 0);

function get_office() {

    $bg   = wp_get_attachment_image_src( get_field( 'office_background_image', 'option' ), 'large' );
    $tv   = wp_get_attachment_image_src( get_field( 'office_other_television_background', 'option' ), 'large'  );
    $cork = wp_get_attachment_image_src( get_field( 'office_corkboard_background_image', 'option' ), 'large' );

    print '
        <div id="zoom-wrap">
          <div class="zoomViewport">
            <div style="position:fixed; z-index:30; top:30px; left:0; width:11em; height:2em; line-height: 2em; padding: 0 1em; background-color:rgba(255,255,255,0.65);">
                <ul>
                    <li class="office-toggle close">
                        <a href="#">View more Content</a>
                    </li>
                </ul>
            </div>
                <div data-tool="Click to inspect the television." style="width:20%; left:20%; top: 28%; position:fixed; background: transparent" class="zoomTarget">
                	<img style="width:100%; height:auto;" src="'. $tv[0] .'" />
                </div>
                <div data-tool="Click to inspect the corkboard." id="a" style="width: 20%; left:57%; top: 32%; position:fixed;" class="zoomTarget">
	          <div id="a1" class="cork-section zoomTarget level2">&nbsp;</div>
                  <div id="a2" class="cork-section zoomTarget level2">&nbsp;</div>
                  <div id="a3" class="cork-section zoomTarget level2">&nbsp;</div>
                  <div id="a4" class="cork-section zoomTarget level2">&nbsp;</div>
                  <img style="width:100%; height:auto;" src="'.$cork[0].'" />
                </div>
           <img class="office-bg" width="100%" src="'. $bg[0] .'" />
        </div>
      </div>
        ';
}