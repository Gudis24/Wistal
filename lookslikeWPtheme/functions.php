<?php
function lookslike_assets() {
  wp_enqueue_style( 'lookslike-stylesheet', get_template_directory_uri() . '/dist/css/bundle.css', array(), '1.0.0', 'all' );
  wp_enqueue_style( 'fontello', get_template_directory_uri() . '/dist/fontello/css/wistal.css', array(), '1.0.0', 'all' );
  wp_enqueue_style( 'fancybox-css', get_template_directory_uri() . '/static/fancybox/fancybox.min.css', array(), '1.0.0', 'all' );
  wp_enqueue_script( 'fancybox-js', get_template_directory_uri() . '/static/fancybox/fancybox.min.js', array(), '1.0.0', true );
  wp_enqueue_script( 'lookslike-scripts', get_template_directory_uri() . '/dist/js/bundle.js', array('jquery'), '1.0.0', true );
}
add_action('wp_enqueue_scripts', 'lookslike_assets');

add_theme_support('post-thumbnails');
//image sizes
// ustawianie wielkosci obrazow
add_image_size('auto', 0, 0, array( 'center', 'center' ));
add_image_size('logo', 180, 0);
add_image_size('logo_mobile', 120, 0);
add_image_size('ikona', 0, 80);
add_image_size('blog', 370, 250, true);
add_image_size('main_post', 955, 400, array( 'center', 'center' ));
add_image_size('post', 285, 305, array( 'center', 'center' ));
add_image_size('fullSize', 1920, 0, array( 'center', 'center' ));
add_image_size('desktop', 1920, 1150, array( 'center', 'center' ));
if( function_exists('acf_add_options_page') ) {

  acf_add_options_page(array(
  'page_title' 	=> 'Opcje Theme',
  'menu_title'	=> 'Opcje Theme',
  'menu_slug' 	=> 'opcjeTheme',
  'capability'	=> 'edit_posts',
  'redirect'		=> false
));

}

function lookslike_menus() {

	$locations = array(
		'primary'  => __( 'Desktop Horizontal Menu', 'lookslike' ),
		'mobile'   => __( 'Mobile Menu', 'lookslike' ),
    'topbar'   => __( 'Górna belka', 'lookslike' ),
		'footer'   => __( 'Footer Menu', 'lookslike' ),
	);

	register_nav_menus( $locations );
}
add_action( 'init', 'lookslike_menus' );


function oferta_formularz($title_page, $owner_email, $secret, $key, $type = 'contact') {
  // title_page - z ktorej oferty mailto
  // owner_email - na jakas skrzynke wysylac
  // secret
  // key
  $nameError = '';
  $emailError = '';
  $commentError = '';
  $rodoError = '';
  $phoneError = '';
  $rodo = get_field('rodo', 'option');
  if(isset($_POST['submitted'])) {
    $url = "https://www.google.com/recaptcha/api/siteverify";
      $data = [
        'secret' => $secret,
        'response' => $_POST['token'],
        // 'remoteip' => $_SERVER['REMOTE_ADDR']
      ];


          $options = array(
              'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
              )
            );

          $context  = stream_context_create($options);
          $response = file_get_contents($url, false, $context);

          $res = json_decode($response, true);
          if($res['success'] == true) {

            // tutaj walidacja formularza jesli mamy true z captcha


              if(trim($_POST['contactName']) === '') {
                $nameError = 'Proszę wpisać imię i nazwisko.';
                $hasError = true;
              } else {
                $name = trim($_POST['contactName']);
              }

              if(trim($_POST['email']) === '')  {
                $emailError = 'Proszę wpisać adres e-mail.';
                $hasError = true;
              } else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['email']))) {
                $emailError = 'Wprowadziłeś zły adres e-mail.';
                $hasError = true;
              } else {
                $email = trim($_POST['email']);
              }

              if(trim($_POST['comments']) === '') {
                $commentError = 'Proszę wpisać treść wiadomości.';
                $hasError = true;
              } else {
                if(function_exists('stripslashes')) {
                  $comments = stripslashes(trim($_POST['comments']));
                } else {
                  $comments = trim($_POST['comments']);
                }
              }

              if(trim($_POST['rodo']) === '' || trim($_POST['rodo']) === false || !isset($_POST['rodo'])) {
                $rodoError = 'Proszę wyrazić zgodę na przetwanie danych osobowych';
                $hasError = true;
              } else {
                if(function_exists('stripslashes')) {
                  $rodo = stripslashes(trim($_POST['rodo']));
                } else {
                  $rodo = trim($_POST['rodo']);
                }
              }

              $phone = trim($_POST['phone']);

              if(!isset($hasError)) {
                $site_name = get_bloginfo();
                $emailTo = $owner_email;
                if (!isset($emailTo) || ($emailTo == '') ){
                  $emailTo = $owner_email;
                }
                if ($type == 'contact') {
                  $subject = 'Zapytanie z formularza - '.$title_page;
                  $body = "Nazwa: $name \n\nEmail: $email \n\nTelefon: $phone \n\nTreść: $comments \n\n-- \n\nWiadomość wysłana ze strony internetowej - $site_name";
                } else {
                  $subject = 'Zapytanie ofertowe - '.$title_page;
                  $body = "Zapytanie dotyczy oferty: $title_page \n\nNazwa: $name \n\nEmail: $email \n\nTelefon: $phone \n\nTreść: $comments \n\n-- \n\nWiadomość wysłana ze strony internetowej - $site_name";
                }

                $headers = 'From: '.$name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

                wp_mail($emailTo, $subject, $body, $headers);
                $emailSent = true;
              }

          } else {

            // jeśli błąd captcha

            $captchaError = 'Nie jesteś człowiekiem.';
            $hasError = true;
          }
        }

  // captcha end
?>
<script src="https://www.google.com/recaptcha/api.js?render=<?=$key?>"></script>
<form action="<?php the_permalink(); ?>#contactForm" id="contactForm" class="contactFormOferta" method="post">
  <ul>
      <div>
      <li>
        <input class="input" type="text" name="contactName" id="contactName" value="" placeholder="<?= _e('Twoje imię i nazwisko / Firma','lookslike') ?>" />
        <?php if($nameError != '') { ?>
          <span class="error"><?=$nameError;?></span>
        <?php } ?>
      </li>
      <li class="full">
        <input class="input" type="text" name="email" id="email" value="" placeholder="<?= _e('Adres e-mail','lookslike') ?>"/>
        <?php if($emailError != '') { ?>
          <span class="error"><?=$emailError;?></span>
        <?php } ?>
      </li>
      <li>
        <input class="input" type="text" name="phone" id="phone" value="" placeholder="<?= _e('Telefon','lookslike') ?>"/>
      </li>
      <li class="textarea">
        <textarea class="input" name="comments" id="commentsText" placeholder="<?= _e('Wiadomość','lookslike') ?>"></textarea>
        <?php if($commentError != '') { ?>
          <span class="error"><?=$commentError;?></span>
        <?php } ?>
      </li>
    </div>
    <li class="formButton">
      <button type="submit" class="classicButton"><?= _e('Wyślij','lookslike') ?></button>
    </li>
    <li class="rodoInfo">
      <p>
        <input type="checkbox" name="rodo" id="rodo" placeholder="<?= _e('Rodo','lookslike') ?>"/>
      <?= $rodo ?>
      </p>
      <?php if($rodoError != '') { ?>
        <span class="error" style="color:#ef6969;padding-left:10px;"><?=$rodoError;?></span>
      <?php } ?>
    </li>
  </ul>
  <input type="hidden" id="token" name="token">
  <input type="hidden" name="submitted" id="submitted" value="true" />
</form>
<!-- walidacja -->

<?php if(isset($captchaError)) { ?>
  <div class="errorCaptcha" style="color:#ef6969;padding-left:10px;">
    <p>
      <?= _e('Nie jesteś człowiekiem','lookslike') ?>
    </p>
  </div>
<?php } ?>
<?php if(isset($emailSent) && $emailSent == true) { ?>
  <div class="thanks" style="color:#28a745;padding-left:10px;">
    <p>
      <?= _e('Dziękujemy, email został pomyślnie przesłany','lookslike') ?>
    </p>
  </div>
<?php } else { ?>

  <?php if(isset($hasError) || isset($captchaError)) { ?>
    <p class="error" style="color:#ef6969;padding-left:10px;">
      <?= _e('Przepraszamy, wystąpił błąd','lookslike') ?>
    <p>

  <?php } ?>
<?php } ?>
<script>
  grecaptcha.ready(function() {
      grecaptcha.execute('<?=$key?>', {action: 'homepage'}).then(function(token) {
         // console.log(token);
         document.getElementById("token").value = token;

      });
  });
</script>

<?php
}

function slick_basic($field_name, $slider_class, $loading) {
  // ustawienia dla nazwy dodajemy w src\js\components\slider.js
  // field_name - nazwa pola z ACF *required
  // slider_classe - nazwa slidera *required
  // loading - jakie ladowanie eager czy lazy *required
    if( $field_name ):
    ?>
    <div class="<?= $slider_class ?>">
              <div class="slide">
                <div class="slideWrapper">
                  <?php
                  $images = get_field($field_name);
                    foreach( $images as $image_id ): ?>
                    <div class="slideContent">
                        <?php echo wp_get_attachment_image($image_id['id'],'auto',false,'loading='.$loading.'') ?>
                    </div>
                  <?php endforeach; ?>
                  <?php wp_reset_query(); ?>
              </div>
            </div>
            <div class="pager"></div>
    </div>

    <?php
        endif;

  }

function slick_advance($field_name, $slider_class, $loading, $subfields = NULL) {
  // ustawienia dla nazwy dodajemy w src\js\components\slider.js
  // field_name - nazwa pola z ACF *required
  // slider_classe - nazwa slidera *required
  // subfields to array z danymi subfieldów przyjmuje wartość nazwy pola ACF bądź false
  // loading - jakie ladowanie eager czy lazy *required
  if( have_rows($field_name) ):
  ?>
  <div class="<?= $slider_class ?>">
            <div class="slider">
              <div class="sliderWrapper">
                <?php while( have_rows($field_name) ) : the_row();?>
                  <div class="slideContent">
                    <?php
                    if($subfields['ikona'] !== false): ?>
                    <i class="sliderIcon icon <?=get_sub_field($subfields['ikona']); ?>"></i>
                    <?php endif;
                    if($subfields['gallery'] !== false): ?>
                      <?php foreach( get_sub_field($subfields['gallery']) as $image_id ): ?>
                          <img loading="<?= $loading ?>" class="sliderGallery" src="<?= $image_id ?>">
                      <?php endforeach; ?>
                    <?php endif; ?>
                    <?php
                    if($subfields['tytul'] !== false): ?>
                    <h5 class="sliderTitle"><?=get_sub_field($subfields['tytul']); ?></h5>
                    <?php endif;
                    if($subfields['opis'] !== false): ?>
                    <p class="sliderDescription"><?=get_sub_field($subfields['opis']); ?></p>
                    <?php endif; ?>
                  </div>
                <?php endwhile; wp_reset_query(); ?>
            </div>
          </div>
          <div class="pager"></div>
  </div>

  <?php
      endif;

}


// animacje

function animacje_klasy($typ) {
  // delay 1,2,3,4,5s
  // animate__slow 	2s
  // animate__slower 	3s
  // animate__fast 	800ms
  // animate__faster 	500ms
  switch($typ){
    case "p_lewo":
      return "wow animate__animated animate__fadeInUp";
    case "p_prawo":
      return "wow animate__animated animate__fadeInUp";
    case "p_srodek":
      return "wow animate__animated animate__fadeInUp";
    case "oferta_lewo":
      return "wow animate__animated animate__fadeInLeft";
    case "oferta_prawo":
      return "wow animate__animated animate__fadeInRight";
    case "oferta_srodek":
      return "wow animate__animated animate__fadeInUp";
    case "div_lista_lewo":
      return "wow animate__animated animate__fadeInUp";
    case "div_lista_prawo":
      return "wow animate__animated animate__fadeInRight";
    case "div_lista_srodek":
      return "wow animate__animated animate__fadeInUp";
    case "naglowek_lewo":
      return "wow animate__animated animate__fadeInUp";
    case "naglowek_srodek":
      return "wow animate__animated animate__fadeInUp";
    case "naglowek_prawo":
      return "wow animate__animated animate__fadeInUp";
    case "zdjecie":
      return "animate__animated animate__fadeIn animate__delay-1s animate__slow";
    case "delikatnie":
      return "wow animate__animated animate__fadeIn animate__delay-1s";
    case "standard":
      return "wow animate__animated animate__fadeIn";
    case "blok_lewy":
      return "animate__animated animate__fadeInLeft animate__delay-1s animate__slow";
    case "blok_prawy":
        return "animate__animated animate__fadeInRight";
    case "blok_srodek":
      return "animate__animated animate__fadeIn animate__delay-1s";
  }
}
function animacje_offset($wartosc) {
  return "data-wow-offset='".$wartosc."'";
}
/*=============================================
=            BREADCRUMBS			            =
=============================================*/

//  to include in functions.php
function the_breadcrumb() {

    $sep = ' <span>/</span> ';

    if (!is_front_page()) {

	// Start the breadcrumb with a link to your homepage
        echo '<div class="breadcrumbs">';
        echo '<a href="';
        echo get_option('home');
        echo '">';
        echo '<i class="icon icon-house"></i>';
        echo '</a>' . $sep;

	// Check if the current page is a category, an archive or a single page. If so show the category or archive name.
        if (is_category()){
            $categories = get_the_category();
            $category_id = $categories[0]->cat_ID;
            $post = get_post();
            echo '<a href="';
            echo get_permalink( get_option( 'page_for_posts' ) );
            echo '">';
            echo _e('Aktualności', "lookslike");
            echo "</a>";
            echo '<span>/</span> <span>';
            echo _e(get_cat_name($category_id), "lookslike");
            echo "</span>";

        }
        elseif(is_singular('post')){
          $post = get_post();
          echo '<a href="';
          echo get_permalink( get_option( 'page_for_posts' ) );
          echo '">';
          echo _e("Aktualności", "lookslike");
          echo "</a>";
        }
        elseif(is_singular() && !is_page()){
          $post = get_post();
          echo '<a href="';
          echo get_site_url().'/'.$post->post_type.'/';
          echo '">';
          echo $post->post_type;
          echo "</a>";
        }
          elseif (is_archive() || is_single()){
            if ( is_day() ) {
                printf( __( '%s', 'lookslike' ), get_the_date() );
            } elseif ( is_month() ) {
                printf( __( '%s', 'lookslike' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'lookslike' ) ) );
            } elseif ( is_year() ) {
                printf( __( '%s', 'lookslike' ), get_the_date( _x( 'Y', 'yearly archives date format', 'lookslike' ) ) );
            } else {
              $post = get_post();
              echo $post->post_type;

            }
        }

	// If the current page is a single post, show its title with the separator
        if (is_single()) {
            echo $sep;
            the_title();
        }

	// If the current page is a static page, show its title.
        if (is_page()) {
            echo the_title();
        }

	// if you have a static page assigned to be you posts list page. It will find the title of the static page and display it. i.e Home >> Blog
        if (is_home()){
            global $post;
            $page_for_posts_id = get_option('page_for_posts');
            if ( $page_for_posts_id ) {
                $post = get_page($page_for_posts_id);
                setup_postdata($post);
                the_title();
                rewind_posts();
            }
        }

        echo '</div>';
    }
}
/*
* Credit: http://www.thatweblook.co.uk/blog/tutorials/tutorial-wordpress-breadcrumb-function/
*/

add_action( 'pre_get_posts', 'add_custom_post_types_to_loop' );

function add_custom_post_types_to_loop( $query ) {
	if ( is_home() && $query->is_main_query() )
		$query->set( 'post_type', array( 'post', 'oferta' ) );
	return $query;
}


// excerpt Limit
/* Change excerpt length */

function wplab_custom_excerpt_length( $length ) {
     return 25;
 }
 add_filter( 'excerpt_length', 'wplab_custom_excerpt_length', 999 );

 add_action('admin_head', 'admin_style');

 function modul_zapytanie( $telefon) { ?>
   <?php $company = get_field('company', 'option'); ?>
   <?php $email =  $company['adres_email_zapytanie'] ?>
   <div class="offerButtons">
     <button id="modalButton" class="sendOffer flexing"><?php _e('WYŚLIJ ZAPYTANIE','lookslike'); ?> <i class="icon icon-email-form"></i> </button>
     <a href="tel:<?php echo $telefon; ?>" class="sendOffer phone flexing"><?php _e('ZADZWOŃ','lookslike'); ?> <i class="icon icon-phone-form"></i> </a>
   </div>


<script type="text/javascript">
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("modalButton");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
  modal.style.display = "flex";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

</script>

 <?php }

function admin_style() {
  echo '<style>
  .cmsLogoPortfolio{width:50px;margin:12px 8px auto auto}
  </style>';
}

/* Start funkcji Users
 * Creating the Manager role
 * Any role cannot create Administrator user
*/

function what_user_can() { // creating role capabilities
  add_role( 'manager', 'Manager strony',
    [
      'read'         => true,
      'edit_posts'   => true,
      'edit_others_posts' => true,
      'edit_private_posts' => true,
      'publish_posts' => true,
      'read_private_posts' => true,
      'edit_others_posts' => true,
      'edit_published_posts' => true,
      'edit_pages' => true,
      'edit_others_pages' => true,
      'read_private_pages' => true,
      'edit_private_pages' => true,
      'publish_pages' => true,
      'edit_published_pages' => true,
      'delete_posts' => true,
      'delete_private_posts' => true,
      'upload_files' => true,
      'delete_published_posts' => true,
      'manage_categories' => true,
      'delete_pages' => true,
      'delete_others_pages' => true,
      'delete_published_pages' => true,
      'delete_others_posts' => true,
      'delete_private_posts' => true,
      'delete_private_pages' => true,
      'manage_options' => true,
      'edit_theme_options' => true,
      'create_users' => true
      ]
  );
  $user = wp_get_current_user(); // specify if user is not administrator
   if ( !in_array('administrator', $user->roles) ) {
      add_filter('acf/settings/show_admin', '__return_false'); // turn off ACF
      remove_action( 'admin_menu', 'cptui_plugin_menu' ); // turn off CPT UI
      function wpdocs_remove_menus(){ // delete specific menu items
        remove_menu_page( 'edit-comments.php' );  // turn off Comments
      }
      add_action( 'admin_menu', 'wpdocs_remove_menus' );
   }
   remove_role('author');  // remove specific roles
   remove_role('editor');
   remove_role('contributor');
   remove_role('subscriber');
 }
  add_action('init', 'what_user_can'); // init function

  /**
 * Deny access to 'administrator' for other roles
 * Else anyone, with the edit_users capability, can edit others
 * to be administrators - even if they are only editors or authors
 *
 * @since   0.1
 * @param   (array) $all_roles
 * @return  (array) $all_roles
 */
function deny_change_to_admin( $all_roles )
{
    if ( ! current_user_can('administrator') )
        unset( $all_roles['administrator'] );

    if (
        ! current_user_can('administrator')
        OR ! current_user_can('editor')
    )
        unset( $all_roles['editor'] );

    if (
        ! current_user_can('administrator')
        OR ! current_user_can('editor')
        OR ! current_user_can('author')
    )
        unset( $all_roles['author'] );

    return $all_roles;
}
function deny_rolechange()
{
    add_filter( 'editable_roles', 'deny_change_to_admin' );
}
add_action( 'after_setup_theme', 'deny_rolechange' );




 function buildFormAjax($security, $title, $typ){
   // tworzmy tutaj formularz i wysyłamy stąd zapytanie do ajaxa z $security zabezpieczajacym to zapytanie
   if($typ == "kontakt"):
     $title = "Kontakt";
   endif;
   ?>
   <script src="https://www.google.com/recaptcha/api.js?render=<?=get_field('recaptcha_v3_-_public_key', 'option')?>"></script>
   <form action="" id="contactForm" class="contactFormOferta" method="post">
     <ul>
         <div>
         <li>
           <input class="input" type="text" name="name" id="name" value="" placeholder="<?= _e('Twoje imię i nazwisko','lookslike') ?>" />
         </li>
         <li class="full">
           <input class="input" type="text" name="email" id="email" value="" placeholder="<?= _e('Adres e-mail','lookslike') ?>"/>
         </li>
         <li>
           <input class="input" type="text" name="phone" id="phone" value="" placeholder="<?= _e('Telefon','lookslike') ?>"/>
         </li>
         <li class="textarea">
           <textarea class="input" name="message" id="message" placeholder="<?= _e('Wiadomość','lookslike') ?>"></textarea>
         </li>
       </div>
       <li class="formButton">
         <button type="submit" class="classicButton"><?= _e('Wyślij','lookslike') ?></button>
         <input type="hidden" name="action" value="formAjax" style="display: none; visibility: hidden; opacity: 0;">
       </li>
       <?php
       if(get_field('rodo', 'option')):
        ?>
       <li class="rodoInfo">
         <p>
           <input type="checkbox" name="rodo" id="rodo" placeholder="<?= _e('Rodo','lookslike') ?>"/>
           <?= get_field('rodo', 'option') ?>
         </p>
       </li>
       <?php
        endif;
        ?>
     </ul>
     <input type="hidden" id="token" name="token">
     <input type="hidden" id="security" name="security" value="<?=$security?>">
     <input type="hidden" name="submitted" id="submitted" value="true" />
     <input type="hidden" name="title" id="titlePage" value="<?=$title?>" />
     <input type="hidden" name="typ" id="typ" value="<?=$typ?>" />
     <div class="validateFormSuccessField"></div>
   </form>
   <?php  $ajax_nonce = wp_create_nonce( "security_".$security );  ?>

   <script type="text/javascript">
     grecaptcha.ready(function() {
         grecaptcha.execute('<?=get_field('recaptcha_v3_-_public_key', 'option')?>', {action: 'homepage'}).then(function(token) {
            // console.log(token);
            document.getElementById("token").value = token;

         });
     });

     jQuery( '#contactForm' ).on( 'submit', function(event) {
       event.preventDefault();
         var form_data = jQuery( this ).serializeArray();
         form_data.push( { "name" : "security", "value" : "<?= $ajax_nonce ?>" } );

         jQuery.ajax({
             url : '<?= admin_url('admin-ajax.php'); ?>',
             type : 'POST',
             data : form_data,
             success : function( response ) {
               response = JSON.parse(response);
               if(response.status == false){
                 jQuery("#contactForm .validateFormSuccessField .validateFormSuccess").remove();
                 jQuery("#contactForm .validateFormSuccessField .validateFormFail").remove();
                 jQuery("#contactForm li .validateFormFail").remove();
                 if(response.message.email){
                   jQuery("#contactForm #email").parent().append("<p class='validateFormFail'>"+response.message.email+"</p>");
                 }
                 if(response.message.phone){
                   jQuery("#contactForm #phone").parent().append("<p class='validateFormFail'>"+response.message.phone+"</p>");
                 }
                 if(response.message.name){
                   jQuery("#contactForm #name").parent().append("<p class='validateFormFail'>"+response.message.name+"</p>");
                 }
                 if(response.message.rodo){
                   jQuery("#contactForm #rodo").parent().append("<p class='validateFormFail'>"+response.message.rodo+"</p>");
                 }
                 if(response.message.message){
                   jQuery("#contactForm #message").parent().append("<p class='validateFormFail'>"+response.message.message+"</p>");
                 }
               }
               if(response.status == true){
                 if(response.message.success == undefined){
                   jQuery("#contactForm .validateFormSuccessField .validateFormSuccess").remove();
                   jQuery("#contactForm .validateFormSuccessField .validateFormFail").remove();
                   jQuery("#contactForm li .validateFormFail").remove();
                    jQuery("#contactForm .validateFormSuccessField").append("<p class='validateFormFail'>Odśwież stronę aby wysłać nową wiadomość</p>");
                 }
                 else{
                   jQuery("#contactForm .validateFormSuccessField .validateFormSuccess").remove();
                   jQuery("#contactForm .validateFormSuccessField .validateFormFail").remove();
                   jQuery("#contactForm li .validateFormFail").remove();
                    jQuery("#contactForm .validateFormSuccessField").append("<p class='validateFormSuccess'>"+response.message.success+"</p>");
                 }
               }
             },
             fail : function( err ) {

                 alert( "wystąpił błąd: " + err );
             },
             error: function (xhr, ajaxOptions, thrownError) {
               console.log(thrownError);
             }
         });

         return false;
     });
     </script>

  <?php
 }

 function formAjax()
 {
      wp_verify_nonce("security_".$_POST['security']);


      $name = trim( strip_tags( htmlspecialchars( $_POST['name'] ) ) );
      $email = trim( strip_tags( htmlspecialchars( $_POST['email'] ) ) );
      $phone = trim( strip_tags( htmlspecialchars( $_POST['phone'] ) ) );
      $text = trim( strip_tags(htmlspecialchars( $_POST['message'] ) ) );


      $response = array(
          'status' => true,
          'message' => array()
      );

      if ( empty( $name ) ) {
          $response['status'] = false;
          $response['message']['name'] = 'Proszę wpisać imię i nazwisko lub nazwę Firmy.';
      } else if ( ! preg_match( "/^[a-zA-Z ]*$/", $name ) ) {
          $response['status'] = false;
          $response['message']['name'] = 'Użyto niedwozolonych znaków.';
      } else {
          $message .= 'Name: ' . $name . ', ';
      }


      if ( empty( $email ) ) {
          $response['status'] = false;
          $response['message']['email'] = 'Email jest wymagany.';
      } else if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
          $response['status'] = false;
          $response['message']['email'] = 'Zły format emailu.';
      } else {
          $message .= 'Email: ' . $email . ', ';
      }

      if ( ! preg_match("/^[0-9\+]{8,13}$/", $phone) && $phone !== '') {
          $response['status'] = false;
          $response['message']['phone'] = 'Zły format numeru telefonu.';
      }
      elseif( empty( $phone ) ) {
          $response['status'] = true;
  
      }


      if ( empty( $text ) ) {
          $response['status'] = false;
          $response['message']['message'] = 'Wypełnij treść wiadomości.';
      }
      else{
        $content .= 'Wiadomość: ' . $text . '.';
      }

      if(!isset($_POST['rodo'])) {
        $response['status'] = false;
        $response['message']['rodo'] = 'Proszę wyrazić zgodę na przetwanie danych osobowych.';
      }

      if ( $response['status'] == true ) {
          // captch validacja
          $url = "https://www.google.com/recaptcha/api/siteverify";
          $data = [
            'secret' => get_field('recaptcha_v3_secret_key', 'option'),
            'response' => $_POST['token'],
            // 'remoteip' => $_SERVER['REMOTE_ADDR']
          ];
          $options = array(
              'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
              )
            );
          $context  = stream_context_create($options);
          $response_google = file_get_contents($url, false, $context);
          $res = json_decode($response_google, true);
          if($res['success'] == true) {
          // captcha end validate
          $site_name = get_bloginfo();
          $company = get_field('company', 'option');
          $response['message']['success'] = "Dziękujemy, wiadomość została wysłana.";
          $headers = 'Content-type: text/html; charset=utf-8';
          if ($_POST['typ'] == 'kontakt') {
            $subject = 'Zapytanie z formularza '.$_POST['title'];
            $body = "Zapytanie dotyczy oferty: ".$_POST['title']."\n\nNazwa: $name \n\nEmail: $email \n\nTelefon: $phone \n\nTreść: $content \n\n-- \n\nWiadomość wysłana ze strony internetowej - $site_name";
          } else {
            $subject = 'Zapytanie ofertowe - '.$_POST['title'];
            $body = "Zapytanie dotyczy oferty: ".$_POST['title']."\n\nNazwa: $name \n\nEmail: $email \n\nTelefon: $phone \n\nTreść: $content \n\n-- \n\nWiadomość wysłana ze strony internetowej - $site_name";
          }
          $headers = 'From: '.$name.' <'.$company["adres_email_zapytanie"].'>' . "\r\n" . 'Reply-To: ' . $email;
          wp_mail($company["adres_email_zapytanie"], $subject, $body, $headers);
        }

      }
      echo json_encode($response);
      die();

 }

 add_action('wp_ajax_formAjax', 'formAjax');
 add_action('wp_ajax_nopriv_formAjax', 'formAjax');

// Koniec funkcji Users
?>
