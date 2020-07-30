<div class="card mb-4">
	<div class="row no-gutters">
		<div class="col-auto">
			<?php
			$image = wp_get_attachment_image(carbon_get_post_meta(get_the_ID(), 'rm_image'), 'thumbnail');
			?>
			<a href="<?php echo get_permalink(get_the_ID());?>"><?php echo $image; ?></a>
		</div>
		<div class="col">
			<div class="card-block px-2">
				<h4 class="card-title"><?php echo carbon_get_post_meta(get_the_ID(), 'rm_title') ?></h4>
				<p class="card-text"><?php echo etcGetExcerpt(\RealtyManager\Constants::$excerptWordsLimit); ?></p>
				<a href="<?php echo get_permalink(get_the_ID());?>" class="btn btn-primary"><?php echo __('More', 'etc');?></a>
			</div>
		</div>
	</div>
	<div class="card-footer w-100 text-muted d-flex justify-content-between">
		<div>
			<?php
			$buildingTypes = \RealtyManager\Constants::formValuesTypes();
			?>
			<strong><?php echo __('Floors', 'etc');?></strong>: <?php echo carbon_get_post_meta(get_the_ID(), 'rm_floor');?>,
			<strong><?php echo __('Material', 'etc');?></strong>: <?php echo $buildingTypes[ carbon_get_post_meta(get_the_ID(), 'rm_building_type') ];?>,
			<strong><?php echo __('Eco-friendliness', 'etc');?></strong>: <?php echo carbon_get_post_meta(get_the_ID(), 'rm_ecological_index');?>
		</div>
		<div>
			<?php
			$count = count(carbon_get_post_meta(get_the_ID(), 'rm_apartment'));
			echo sprintf(_n('%d apartment', '%d apartments', $count, 'etc'), $count);
			?>
		</div>
	</div>
</div>
