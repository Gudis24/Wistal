<?php
/**
 * Front Header
 */

?>
<div class="headerImage background">
  <img class="triangleBG <?php echo animacje_klasy('oferta_prawo'); ?>" loading="lazy" src="<?php echo get_template_directory_uri(); ?>/dist/images/triangle.png" alt="Wyroby hutnicze w Świdnicy">
  <div class="headerFront flexing siteWidth">
    <div class="headingHero">
      <div class="headerContent">
        <div class="OfertaHeader">
          <h1 class="bigTitle"><?php echo $page_title; ?></h1>
         <?php echo $page_description; ?>
         <a class="button btn-orange" href="/oferta/"><?php _e('SPRAWDŹ OFERTĘ') ?></a>
        </div>
      </div>
    </div>
    <div class="scrollDown">
      <div class="container">
        <div class="chev-container">
          <div class="chevron"></div>
          <div class="chevron"></div>
          <div class="chevron"></div>
        </div>
        <span class="text"><?php _e('PRZEJDŹ NA DÓŁ', 'lookslike'); ?></span>
      </div>
  </div>
</div>
