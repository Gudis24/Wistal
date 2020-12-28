<?php
/**
 *
 *
 */

get_header();
?>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/pl_PL/sdk.js#xfbml=1&version=v7.0&appId=2446485202254045&autoLogAppEvents=1"></script>
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
      <div class="flexing blogContent">
        <div class="posts">
        <div class="contentPost">
          <div class="postThumbnail">
            <?php echo get_the_post_thumbnail($post, 'medium'); ?>
          </div>
          <?php the_content(); ?>
        </div>
      </div>
      <div id="sidebar" class="sidebar">
        <div class="recentPosts">
          <h5><?php _e('Najnowsze aktualności','lookslike') ?></h5>
          <ul class="postsList clearList">
            <?php
            $recent_posts = wp_get_recent_posts(array('post_type'=>'post'));
            foreach( $recent_posts as $recent ){
                echo '<li><a href="' . get_permalink($recent["ID"]) . '" title="Look '.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a> </li> ';
            }
             ?>
          </ul>
        </div>
        <div class="categories clearList">
          <h5><?php _e('Kategorie','lookslike') ?></h5>
            <?php
            wp_list_categories('title_li=');
             ?>
        </div>
        <div class="facebook">
          <h5><?php _e('Polub nas na facebooku', 'lookslike') ?></h5>
          <div class="fb-page" data-href="https://www.facebook.com/WIstal-109152840892837/" data-tabs="message" data-width="250" data-height="" data-small-header="false" data-adapt-container-width="false" data-hide-cover="false" data-show-facepile="false">
            <blockquote cite="https://www.facebook.com/WIstal-109152840892837/" class="fb-xfbml-parse-ignore">
              <a href="https://www.facebook.com/WIstal-109152840892837/">Wistal</a>
            </blockquote>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php get_footer(); ?>
