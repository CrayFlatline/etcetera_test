<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		the_title( '<h1 class="entry-title">', '</h1>' );
		?>
	</header><!-- .entry-header -->

    <div class="entry-content">
        <div class="clearfix">
		    <?php
		    $image = wp_get_attachment_image(carbon_get_post_meta(get_the_ID(), 'rm_image'), 'medium', false, array('class' => 'float-right ml-2 mb-2'));
		    echo $image;
		    ?>

		    <?php
		    the_content();

		    wp_link_pages( array(
			    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wp-bootstrap-starter' ),
			    'after'  => '</div>',
		    ) );
		    ?>
        </div>

        <table class="table mt-5 mb-5">
            <tr>
                <th style="width: 25%"><?php _e('Location', 'etc') ?></th>
                <td><?php echo carbon_get_post_meta(get_the_ID(), 'rm_coordinates');?></td>
            </tr>
            <tr>
                <th style="width: 25%"><?php _e('Floors count', 'etc') ?></th>
                <td><?php echo carbon_get_post_meta(get_the_ID(), 'rm_floor');?></td>
            </tr>
            <tr>
                <th style="width: 25%"><?php _e('Material', 'etc') ?></th>
                <td><?php echo carbon_get_post_meta(get_the_ID(), 'rm_building_type');?></td>
            </tr>
            <tr>
                <th style="width: 25%"><?php _e('Eco-friendliness', 'etc') ?></th>
                <td><?php echo carbon_get_post_meta(get_the_ID(), 'rm_ecological_index');?></td>
            </tr>
        </table>


        <?php
            $apartments = carbon_get_post_meta(get_the_ID(), 'rm_apartment');

            if(count($apartments)):
        ?>
        <h2><?php echo __('Available rooms', 'etc');?></h2>
        <?php
                foreach ($apartments as $apartment):
        ?>

        <div class="card mb-3">
            <div class="row no-gutters">
                <div class="col-auto">
				    <?php
				    $image = wp_get_attachment_image($apartment['rm_image'], 'thumbnail');
				    ?>
                    <?php echo $image; ?>
                </div>
                <div class="col">
                    <div class="card-block px-2">
                        <div class="card-body">
                        <ul>
                            <li>
                                <strong><?php _e('Square', 'etc') ?></strong>
                                <span><?php echo $apartment['rm_square'];?></span>
                            </li>
                            <li>
                                <strong><?php _e('Rooms count', 'etc') ?></strong>
                                <span><?php echo $apartment['rm_rooms'];?></span>
                            </li>
                            <li>
                                <strong><?php _e('Balcony', 'etc') ?></strong>
                                <span><?php echo $apartment['rm_balcony'] == 1 ? __('Yes', 'etc') : __('No', 'etc') ;?></span>
                            </li>
                            <li>
                                <strong><?php _e('Bathroom', 'etc') ?></strong>
                                <span><?php echo $apartment['rm_toilet'] == 1 ? __('Yes', 'etc') : __('No', 'etc') ;?></span>
                            </li>
                        </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
            endforeach;
        endif;
        ?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php wp_bootstrap_starter_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
