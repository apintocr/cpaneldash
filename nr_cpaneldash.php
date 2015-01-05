<?php
/**
* Plugin Name: CPanel Dashboard
* Plugin URI: http://numeroserabiscos.com/
* Description: Shows Basic CPanel Account Information
* Version: 1.0
* Author: António Pinto, Números e Rabiscos
* Author URI: http://numeroserabiscos.com/
*/

defined('ABSPATH') or die("Shhh... Listen... it's silence, isn't it amazing?");

/** ===================================
 *  Vendor Packages
 */

// CPanel XML API v1/v2
include 'vendor/xmlapi-php/xmlapi.php';




/** ===================================
 *  Base Files
 */

// Config Menu for the Plugin
include 'admin/menu-config.php';

// WP Admin Dashboard Widget
include 'admin/dashwidget-main.php';




/** ===================================
 *  Plugin Functions
 */

// Get Options
function  nr_cpaneldash_options()
{
	// Check if The Options Are Set and define variables
	if( get_option( 'nr_cpaneldash_Config' ) != false )
	{
		$wp_options =  get_option( 'nr_cpaneldash_Config' );

		$options['CpanelDomain']    = $wp_options['nr_cpaneldash_CpanelDomain'];
		$options['CpanelUsername']  = $wp_options['nr_cpaneldash_CpanelUsername'];
		$options['CpanelPassword']  = $wp_options['nr_cpaneldash_CpanelPassword'];
	}

	return $options;
}


// Login to CPanel
function nr_cpaneldash_login( )
{
	// Call Options Function
	$options = nr_cpaneldash_options();

	$xmlapi = new xmlapi($options['CpanelDomain']);
	$xmlapi->set_protocol('https');
	$xmlapi->set_port('2083');
	$xmlapi->set_output('json');

	$xmlapi->password_auth(
		$options['CpanelUsername'], 
		$options['CpanelPassword']
	);

	return $xmlapi;
}


// Get Account Disk Usage Stats
function nr_cpaneldash_get_diskStats( )
{
	// Call Login Function
	$xmlapi = nr_cpaneldash_login();

	// Call Options Function
	$options = nr_cpaneldash_options();

	// Get Disk Stats as JSON
	$diskStats_json = $xmlapi->stat($options['CpanelUsername'], array('diskusage'));

	// Decode JSON and Get the DATA object
	$diskStats = json_decode($diskStats_json);
	$diskStats = $diskStats->{'cpanelresult'}->{'data'};
	$diskStats = $diskStats[0]; // this is a stdClass

	//Set the RESULT array
	$result = array(
		'max'        => $diskStats->_max,   // Max Quota for the Account
		'used'       => $diskStats->count , // Currently used disk quota
		'percent'    => $diskStats->percent , // Currently used percentage
		'unit'       => $diskStats->units , // Measurement Units (MB, GB, etc)
		'unlimited'  => $diskStats->zeroisunlimited , // Is the Quota Unlimited? ZERO means Yes.
		'full'       => $diskStats->_maxed , // Is the disk quota full? ONE means Yes.
	);

	return $result;
}
