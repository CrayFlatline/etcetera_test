<div class="card mb-5">
	<form action="<?php echo esc_url( $submitUrl ); ?>" method="post" class="faceted-filter-form">
		<h3 class="card-header"><?php echo __('Filter', 'etc');?></h3>
		<div class="card-body">
			<fieldset>
				<legend><?php echo __('Buildings', 'etc');?></legend>

				<div class="form-group">
					<label for="rm-title"><?php echo __('Building title', 'etc');?></label>
					<input name="rm_title" type="text" class="form-control" id="rm-title">
				</div>
				<div class="form-group">
					<label for="rm-building-type"><?php echo __('Material', 'etc');?></label>
					<select name="rm_building_type" id="rm-building-type" class="form-control">
						<option value=""><?php echo __('Select option', 'etc');?></option>
						<?php
						foreach (\RealtyManager\Constants::formValuesTypes() as $key => $type):
							echo "<option value='" . $key . "'>" . $type . "</option>" . PHP_EOL;
						endforeach;
						?>
					</select>
				</div>
				<div class="form-group">
					<label for="rm-ecological-index"><?php echo __('Eco-friendliness', 'etc');?></label>
					<select name="rm_ecological_index" id="rm-ecological-index" class="form-control">
						<option value=""><?php echo __('Select option', 'etc');?></option>
						<?php
						foreach (\RealtyManager\Constants::formValuesEcologicalIndex() as $key => $type):
							echo "<option value='" . $key . "'>" . $type . "</option>" . PHP_EOL;
						endforeach;
						?>
					</select>
				</div>
			</fieldset>

			<fieldset>
				<legend><?php echo __('Apartments', 'etc');?></legend>

				<div class="form-group">
					<label for="rm-square"><?php echo __('Square', 'etc');?></label>
					<input name="rm_square" type="number" class="form-control" id="rm-square">
				</div>
				<div class="form-group">
					<label for="rm-rooms"><?php echo __('Rooms count', 'etc');?></label>
					<select name="rm_rooms" id="rm-rooms" class="form-control">
						<option value=""><?php echo __('Select option', 'etc');?></option>
						<?php
						foreach (\RealtyManager\Constants::formValuesRooms() as $key => $type):
							echo "<option value='" . $key . "'>" . $type . "</option>" . PHP_EOL;
						endforeach;
						?>
					</select>
				</div>
				<div class="form-group">
					<label for="rm-balcony"><?php echo __('Balcony', 'etc');?></label>
					<div class="rm-balcony">
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="rm_balcony" id="rm_balcony1" value="1">
							<label class="form-check-label" for="rm_balcony1"><?php echo __('Yes', 'etc');?></label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="rm_balcony" id="rm_balcony0" value="0">
							<label class="form-check-label" for="rm_balcony0"><?php echo __('No', 'etc');?></label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="rm-toilet"><?php echo __('Bathroom', 'etc');?></label>
					<div class="rm-toilet">
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="rm_toilet" id="rm_toilet1" value="1">
							<label class="form-check-label" for="rm_toilet1"><?php echo __('Yes', 'etc');?></label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="rm_toilet" id="rm_toilet0" value="0">
							<label class="form-check-label" for="rm_toilet0"><?php echo __('No', 'etc');?></label>
						</div>
					</div>
				</div>
			</fieldset>
		</div>
		<div class="card-footer w-100 text-muted">
            <input type="hidden" name="action" value="faceted_filter">
            <input type="hidden" name="current_url" value="<?php echo $currentUrl; ?>">
            <input type="hidden" name="paged" value="<?php echo $page; ?>" id="faceted-filter-form-page">
			<button type="reset" class="btn btn-secondary"><?php echo __('Cancel', 'etc'); ?></button>
			<button type="submit" class="btn btn-primary"><?php echo __('Submit', 'etc'); ?></button>
		</div>
	</form>
</div>