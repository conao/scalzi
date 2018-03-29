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
        
        <?php if (get_post_type() == 'post'): ?>
            <div class="entry-meta">
                <?php scalzi_posted_on(); ?>
                <?php
                /* translators: used between list items, there is a space after the comma */
                $categories_list = get_the_category_list( __( ', ', 'Scalzi' ) );
                if ($categories_list && scalzi_categorized_blog()):
                ?>
                    <span class="cat-links">
                        <?php printf(__('/ Posted in %1$s', 'Scalzi'), $categories_list); ?>
                    </span>
                <?php endif; ?>
                <?php if (!post_password_required() && (comments_open() || '0' != get_comments_number())): ?>
                    / <span class="comments-link">
                    <?php comments_popup_link(
                        __('Leave a comment', 'Scalzi'),
                        __('1 Comment', 'Scalzi'),
                        __('% Comments', 'Scalzi')); ?>
                    </span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </header>

    <?php if (is_search()): ?>
        <div class="entry-summary">
            <?php the_excerpt(); ?>
        </div>
    <?php else: ?>
        <div class="entry-content">
            <?php the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', 'Scalzi')); ?>
            <?php
            wp_link_pages( array(
                'before' => '<div class="page-links">' . __('Pages:', 'Scalzi'),
                'after'  => '</div>',
            ));
            ?>
        </div><!-- .entry-content -->
    <?php endif; ?>

    <footer class="entry-meta">
        <?php if ('post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
            <?php
            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list('', __(', ', 'Scalzi'));
            if ($tags_list) :
            ?>
                <span class="tags-links">
                    <?php printf(__('Tags: %1$s', 'Scalzi'), $tags_list); ?>
                </span>
            <?php endif; ?>
        <?php endif;  ?>


        <?php edit_post_link(__('Edit', 'Scalzi'), '<span class="edit-link">', '</span>' ); ?>
    </footer>
</article>
