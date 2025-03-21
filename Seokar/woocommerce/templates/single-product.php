<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
    <div class="single-product-container">
        <div class="product-image">
            <?php woocommerce_show_product_images(); ?>
        </div>
        <div class="product-details">
            <h1><?php the_title(); ?></h1>
            <?php woocommerce_template_single_price(); ?>
            <?php woocommerce_template_single_add_to_cart(); ?>
            <?php woocommerce_template_single_excerpt(); ?>
        </div>
    </div>
<?php endwhile; ?>

<?php get_footer(); ?>
