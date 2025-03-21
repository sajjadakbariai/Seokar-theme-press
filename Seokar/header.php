<?php
/**
 * Header Template
 *
 * @package Seokar
 */

defined( 'ABSPATH' ) || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="header">
    <div class="container">
        <h1 class="site-title">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <?php bloginfo( 'name' ); ?>
            </a>
        </h1>
        <nav class="main-navigation">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'menu_class'     => 'nav-menu',
                'container'      => false,
            ]);
            ?>
        </nav>
    </div>
</header>
<a href="<?php echo home_url(); ?>">
    <img src="<?php echo esc_url(seokar_get_option('seokar_logo', get_template_directory_uri() . '/assets/images/logo.png')); ?>" alt="لوگوی سایت">
</a>
<input type="text" id="search-input" placeholder="جستجو...">
<div id="search-results"></div>
