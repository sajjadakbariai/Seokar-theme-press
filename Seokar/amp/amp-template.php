<!DOCTYPE html>
<html amp>
    <style amp-custom>
    <?php readfile(get_template_directory() . "/amp/amp-style.css"); ?>
    </style>
<head>
    <meta charset="utf-8">
    <title><?php bloginfo('name'); ?> - نسخه AMP</title>
    <link rel="canonical" href="<?php echo esc_url(get_permalink()); ?>">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <style amp-custom>
        body { font-family: Arial, sans-serif; background: #f9f9f9; color: #333; text-align: center; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        h1 { font-size: 24px; }
        p { font-size: 16px; }
        .amp-img { width: 100%; height: auto; }
    </style>
    <script async src="https://cdn.ampproject.org/v0.js"></script>
</head>
<body>

    <div class="container">
        <h1><?php the_title(); ?></h1>
        <p><?php the_content(); ?></p>

        <?php if (has_post_thumbnail()) : ?>
            <amp-img src="<?php echo get_the_post_thumbnail_url(); ?>" width="800" height="400" layout="responsive" class="amp-img"></amp-img>
        <?php endif; ?>

        <p><a href="<?php echo esc_url(home_url()); ?>">بازگشت به صفحه اصلی</a></p>
    </div>

</body>
</html>
