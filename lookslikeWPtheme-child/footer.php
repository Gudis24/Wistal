<?php $company = get_field('company', 'option'); ?>
<?php $socialMedia = get_field('social_media', 'option'); ?>
<footer>
  <div class="footerWrapper siteWidth flexing">
    <div class="columnLeft">
      <div class="wrapper">
        <div class="heading"><?php _e('Oferta WISTAL','lookslike'); ?></div>
        <div class="footerMenuContainer">
          <ul class="clearList footerMenu list-style">
            <?php
            if ( has_nav_menu( 'footer' ) ) :
              wp_nav_menu(
                array(
                  'container'  => '',
                  'items_wrap' => '%3$s',
                  'theme_location' => 'footer',
                )
              );
            endif; ?>
          </ul>
        </div>
      </div>
    </div>
    <div class="columnsRight flexing">
      <div class="column">
        <i class="icon icon-map-marker"></i>
        <div class="wrapper">
          <div class="heading"><?php _e('Siedziba firmy','lookslike'); ?></div>
          <p><?php echo $company['company_name']; ?><br>
             <?php echo $company['company_adress']; ?></p>
        </div>
      </div>
      <div class="column">
        <i class="icon icon-at"></i>
        <div class="wrapper">
          <div class="heading"><?php _e('Numer telefonu','lookslike'); ?></div>
        <p><a href="tel:<?php echo $company['numer_telefonu']; ?>" class="contact"><?php echo $company['numer_telefonu']; ?></a><br>
            <a href="tel:74 852 12 74" class="contact">74 852 12 74</a>
        </p>
        </div>
      </div>
      <div class="column">
        <i class="icon icon-phone"></i>
        <div class="wrapper">
          <div class="heading secondheading"><?php _e('Adres E-mail','lookslike'); ?></div>
          <p><a href="mailto:<?php echo $company['company_email']; ?>" class="contact"><?php echo $company['company_email']; ?></a></p>
        </div>
      </div>
      <div class="credits">
        <div class="flexing creditsWrapper">
          <div class="companyName"> © <?php echo date('Y').' '.$company['company_name']; ?></div>
          <a href="https://lookslike.pl" target="_blank" rel="nofollow" class="craftedBy"> <span><?php _e(' Crafted by','lookslike'); ?></span> <img src="<?php echo get_template_directory_uri(); ?>/dist/images/LL.svg" alt=""></a>
        </div>
      </div>
    </div>
  </div>
</footer>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.js"></script>
<script>
  new WOW().init();
</script>
<?php wp_footer(); ?>
<script>
jQuery(".wp-block-gallery .blocks-gallery-item a").fancybox().attr('data-fancybox', 'gallery');
</script>
</body>
</html>
