<?php


/**
 * Template Name: Kontakt
 * Template Post Type: page
 */

// captcha start
get_header(); ?>
<?php $company = get_field('company', 'option'); ?>
<div class="pageContainer">
    <div class="theContent siteWidth">
      <h1 class="bigTitle decoration">
        <?php the_title(); ?>
      </h1>
        <div class="contactBlock flexing">
          <div class="contactForm">
            <?php buildFormAjax("token", get_the_title(), "kontakt") ?>
          </div>
          <div class="content">
            <?php the_content(); ?>
          </div>
        </div>
    </div>
      <div class="siteWidth mapSection">
        <h2 class="decoration"><?php echo get_field('tytul_sekcji'); ?></h2>
        <div class="mapContainer">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2519.4166872394603!2d16.50346941590681!3d50.84196766695718!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x470e4d2deeff1f2b%3A0xaacdff3a4ef0c69d!2zIldJU1RBTCIgQ3plc8WCYXcgV29qdHlsYSBpIFdzcMOzbG5pY3kgU3DDs8WCa2EgSmF3bmE!5e0!3m2!1spl!2spl!4v1596019013691!5m2!1spl!2spl" width="100%" height="500" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
      </div>
</div>

<?php get_footer(); ?>
