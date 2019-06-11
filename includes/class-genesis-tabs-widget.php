<?php
/**
 * Genesis Tabs Widget file.
 *
 * @package genesis-tabs
 */

/**
 * Widget Class. Handles the widget form and output.
 *
 * @package Genesis_Tabs
 * @since 0.9.0
 */
class Genesis_Tabs_Widget extends WP_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		$widget_ops  = array(
			'classname'   => 'ui-tabs',
			'description' => __( 'Displays featured posts in Tabs', 'genesis' ),
		);
		$control_ops = array(
			'width'   => 505,
			'height'  => 350,
			'id_base' => 'tabs',
		);
		parent::__construct( 'tabs', __( 'Featured Tabs', 'genesis' ), $widget_ops, $control_ops );
	}

	/**
	 * Widget Output
	 *
	 * @param array $args Args.
	 * @param array $instance Instance.
	 */
	public function widget( $args, $instance ) {

		/* defaults */
		$instance = wp_parse_args(
			(array) $args['instance'],
			array(
				'title'           => '',
				'posts_cat_1'     => '',
				'posts_cat_2'     => '',
				'posts_cat_3'     => '',
				'posts_cat_4'     => '',
				'posts_cat_5'     => '',
				'posts_cat_6'     => '',
				'posts_cat_7'     => '',
				'posts_cat_8'     => '',
				'posts_cat_9'     => '',
				'posts_cat_10'    => '',
				'show_image'      => 0,
				'image_alignment' => '',
				'image_size'      => '',
				'show_title'      => 0,
				'show_byline'     => 0,
				'post_info'       => '[post_date] ' . __( 'By', 'genesis' ) . ' [post_author_posts_link] [post_comments]',
				'show_content'    => 'excerpt',
				'content_limit'   => '',
				'more_text'       => __( '[Read More...]', 'genesis' ),
			)
		);

		echo esc_attr( $args['before_widget'] );

			/* Output Widget Title */
		if ( ! empty( $instance['title'] ) ) {
			echo esc_attr( $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $args['after_title'] );
		}

			/* Pull the chosen categories into an array */
			$cats = array( $instance['posts_cat_1'], $instance['posts_cat_2'], $instance['posts_cat_3'], $instance['posts_cat_4'], $instance['posts_cat_5'], $instance['posts_cat_6'], $instance['posts_cat_7'], $instance['posts_cat_8'] );

			/* Display the tab links */
			echo '<ul class="ui-tabs-nav">';
		foreach ( (array) $cats as $cat ) {
			if ( $cat ) {
				echo '<li><a href="#cat-' . esc_html( $cat ) . '">' . esc_html( get_cat_name( $cat ) ) . '</a></li>';
			}
		}
			echo '</ul>';

			/* Loop through all chosen categories */
		foreach ( (array) $cats as $cat ) :

			if ( ! $cat ) {
				continue; /* skip iteration if $cat is empty */
			}

			/* Custom loop */
			$tabbed_posts = new WP_Query(
				array(
					'cat'       => $cat,
					'showposts' => 1,
					'orderby'   => 'date',
					'order'     => 'DESC',
				)
			);
			if ( $tabbed_posts->have_posts() ) :
				while ( $tabbed_posts->have_posts() ) :
					$tabbed_posts->the_post();

					echo '<div id="cat-' . esc_html( $cat ) . '" ';
					post_class( 'ui-tabs-hide' );
					echo '>';

					if ( ! empty( $instance['show_image'] ) ) :
						printf(
							'<a href="%s" title="%s" class="%s">%s</a>',
							esc_attr( get_permalink() ),
							the_title_attribute( 'echo=0' ),
							esc_attr( $instance['image_alignment'] ),
							esc_attr(
								genesis_get_image(
									array(
										'format' => 'html',
										'size'   => $instance['image_size'],
									)
								)
							)
						);
						endif;

					if ( ! empty( $instance['show_title'] ) ) :
						printf( '<h2><a href="%s" title="%s">%s</a></h2>', esc_attr( get_permalink() ), the_title_attribute( 'echo=0' ), esc_html( get_the_title() ) );
						endif;

					if ( ! empty( $instance['show_byline'] ) && ! empty( $instance['post_info'] ) ) :
						printf( '<p class="byline post-info">%s</p>', do_shortcode( esc_html( $instance['post_info'] ) ) );
						endif;

					if ( ! empty( $instance['show_content'] ) ) :

						if ( 'excerpt' === $instance['show_content'] ) :
							the_excerpt();
							elseif ( 'content-limit' === $instance['show_content'] ) :
								the_content_limit( (int) $instance['content_limit'], esc_attr( $instance['more_text'] ) );
							else :
								the_content( esc_html( $instance['more_text'] ) );
							endif;

										endif;

					echo '</div><!--end post_class()-->' . "\n\n";

				endwhile;
endif;

			endforeach;

		echo esc_attr( $args['after_widget'] );
		wp_reset_postdata();
	}

	/**
	 * Update data.
	 *
	 * @param array $new_instance New instance.
	 * @param array $old_instance Old instance.
	 */
	public function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	/**
	 * Form output
	 *
	 * @param array $instance Instance.
	 */
	public function form( $instance ) {

		/* ensure value exists */
		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title'           => '',
				'posts_cat_1'     => '',
				'posts_cat_2'     => '',
				'posts_cat_3'     => '',
				'posts_cat_4'     => '',
				'posts_cat_5'     => '',
				'posts_cat_6'     => '',
				'posts_cat_7'     => '',
				'posts_cat_8'     => '',
				'posts_cat_9'     => '',
				'posts_cat_10'    => '',
				'show_image'      => 0,
				'image_alignment' => '',
				'image_size'      => '',
				'show_title'      => 0,
				'show_byline'     => 0,
				'post_info'       => '[post_date] ' . __( 'By', 'genesis' ) . ' [post_author_posts_link] [post_comments]',
				'show_content'    => 'excerpt',
				'content_limit'   => '',
				'more_text'       => __( '[Read More...]', 'genesis' ),
			)
		);
		?>

	<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'genesis' ); ?>:</label>
	<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:95%;" /></p>

	<div class="genesis-widget-column">

		<div class="genesis-widget-column-box genesis-widget-column-box-top">

		<p><span class="description">Choose up to 8 categories to pull posts from. Each category you choose will represent a single tab.</span></p>

		<p>
		<?php
		wp_dropdown_categories(
			array(
				'name'            => $this->get_field_name( 'posts_cat_1' ),
				'selected'        => $instance['posts_cat_1'],
				'orderby'         => 'Name',
				'hierarchical'    => 1,
				'show_option_all' => __( '- None Selected -', 'genesis' ),
				'hide_empty'      => '0',
			)
		);
		?>
		</p>

		<p>
		<?php
		wp_dropdown_categories(
			array(
				'name'            => $this->get_field_name( 'posts_cat_2' ),
				'selected'        => $instance['posts_cat_2'],
				'orderby'         => 'Name',
				'hierarchical'    => 1,
				'show_option_all' => __( '- None Selected -', 'genesis' ),
				'hide_empty'      => '0',
			)
		);
		?>
		</p>

		<p>
		<?php
		wp_dropdown_categories(
			array(
				'name'            => $this->get_field_name( 'posts_cat_3' ),
				'selected'        => $instance['posts_cat_3'],
				'orderby'         => 'Name',
				'hierarchical'    => 1,
				'show_option_all' => __( '- None Selected -', 'genesis' ),
				'hide_empty'      => '0',
			)
		);
		?>
		</p>

		<p>
		<?php
		wp_dropdown_categories(
			array(
				'name'            => $this->get_field_name( 'posts_cat_4' ),
				'selected'        => $instance['posts_cat_4'],
				'orderby'         => 'Name',
				'hierarchical'    => 1,
				'show_option_all' => __( '- None Selected -', 'genesis' ),
				'hide_empty'      => '0',
			)
		);
		?>
		</p>

		<p>
		<?php
		wp_dropdown_categories(
			array(
				'name'            => $this->get_field_name( 'posts_cat_5' ),
				'selected'        => $instance['posts_cat_5'],
				'orderby'         => 'Name',
				'hierarchical'    => 1,
				'show_option_all' => __( '- None Selected -', 'genesis' ),
				'hide_empty'      => '0',
			)
		);
		?>
		</p>

		<p>
		<?php
		wp_dropdown_categories(
			array(
				'name'            => $this->get_field_name( 'posts_cat_6' ),
				'selected'        => $instance['posts_cat_6'],
				'orderby'         => 'Name',
				'hierarchical'    => 1,
				'show_option_all' => __( '- None Selected -', 'genesis' ),
				'hide_empty'      => '0',
			)
		);
		?>
		</p>

		<p>
		<?php
		wp_dropdown_categories(
			array(
				'name'            => $this->get_field_name( 'posts_cat_7' ),
				'selected'        => $instance['posts_cat_7'],
				'orderby'         => 'Name',
				'hierarchical'    => 1,
				'show_option_all' => __( '- None Selected -', 'genesis' ),
				'hide_empty'      => '0',
			)
		);
		?>
		</p>

		<p>
		<?php
		wp_dropdown_categories(
			array(
				'name'            => $this->get_field_name( 'posts_cat_8' ),
				'selected'        => $instance['posts_cat_8'],
				'orderby'         => 'Name',
				'hierarchical'    => 1,
				'show_option_all' => __( '- None Selected -', 'genesis' ),
				'hide_empty'      => '0',
			)
		);
		?>
			</p>

		<p>
		<?php
		wp_dropdown_categories(
			array(
				'name'            => $this->get_field_name( 'posts_cat_9' ),
				'selected'        => $instance['posts_cat_9'],
				'orderby'         => 'Name',
				'hierarchical'    => 1,
				'show_option_all' => __( '- None Selected -', 'genesis' ),
				'hide_empty'      => '0',
			)
		);
		?>
			</p>

		<p>
		<?php
		wp_dropdown_categories(
			array(
				'name'            => $this->get_field_name( 'posts_cat_10' ),
				'selected'        => $instance['posts_cat_10'],
				'orderby'         => 'Name',
				'hierarchical'    => 1,
				'show_option_all' => __( '- None Selected -', 'genesis' ),
				'hide_empty'      => '0',
			)
		);
		?>
			</p>

		</div>

	</div>

	<div class="genesis-widget-column genesis-widget-column-right">

		<div class="genesis-widget-column-box genesis-widget-column-box-top">

		<p><input id="<?php echo esc_attr( $this->get_field_id( 'show_image' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'show_image' ) ); ?>" value="1" <?php checked( 1, $instance['show_image'] ); ?>/> <label for="<?php echo esc_attr( $this->get_field_id( 'show_image' ) ); ?>"><?php esc_html_e( 'Show Featured Image', 'genesis' ); ?></label></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'image_size' ) ); ?>"><?php esc_html_e( 'Image Size', 'genesis' ); ?>:</label>
		<?php $sizes = wp_get_additional_image_sizes(); ?>
		<select id="<?php echo esc_attr( $this->get_field_id( 'image_size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image_size' ) ); ?>">
			<option value="thumbnail">thumbnail (<?php echo esc_attr( get_option( 'thumbnail_size_w' ) ); ?>x<?php echo esc_attr( get_option( 'thumbnail_size_h' ) ); ?>)</option>
			<?php
			foreach ( (array) $sizes as $name => $size ) :
				echo '<option value="' . esc_attr( $name ) . '" ' . selected( $name, $instance['image_size'], false ) . '>' . esc_html( $name ) . ' (' . esc_attr( $size['width'] ) . 'x' . esc_attr( $size['height'] ) . ')</option>';
			endforeach;
			?>
		</select></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'image_alignment' ) ); ?>"><?php esc_html_e( 'Image Alignment', 'genesis' ); ?>:</label>
		<select id="<?php echo esc_attr( $this->get_field_id( 'image_alignment' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image_alignment' ) ); ?>">
			<option value="">- <?php esc_html_e( 'None', 'genesis' ); ?> -</option>
			<option value="alignleft" <?php selected( 'alignleft', $instance['image_alignment'] ); ?>><?php esc_html_e( 'Left', 'genesis' ); ?></option>
			<option value="alignright" <?php selected( 'alignright', $instance['image_alignment'] ); ?>><?php esc_html_e( 'Right', 'genesis' ); ?></option>
		</select></p>

		</div>

		<div class="genesis-widget-column-box">

		<p><input id="<?php echo esc_attr( $this->get_field_id( 'show_title' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'show_title' ) ); ?>" value="1" <?php checked( 1, $instance['show_title'] ); ?>/> <label for="<?php echo esc_attr( $this->get_field_id( 'show_title' ) ); ?>"><?php esc_html_e( 'Show Post Title', 'genesis' ); ?></label></p>

		<p><input id="<?php echo esc_attr( $this->get_field_id( 'show_byline' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'show_byline' ) ); ?>" value="1" <?php checked( 1, $instance['show_byline'] ); ?>/> <label for="<?php echo esc_attr( $this->get_field_id( 'show_byline' ) ); ?>"><?php esc_html_e( 'Show Post Info', 'genesis' ); ?></label>

		<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'post_info' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_info' ) ); ?>" value="<?php echo esc_attr( $instance['post_info'] ); ?>" class="widefat" />

		</p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'show_content' ) ); ?>"><?php esc_html_e( 'Content Type', 'genesis' ); ?>:</label>
		<select id="<?php echo esc_attr( $this->get_field_id( 'show_content' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_content' ) ); ?>">
			<option value="content" <?php selected( 'content', $instance['show_content'] ); ?>><?php esc_html_e( 'Show Content', 'genesis' ); ?></option>
			<option value="excerpt" <?php selected( 'excerpt', $instance['show_content'] ); ?>><?php esc_html_e( 'Show Excerpt', 'genesis' ); ?></option>
			<option value="content-limit" <?php selected( 'content-limit', $instance['show_content'] ); ?>><?php esc_html_e( 'Show Content Limit', 'genesis' ); ?></option>
			<option value="" <?php selected( '', $instance['show_content'] ); ?>><?php esc_html_e( 'No Content', 'genesis' ); ?></option>
		</select>

		<br /><label for="<?php echo esc_attr( $this->get_field_id( 'content_limit' ) ); ?>"><?php esc_html_e( 'Limit content to', 'genesis' ); ?></label> <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'image_alignment' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'content_limit' ) ); ?>" value="<?php echo esc_attr( intval( $instance['content_limit'] ) ); ?>" size="3" /> <?php esc_html_e( 'characters', 'genesis' ); ?></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'more_text' ) ); ?>"><?php esc_html_e( 'More Text (if applicable)', 'genesis' ); ?>:</label>
		<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'more_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'more_text' ) ); ?>" value="<?php echo esc_attr( $instance['more_text'] ); ?>" /></p>

		</div>

	</div>

		<?php
	}
}
