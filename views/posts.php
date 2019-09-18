<div class="query_shortcode_wrapper">
	<div class="query_shortcode_posts <?php echo $atts['cols'] > 1 ? 'et_pb_blog_grid' : 'et_pb_blog' ?> cols-<?php echo $atts['cols'] ?>">

		<?php foreach( $query->posts as $post ) { ?>

			<?php

				if ( $atts['categories'] == 1 ) {
					$categories = wp_get_post_categories( $post->ID, [ 'fields' => 'all' ] );

					$slugs = [];
					$links = [];
					foreach( $categories as $category ) {
						$slugs[] = 'cat_' . $category->slug;
						$links[] = '<a href="' . get_category_link( $category->term_id ) . '">' . $category->name . '</a>';
					}
				}
				if ( !empty( $atts['terms'] ) ) {

					$terms = wp_get_post_terms( $post->ID, $atts['terms']);
					$term_slugs = [];
					$term_links = [];
					foreach( $terms as $term ) {
						$term_slugs[] = 'term_' . $term->slug;
						$term_links[] = '<a href="' . get_term_link( $term->term_id ) . '">' . $term->name . '</a>';
					}

				}

			?>

			<article id="post-<?php echo $post->ID ?>" class="et_pb_post clearfix et_pb_no_thumb post-<?php echo $post->ID ?> post type-post status-publish format-standard hentry rotate<?php echo mt_rand(-3,3) ?> <?php echo implode( ' ', $slugs ) ?> <?php echo implode( ' ', $term_slugs ) ?>">
				<a href="<?php echo get_permalink( $post->ID ) ?>" class="entry-featured-image-url">
					<img src="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $post->ID ), $cols == 1 ? 'et-pb-post-main-image-fullwidth' : 'et-pb-post-main-image' ) ?>" alt="<?php echo $post->post_title ?>">															</a>
				<h4 class="entry-title"><a href="<?php echo get_permalink( $post->ID ) ?>"><?php echo $post->post_title ?></a></h4>
				<p class="post-meta">
					<?php if ( $atts['categories'] == 1 ) { ?>
						<span class="categories"><?php echo implode( ', ', $links ); ?></span>
					<?php } ?>
					<?php if ( !empty( $atts['terms'] ) ) { ?>
						<span class="terms"><?php echo implode( ', ', $term_links ); ?></span>
					<?php } ?>
					<span class="published"><?php echo get_the_date( get_option( 'date_format' ), $post->ID ) ?></span>
				</p>
				<div class="post-content"><p><?php echo wp_trim_words( $this->strip( $post->post_content ), $atts['words'], " (&hellip;)" ) ?></p></div>
				<?php if ( $atts['read_more'] > 0 ) { ?>
						<a class="et_pb_button" href="<?php echo get_permalink( $post->ID ) ?>" class="more-link">bővebben</a>
					<?php } ?>
			</article>

		<?php } ?>

	</div>

	<?php if ( $atts['pagination'] ) { ?>
		<div class="query_shortcode_pagination">

			<?php

				$big = 999999999;

				echo paginate_links( array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '/page/%#%',
					'current' => max( 1, get_query_var('paged') ),
					'total' => max( 1, ceil( ( $query->found_posts - $atts['offset'] ) / $atts['posts_per_page'] ) )
				) );
			
			?>

		</div>
	<?php } ?>
</div>