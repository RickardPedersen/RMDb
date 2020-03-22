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

if ( get_post_meta( $post->ID, 'valid_imdb_id', true ) ) {
	$icon_url = 'https://img.icons8.com/officexs/16/000000/ok.png';
} elseif ( ! empty( get_post_meta( $post->ID, 'imdb_id', true ) ) ) {
	$icon_url = 'https://img.icons8.com/officexs/16/000000/cancel-2.png';
} else {
	$icon_url = 'https://img.icons8.com/officexs/16/000000/help.png';
}
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

<li id="movie-list-item" class="list-group-item bg-dark">
	<img class="archive-poster" src="<?php echo esc_url( $img_url ); ?>" alt="">
	<span class="archive-title">
		<a href="<?php the_permalink(); ?>">
			<h2><?php the_title(); ?></h2>
		</a>
		<?php echo kk_star_ratings(); ?>
		<div class="imdb-id-check">IMDb-id: <img src="<?php echo esc_url( $icon_url ); ?>"/></div>
	</span>
</li>

</article><!-- #post-## -->
