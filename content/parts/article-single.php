<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if (has_post_thumbnail()): ?>
        <div class="blogthumb">
            <?php the_post_thumbnail(); ?>
        </div>
    <?php endif; ?>
    <header class="entry-header">
        <h1 class="entry-title">
            <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
        </h1>
        
        <div class="entry-meta">
            <?php scalzi_posted_on(); ?>
            <?php
            /* translators: used between list items, there is a space after the comma */
            $category_list = get_the_category_list(__(', ', 'Scalzi'));

            /* translators: used between list items, there is a space after the comma */
            $tag_list = get_the_tag_list('', __( ', ', 'Scalzi'));

            if (!scalzi_categorized_blog()) {
            } else {
                $meta_text = __('/ Posted in %1$s', 'Scalzi');
            } // end check for categories on this blog

            printf(
                $meta_text,
                $category_list,
                $tag_list,
                get_permalink()
            );
            ?>
        </div>
    </header>

    <div class="entry-content">
        <?php the_content(); ?>
        <?php
        wp_link_pages(array(
            'before' => '<div class="page-links">' . __('Pages:', 'Scalzi'),
            'after'  => '</div>',
        ));
        ?>
    </div>

    <footer class="entry-meta">
        <?php
        /* translators: used between list items, there is a space after the comma */
        $category_list = get_the_category_list(__(', ', 'Scalzi'));

        /* translators: used between list items, there is a space after the comma */
        $tag_list = get_the_tag_list('', __(', ', 'Scalzi'));

        if (!scalzi_categorized_blog()) {
            // This blog only has 1 category so we just need to worry about tags in the meta text
            $meta_text = __( '<a href="%3$s" rel="bookmark" class="bookmark">Bookmark this</a>', 'Scalzi' );
        } else {
            // But this blog has loads of categories so we should probably display them here
            if ('' != $tag_list) {
                $meta_text = __( '<a href="%3$s" rel="bookmark" class="bookmark">Bookmark this</a> Tags: %2$s', 'Scalzi' );
            } else {
                $meta_text = __( '<a href="%3$s" rel="bookmark" class="bookmark">Bookmark this</a>', 'Scalzi' );
            }
        }

        printf(
            $meta_text,
            $category_list,
            $tag_list,
            get_permalink()
        );
        ?>

        <?php edit_post_link( __( 'Edit', 'Scalzi' ), '<span class="edit-link">', '</span>' ); ?>
    </footer>
</article>
