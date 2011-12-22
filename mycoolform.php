<?php
/**
 * Plugin Name: My cool Wordpress Form Plugin
 */
 
/**
 * load form tempalte
 */
function mcform_display() {
	include('templates/form.php');
}

function mcform_store_input_to_database() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'mcform';
	
	// bacuse wp has no installer we gonna look if all our db tables are ready and may create them
	$sql = '
		CREATE TABLE IF NOT EXISTS `' . $wpdb->prefix . 'mcform` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `val1` int(11) NOT NULL,
		  `val2` int(11) NOT NULL,
		  `val3` int(11) NOT NULL,
		  `amount` int(11) NOT NULL,
		  PRIMARY KEY (`id`)
		);
	';
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
	
	// hey all done so get our input from the form
	if(isset($_POST['checkbox1']))
		$input['checkbox1'] = 10;
	else
		$input['checkbox1'] = 0;

	if(isset($_POST['checkbox2']))
		$input['checkbox2'] = 20;
	else
		$input['checkbox2'] = 0;
		
	if(isset($_POST['checkbox3']))
		$input['checkbox3'] = 50;
	else
		$input['checkbox3'] = 0;
	
	// addentional calculations go here
	$result = $input['checkbox1'] + $input['checkbox2'] + $input['checkbox3'];
	
	// now we gonna write it to db
	$wpdb->insert(
		$table_name,
		array(
			'val1' 		=> $input['checkbox1'],
			'val2' 		=> $input['checkbox2'],
			'val3' 		=> $input['checkbox3'],
			'amount' 	=> $result
		)
	);
	
}

/**
 * kickstart
 */
function mcform_bootstrap() {
	// look if someone has submit data via our form
	if(isset($_POST['mcformsubmit'])) {
		// yeah, so let us call a function to store this
		mcform_store_input_to_database();
	}
	
	// register new filter for detecting plugin useage
	add_filter('the_content', 'mcform_useage_filter', 1);
}
add_action('init', 'mcform_bootstrap');

/**
 * this filter looks for useage of our form embeded tag and calls the form funciton
 */
function mcform_useage_filter($post) {
	// our syntax to embeded is %%mycoolform%% so we look if a post contains this string and them...
	if (substr_count($post, '%%mycoolform%%') > 0) {
		// ...we replace this string with our form
		$post = str_replace('%%mycoolform%%', mcform_display(), $post);
	}
	return $post;
}