<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="utf-8">
        <meta charset="<?php bloginfo( 'charset' ); ?>">
    		<meta name="viewport" content="width=device-width, initial-scale=1.0" >
      <?php wp_head(); ?>
      <style>
      @font-face {
          font-family: 'LeagueSpartan';
          font-weight: 400;
          src: url('<?php echo get_template_directory_uri(); ?>/dist/fonts/LeagueSpartan-Regular.woff') format('woff');
      }
      @font-face {
          font-family: 'LeagueSpartan';
          font-weight: 600;
          src: url('<?php echo get_template_directory_uri(); ?>/dist/fonts/LeagueSpartan-Semibold.woff') format('woff');
      }
      </style>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/>

      <!-- Global site tag (gtag.js) - Google Analytics -->
      <script async src="https://www.googletagmanager.com/gtag/js?id=G-8BKR3QEQ9Z"></script>
      <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-8BKR3QEQ9Z');
      </script>
    </head>
    <body <?php body_class('no-scroll-y'); ?> id="page-top">
      <?php if (is_singular('oferta')) : ?>
        <div id="myModal" class="modal">
           <!-- Modal content -->
           <div class="modal-content">
             <span class="close">&times;</span>
             <div class="topHeading">
               <?php _e('Zapytanie ofertowe','lookslike'); ?>
             </div>
             <div class="heading">
               <?php echo get_the_title(); ?>
             </div>
              <?php buildFormAjax("token", get_the_title(), "oferta") ?>
           </div>
       </div>
      <?php endif; ?>

      <?php $page_title = get_field('page_title'); ?>
      <?php $page_description = get_field('page_description'); ?>
      <?php $company = get_field('company', 'option'); ?>
      <?php /* preloader(); */ ?>
      <header id="header" class="pageHeader <?php if (!is_front_page()) {echo 'shortHeader';} ?>">
        <?php include( locate_template( 'template-parts/mobile-menu.php', false, false ) );  ?>
        <?php if (is_front_page()): ?>
          <?php include( locate_template( 'template-parts/headers/header-front.php', false, false ) );  ?>
        <?php elseif (is_404()): ?>
          <div class="errorContent">
            <div class="errorWrapper">
              <div class="bigErr">404</div>
              <div class="errorInfo"><?php _e('Strona na której jesteś, została usunięta, jej nazwa została zmieniona lub jest tymczasowo niedostępna.','lookslike') ?></div>
              <div class="buttonEffect"><a href="/" class="button btn-white"><?php _e('WRÓĆ NA STRONĘ GŁÓWNĄ','lookslike') ?></a></div>
            </div>
          </div>
      <?php else: ?>
        <?php include( locate_template( 'template-parts/headers/header-default.php', false, false ) );  ?>
        <?php endif; ?>
        <div class="topBar">
          <div class="topNavContainer siteWidth flexing">
            <ul class="topBarMenu clearList flexing">
              <li class="menu-item"><a href="mailto:<?php echo $company['company_email']; ?>" class="contact"><i class="icon icon-at"></i> <?php echo $company['company_email']; ?></a></li>
              <li class="menu-item"><a href="tel:<?php echo $company['numer_telefonu']; ?>" class="contact"><i class="icon icon-phone"></i> <?php echo $company['numer_telefonu']; ?></a></li>
            <?php
            if ( has_nav_menu( 'topbar' ) ) :
              wp_nav_menu(
                array(
                  'container'  => '',
                  'items_wrap' => '%3$s',
                  'theme_location' => 'topbar',
                )
              );
            endif; ?>
            </ul>
          </div>
        </div>
        <div class="mainNav">
          <div class="navContainer flexing siteWidth">
            <div class="logo">
              <?php if ( $company ): ?>
                <a class="companyLogo" href="<?php echo get_site_url(); ?>"> <?php echo wp_get_attachment_image($company['comapny_logo'], 'logo') ?></a>
                <?php  else: echo "looklsike.pl";
               endif; ?>
            </div>
            <nav id="navigation">
              <?php
              if ( has_nav_menu( 'primary' ) ) :
                wp_nav_menu(
                  array(
                    'container'  => '',
                    'items_wrap' => '%3$s',
                    'theme_location' => 'primary',
                  )
                );
              endif; ?>
            </nav>
          </div>
        </div>
      </header>
