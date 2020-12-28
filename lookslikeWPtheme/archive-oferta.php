<?php
/**
 * Template Name: Oferta
 * Template Post Type: page
 */

get_header();
?>

<div class="pageContainer oferta-page">
  <div class="siteWidth">
    <h1 class="bigTitle decoration">
      <?php
      $post = get_post();
      if(is_archive()):
        if(is_category()):
          echo _e("Kategoria: ", "lookslike").single_cat_title();
        else:
            echo $post->post_type;
        endif;

      elseif(is_home()):
        echo _e('Blog', 'lookslike');
      else:
        the_title();
      endif;
      ?>
    </h1>
    <div class="columnsWrapper flexing bg">
      <?php
        $loop = new WP_Query( array(
          'post_type' => 'oferta',
          'posts_per_page' => -1,
          'order' => 'ASC'
        )
        );
      ?>
      <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
        <div class="columns_1">
          <a href="<?php echo get_permalink();?>" class="offerContainer flexing">
            <div class="offerImage">
              <?php echo get_the_post_thumbnail(); ?>
            </div>
            <div class="description flexing">
              <div class="wrapper">
                <h3><?= get_the_title() ?></h3>
                <?php the_excerpt(); ?>
              </div>
              <div class="button btn-blue"><?php _e('Zobacz ofertę','lookslike'); ?></div>
            </div>
          </a>
        </div>
      <?php endwhile; wp_reset_query(); ?>



    </div>
  </div>
</div>

<?php get_footer(); ?>
