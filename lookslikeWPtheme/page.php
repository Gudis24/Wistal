<?php
/**
 * Page
 *
 */

get_header();
?>

<div class="pageContainer">
  <div class="theContent siteWidth">
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
    <?php the_content(); ?>
  </div>
</div>

<?php get_footer(); ?>
