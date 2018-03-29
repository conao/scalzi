<?php if (have_posts()): ?>
    <?php while (have_posts()): ?>
        <?php the_post(); ?>
        <?php scalzi_article_load(get_post_format()); ?>
    <?php endwhile; ?>
    <?php scalzi_paging_nav(); ?>
<?php else: ?>
    <?php scalzi_article_load('none'); ?>
<?php endif; ?>
