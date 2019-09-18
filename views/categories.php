<div class="query_shortcode_categories">
	<a href="<?php echo remove_query_arg( 'category' ) ?>" class="et_pb_button"><?php echo __( 'Összes bejegyzés', 'kd-query-shortcode' ) ?></a>
	<?php foreach( $terms as $term ) { ?>

		<a href="<?php echo add_query_arg([ 'category' => $term->slug ]) ?>" class="cat_<?php echo $term->slug ?> <?php echo $term->slug == $_GET['category'] ? 'active' : '' ?>"><?php echo $term->name ?></a>

	<?php } ?>
</div>