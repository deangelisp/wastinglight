<?php get_header(); ?>
<main id="content">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php 
        if ( has_post_thumbnail() ) { 
            echo '<figure class="post-thumbnail">';
            the_post_thumbnail();
            if(get_post_meta(get_the_ID(), 'title_on_meta', true)){
                echo '<div class="container center-absolute"><h1 class="entry-title">'.get_the_title().'</h1></div>';
            }else{
                echo '<a href="" class="button center-absolute">BOOK NOW</a>';
            }
        ?>
        <img id="scroll-to-down" class="arrow-down md-none" src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrow-down.png" />
        <?php
            echo '</figure>';
        } 
        ?>
        <div class="entry-content container">
            <?php the_content(); ?>
        </div>
    </article>
    <?php endwhile; endif; ?>
    <?php  get_template_part( 'resources/partials/scroll-to-top' ); ?>
</main>
<?php get_footer(); ?>