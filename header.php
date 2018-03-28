<!DOCTYPE html>

<html lang="<?php language_attributes(); ?>">
    <head>
        <meta charset="UTF-8">
        <?php if (is_singular()) wp_enqueue_script("comment-reply"); ?>
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <div class="container">
            <header>
                <h1>
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <?php bloginfo('name'); ?>
                    </a>
                </h1>
                <p><?php bloginfo('description'); ?></p>
                <?php get_search_form(); ?>
                <?php wp_nav_menu(); ?>
            </header>
