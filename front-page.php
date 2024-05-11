<?php get_header(); ?>
<div id="front-page"> 
    <section id="content"> 
    <?php  
        // Initialisation de variable pour les filtres de requettes Query
        $order = "ASC";
        $orderby = "date";   
        //Chargement du hero -->
        get_template_part( 'template-parts/header/hero' ); 
		//Chargement des filtres -->
        get_template_part( 'template-parts/post/photo-filter' ); ?>
	   

		<?php  
        // Initialisation du filtre d'affichage des posts
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        $tax_categorie=get_categories(array('taxonomy' => 'categorie')); 

        $custom_args = array(
			'post_type' => 'photographie',
			// 'posts_per_page' => 8,
			'posts_per_page' => get_option( 'posts_per_page'), // Valeur par défaut
			'order' => $order, // "", ASC , DESC 
			'orderby' =>  $orderby, // 'date' , 'meta_value_num', rand
			'paged' => 1,
			'tax_query'		=> array(
				'relation'		=> 'AND',
				array(
					'taxonomy'	=> 'categorie',
					//'field'		=> 'slug',
					'field'		=> 'term_id',
                    'operator' => 'EXISTS',
                    //'compare'   => 'LIKE',
					//'terms'		=> $filter_categorie
				),
				array(
					'taxonomy'	=> 'format',
					'field'		=> 'term_id',
                    'operator' => 'EXISTS'
                    //'compare'   => 'LIKE',
					//'terms'		=> $filter_format
				)
				),
            'nopaging' => false,
            );            
            //On crée ensuite une instance de requête WP_Query basée sur les critères placés dans la variables $args
            $query = new WP_Query( $custom_args ); 
            set_filtered_posts($query->posts);
			//var_dump($query);
            $max_pages = $query->max_num_pages;
            
            // Création du filtre pour la lightbox pour créer un tableau 
            // avec la liste de toutes les photos correspondantes aux filtres
            $custom_args2 = array_replace($custom_args, array( 'posts_per_page' => -1, 'nopaging' => true,));
            $total_posts = get_posts( $custom_args2 );
            //print_r( $total_posts);
            $nb_total_posts = count($total_posts);   
            print_r( $nb_total_posts);       
                      
            ?>
            <!-- On vérifie si le résultat de la requête contient des articles -->
            <?php if($query->have_posts()) : ?>
                <article class="publication-list container-news flexrow">
                    <!-- Mise à disposition de JS du tableau contenant toutes les données de la requette et le nombre -->
                    <form> 
                        <input type="hidden" name="total_posts" id="total_posts" value="<?php print_r( $total_posts); ?>">     
                        <input type='hidden' name='max_pages' id='max_pages' value='<?php echo $max_pages; ?>'>
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
        
        <div id="pagination">
            <!-- afficher le système de pagination (s’il existe de nombreux articles) -->
            <!-- <h3>Articles suivants</h3> -->
            <!-- Variables qui vont pourvoir être récupérées par JavaScript -->
            <form>
                <input type="hidden" name="orderby" id="orderby" value="<?php echo $orderby; ?>">
                <input type="hidden" name="order" id="order" value="<?php echo $order; ?>">
                <input type="hidden" name="posts_per_page" id="posts_per_page" value="<?php echo get_option( 'posts_per_page'); ?>">
                <input type="hidden" name="currentPage" id="currentPage" value="<?php  echo $paged; ?>">
                <input type="hidden" name="displayed_posts" id="displayed_posts" value="<?php  echo get_option( 'posts_per_page'); ?>">
                <input type="hidden" name="ajaxurl" id='ajaxurl' value="<?php echo site_url() ?>/wp-admin/admin-ajax.php">
                <!-- c’est un jeton de sécurité, pour s’assurer que la requête provient bien de ce site, et pas d’un autre -->
                <input type="hidden" name="nonce" id='nonce' value="<?php echo wp_create_nonce( 'mota_nonce' ); ?>" > 
                <!-- On cache le bouton s'il n'y a pas plus d'1 page -->
                <?php if ($max_pages > 1): ?>
                    <button class="btn_load-more" id="load-more">Charger plus</button>
                    <span class="camera"></span>
                <?php endif ?>
            </form>                 
        </div>
      </section>   

  </div>
<?php get_footer(); ?>