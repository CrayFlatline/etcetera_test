<div class="card mb-4">
	<div class="row no-gutters">
		<div class="col-auto">
			<?php
			$image = wp_get_attachment_image(carbon_get_post_meta(get_the_ID(), 'rm_image'), 'thumbnail');
			?>
			<a href="<?php echo get_permalink(get_the_ID());?>" style="max-width: 80px"><?php echo $image; ?></a>
		</div>
		<div class="col">
			<div class="card-block px-2">
				<h4 class="card-title"><?php echo carbon_get_post_meta(get_the_ID(), 'rm_title') ?></h4>
				<p class="card-text"><?php echo etcGetExcerpt(\RealtyManager\Constants::$excerptWordsLimit); ?></p>
				<a href="<?php echo get_permalink(get_the_ID());?>" class="btn btn-primary btn-sm"><?php echo __('More', 'etc');?></a>
			</div>
		</div>
	</div>
</div>
