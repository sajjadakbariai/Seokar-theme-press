<?php
/**
 * Main Template File
 *
 * @package Seokar
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main class="site-main">
    <div class="container">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                the_title( '<h2>', '</h2>' );
                the_content();
            endwhile;
        else :
            echo '<p>محتوایی برای نمایش وجود ندارد.</p>';
        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>
