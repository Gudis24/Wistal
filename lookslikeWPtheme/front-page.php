<?php get_header(); ?>
<div class="pageContainer">
  <section class="flexing siteWidth sectionOferujemy">
    <h2 class="decoration"><?= _e("Oferujemy") ?></h2>
    <div class="wrapperColumns">
      <div class="columns flexing">

          <?php
            $loop = new WP_Query( array(
                'post_type' => 'oferta',
                'posts_per_page' => 6
              )
            );
            ?>

            <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
              <div class="OfertaSingle columns_3">
                <a href="<?php echo get_permalink();?>" class="wrapper">
                  <i class="icon <?php echo get_field('ikona'); ?>"></i>
                  <h3><?= get_the_title() ?></h3>
                </a>
              </div>
            <?php endwhile; wp_reset_query(); ?>
      </div>
    </div>
    <div class="flexing buttonContainer">
      <a class="button btn-blue" href="/oferta/"><?= _e("Zobacz pełną ofertę") ?></a>
    </div>
  </section>
  <section class="flexing sectionSeparator">
    <div class="contentSeparator siteWidth">
      <div class="contentSeparatorContainer flexing">
        <h2 class="decoration"><?= get_field('sekcja_1_-_tytul') ?></h2>
          <?= get_field('sekcja_1_-_opis') ?>
        <div class="flexing buttonContainer">
          <a class="button btn-white" href="/oferta/"><?= get_field('sekcja_1_-_przycisk') ?></a>
        </div>
      </div>

    </div>
    <?php slick_basic("sekcja_1_-_slider", "basicSlider", "eager"); ?>
    <!--
      slick_basic($field_name, $slider_class, $loading)
     ustawienia dla slider_class dodajemy w src\js\components\slider.js
     field_name - nazwa pola z ACF *required
     slider_classe - nazwa slidera *required
     loading - jakie ladowanie eager czy lazy *required
   -->
  </section>
  <section class="flexing siteWidth sectionStandard">
    <div class="columns flexing">
      <div class="column_1">
        <h2 class="decoration"><?= get_field('sekcja_2_-_tytul') ?></h2>
        <div class="description"><?= get_field('sekcja_2_-_opis') ?></div>
      </div>
      <div class="column_2 flexing">
        <?php slick_advance("sekcja_2_-_slider", "advanceSlider", "eager", array(
          'ikona' => 'ikona',
          'gallery' => false,
          'tytul' => 'tytul',
          'opis' => false,
        )); ?>
        <!--
         ustawienia dla nazwy dodajemy w src\js\components\slider.js
         field_name - nazwa pola z ACF *required
         slider_classe - nazwa slidera *required
         subfields to array z danymi subfieldów przyjmuje wartość nazwy pola ACF bądź false
         loading - jakie ladowanie eager czy lazy *required
       -->
      </div>
    </div>


  </section>
  <section class="flexing siteWidth sectionNews">
    <h2 class="decoration"><?= _e("Aktualności") ?></h2>
    <div class="wrapper">
      <div class="columns flexing">

        <?php
          $loop = new WP_Query( array(
              'post_type' => 'post',
              'posts_per_page' => 3
            )
          );
          $i= 0;
          ?>

          <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
            <?php if( $i == 0 ) : ?>
              <div class="column_2">
            <?php elseif( $i == 1 ) : ?>
              <div class="column_2">
            <?php endif; ?>
                <a href="<?php echo get_permalink();?>" class="single  flexing">
                  <div class="postImage"><img src="<?= get_the_post_thumbnail_url()  ?>" alt="<?= get_the_title() ?>" loading="lazy"></div>
                  <div class="description">
                    <h3><?= get_the_title() ?></h3>
                    <div class="button <?php if( $i == 0 ) : ?>btn-white<?php else: ?>btn-blue<?php endif; ?>"><?php _e('Czytaj więcej', 'lookslike') ?></div>
                  </div>
                </a>
            <?php if($i==0 || $i==2): ?>
              </div>
            <?php endif; ?>
            <?php $i++; ?>
          <?php endwhile; wp_reset_query(); ?>
          </div>
    </div>
    <div class="flexing buttonContainer">
      <a class="button btn-blue" href="<?php echo get_permalink( get_option( 'page_for_posts' )) ; ?>"><?= _e("Zobacz wszystkie") ?></a>
    </div>
  </section>
</div>
<?php get_footer(); ?>
