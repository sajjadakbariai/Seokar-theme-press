<?php
/**
 * Single Post Template for Seokar Theme
 *
 * @package Seokar
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <h1 class="post-title"><?php the_title(); ?></h1>
        
        <div class="post-meta">
            <span class="post-date"><?php echo get_the_date(); ?></span>
            <span class="post-author"><?php the_author_posts_link(); ?></span>
        </div>

        <div class="post-content">
            <?php the_content(); ?>
        </div>

        <div class="post-tags">
            <?php the_tags( 'برچسب‌ها: ', ', ', '' ); ?>
        </div>

        <div class="post-navigation">
            <div class="previous"><?php previous_post_link(); ?></div>
            <div class="next"><?php next_post_link(); ?></div>
        </div>

        <?php if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif; ?>
    </article>
<?php endwhile; else : ?>
    <p>محتوایی یافت نشد.</p>
<?php endif; ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
