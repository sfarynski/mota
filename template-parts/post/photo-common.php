<?php 
   // [post_type] => post
   // [post_type] => photo

   // Initialisation de varaibles pour le filtres d'affichage des photos
   $order = "";          
   $orderby = "date";

   // Récupération du n° de la catégorie pour filtrage
   $categorie_values  =get_the_terms(get_the_ID(), 'categorie');  
   $categorie_id  = my_cpf_load_value('term_id', $categorie_values);
   // Récupération du nom de la catégorie 
   $categorie  = my_cpf_load_value('name', $categorie_values); 
   $format_values  =get_the_terms(get_the_ID(), 'format');  
   $format_id  = my_cpf_load_value('term_id', $format_values);

   // Récupérer l'ID du post actuellement ouvert
   $current_post_id = get_the_ID();
   $custom_args = array(
      'post_type' => 'photographie',
      'posts_per_page' => 2,
      'orderby' => 'rand',
      'post__not_in' => array($current_post_id),
      'tax_query' => array(
            array(
               'taxonomy' => 'categorie',
               'field' => 'slug',
               'terms' =>  (!empty($categorie_values)) ? $categorie_values[0]->slug : '',
            ),
      ),
   );
   
   //On crée ensuite une instance de requête WP_Query basée sur les critères placés dans la variables $args
   
   $total_posts = get_posts( $custom_args );
   $query = new WP_Query( $custom_args );
   $nb_total_posts = count($total_posts);
   $max_pages = $query->max_num_pages;
  
?>
<?php //print_r( $query->posts ); ?>
 <!-- On vérifie si le résultat de la requête contient des articles -->
  <?php if($query->have_posts()) : ?>
      <article class="container-common flexrow">
      <form>
         <input type="hidden" name="common_posts" id="common_posts" value="<?php print_r( $query->posts); ?>">
         <input type="hidden" name="nb_total_posts" id="nb_total_posts" value="<?php  echo $nb_total_posts; ?>">

      </form>  
      <!-- On parcourt chacun des articles résultant de la requête -->
      <?php while($query->have_posts()) : $query->the_post();           
            get_template_part('template-parts/post/publication');
         endwhile; ?>
      </article>
      <div class="lightbox hidden" id="lightbox">    
         <button class="lightbox__close" title="Refermer cet agrandissement">Fermer</button>
         <div class="lightbox__container">
            <div class="lightbox__loader hidden"></div>
            <div class="lightbox__container_info flexcolumn" id="lightbox__container_info"> 
                  <div class="lightbox__container_content flexcolumn" id="lightbox__container_content"></div>   
                  <button class="lightbox__next" aria-label="Voir la photo suivante" title="Photo suivante"></button>
                  <button class="lightbox__prev" aria-label="Voir la photo précente" title="Photo précédente"></button>                     
            </div>
         </div> 
      </div>
   <?php else : ?>
         <p>Désolé. Aucun article ne correspond à cette demande.</p>    
   <?php endif; ?>      
   <?php
   // On réinitialise à la requête principale
   // wp_reset_query(); 
   wp_reset_postdata();       
   ?>


<!-- Variables qui vont pourvoir être récupérées par JavaScript -->
<form>
   <input type="hidden" name="categorie_id" id="categorie_id" value="<?php echo $categorie_id; ?>">
   <input type="hidden" name="format_id" id="format_id" value="<?php echo $format_id; ?>">
   <input type="hidden" name="orderby" id="orderby" value="<?php echo $orderby; ?>">
   <input type="hidden" name="order" id="order" value="<?php echo $order; ?>">
   <input type="hidden" name="max_pages" id="max_pages" value="<?php echo $max_pages; ?>">
   <input type="hidden" name="ajaxurl" id='ajaxurl' value="<?php echo admin_url( 'admin-ajax.php' ); ?>">
  <!-- c’est un jeton de sécurité, pour s’assurer que la requête provient bien de ce site, et pas d’un autre -->
   <input type="hidden" name="nonce" id='nonce' value="<?php echo wp_create_nonce( 'mota_nonce' ); ?>" > 
</form>  


