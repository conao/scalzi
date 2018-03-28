<?php get_header(); ?>

<?php if (have_posts()): ?>
    <?php while (have_posts()): ?>
        <?php the_post(); ?>
        <?php get_template_part('content', get_post_format()); ?>
    <?php endwhile; ?>
    <?php scalzi_paging_nav(); ?>
<?php else: ?>
    <?php get_template_part('content', 'none'); ?>
<?php endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
