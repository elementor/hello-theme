<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_VERSION', '2.5.0' );

if ( ! isset( $content_width ) ) {
	$content_width = 800; // Pixels.
}

if ( ! function_exists( 'hello_elementor_setup' ) ) {
	/**
	 * Set up theme support.
	 *
	 * @return void
	 */
	function hello_elementor_setup() {
		if ( is_admin() ) {
			hello_maybe_update_theme_version_in_db();
		}

		$hook_result = apply_filters_deprecated( 'elementor_hello_theme_load_textdomain', [ true ], '2.0', 'hello_elementor_load_textdomain' );
		if ( apply_filters( 'hello_elementor_load_textdomain', $hook_result ) ) {
			load_theme_textdomain( 'hello-elementor', get_template_directory() . '/languages' );
		}

		$hook_result = apply_filters_deprecated( 'elementor_hello_theme_register_menus', [ true ], '2.0', 'hello_elementor_register_menus' );
		if ( apply_filters( 'hello_elementor_register_menus', $hook_result ) ) {
			register_nav_menus( [ 'menu-1' => __( 'Header', 'hello-elementor' ) ] );
			register_nav_menus( [ 'menu-2' => __( 'Footer', 'hello-elementor' ) ] );
		}

		$hook_result = apply_filters_deprecated( 'elementor_hello_theme_add_theme_support', [ true ], '2.0', 'hello_elementor_add_theme_support' );
		if ( apply_filters( 'hello_elementor_add_theme_support', $hook_result ) ) {
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support(
				'html5',
				[
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
				]
			);
			add_theme_support(
				'custom-logo',
				[
					'height'      => 100,
					'width'       => 350,
					'flex-height' => true,
					'flex-width'  => true,
				]
			);

			/*
			 * Editor Style.
			 */
			add_editor_style( 'classic-editor.css' );

			/*
			 * Gutenberg wide images.
			 */
			add_theme_support( 'align-wide' );

			/*
			 * WooCommerce.
			 */
			$hook_result = apply_filters_deprecated( 'elementor_hello_theme_add_woocommerce_support', [ true ], '2.0', 'hello_elementor_add_woocommerce_support' );
			if ( apply_filters( 'hello_elementor_add_woocommerce_support', $hook_result ) ) {
				// WooCommerce in general.
				add_theme_support( 'woocommerce' );
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
				// zoom.
				add_theme_support( 'wc-product-gallery-zoom' );
				// lightbox.
				add_theme_support( 'wc-product-gallery-lightbox' );
				// swipe.
				add_theme_support( 'wc-product-gallery-slider' );
			}
		}
	}
}
add_action( 'after_setup_theme', 'hello_elementor_setup' );

function hello_maybe_update_theme_version_in_db() {
	$theme_version_option_name = 'hello_theme_version';
	// The theme version saved in the database.
	$hello_theme_db_version = get_option( $theme_version_option_name );

	// If the 'hello_theme_version' option does not exist in the DB, or the version needs to be updated, do the update.
	if ( ! $hello_theme_db_version || version_compare( $hello_theme_db_version, HELLO_ELEMENTOR_VERSION, '<' ) ) {
		update_option( $theme_version_option_name, HELLO_ELEMENTOR_VERSION );
	}
}

if ( ! function_exists( 'hello_elementor_scripts_styles' ) ) {
	/**
	 * Theme Scripts & Styles.
	 *
	 * @return void
	 */
	function hello_elementor_scripts_styles() {
		$enqueue_basic_style = apply_filters_deprecated( 'elementor_hello_theme_enqueue_style', [ true ], '2.0', 'hello_elementor_enqueue_style' );
		$min_suffix          = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		if ( apply_filters( 'hello_elementor_enqueue_style', $enqueue_basic_style ) ) {
			wp_enqueue_style(
				'hello-elementor',
				get_template_directory_uri() . '/style' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( apply_filters( 'hello_elementor_enqueue_theme_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor-theme-style',
				get_template_directory_uri() . '/theme' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_scripts_styles' );

if ( ! function_exists( 'hello_elementor_register_elementor_locations' ) ) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
	 *
	 * @return void
	 */
	function hello_elementor_register_elementor_locations( $elementor_theme_manager ) {
		$hook_result = apply_filters_deprecated( 'elementor_hello_theme_register_elementor_locations', [ true ], '2.0', 'hello_elementor_register_elementor_locations' );
		if ( apply_filters( 'hello_elementor_register_elementor_locations', $hook_result ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action( 'elementor/theme/register_locations', 'hello_elementor_register_elementor_locations' );

if ( ! function_exists( 'hello_elementor_content_width' ) ) {
	/**
	 * Set default content width.
	 *
	 * @return void
	 */
	function hello_elementor_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'hello_elementor_content_width', 800 );
	}
}
add_action( 'after_setup_theme', 'hello_elementor_content_width', 0 );

if ( is_admin() ) {
	require get_template_directory() . '/includes/admin-functions.php';
}

/**
 * If Elementor is installed and active, we can load the Elementor-specific Settings & Features
*/

// Allow active/inactive via the Experiments
require get_template_directory() . '/includes/elementor-functions.php';

/**
 * Include customizer registration functions
*/
function hello_register_customizer_functions() {
	if ( hello_header_footer_experiment_active() && is_customize_preview() ) {
		require get_template_directory() . '/includes/customizer-functions.php';
	}
}
add_action( 'init', 'hello_register_customizer_functions' );

if ( ! function_exists( 'hello_elementor_check_hide_title' ) ) {
	/**
	 * Check hide title.
	 *
	 * @param bool $val default value.
	 *
	 * @return bool
	 */
	function hello_elementor_check_hide_title( $val ) {
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			$current_doc = Elementor\Plugin::instance()->documents->get( get_the_ID() );
			if ( $current_doc && 'yes' === $current_doc->get_settings( 'hide_title' ) ) {
				$val = false;
			}
		}
		return $val;
	}
}
add_filter( 'hello_elementor_page_title', 'hello_elementor_check_hide_title' );

/**
 * Wrapper function to deal with backwards compatibility.
 */
if ( ! function_exists( 'hello_elementor_body_open' ) ) {
	function hello_elementor_body_open() {
		if ( function_exists( 'wp_body_open' ) ) {
			wp_body_open();
		} else {
			do_action( 'wp_body_open' );
		}
	}
};

// Don't load Gutenberg-related stylesheets.
add_action( 'wp_enqueue_scripts', 'remove_block_css', 100 );
function remove_block_css() {
    wp_dequeue_style( 'wp-block-library-theme' ); // Wordpress core
    wp_dequeue_style( 'wc-block-style' ); // WooCommerce
    wp_dequeue_style( 'storefront-gutenberg-blocks' ); // Storefront theme
}

/* Related Posts */
function get_max_related_posts( $taxonomy_1 = 'post_tag', $taxonomy_2 = 'category', $total_posts = 4 )
{
    // First, make sure we are on a single page, if not, bail
    if ( !is_single() )
        return false;

    // Sanitize and vaidate our incoming data
    if ( 'post_tag' !== $taxonomy_1 ) {
        $taxonomy_1 = filter_var( $taxonomy_1, FILTER_SANITIZE_STRING );
        if ( !taxonomy_exists( $taxonomy_1 ) )
            return false;
    }

    if ( 'category' !== $taxonomy_2 ) {
        $taxonomy_2 = filter_var( $taxonomy_2, FILTER_SANITIZE_STRING );
        if ( !taxonomy_exists( $taxonomy_2 ) )
            return false;
    }

    if ( 4 !== $total_posts ) {
        $total_posts = filter_var( $total_posts, FILTER_VALIDATE_INT );
            if ( !$total_posts )
                return false;
    }

    // Everything checks out and is sanitized, lets get the current post
    $current_post = sanitize_post( $GLOBALS['wp_the_query']->get_queried_object() );

    // Lets get the first taxonomy's terms belonging to the post
    $terms_1 = get_the_terms( $current_post, $taxonomy_1 );

    // Set a varaible to hold the post count from first query
    $count = 0;
    // Set a variable to hold the results from query 1
    $q_1   = [];

    // Make sure we have terms
    if ( $terms_1 ) {
        // Lets get the term ID's
        $term_1_ids = wp_list_pluck( $terms_1, 'term_id' );

        // Lets build the query to get related posts
        $args_1 = [
            'post_type'      => $current_post->post_type,
            'post__not_in'   => [$current_post->ID],
            'posts_per_page' => $total_posts,
            'fields'         => 'ids',
            'tax_query'      => [
                [
                    'taxonomy'         => $taxonomy_1,
                    'terms'            => $term_1_ids,
                    'include_children' => false
                ]
            ],
        ];
        $q_1 = get_posts( $args_1 );
        // Count the total amount of posts
        $q_1_count = count( $q_1 );

        // Update our counter
        $count = $q_1_count;
    }

    // We will now run the second query if $count is less than $total_posts
    if ( $count < $total_posts ) {
        $terms_2 = get_the_terms( $current_post, $taxonomy_2 );
        // Make sure we have terms
        if ( $terms_2 ) {
            // Lets get the term ID's
            $term_2_ids = wp_list_pluck( $terms_2, 'term_id' );

            // Calculate the amount of post to get
            $diff = $total_posts - $count;

            // Create an array of post ID's to exclude
            if ( $q_1 ) {
                $exclude = array_merge( [$current_post->ID], $q_1 );
            } else {
                $exclude = [$current_post->ID];
            }

            $args_2 = [
                'post_type'      => $current_post->post_type,
                'post__not_in'   => $exclude,
                'posts_per_page' => $diff,
                'fields'         => 'ids',
                'tax_query'      => [
                    [
                        'taxonomy'         => $taxonomy_2,
                        'terms'            => $term_2_ids,
                        'include_children' => false
                    ]
                ],
            ];
            $q_2 = get_posts( $args_2 );

            if ( $q_2 ) {
                // Merge the two results into one array of ID's
                $q_1 = array_merge( $q_1, $q_2 );
            }
        }
    }

    // Make sure we have an array of ID's
    if ( !$q_1 )
        return false;

    // Run our last query, and output the results
    $final_args = [
        'ignore_sticky_posts' => 1,
        'post_type'           => $current_post->post_type,
        'posts_per_page'      => count( $q_1 ),
        'post__in'            => $q_1,
        'order'               => 'rand',
        'orderby'             => 'post__in',
        'suppress_filters'    => true,
        'no_found_rows'       => true
    ];
    $final_query = new WP_Query( $final_args );

    return $final_query;
}

function wpdocs_my_search_form( $form ) {
    $form = '<form role="search" method="get" action="' . home_url( '/' ) . '" class="wp-block-search__button-inside wp-block-search__icon-button search-form wp-block-search"><div class="wp-block-search__inside-wrapper " style="width: 100%"><input type="search" id="wp-block-search__input-1" class="wp-block-search__input " name="s" value="" placeholder="Pesquise seu destino..." required=""><button type="submit" class="wp-block-search__button has-text-color has-white-color has-background has-icon" style="background-color: #c36" aria-label="Pesquisar" value="'. esc_attr__( 'Search' ) .'"><svg id="search-icon" class="search-icon" viewBox="0 0 24 24" width="24" height="24"><path d="M13.5 6C10.5 6 8 8.5 8 11.5c0 1.1.3 2.1.9 3l-3.4 3 1 1.1 3.4-2.9c1 .9 2.2 1.4 3.6 1.4 3 0 5.5-2.5 5.5-5.5C19 8.5 16.5 6 13.5 6zm0 9.5c-2.2 0-4-1.8-4-4s1.8-4 4-4 4 1.8 4 4-1.8 4-4 4z"></path></svg></button></div>    </form>';
    return $form;
}
add_filter( 'get_search_form', 'wpdocs_my_search_form' );

//custom archive header
add_filter( 'get_the_archive_title', 'errorsea_archive_title' );
function errorsea_archive_title( $title ) {
	if ( is_category() ) {
		// Remove prefix in category archive page
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		// Remove prefix in tag archive page
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		// Remove prefix in author archive page
		$title = get_the_author();
	}
	return $title;
}

// Get the first category of a post
function get_first_category_of_a_post () {
	$categories = get_the_category();
	if ( ! empty( $categories ) ) {
		$category_ok = '';
		foreach( $categories as $key => $category ) :
		$category_name = $category->cat_name;
		if ( $category_name !== 'Uncategorised' && $category_name !== 'Event' ) {
			$category_ok = esc_html( $category_name );
			break;
		}
		endforeach;
	}
	echo $category_ok;
}

// Get the estimated reading time of a post
function estimated_reading_time () {
	$mycontent = get_the_content(); // wordpress users only
	$word = str_word_count(strip_tags($mycontent));
	$m = floor($word / 200);
	$s = floor($word % 200 / (200 / 60));
	$est = $m . ' minuto' . ($m == 1 ? '' : 's');
	if ( ! $est ) {
		return;
	}
	echo ( "Leitura estimada: " . $est );
}

// Get the total of comments number
function total_comments_number () {
	$comments = get_comments_number();
	if ( $comments == 0) {
		$comments = "-";
	}
	echo ( "Comentários: " . $comments );
}

// Numbere Pagination
function numeric_posts_nav() {
    if( is_singular() )
        return;
    global $wp_query; 
    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;
    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );
    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;
    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }
    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    } 
    echo '<div class="navigation"><ul>' . "\n"; 
    /** Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li>%s</li>' . "\n", get_previous_posts_link() );
    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : ''; 
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' ); 
        if ( ! in_array( 2, $links ) )
            echo '<li>…</li>';
    } 
    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    } 
    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li>…</li>' . "\n"; 
        $class = $paged == $max ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    } 
    /** Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li>%s</li>' . "\n", get_next_posts_link() );
    echo '</ul></div>' . "\n"; 
}

/* AMP */
add_filter('amp_to_amp_linking_enabled', '__return_false');

// Web Stories Filter WP-Meteor
add_filter('wpmeteor_enabled', function ($value) {
    $url = get_permalink();
    if ( preg_match("/.*\/web-stories\//", $url, )) {
        return false;
    }
    return $value;
});
