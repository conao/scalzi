<?php

add_theme_support('menus');
add_theme_support('title-tag');
add_theme_support('post-thumbnails');
add_theme_support('automatic-feed-links');

if (!isset($content_width)) {
    $content_width = 960;
}

function scalzi_title($title) {
    if (is_front_page() && is_home()) {
        $title = get_bloginfo('name', 'display');
    } elseif (is_singular()) {
        $title = single_post_title('', false);
    }
    return $title;
}
add_filter('pre_get_document_title', 'scalzi_title' );

function scalzi_script() {
    wp_enqueue_style('mplus1p', '//fonts.googleapis.com/earlyaccess/mplus1p.css', array());
    wp_enqueue_style('Sacramento', '//fonts.googleapis.com/css?family=Sacramento&amp;amp;subset=latin-ext', array());
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), '4.7.0');
    wp_enqueue_style('normalize', get_template_directory_uri() . '/css/normalize.css', array(), '4.5.0');
    wp_enqueue_style('scalzi', get_template_directory_uri() . '/css/scalzi.css', array(), '1.0.0');
    wp_enqueue_style('style', get_template_directory_uri() . '/style.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'scalzi_script' );

function scalzi_widgets_init() {
    register_sidebar (
        array(
            'name'          => 'カテゴリーウィジェット',
            'id'            => 'category_widget',
            'description'   => 'カテゴリー用ウィジェットです',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2><i class="fa fa-folder-open" aria-hidden="true"></i>',
            'after_title'   => "</h2>\n"
        )
    );
}

add_action('widgets_init', 'scalzi_widgets_init');

function scalzi_theme_add_editor_styles() {
    add_editor_style(get_template_directory_uri() . "/css/editor-style.css");
}
add_action('admin_init', 'scalzi_theme_add_editor_styles');


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


//Include shortcode file
require( get_template_directory() . '/inc/shortcode.php' );

// Enqueue Scripts/Styles for our Lightbox
function scalzi_add_lightbox() {
    wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/js/jquery.fancybox.pack.js', array( 'jquery' ), false, true );
    wp_enqueue_script( 'lightbox', get_template_directory_uri() . '/js/lightbox.js', array( 'fancybox' ), false, true );
    wp_enqueue_style( 'lightbox-style', get_template_directory_uri() . '/css/jquery.fancybox.css' );
}
add_action( 'wp_enqueue_scripts', 'scalzi_add_lightbox' );

?>
