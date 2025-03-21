<div id="post-container">
    <?php while (have_posts()) : the_post(); ?>
        <div class="post-item">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </div>
    <?php endwhile; ?>
</div>
<button id="load-more">بارگذاری بیشتر</button>
