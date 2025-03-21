<?php get_header(); ?>

<h1>نمونه کارهای ما</h1>
<div class="portfolio-container">
    <?php
    $args = array('post_type' => 'portfolio', 'posts_per_page' => 10);
    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
    ?>
        <div class="portfolio-item">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('medium'); ?>
                <h2><?php the_title(); ?></h2>
            </a>
        </div>
    <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo '<p>نمونه کاری وجود ندارد.</p>';
    endif;
    ?>
</div>

<?php get_footer(); ?>
