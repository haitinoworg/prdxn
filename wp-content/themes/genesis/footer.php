<?php
/**
 * Footer
 */

genesis_structural_wrap( 'site-inner', 'close' );
genesis_markup( array(
	'close'   => '</div>',
	'context' => 'site-inner',
	) );

do_action( 'genesis_before_footer' );
do_action( 'genesis_footer' );
do_action( 'genesis_after_footer' );

genesis_markup( array(
	'close'   => '</div>',
	'context' => 'site-container',
	) );

wp_footer();

genesis_markup( array(
	'close'   => '</body>',
	'context' => 'body',
	) );

	?>
	</html>
