//This is a modification done to filter everything pro wordpress filter plugin,
//with this function it changes the search option to only search for title and expert, 
//also it replaces wordpress LIKE with REGEXP to search the entire world instead of searching for part of it.

// Remove the existing hooks
add_action('wp_loaded', function() {
    remove_action('wpc_filtered_query_end', [ $this, 'addSearchArgsToWpQuery' ]);
    remove_action('wpc_all_set_wp_queried_posts', [ $this, 'addSearchArgsToWpQuery' ]);
	
	// Re-add the hooks with a modified function
add_action( 'wpc_filtered_query_end', 'forceSearchToABC' );
add_action( 'wpc_all_set_wp_queried_posts', 'forceSearchToABC' );
});



// Remove the existing hooks
add_action('wp_loaded', function() {
    remove_action('wpc_filtered_query_end', [ $this, 'addSearchArgsToWpQuery' ]);
    remove_action('wpc_all_set_wp_queried_posts', [ $this, 'addSearchArgsToWpQuery' ]);
    
    // Re-add the hooks with a modified function
    add_action( 'wpc_filtered_query_end', 'forceSearchToABC' );
    add_action( 'wpc_all_set_wp_queried_posts', 'forceSearchToABC' );
});

// Remove the existing hooks
add_action('wp_loaded', function() {
    remove_action('wpc_filtered_query_end', [ $this, 'addSearchArgsToWpQuery' ]);
    remove_action('wpc_all_set_wp_queried_posts', [ $this, 'addSearchArgsToWpQuery' ]);
    
    // Re-add the hooks with a modified function
    add_action( 'wpc_filtered_query_end', 'forceSearchToABC' );
    add_action( 'wpc_all_set_wp_queried_posts', 'forceSearchToABC' );
});

function forceSearchToABC( $wp_query ) {
    // Ensure we are only modifying the main query on search pages
    if ( isset($_GET['srch']) ) {
        // Force the search to always be the search term
        $search_term = $_GET['srch'];
  $wp_query->set( 's', $_GET['srch'] ); // Only retrieve post IDs to optimize the query
		$wp_query->set('exact', true);
        // Search only in the post titles and post excerpts
        $wp_query->set( 'fields', 'ids' ); // Only retrieve post IDs to optimize the query

        // Modify the search query to search in post title and post excerpt
        $wp_query->set( 'search_columns', array( 'post_title', 'post_excerpt' ) );


    }

    return $wp_query;
}


function exact_search_filter($search, $wp_query) {
    if (!empty($wp_query->query_vars['exact'])) {
        // Get the search term and wrap it with word boundaries
        $search_term = $wp_query->query_vars['s'];
        $search_term = '\\\\b' . preg_quote($search_term, '/') . '\\\\b';

        // Modify the search query to use REGEXP instead of LIKE
        $search = str_replace('LIKE', 'REGEXP', $search);
        $search = str_replace('%', '', $search);

        // Replace the search term with the word boundary-wrapped term
        $search = str_replace($wp_query->query_vars['s'], $search_term, $search);
    }
    return $search;
}

add_filter('posts_search', 'exact_search_filter', 10, 2);

