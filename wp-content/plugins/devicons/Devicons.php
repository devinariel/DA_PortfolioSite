<?php
/*
Plugin Name: Devicons
Plugin URI: http:/ryderdamen.com/projects/devicons
Description: Display Devicons (Software and Web Developer Icons) on your WordPress site.
Version: 1.0
Author: Ryder Damen
Author URI: https://ryderdamen.com/
*/

	
// Hooks ------------------------------------------------------------------------------------------------------------
add_shortcode( 'devicons', 'devicons_shortcode' );
add_shortcode( 'devicon', 'devicon_singular_shortcode' );


// Functions --------------------------------------------------------------------------------------------------------

// Determines if a devicon has a plain icon: @returns either "plain" or name of first object
function devicons_hasPlain($devicon) {
	 return in_array('plain', $devicon['versions']['font']) ? 'plain' : $devicon['versions']['font'][0];
}

// Determines if a devicon has a wordmark: @returns either '-wordmark' or '' an empty string
function devicons_hasWordmark($precursor, $devicon) {
	 return in_array( $precursor . '-wordmark', $devicon['versions']['font']) ? '-wordmark' : '';
}

// Renders the devicon, @return html
function devicons_render($devicon, $atts, $iconClass) {	
	
	switch ($atts) {
		
		// Standard Output (Full colour, no titles)
	    case ($atts['color'] === true) and ($atts['title'] === false):	    
	        return '<i class="devicon-' . $devicon['name'] . '-' . devicons_hasPlain($devicon) . ' colored ' . $iconClass . '" title="' . ucwords( $devicon['name'] ) . '"></i> ';
	    
	    // Full colour and titles included (wordmark)   
	    case ($atts['color'] === true) and ($atts['title'] !== false):
	        return '<i class="devicon-' . $devicon['name'] . '-' . devicons_hasPlain($devicon) . devicons_hasWordmark(devicons_hasPlain($devicon), $devicon) . ' colored ' . $iconClass . '" title="' . ucwords( $devicon['name'] ) . '"></i> ';
	        
	    // The user has specified a colour, and no titles
	    case ($atts['color'] !== true) and ($atts['title'] === false):
	        return '<i class="devicon-' . $devicon['name'] .  '-' . devicons_hasPlain($devicon) . ' ' . $iconClass . '" style="color: ' . $atts['color'] . ';" title="' . ucwords( $devicon['name'] ) . '"></i> ';
	    
	    // The user has specified a colour, and a title (wordmark)
	    case ($atts['color'] !== true) and ($atts['title'] !== false):
	        return '<i class="devicon-' . $devicon['name'] .  '-' . devicons_hasPlain($devicon) . devicons_hasWordmark(devicons_hasPlain($devicon), $devicon) . ' ' . $iconClass . '" style="color: ' . $atts['color'] . ';" title="' . ucwords( $devicon['name'] ) . '"></i> ';
	        
	}
	
}

// Accepts 1 devicon as a parameter and returns it within the inline style
function devicon_singular_shortcode( $atts, $content = null ) {
            
    // Set attributes and defaults
    $atts = shortcode_atts(
		array(
            'title' => false,
            'color' => true,
            'icon' => false
		), 
		$atts,
		'devicon'
    );    
    
    try {
	    
	    // If the user hasn't set anything, return
	    if ( $atts['icon'] === false ) return;
	    	    
    	// Enqueue styles
    	wp_enqueue_style( 'Devicons_Main', plugins_url( '/css/main.css', __FILE__ ) );
    	wp_enqueue_style( 'Devicons_Lib', plugins_url( '/css/devicon.min.css', __FILE__ ) );
    	
    	// Retrieve list of available devicons
    	$availableDevicons = json_decode(file_get_contents( plugins_url('/inc/devicon.json', __FILE__) ), true);
    	
    	// Build an associative array (it's more efficiant than a double loop)
    	$availableDevicons_table = array();
    	foreach ($availableDevicons as $devicon) {
	    	$availableDevicons_table[$devicon['name']] = $devicon;
    	}
    	
    	
	    // If the icon exists, return it in the style of the view	
    	if ( isset( $availableDevicons_table[ strtolower($atts['icon']) ]  ) ) {
	    	// A value exists in the associative array! Woohoo!
	    	$html = devicons_render( $availableDevicons_table[ strtolower($atts['icon']) ], $atts, '' );
    	}
	 
    	return $html;
    }
    catch (Exception $e) { // If there is an error, return the error
	    return "<strong>" . esc_html('Devicons Plugin Error: ' . $e->getMessage()) . "</strong>";
    }	
    	
    	
}

// Accepts a list of devicons and returns them as 50px icons
function devicons_shortcode( $atts, $content = null ) {
            
    // Set attributes and defaults
    $atts = shortcode_atts(
		array(
            'title' => false,
            'color' => true
		), 
		$atts,
		'devicons'
    );    
    
    try {
	    
    	// Enqueue styles
    	wp_enqueue_style( 'Devicons_Main', plugins_url( '/css/main.css', __FILE__ ) );
    	wp_enqueue_style( 'Devicons_Lib', plugins_url( '/css/devicon.min.css', __FILE__ ) );
    	
    	// Strip HTML Tags, Separate content into an array based on white space or commas, filter out empty elements and re-key
     	$requestedDevicons = array_values( array_filter( preg_split('/[\ \n\,]+/', strip_tags( $content ) ) ) );

    	// If no icons have been requested, return nothing
    	if ( empty($requestedDevicons) ) return;
    	
    	// Retrieve list of available devicons
    	$availableDevicons = json_decode(file_get_contents( plugins_url('/inc/devicon.json', __FILE__) ), true);
    	
    	// Build an associative array (it's more efficiant than a double loop)
    	$availableDevicons_table = array();
    	foreach ($availableDevicons as $devicon) {
	    	$availableDevicons_table[$devicon['name']] = $devicon;
    	}
    	
    	// Build the markup
    	$html = '<div class="devicons-container">';
    	
    	// For each requested devicon, check if an available one exists, if it does, render it
    	foreach ($requestedDevicons as $requested) {
	    	
	    	if ( isset( $availableDevicons_table[ strtolower($requested) ]  ) ) {
		    	// A value exists in the associative array! Woohoo!
		    	$html .= devicons_render( $availableDevicons_table[ strtolower($requested) ], $atts, 'wp-devicon' );
	    	}
	    	
    	}
    	
    	$html .= '</div>';

    	return $html;
    }
    catch (Exception $e) { // If there is an error, return the error
	    return "<strong>" . esc_html('Devicons Plugin Error: ' . $e->getMessage()) . "</strong>";
    }	
    	
    	
}