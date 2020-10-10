<?php get_header(); ?>
<main id="content">
    <div class="video-container">
        <div class="filter"></div>
        <video autoplay loop muted playsinline src="<?php echo wp_get_attachment_url(get_post_meta( get_option('page_on_front'), 'video_box', true )); ?>" class="center-absolute"></video>
        <div class="poster hidden">
            <img src="<?php echo get_the_post_thumbnail_url(get_option('page_on_front'),'full'); ?>" alt="">
        </div>
        <div class="vc-text center-absolute aligncenter">
            <h1>Welcome to the light</h1>
            <a href="" class="button">BOOK NOW</a>
        </div>
        <img id="scroll-to-down" class="arrow-down md-none" src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrow-down.png" />
    </div>
    <div class="entry-content container">
        <?php the_content(); ?>
    </div>
    <?php  get_template_part( 'resources/partials/scroll-to-top' ); ?>
</main>
<?php get_footer(); ?>