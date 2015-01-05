<?php
/**
* Plugin Name: CPanel Dashboard
* Plugin URI: http://numeroserabiscos.com/
* This File: Shows Main Information on the WordPress Admin Dashboard Widget.
*/
defined('ABSPATH') or die("Shhh... Listen... it's silence, isn't it amazing?");

add_action( 'wp_dashboard_setup', 'nr_cpaneldash_dashwidgetMain' );
function nr_cpaneldash_dashwidgetMain() {

	wp_add_dashboard_widget(
				'nr_cpaneldash_dashwidgetMain',       // Widget slug
				'CPanel Dashboard',                   // Title
				'nr_cpaneldash_dashwidgetMain_Render' // Display function
		);	
}

/**
 * Output the contents the Dashboard Widget
 */
function nr_cpaneldash_dashwidgetMain_Render() {

	// Get the Disk Stats
	$diskStats = nr_cpaneldash_get_diskStats();

	// Show Disk Stats Information, HTML
	?>

		<h3><?php _e('Disk Usage', 'nr_cpaneldash'); ?></h3>

		<p>
		<?php _e('You have used', 'nr_cpaneldash'); ?>: 
		<strong><?php echo $diskStats['used']; ?> <?php echo $diskStats['unit']; ?></strong>

		<em>(<?php echo $diskStats['percent'] ?>%)</em><br>
		<?php _e('Your limit is', 'nr_cpaneldash'); ?>: 
		<?php echo $diskStats['max']; ?> <?php echo $diskStats['unit']; ?>
		</p>

	<?php
}