<?php
/**
 * Content Loader
 */

function scalzi_parts_load($slug, $name = null) {
    get_template_part("content/parts/{$slug}", $name);
}

function scalzi_article_load($name) {
    scalzi_parts_load('article', $name);
}

function scalzi_content_load() {
    $template  =  false;
    if (is_embed()                   && $template = scalzi_get_embed_template()) {
    } elseif (is_404()               && $template = scalzi_get_404_template()) {
    } elseif (is_search()            && $template = scalzi_get_search_template()) {
    } elseif (is_front_page()        && $template = scalzi_get_front_page_template()) {
    } elseif (is_home()              && $template = scalzi_get_home_template()) {
    } elseif (is_post_type_archive() && $template = scalzi_get_post_type_archive_template()) {
    } elseif (is_tax()               && $template = scalzi_get_taxonomy_template()) {
    } elseif (is_attachment()        && $template = scalzi_get_attachment_template()) {
        remove_filter('the_content','prepend_attachment');
    } elseif (is_single()            && $template = scalzi_get_single_template()) {
    } elseif (is_page()              && $template = scalzi_get_page_template()) {
    } elseif (is_singular()          && $template = scalzi_get_singular_template()) {
    } elseif (is_category()          && $template = scalzi_get_category_template()) {
    } elseif (is_tag()               && $template = scalzi_get_tag_template()) {
    } elseif (is_author()            && $template = scalzi_get_author_template()) {
    } elseif (is_date()              && $template = scalzi_get_date_template()) {
    } elseif (is_archive()           && $template = scalzi_get_archive_template()) {
    } else {
        $template = scalzi_get_index_template();
    }
    
    if ( $template = apply_filters( 'template_include', $template ) ) {
        include( $template );
    } elseif ( current_user_can( 'switch_themes' ) ) {
        $theme = wp_get_theme();
        if ( $theme->errors() ) {
            wp_die( $theme->errors() );
        }
    }
}

function scalzi_get_query_template( $type, $templates = array() ) {
	$type = preg_replace( '|[^a-z0-9-]+|', '', $type );

	if (empty($templates))
		$templates = array("{$type}.php");

    $templates = array_map(function($val) {return('content/' . $val);}, $templates);
	$templates = apply_filters( "{$type}_template_hierarchy", $templates );
    
	$template = locate_template( $templates );
    echo implode(', ', $templates) . '<br />' . $template . '<br />';
	return apply_filters( "{$type}_template", $template, $type, $templates );
}

function scalzi_get_index_template() {
	return scalzi_get_query_template('index');
}

function scalzi_get_404_template() {
	return scalzi_get_query_template('404');
}

function scalzi_get_archive_template() {
	$post_types = array_filter( (array) get_query_var( 'post_type' ) );

	$templates = array();

	if ( count( $post_types ) == 1 ) {
		$post_type = reset( $post_types );
		$templates[] = "archive-{$post_type}.php";
	}
	$templates[] = 'archive.php';

	return scalzi_get_query_template( 'archive', $templates );
}

function scalzi_get_post_type_archive_template() {
	$post_type = get_query_var( 'post_type' );
	if ( is_array( $post_type ) )
		$post_type = reset( $post_type );

	$obj = get_post_type_object( $post_type );
	if ( ! ( $obj instanceof WP_Post_Type ) || ! $obj->has_archive ) {
		return '';
	}

	return scalzi_get_archive_template();
}

function scalzi_get_author_template() {
	$author = get_queried_object();

	$templates = array();

	if ( $author instanceof WP_User ) {
		$templates[] = "author-{$author->user_nicename}.php";
		$templates[] = "author-{$author->ID}.php";
	}
	$templates[] = 'author.php';

	return scalzi_get_query_template( 'author', $templates );
}

function scalzi_get_category_template() {
	$category = get_queried_object();

	$templates = array();

	if ( ! empty( $category->slug ) ) {

		$slug_decoded = urldecode( $category->slug );
		if ( $slug_decoded !== $category->slug ) {
			$templates[] = "category-{$slug_decoded}.php";
		}

		$templates[] = "category-{$category->slug}.php";
		$templates[] = "category-{$category->term_id}.php";
	}
	$templates[] = 'category.php';

	return scalzi_get_query_template( 'category', $templates );
}

function scalzi_get_tag_template() {
	$tag = get_queried_object();

	$templates = array();

	if ( ! empty( $tag->slug ) ) {

		$slug_decoded = urldecode( $tag->slug );
		if ( $slug_decoded !== $tag->slug ) {
			$templates[] = "tag-{$slug_decoded}.php";
		}

		$templates[] = "tag-{$tag->slug}.php";
		$templates[] = "tag-{$tag->term_id}.php";
	}
	$templates[] = 'tag.php';

	return scalzi_get_query_template( 'tag', $templates );
}

function scalzi_get_taxonomy_template() {
	$term = get_queried_object();

	$templates = array();

	if ( ! empty( $term->slug ) ) {
		$taxonomy = $term->taxonomy;

		$slug_decoded = urldecode( $term->slug );
		if ( $slug_decoded !== $term->slug ) {
			$templates[] = "taxonomy-$taxonomy-{$slug_decoded}.php";
		}

		$templates[] = "taxonomy-$taxonomy-{$term->slug}.php";
		$templates[] = "taxonomy-$taxonomy.php";
	}
	$templates[] = 'taxonomy.php';

	return scalzi_get_query_template( 'taxonomy', $templates );
}

function scalzi_get_date_template() {
	return scalzi_get_query_template('date');
}

function scalzi_get_home_template() {
	$templates = array( 'home.php', 'index.php' );

	return scalzi_get_query_template( 'home', $templates );
}

function scalzi_get_front_page_template() {
	$templates = array('front-page.php');

	return scalzi_get_query_template( 'front_page', $templates );
}

function scalzi_get_page_template() {
	$id = get_queried_object_id();
	$template = get_page_template_slug();
	$pagename = get_query_var('pagename');

	if ( ! $pagename && $id ) {
		// If a static page is set as the front page, $pagename will not be set.
        // Retrieve it from the queried object
		$post = get_queried_object();
		if ( $post )
			$pagename = $post->post_name;
	}

	$templates = array();
	if ( $template && 0 === validate_file( $template ) )
		$templates[] = $template;
	if ( $pagename ) {
		$pagename_decoded = urldecode( $pagename );
		if ( $pagename_decoded !== $pagename ) {
			$templates[] = "page-{$pagename_decoded}.php";
		}
		$templates[] = "page-{$pagename}.php";
	}
	if ( $id )
		$templates[] = "page-{$id}.php";
	$templates[] = 'page.php';

	return scalzi_get_query_template( 'page', $templates );
}

function scalzi_get_search_template() {
	return scalzi_get_query_template('search');
}

function scalzi_get_single_template() {
	$object = get_queried_object();

	$templates = array();

	if ( ! empty( $object->post_type ) ) {
		$template = get_page_template_slug( $object );
		if ( $template && 0 === validate_file( $template ) ) {
			$templates[] = $template;
		}

		$name_decoded = urldecode( $object->post_name );
		if ( $name_decoded !== $object->post_name ) {
			$templates[] = "single-{$object->post_type}-{$name_decoded}.php";
		}

		$templates[] = "single-{$object->post_type}-{$object->post_name}.php";
		$templates[] = "single-{$object->post_type}.php";
	}

	$templates[] = "single.php";

	return scalzi_get_query_template( 'single', $templates );
}

function scalzi_get_embed_template() {
	$object = get_queried_object();

	$templates = array();

	if ( ! empty( $object->post_type ) ) {
		$post_format = get_post_format( $object );
		if ( $post_format ) {
			$templates[] = "embed-{$object->post_type}-{$post_format}.php";
		}
		$templates[] = "embed-{$object->post_type}.php";
	}

	$templates[] = "embed.php";

	return scalzi_get_query_template( 'embed', $templates );
}

function scalzi_get_singular_template() {
	return scalzi_get_query_template( 'singular' );
}

function scalzi_get_attachment_template() {
	$attachment = get_queried_object();

	$templates = array();

	if ( $attachment ) {
		if ( false !== strpos( $attachment->post_mime_type, '/' ) ) {
			list( $type, $subtype ) = explode( '/', $attachment->post_mime_type );
		} else {
			list( $type, $subtype ) = array( $attachment->post_mime_type, '' );
		}

		if ( ! empty( $subtype ) ) {
			$templates[] = "{$type}-{$subtype}.php";
			$templates[] = "{$subtype}.php";
		}
		$templates[] = "{$type}.php";
	}
	$templates[] = 'attachment.php';

	return scalzi_get_query_template( 'attachment', $templates );
}


?>
