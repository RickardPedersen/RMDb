<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! empty( get_post_meta( $post->ID, 'imdb_image_url', true ) ) ) {
	$img_url = get_post_meta( $post->ID, 'imdb_image_url', true );
} else {
	$img_url = 'https://m.media-amazon.com/images/G/01/imdb/images/nopicture/medium/film-3385785534._CB468454186_.png';
}
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<div class="card mb-3 bg-dark">
		<div class="row no-gutters">
			<div class="col-md-2">
				<img src="<?php echo esc_url( $img_url ); ?>" class="card-img poster" alt="picture of sales object">
			</div>
			<div class="col-md-8">
				<div class="card-body">
					<a href="<?php the_permalink(); ?>">
						<h5 class="card-title"><?php the_title(); ?></h5>
					</a>
					<span class="stars"><?php echo kk_star_ratings(); ?></span>
					<p class="card-text"><?php echo esc_html( wp_trim_words( get_the_content(), 20 ) ); ?></p>
				</div>
			</div>
		</div>
	</div>

</article><!-- #post-## -->
