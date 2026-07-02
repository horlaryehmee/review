<?php
/**
 * Template for rendering the `carousel` template for gallery block in single listing page.
 *
 * @since 1.0
 */
if ( ! defined('ABSPATH') ) {
    exit;
}

$items_per_row = min( 3, count( $gallery_items ) );

// if we're displaying a single image, use the full size image
if ( count( $gallery_items ) === 1 ) {
    $gallery_items[0]['url'] = $gallery_items[0]['full_size_url'];
}
?>

<div
	class="element gallery-carousel-block carousel-items-<?php echo count( $gallery_items ) ?>">
	<?php if ( count( $gallery_items ) > 3 ): ?>
	<div class="mlt-gallery-nav gallery-nav">
		<ul>
			<li><a href="#" class="gallery-prev-btn"><i class="mi keyboard_arrow_left"></i></a></li>
			<li><a href="#" class="gallery-next-btn"><i class="mi keyboard_arrow_right"></i></a></li>
		</ul>
	</div>
	<?php endif ?>

	<div class="gallery-carousel owl-carousel photoswipe-gallery"
		data-items="<?php echo absint( $items_per_row ) ?>"
		data-items-mobile="<?php echo absint( $items_per_row ) ?>">
		<?php foreach ( $gallery_items as $item ): ?>
		<a class="item photoswipe-item"
			href="<?php echo esc_url( $item['full_size_url'] ) ?>"
			style="background-image: url('<?php echo esc_url( $item['url'] ) ?>')"></a>
		<?php endforeach ?>
	</div>
</div>