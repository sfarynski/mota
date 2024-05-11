<?php
/**
 * Modal lightbox
 *
 * @package WordPress
 * @subpackage nathalie-mota theme
 */

 // Récupérer la taxonomie actuelle

 $categorie_values=get_the_terms( $post->ID, 'categorie' );
 $categorie  = my_cpf_load_value('name', $categorie_values); 
 $reference = get_post_meta( get_the_ID(), 'reference', true );
 $ref=get_field('reference');
?>
<?php the_post_thumbnail('lightbox'); ?>
<div class="lightbox__info flexrow">
     <p class="photo-ref"><?php echo get_the_ID(); ?></p>
    <p class="photo-cat"><?php echo $categorie; ?></p>
</div> 



