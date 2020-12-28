<?php
/**
 * Template Name: O nas
 * Template Post Type: page
 */

get_header();
?>
<?php $o_nas = get_field('o_nas'); ?>
<div class="pageContainer">
    <div class="theContent siteWidth">
      <h1 class="bigTitle decoration">
        <?php
          the_title();
        ?>
      </h1>
      <?php the_content(); ?>
    </div>
    <div class="siteWidth atuty">
      <h2 class="decoration"><?php echo get_field('tytul_sekcji'); ?></h2>
      <div class="columnsWrapper flexing">
      <?php if (have_rows('atuty')) : ?>
        <?php while( have_rows('atuty') ) : the_row();?>
          <div class="column_3 flexing">
            <i class="sliderIcon icon <?=get_sub_field('ikona'); ?>"></i>
            <h5 class="atutTitle"><?=get_sub_field('tytul'); ?></h5>
          </div>
        <?php endwhile; wp_reset_query(); ?>
      <?php endif; ?>
      </div>
  </div>
</div>

<?php get_footer(); ?>
