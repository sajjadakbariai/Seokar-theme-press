<?php
/**
 * Page Template for Seokar Theme
 *
 * @package Seokar
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <h1 class="page-title"><?php the_title(); ?></h1>

        <div class="page-content">
            <?php the_content(); ?>
        </div>

        <?php
        // اگر دیدگاه‌ها فعال هستند یا دیدگاهی وجود دارد
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;
        ?>
    </article>
<?php endwhile; else : ?>
    <p>محتوایی یافت نشد.</p>
<?php endif; ?>

<?php get_footer(); ?>
