<?php
/**
 * The single : ATRICLE PHOTO 
 *
 * @package WordPress
 * @subpackage nathalie-mota theme
 */

	get_header();

	function search_post_index(array $posts): int {
		$index=30;
		$nbPosts=count($posts);
		//echo "count posts: ".$nbPosts;
		$id=get_the_ID();
		//echo "current post id: ".$id;
		//$index = array_search( $id, $posts);
		$j=0;
		for( $j=0; $j<$nbPosts;$j++){
			//print_r($posts[$j]);
			//echo "filtered post id: ".$posts[$j]->ID;
			
			if ($posts[$j]->ID == $id){
				//echo "post found";
				$index=$j;
			}
			
		}
		return $index;
	 }
	include_once get_template_directory() . '/includes/utils.php';
	$posts_array=get_filtered_posts();
	//print_r($posts_array);
	$this_index=search_post_index($posts_array);
	//echo "index du post: ".$post->ID."dans tableau: ".$this_index;
	$prev_id = $posts_array[ $this_index - 1 ];
	$next_id = $posts_array[ $this_index + 1 ];
?>

<?php
if( have_posts() ) : while( have_posts() ) : the_post(); ?>
	<section class="photo_detail">
		<?php get_template_part ( 'template-parts/post/photo-detail'); ?>
		
		<div class="photo__contact flexrow">
			<p>Cette photo vous intéresse ? <button class="btn" type="button"><?php echo do_shortcode('[contact]'); ?></button></p>
			<div class="site__navigation flexrow">				
				<div class="site__navigation__prev">
				<?php				
					if(! empty( $prev_id ) ) {
						echo '<a rel="prev" href="' . get_permalink($prev_id) . '" title="' . $prev_title. '" class="previous_post">';
						
						if (has_post_thumbnail($prev_id)){
							?>
							<div>
								<?php echo get_the_post_thumbnail($prev_id, array(77,60));?></div>
							<?php
							}
							else{
								echo '<img src="'. get_stylesheet_directory_uri() .'/assets/images/no-image.jpeg" alt="Pas de photo" width="77px" ><br>';
							}							
							echo '<img src="'. get_stylesheet_directory_uri() .'/assets/images/precedent.png" alt="Photo précédente" ></a>';
					}
					?>
				</div>
				<div class="site__navigation__next">
					<?php
						if(! empty( $next_id )) {
							echo  '<a rel="next" href="' . get_permalink($next_id) . '" title="' . $next_title. '" class="next_post">';
							if (has_post_thumbnail($next_id)){
							?>
								<div><?php echo get_the_post_thumbnail($next_id, array(77,60));?></div>
							<?php
							}
							else{
								echo '<img src="'. get_stylesheet_directory_uri() .'/assets/images/no-image.jpeg" alt="Pas de photo" width="77px" ><br>';
							}							
							echo '<img src="'. get_stylesheet_directory_uri() .'/assets/images/suivant.png" alt="Photo suivante" ></a>';
						}
					?>
					
				</div>
			</div>
		</div>
		<div class="photo__others flexcolumn">
			<h2>Vous aimerez aussi</h2>		
			<div class="photo__others--images flexrow">
				<?php 
					get_template_part ( 'template-parts/post/photo-common');
				 ?>
			</div>
			<button class="btn btn-all-photos" type="button">
				<a href="<?php echo home_url( '/' ); ?>" aria-label="Page d'accueil de Nathalie Mota">Toutes les photos</a>
			</button>
		</div>
	</section>
<?php endwhile; endif; ?>

<?php get_footer();?>
