<?php 
	// echo ('photo-detail.php');
	//   Vérifier l'activation de ACF
	if ( !function_exists('get_field')) return;

    $reference = get_field('reference');
    $type = get_field('type');
    $categorie_values=get_the_terms( $post->ID, 'categorie' );
    $categorie  = my_cpf_load_value('name', $categorie_values); 
    $format_values=get_the_terms( $post->ID, 'format' );
    $format  = my_cpf_load_value('name', $format_values); 
?>

<article class="container__photo flexcolumn">
    <div class="photo__info flexrow">
        <div class="photo__info--description flexcolumn">
            <h1><?php the_title(); ?></h1>
            <ul class="flexcolumn">
                <!-- Affiche les données ACF -->
                <li class="reference">Référence : 
                    <?php 
                        if($reference) {
                            echo $reference;
                        } else {
                            echo ('Inconnue');
                        }
                    ?>
                </li>
                <li>Catégorie :
                    <?php 
                        if($categorie) {
                            echo $categorie;
                        } else {
                            echo ('Inconnue');
                        }
                    ?>
                </li>
                <li>Format :             
                    <?php 
                        if($format) {
                            echo $format;
                        } else {
                            echo ('Inconnu');
                        }
                    ?>
                </li>
                <li>Type :              
                    <?php 
                        if($type) {
                            echo $type;
                        } else {
                            echo ('Inconnu');
                        }
                    ?>
                </li>
                <li>Année : 
                    <?php echo the_time( 'Y' ); ?>
                </li>
            </ul>
        </div>
        <div class="photo__info--image flexcolumn">
            <div class="container--image brightness">
                <!-- permet d’afficher l’image mise en avant -->
                <?php the_post_thumbnail('medium_large'); ?>            
                <span class="openLightbox"></span>
            </div>                     
            <form>
                <input type="hidden" name="postid" class="postid" value="<?php the_id(); ?>">
                <button class="openLightbox" title="Afficher la photo en plein écran" alt="Afficher la photo en plein écran"
                    data-postid="<?php echo get_the_id(); ?>"       
                    data-arrow="false"
                    data-nonce="<?php echo wp_create_nonce('mota_lightbox'); ?>"
                    data-action="mota_lightbox"
                    data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ); ?>"
                >
                </button>
            </form>
        </div>         
    </div>
</article>

