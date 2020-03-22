<?php
/**
 * Single post partial template.
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
		<div id="single-card" class="row no-gutters">
			<div class="col-md-3">
				<img src="<?php echo esc_url( $img_url ); ?>" id="single-poster" class="card-img" alt="picture of sales object">
			</div>
			<div class="col-md-8">
				<div class="card-body">

					<?php if ( get_post_meta( $post->ID, 'valid_imdb_id', true ) ) : ?>
						<a href="https://www.imdb.com/title/<?php echo esc_attr( get_post_meta( $post->ID, 'imdb_id', true ) ); ?>"><img id="imdb-button" src="https://img.icons8.com/color/48/000000/imdb.png"/></a>
					<?php endif; ?>
					<h1 id="single-title" class="entry-title"><?php the_title(); ?></h1>
					<div class="stars"><?php echo kk_star_ratings(); ?></div>

					<?php
					$genres = get_the_terms( $post->ID, 'genre' );
					if ( false !== $genres ) { ?>
						<p><strong>Genres: </strong>
						<?php
						$number_of_genres = count( $genres );
						$seperator = ', ';
						for ( $i = 0; $i < $number_of_genres; $i++ ) {
							if ( $number_of_genres - 1 === $i ) {
								$seperator = '';
							}
							echo esc_html( $genres[ $i ]->name . $seperator );
						}
						?>
						</p>
						<?php
					}
					?>

					<?php if ( ! empty( get_post_meta( $post->ID, 'imdb_year', true ) ) ) : ?>
					<p><strong>Released: </strong><?php echo esc_html( get_post_meta( $post->ID, 'imdb_year', true ) ); ?></p>
					<?php endif; ?>

					<?php if ( ! empty( get_post_meta( $post->ID, 'imdb_actors', true ) ) ) : ?>
					<p><strong>Actors: </strong><?php echo esc_html( get_post_meta( $post->ID, 'imdb_actors', true ) ); ?></p>
					<?php endif; ?>

					<p class="card-text"><?php the_content(); ?></p>
				</div>
			</div>
		</div>
	</div>

</article><!-- #post-## -->
