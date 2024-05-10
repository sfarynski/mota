<?php
/**
 * Modal publication
 *
 * @package WordPress
 * @subpackage nathalie-mota theme
 */
?>

<?php if(has_post_thumbnail()) : ?>                        

<?php
    // Récupérer la taxonomie CPF actuelle
    $term = get_queried_object();                                              

    //$taxonomy_names = get_post_taxonomies(get_the_ID());
    //print_r( $taxonomy_names );
    // Récupération du nom de la catégorie 
    $taxonomy_values=get_the_terms( $post->ID, 'categorie' );
    $categorie  = my_cpf_load_value('name', $taxonomy_values); 
    //print_r( $taxonomy_values);
    //print_r(get_the_ID());
    //print_r(get_post_meta( get_the_ID(), 'type' ));
?>

<!-- Génération du nombre de photo en fonction de l'option dans WordPress -->
<div class="news-info brightness">
    <h2 class="info-title"><?php the_title(); ?></h2>
    <h3 class="info-tax"><?php echo $categorie; ?></h3>
    <a href="<?php the_permalink() ?>" aria-label="Voir le détail de la photo <?php the_title(); ?>" alt="<?php the_title(); ?>" title="Voir le détail de la photo"><span class="detail-photo"></span></a>                            
    <?php the_post_thumbnail(); ?>
    <p><?php the_terms( $post->ID, 'categorie', '' ); ?></p>
    
    <form>
        <input type="hidden" name="postid" class="postid" value="<?php the_id(); ?>">
                       
        <a class="openLightbox" title="Afficher la photo en plein écran" alt="Afficher la photo en plein écran"
            data-postid="<?php echo get_the_id(); ?>"    
            data-arrow="true" 
        >
        </a>
    </form>
</div> 

<?php endif; ?> 
