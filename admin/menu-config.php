<?php
/**
* Plugin Name: CPanel Dashboard
* Plugin URI: http://numeroserabiscos.com/
* This File: Config menu for the plugin.
*/
defined('ABSPATH') or die("Shhh... Listen... it's silence, isn't it amazing?");

add_action( 'admin_menu', 'nr_cpaneldash_add_admin_menu' );
add_action( 'admin_init', 'nr_cpaneldash_Config_init' );


function nr_cpaneldash_add_admin_menu(  )
{
	add_submenu_page( 'tools.php', 'nr_cpaneldash', 'CPanel Dashboard', 'manage_options', 'nr_cpaneldash_Config', 'nr_cpaneldash_options_page' );
}



/** ===================================
 *  Define Configuration Section
 */

function nr_cpaneldash_Config_init(  ) { 

	register_setting( 'nr_cpaneldash-Configuration', 'nr_cpaneldash_Config' );

	// Add Configuration Section
	add_settings_section(
		'nr_cpaneldash_nr_cpaneldash-Configuration_section', 
		__( 'Main Configurations', 'nr_cpaneldash' ), 
		'nr_cpaneldash_Configuration_section_callback', 
		'nr_cpaneldash-Configuration'
	);


	// Options Field 0: CPanel Domain
	add_settings_field( 
		// Name
		'nr_cpaneldash_CpanelDomain',
		// Description
		__( 'CPanel Domain or IP', 'nr_cpaneldash' ),
		// Render
		'nr_cpaneldash_FieldRender_CpanelDomain',

		'nr_cpaneldash-Configuration', 
		'nr_cpaneldash_nr_cpaneldash-Configuration_section' 
	);

	// Options Field 1: CPanel Username
	add_settings_field( 
		// Name
		'nr_cpaneldash_CpanelUsername', 
		// Description
		__( 'CPanel Username', 'nr_cpaneldash' ), 
		// Render
		'nr_cpaneldash_FieldRender_CpanelUsername',

		'nr_cpaneldash-Configuration', 
		'nr_cpaneldash_nr_cpaneldash-Configuration_section' 
	);

	// Options Field 2: CPanel Password
	add_settings_field( 
		// Name
		'nr_cpaneldash_CpanelPassword',
		// Description
		__( 'CPanel Password', 'nr_cpaneldash' ),
		// Render
		'nr_cpaneldash_FieldRender_CpanelPassword',

		'nr_cpaneldash-Configuration', 
		'nr_cpaneldash_nr_cpaneldash-Configuration_section' 
	);


}



// Configuration Section Callback
function nr_cpaneldash_Configuration_section_callback(  ) { 

	echo __( 'These are your CPanel login details.', 'nr_cpaneldash' );

}


/** ===================================
 *  Render The Fields
 */

// Options Field 0: CPanel Domain
function nr_cpaneldash_FieldRender_CpanelDomain(  ) { 

	$options = get_option( 'nr_cpaneldash_Config' );
	?>
	<input type='text' name='nr_cpaneldash_Config[nr_cpaneldash_CpanelDomain]' placeholder="localhost" value='<?php echo $options['nr_cpaneldash_CpanelDomain']; ?>'>
	<?php

}

// Options Field 1: CPanel Username
function nr_cpaneldash_FieldRender_CpanelUsername(  ) { 

	$options = get_option( 'nr_cpaneldash_Config' );
	?>
	<input type='text' name='nr_cpaneldash_Config[nr_cpaneldash_CpanelUsername]' value='<?php echo $options['nr_cpaneldash_CpanelUsername']; ?>'>
	<?php

}

// Options Field 2: CPanel Password
function nr_cpaneldash_FieldRender_CpanelPassword(  ) { 

	$options = get_option( 'nr_cpaneldash_Config' );
	?>
	<input type='password' name='nr_cpaneldash_Config[nr_cpaneldash_CpanelPassword]' value='<?php echo $options['nr_cpaneldash_CpanelPassword']; ?>'>
	<?php

}



// Show Config Options Template
function nr_cpaneldash_options_page(  ) { 

	?>
	<form action='options.php' method='post'>
		
		<h2><?php _e('CPanel Dashboard Settings', 'nr_cpaneldash') ?></h2>
		
		<?php
		settings_fields( 'nr_cpaneldash-Configuration' );
		do_settings_sections( 'nr_cpaneldash-Configuration' );
		submit_button();
		?>
		
	</form>
	<?php

}
