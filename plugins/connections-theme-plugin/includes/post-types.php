<?php

/**
 * Custom post types
 */
function cn_get_cpt() {

    $post_types = [
        'cn-case'   	=> [
            'labels'    	=> [
                'name'               => esc_html__( 'Case Files', 'connections' ),
                'singular_name'      => esc_html__( 'Case File', 'connections' ),
            ],
        ],
        'cn-asset' 	=> [
            'labels' 		=> [
                'name'              => esc_html__( 'Assets', 'connections' ),
                'singular_name'     => esc_html__( 'Asset', 'connections' ),
            ],
        ],
        'cn-contributor' => [
            'labels' 		=> [
                'name'              => esc_html__( 'Contributors', 'connections' ),
                'singular_name'     => esc_html__( 'Contributor', 'connections' ),
            ],
        ],
        'cn-glossary' => [
            'labels' 		=> [
                'name'              => esc_html__( 'Glossaries', 'connections' ),
                'singular_name'     => esc_html__( 'Glossary', 'connections' ),
            ],
        ],
    ];

    return $post_types;
}

/**
 * Custom post types list
 */
function cn_cpt_list( $return_key = false ) {

	$post_types = cn_get_cpt();

	if ( empty( $post_types ) ) return;
	
	$result = [];

	foreach ( $post_types as $key => $post_type ) {
		$result[ $key ] = $post_type['labels']['singular_name'];
	}

	return ( $return_key ) ? array_flip( $result ) : $result;
}

/**
 * Custom taxonomies
 */
function cn_get_taxonomies() {

	$taxonomies = [
		'cn-case-category' 			=> [
			'post_types' 				=> 'cn-case',
			'singular_name' 			=> 'Category',
			'plural_name' 				=> 'Categories',
		],
		'cn-asset-category' 		=> [
			'post_types' 				=> 'cn-asset',
			'singular_name' 			=> 'Category',
			'plural_name' 				=> 'Categories',
		],
//		'cn-asset-tag' 				=> [
//			'post_types' 				=> 'cn-asset',
//			'singular_name' 			=> 'Episode',
//			'plural_name' 				=> 'Episodes',
//			'rewrite_args' 				=>  [
//				'hierarchical'        		=> false,
//			],
//		],
		'cn-contributor-category' 	=> [
			'post_types' 				=> 'cn-contributor',
			'singular_name' 			=> 'Category',
			'plural_name' 				=> 'Categories',
		],
		'cn-glossary-category' 		=> [
			'post_types' 				=> 'cn-glossary',
			'singular_name' 			=> 'Category',
			'plural_name' 				=> 'Categories',
		],
		'cn-folder' 				=> [
			'post_types' 				=> 'page',
			'singular_name' 			=> 'Folder',
			'plural_name' 				=> 'Folders',
		],
		'cn-site-tag' 				=> [
			'post_types' 				=> [ 'cn-case', 'page', 'cn-glossary', 'cn-contributor'],
			'singular_name' 			=> 'Site tag',
			'plural_name' 				=> 'Site tags',
			'rewrite_args' 				=>  [
				'hierarchical'        		=> false,
			],
		],
	];

	return $taxonomies;
	
}

/**
 * Taxonomies arguments
 */
function cn_taxonomies_args( $slug, $singular_name, $plural_name, $new_args = [] ) {

	$labels = [
	    'name'                        => $singular_name,
	    'singular_name'               => $singular_name,
	    'menu_name'                   => $plural_name,
	    'all_items'                   => 'All ' . $plural_name,
	    'parent_item'                 => 'Parent ' . $singular_name,
	    'parent_item_colon'           => 'Parent ' . $singular_name .':',
	    'new_item_name'               => 'New ' . $singular_name . ' Name',
	    'add_new_item'                => 'Add New ' . $singular_name,
	    'edit_item'                   => 'Edit ' . $singular_name,
	    'update_item'                 => 'Update ' . $singular_name,
	    'separate_items_with_commas'  => 'Separate categories with commas',
	    'search_items'                => 'Search categories',
	    'add_or_remove_items'         => 'Add or remove categories',
	    'choose_from_most_used'       => 'Choose from the most used categories',
	];

	$rewrite = [
	    'slug'                  => $slug,
	    'with_front'            => true,
	    'hierarchical'          => true,
	];

	$args = [
	    'labels'              => $labels,
	    'hierarchical'        => true,
	    'public'              => true,
	    'show_ui'             => true,
	    'show_admin_column'   => true,
	    'show_in_nav_menus'   => true,
	    'show_tagcloud'       => true,
	    'rewrite'             => $rewrite,
	];

	if ( ! empty( $new_args ) ) {
		$args = array_replace( $args, $new_args );
	}	

	return $args;

}

/**
 * Register post types and taxonomies
 */
function cn_register_cpt() {

	$default_args = [
		'supports'              => [ 'title', 'thumbnail', 'editor' ],
		'public'                => true,
		'has_archive'           => true,
	];

	$post_types = cn_get_cpt();

	// Register post types
	foreach ( $post_types as $key => $post_type ) {
		register_post_type( $key, array_merge( $default_args, $post_type ) );
	}

	$taxonomies = cn_get_taxonomies();

	// Register taxonomies
	foreach ( $taxonomies as $key => $taxonomy ) {
		$rewrite_args = isset( $taxonomy['rewrite_args'] ) ? $taxonomy['rewrite_args'] : [];
		$tax_args = cn_taxonomies_args( $key, $taxonomy['singular_name'], $taxonomy['plural_name'], $rewrite_args );
		register_taxonomy( $key, $taxonomy['post_types'], $tax_args );
	}


}

add_action( 'init', 'cn_register_cpt' );