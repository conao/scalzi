<?php
/**
 * scalzi Theme Customizer
 *
 * @package scalzi
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function scalzi_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	//start text colors section
	$wp_customize->add_section('scalzi_colors', array(
		'title'	=> __('Text Colors', 'scalzi'),
		'description' => 'Modify Font Colors',
		'priority'    => 20
	));
	$wp_customize->add_setting('blogtitle_color', array(
		'default'	=> '#4b4b4d'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'blogtitle_color', array(
		'label'	=> __('Edit Blog title color', 'scalzi'),
		'section' => 'scalzi_colors',
		'settings' => 'blogtitle_color'
	) ));

	$wp_customize->add_setting('blogdescription_color', array(
		'default'	=> '#898989'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'blogdescription_color', array(
		'label'	=> __('Edit Blog description color', 'scalzi'),
		'section' => 'scalzi_colors',
		'settings' => 'blogdescription_color'
	) ));
	//start logo upload section
	$wp_customize->add_section( 'uploadlogo_section' , array(
	    'title'       => __( 'Logo', 'scalzi' ),
	    'description' => 'Upload a logo to replace the default site name and description in the header',
	    'priority'    => 30
	) );
	$wp_customize->add_setting( 'scalzi_uploadlogo' );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'scalzi_uploadlogo', array(
	    'label'    => __( 'Logo', 'themeslug' ),
	    'section'  => 'uploadlogo_section',
	    'settings' => 'scalzi_uploadlogo'
	) ) );
}

function scalzi_css_customizer() {
	?>
		<style type="text/css">
			.site-branding h1 a {color: <?php echo get_theme_mod('blogtitle_color'); ?>;}
			h2.site-description {color:<?php echo get_theme_mod('blogdescription_color'); ?>;}
		</style>
	<?php
}

add_action( 'wp_head', 'scalzi_css_customizer' );
add_action( 'customize_register', 'scalzi_customize_register' );



/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function scalzi_customize_preview_js() {
	wp_enqueue_script( 'scalzi_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'scalzi_customize_preview_js' );
