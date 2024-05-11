<?php
/**
 * Complément de fonction.php
 * fonctions pour AJAX 
 *
 * @package WordPress
 * @subpackage nathalie-mota theme
 */

 include_once('utils.php');
// Partie pour gerer le padcategorie_filterding de l'affichage des photos  

/**
*  Génération de l'affichage des photos
*/  
function mota_load() { 
  // Vérification de sécurité
  /*if( 
		! isset( $_REQUEST['nonce'] ) or 
       	! wp_verify_nonce( $_REQUEST['nonce'], 'nathalie_mota_nonce' ) 
    ) {
    	wp_send_json_error( "Vous n’avez pas l’autorisation d’effectuer cette action.", 403 );
      exit;
  	}*/

  // Récupération des données pour le filtre et on les nettoie
  // pour éviter toute injection SQL 
  //$categorie_i$format_idd = sanitize_text_field($_POST['categorie_id']);
  //$format_id = sanitize_text_field($_POST['format_id']);


  $categorie_id = isset($_POST['categorie_id']) ? $_POST['categorie_id'] : '';
  $format_id = isset($_POST['format_id']) ? $_POST['format_id'] : '';
  $orderby = sanitize_text_field($_POST['orderby']);
  $order = empty(sanitize_text_field($_POST['order'])) ? 'asc' : sanitize_text_field($_POST['order']);
  $paged = intval($_POST['paged']);

  print_r( $paged );
  print_r( $order);
  print_r( $orderby);

  // Configuration du filtre
  $custom_args = array(
    'post_type' => 'photographie',
      'posts_per_page' => get_option( 'posts_per_page'), // Valeur par défaut
      'orderby' => $orderby,
      'order' => $order,
      'paged' => $paged, 
      /*'tax_query'    => array(
          'relation'      => 'AND', 
          array(
            'taxonomy'	=> 'categorie',
            'field'		=> 'term_id',
            //'compare'   => 'LIKE',
            'terms'		=> $categorie_id
        ),
        array(
            'taxonomy'	=> 'format',
            'field'		=> 'term_id',
            //'compare'   => 'LIKE',
            'terms'		=> $format_id 
        )
        ),*/
        'nopaging' => false,
        );  

    // Ajouter la taxonomie "categorie" si elle est sélectionnée
    if (!empty($categorie_id)) {
      echo " categorie:";
      print_r( $categorie_id );
      $custom_args['tax_query'][] = array(
        'taxonomy' => 'categorie',
        'field' => 'term_id',
        'terms' => $categorie_id,
      );
      //set_excluded_id_terms($categorie_id, 'categorie');
    }

    // Ajouter la taxonomie "format" si elle est sélectionnée
    if (!empty($format_id)) {
      echo " format:";
      print_r( $format_id );
      $custom_args['tax_query'][] = array(
          'taxonomy' => 'format',
          'field' => 'term_id',
          'terms' => $format_id,
        );
      //set_excluded_id_terms($format_id, 'format');
    }
    $query_more = new WP_Query( $custom_args ); 
    set_filtered_posts($query_more->posts);

    /*if (is_single()){
      $nb_total_posts  = $query_more->found_posts;
      echo "appel de mota_load dans single: avec  ".$nb_total_posts." posts";
      //print_r($query_more->posts);
      return $query_more;
    }*/

     
    $nb_total_posts  = $query_more->found_posts;
    $max_pages = $query_more->max_num_pages;  
    echo " articles trouvés: ".$nb_total_posts. " et  un nombre de pages: ".$max_pages; 

    $custom_args2 = array_replace($custom_args, array( 'posts_per_page' => -1, 'nopaging' => true,));
    $total_posts = get_posts( $custom_args2 );
    //print_r( $total_posts);
    $nb_total_posts = count($total_posts);
    //print_r( $nb_total_posts);

    $response = '';

    if ($paged === 1) :
    ?>
    <form>  
      <!-- Mise à disposition de JS du tableau contenant toutes les données de la requette et le nombre -->                 
      <input type="hidden" name="total_posts" id="total_posts" value="<?php print_r( $total_posts); ?>">     
      <input type='hidden' name='max_pages' id='max_pages' value='<?php echo $max_pages; ?>'>
      <input type="hidden" name="nb_total_posts" id="nb_total_posts" value="<?php  echo $nb_total_posts; ?>">
       <!-- Mise à jour par ajax.php -->                                    
    </form>  
  
    <?php 
    endif;

    if($query_more->have_posts()) {
      while($query_more->have_posts()) : $query_more->the_post();
        $response .= get_template_part('template-parts/post/publication');
      endwhile;        
    } else {
      $response = ''; 
    }

    wp_reset_postdata();
    die();
  }
  add_action('wp_ajax_mota_load', 'mota_load');
  add_action('wp_ajax_nopriv_mota_load', 'mota_load');


  function mota_more_load() { 
    // Vérification de sécurité
    /*if( 
      ! isset( $_REQUEST['nonce'] ) or 
           ! wp_verify_nonce( $_REQUEST['nonce'], 'nathalie_mota_nonce' ) 
      ) {
        wp_send_json_error( "Vous n’avez pas l’autorisation d’effectuer cette action.", 403 );
        exit;
      }*/
  
  
    $categorie_id = isset($_POST['categorie_id']) ? $_POST['categorie_id'] : '';
    $format_id = isset($_POST['format_id']) ? $_POST['format_id'] : '';
    $orderby = sanitize_text_field($_POST['orderby']);
    $order = sanitize_text_field($_POST['order']);
    $paged = intval($_POST['paged']);

  
    print_r( $paged );
    print_r( $order);
    print_r( $orderby);
  
    // Configuration du filtre
    $custom_args = array(
      'post_type' => 'photographie',
        'posts_per_page' => get_option( 'posts_per_page'), // Valeur par défaut
        'orderby' => $orderby,
        'order' => $order,
        'paged' => $paged, 
        'nopaging' => false,
        );  
  
      // Ajouter la taxonomie "categorie" si elle est sélectionnée
      if (!empty($categorie_id)) {
        //echo " categorie:";
        //print_r( $categorie_id );
        $custom_args['tax_query'][] = array(
          'taxonomy' => 'categorie',
          'field' => 'term_id',
          'terms' => $categorie_id,
        );
        //set_excluded_id_terms($categorie_id, 'categorie');
      }
  
      // Ajouter la taxonomie "format" si elle est sélectionnée
      if (!empty($format_id)) {
        //echo " format:";
        //print_r( $format_id );
        $custom_args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'term_id',
            'terms' => $format_id,
          );
        //set_excluded_id_terms($format_id, 'format');
      }
      $query_more = new WP_Query( $custom_args ); 
      set_filtered_more_posts($query_more->posts);
  
      //$total_posts = get_posts( $custom_args );
      echo $query_more->found_posts . " articles trouvés". "\n"; 
      $nb_total_posts  = $query_more->found_posts*$paged;
      echo $query_more->found_posts . " nombre total de posts"; 
      $max_pages = $query_more->max_num_pages;   
  
      $response = '';
  
      if ($paged === 1) :
      ?>
      <form>  
        <!-- Mise à disposition de JS du tableau contenant toutes les données de la requette et le nombre -->                 
        <input type="hidden" name="total_posts" id="total_posts" value="<?php print_r( $total_posts); ?>">     
        <input type='hidden' name='max_pages' id='max_pages' value='<?php echo $max_pages; ?>'>
        <input type="hidden" name="nb_total_posts" id="nb_total_posts" value="<?php  echo $nb_total_posts; ?>">
         <!-- Mise à jour par ajax.php -->                                    
      </form>  
    
      <?php 
      endif;
  
      if($query_more->have_posts()) {
        while($query_more->have_posts()) : $query_more->the_post();
          $response .= get_template_part('template-parts/post/publication');
        endwhile;        
      } else {
        $response = ''; 
      }
  
      wp_reset_postdata();
      die();
    }
    add_action('wp_ajax_mota_more_load', 'mota_more_load');
    add_action('wp_ajax_nopriv_mota_more_load', 'mota_more_load');
  



/**
*  Récupération des données de de la photo pour la lightbox
*/ 
function mota_lightbox() {
  if( 
		! isset( $_POST['nonce'] ) or 
       	! wp_verify_nonce( $_POST['nonce'], 'mota_nonce' ) 
    ) {
    	wp_send_json_error( "Vous n’avez pas l’autorisation d’effectuer cette action.", 403 );
      exit;
  	}

  // On vérifie que l'identifiant a bien été envoyé
  if( ! isset( $_POST['photo_id'] ) ) {
    wp_send_json_error( "L'identifiant de la photo est manquant.", 403 );
    exit;
  }

  // Récupération des données pour le filtre
  $photo_id = intval($_POST['photo_id']);
  
  // Configuration du filtre
  $query_lightbox = new WP_Query([
    'post_type' => 'photographie',
    'posts_per_page' => -1,
  ]);
 
$response = '';

if($query_lightbox->have_posts()) {
  while($query_lightbox->have_posts()) : $query_lightbox->the_post();
  if ( get_the_id() == $photo_id) {
    $response = get_template_part('template-parts/modal/lightbox');
  }
  endwhile;
} else {
  $response = '';

}

wp_reset_postdata();
exit;
 }
add_action('wp_ajax_mota_lightbox', 'mota_lightbox');
add_action('wp_ajax_nopriv_mota_lightbox', 'mota_lightbox');

?>