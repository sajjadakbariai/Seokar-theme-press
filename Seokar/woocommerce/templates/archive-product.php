<?php get_header(); ?>

<h1 class="shop-title"><?php woocommerce_page_title(); ?></h1>

<div class="shop-container">
    <?php if (have_posts()) : ?>
        <div class="products-grid">
            <?php while (have_posts()) : the_post(); ?>
                <div class="product-item">
                    <a href="<?php the_permalink(); ?>">
                        <?php woocommerce_template_loop_product_thumbnail(); ?>
                        <h2><?php the_title(); ?></h2>
                        <?php woocommerce_template_loop_price(); ?>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else : ?>
        <p>هیچ محصولی یافت نشد.</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
