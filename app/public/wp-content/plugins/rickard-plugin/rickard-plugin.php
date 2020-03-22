<?php
/**
 * Plugin Name: Rickard Plugin
 * Description: Movie CPT, IMDb-id custom meta box and Genre custom taxonomy.
 * Version: 1.0.0
 * Author: Rickard Pedersen
 * Author URI: https://github.com/RickardPedersen
 *
 * @package understrap
 */

/**
 * Plugin activation
 */
function plugin_activation() {
	// trigger the function that registers the custom post type.
	create_movie_posttype();
	// add custom meta box.
	imdb_id_add_custom_box();
	// add genre taxonomy.
	add_genre_taxonomy();
	// clear the permalinks after the post type has been registered.
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'plugin_activation' );
/* Activation end */

/**
 * Plugin deactivation
 */
function plugin_deactivation() {
	// unregister genre taxonomy.
	unregister_taxonomy( 'genre' );
	// removes custom meta box.
	remove_meta_box( 'imdb_id', 'movie', 'advanced' );
	// unregister the post type, so the rules are no longer in memory.
	unregister_post_type( 'movie' );
	// clear the permalinks to remove our post type's rules from the database.
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'pluginprefix_deactivation' );
/* Deactivation end */

/**
 * Custom taxonomy start
 */
function add_genre_taxonomy() {
	register_taxonomy(
		'genre',
		'movie',
		array(
			// Hierarchical taxonomy (like categories).
			'hierarchical' => true,
			// This array of options controls the labels displayed in the WordPress Admin UI.
			'labels'       => array(
				'name'              => _x( 'Genres', 'taxonomy general name' ),
				'singular_name'     => _x( 'Genre', 'taxonomy singular name' ),
				'search_items'      => __( 'Search Genres' ),
				'all_items'         => __( 'All Genres' ),
				'parent_item'       => __( 'Parent Genre' ),
				'parent_item_colon' => __( 'Parent Genre:' ),
				'edit_item'         => __( 'Edit Genre' ),
				'update_item'       => __( 'Update Genre' ),
				'add_new_item'      => __( 'Add New Genre' ),
				'new_item_name'     => __( 'New Genre Name' ),
				'menu_name'         => __( 'Genres' ),
				'not_found'         => __( 'No genres found.' ),
			),
			// Control the slugs used for this taxonomy.
			'rewrite'      => array(
				'slug'         => 'genre',
				'with_front'   => false,
				'hierarchical' => true,
			),
			'show_in_rest' => true,
			'has_archive'  => true,
		)
	);
}
add_action( 'init', 'add_genre_taxonomy', 0 );
/* Custom taxonomy end */

/**
 * Custom Post Type Start
 */
function create_movie_posttype() {

	$supports = array(
		'title',
		'editor',
		'thumbnail',
	);
	$labels   = array(
		'name'                     => __( 'Movies', 'understrap-child' ),
		'singular_name'            => __( 'Movie', 'understrap-child' ),
		'menu_name'                => __( 'Movies', 'understrap-child' ),
		'all_items'                => __( 'All Movies', 'understrap-child' ),
		'add_new'                  => __( 'Add new', 'understrap-child' ),
		'add_new_item'             => __( 'Add new Movie', 'understrap-child' ),
		'edit_item'                => __( 'Edit Movie', 'understrap-child' ),
		'new_item'                 => __( 'New Movie', 'understrap-child' ),
		'view_item'                => __( 'View Movie', 'understrap-child' ),
		'view_items'               => __( 'View Movies', 'understrap-child' ),
		'search_items'             => __( 'Search Movies', 'understrap-child' ),
		'not_found'                => __( 'No Movies found', 'understrap-child' ),
		'not_found_in_trash'       => __( 'No Movies found in trash', 'understrap-child' ),
		'parent'                   => __( 'Parent Movie:', 'understrap-child' ),
		'featured_image'           => __( 'Featured image for this Movie', 'understrap-child' ),
		'set_featured_image'       => __( 'Set featured image for this Movie', 'understrap-child' ),
		'remove_featured_image'    => __( 'Remove featured image for this Movie', 'understrap-child' ),
		'use_featured_image'       => __( 'Use as featured image for this Movie', 'understrap-child' ),
		'archives'                 => __( 'Movie archives', 'understrap-child' ),
		'insert_into_item'         => __( 'Insert into Movie', 'understrap-child' ),
		'uploaded_to_this_item'    => __( 'Upload to this Movie', 'understrap-child' ),
		'filter_items_list'        => __( 'Filter Movies list', 'understrap-child' ),
		'items_list_navigation'    => __( 'Movies list navigation', 'understrap-child' ),
		'items_list'               => __( 'Movies list', 'understrap-child' ),
		'attributes'               => __( 'Movies attributes', 'understrap-child' ),
		'name_admin_bar'           => __( 'Movie', 'understrap-child' ),
		'item_published'           => __( 'Movie published', 'understrap-child' ),
		'item_published_privately' => __( 'Movie published privately.', 'understrap-child' ),
		'item_reverted_to_draft'   => __( 'Movie reverted to draft.', 'understrap-child' ),
		'item_scheduled'           => __( 'Movie scheduled', 'understrap-child' ),
		'item_updated'             => __( 'Movie updated.', 'understrap-child' ),
		'parent_item_colon'        => __( 'Parent Movie:', 'understrap-child' ),
	);
	$rewrite  = array(
		'slug'       => 'movie',
		'with_front' => true,
	);
	$args     = array(
		'label'                 => __( 'Movies', 'understrap-child' ),
		'labels'                => $labels,
		'description'           => 'Movie custom post type.',
		'public'                => true,
		'publicly_queryable'    => true,
		'show_ui'               => true,
		'show_in_rest'          => true,
		'rest_base'             => '',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'has_archive'           => true,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => true,
		'delete_with_user'      => false,
		'exclude_from_search'   => false,
		'capability_type'       => 'post',
		'map_meta_cap'          => true,
		'hierarchical'          => false,
		'rewrite'               => $rewrite,
		'query_var'             => true,
		'supports'              => $supports,
	);

	register_post_type( 'movie', $args );
}
add_action( 'init', 'create_movie_posttype' );
/* Custom Post Type End */

/**
 * Custom meta box start
 */
function imdb_id_add_custom_box() {
	add_meta_box(
		'imdb_id',
		'IMDB-id field',
		'imdb_id_box_html',
		'movie'
	);
}

/**
 * Add html for meta box
 *
 * @param type $post current post.
 */
function imdb_id_box_html( $post ) {
	$value = get_post_meta( $post->ID, 'imdb_id', true );
	?>
	<label for="imdb_id_field">imdb_id: </label>
	<input type="text" name="imdb_id_field" value="<?php echo esc_attr( $value ); ?>">
	<?php
}
add_action( 'add_meta_boxes', 'imdb_id_add_custom_box' );

/**
 * Save imdb id as post meta
 *
 * @param type $post_id current post id.
 */
function save_imdb_data( $post_id ) {
	if ( array_key_exists( 'imdb_id_field', $_POST ) ) {
		$imdb_id = sanitize_text_field( wp_unslash( $_POST['imdb_id_field'] ) );

		update_post_meta( $post_id, 'imdb_id', $imdb_id );

		if ( ! empty( $imdb_id ) ) {
			$api_key     = '9614985e';
			$response    = wp_remote_get( "http://www.omdbapi.com/?i=$imdb_id&apikey=$api_key&plot=full" );
			$movie_info  = json_decode( $response['body'] );
			$movie_found = 'True' === $movie_info->Response ? true : false;
			if ( $movie_found ) {
				update_post_meta( $post_id, 'valid_imdb_id', true );
				update_post_meta( $post_id, 'imdb_year', $movie_info->Released );
				update_post_meta( $post_id, 'imdb_actors', $movie_info->Actors );
				update_post_meta( $post_id, 'imdb_image_url', $movie_info->Poster );
				$genres = explode( ',', $movie_info->Genre );
				foreach ( $genres as $genre ) {
					wp_insert_category(
						array(
							'taxonomy'          => 'genre',
							'cat_name'          => $genre,
							'category_nicename' => $genre,
						)
					);

					wp_set_object_terms( $post_id, $genre, 'genre', true );
				}
				$movie = array(
					'ID'           => $post_id,
					'post_title'   => $movie_info->Title,
					'post_content' => $movie_info->Plot,
				);

				wp_update_post( $movie );

			} else {
				update_post_meta( $post_id, 'valid_imdb_id', false );
			}
		} else {
			update_post_meta( $post_id, 'valid_imdb_id', false );
		}
	}
}
add_action( 'save_post', 'save_imdb_data' );
/* Custom meta box end */

/**
 * Adds Genre widget.
 */
class Category_List extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'genre_list', /* Base ID */
			'Genre List', /* Name */
			array( 'description' => __( 'Genre list', 'text_domain' ) )
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;
		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}
		?>

		<hr>
		<div class="list-group bg-dark">
			<?php
			$genres = get_terms(
				array(
					'taxonomy' => 'genre',
					'hide_empty' => false,
				)
			);
			$page_object = get_queried_object();
			foreach ( $genres as $genre ) {
				?>
				<a href="<?php echo esc_url( get_term_link( $genre, 'genre' ) ); ?>" class="list-group-item list-group-item-action bg-dark text-light <?php if ( isset($page_object->term_id) && $page_object->term_id === $genre->term_id) echo 'active'; ?>"><?php echo esc_html( $genre->name ); ?></a>
			<?php } ?>
		</div>
		<?php
		echo $after_widget;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		}
		else {
			$title = __( 'New title', 'text_domain' );
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}
} // class Foo_Widget

add_action( 'widgets_init', 'register_category_list' );

/**
 * Register Category_List widget
 */
function register_category_list() {
	register_widget( 'Category_List' );
}
/* Genre widget end */
