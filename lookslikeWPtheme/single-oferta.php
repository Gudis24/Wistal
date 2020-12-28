<?php
/**
 *
 *
 */

get_header();
?>
<?php $company = get_field('company','options'); ?>
<div class="pageContainer">
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
    <div class="flexing blogContent offerContent">
      <div class="posts">
      <?php echo get_the_post_thumbnail(); ?>
      <div class="contentPost flexing">
        <div class="content">
          <?php the_content(); ?>
        </div>
      </div>
      <div class="table">
        <div class="mainRow flexing">
          <div class="rowName"><?php _e('Rodzaj','lookslike'); ?></div>
          <div class="rowName"><?php _e('Grubość (mm)','lookslike'); ?></div>
        </div>
        <?php if( have_rows('tabela') ): // grupa
          while( have_rows('tabela')): the_row();?>
        <div class="baseRow flexing">
          <div class="rowName <?php if (get_sub_field('kategoria') == true) : ?>bolder <?php endif; ?>">
            <?php echo get_sub_field('rodzaj'); ?></div>
          <div class="rowName">
            <?php echo get_sub_field('grubosc_mm'); ?>
          </div>
        </div>
      <?php endwhile; ?>
    <?php endif; ?>
      </div>
    </div>
    <div id="sidebar" class="sidebar">
      <div class="offerCtn">
        <?php modul_zapytanie($company['numer_telefonu_zapytanie']) ?>
      </div>
      <div class="recentPosts">
        <h5><?php _e('Inne z naszej oferty','lookslike') ?></h5>
        <ul class="postsList clearList">
          <?php
            $loop = new WP_Query( array(
                'post_type' => 'oferta',
                'posts_per_page' => -1
              )
            );
            global $wp;
            $current_url = home_url($wp->request).'/';
            ?>
            <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
              <li <?php if ($current_url == get_permalink()) : ?> class="active" <?php endif; ?> > <a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></li>
            <?php endwhile; wp_reset_query(); ?>

        </ul>
      </div>

      <!-- <div class="facebook">
        <h5><?php// _e('Polub nas na facebooku', 'lookslike') ?></h5>
        <div class="fb-page" data-href="https://www.facebook.com/lookslikepl/" data-tabs="message" data-width="250" data-height="" data-small-header="false" data-adapt-container-width="false" data-hide-cover="false" data-show-facepile="false">
          <blockquote cite="https://www.facebook.com/lookslikepl/" class="fb-xfbml-parse-ignore">
            <a href="https://www.facebook.com/lookslikepl/">lookslike.pl</a>
          </blockquote>
        </div>
      </div> -->
    </div>
  </div>
  </div>
</div>


<?php get_footer(); ?>
