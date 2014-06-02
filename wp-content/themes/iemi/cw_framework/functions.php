<?php
/**
 * CostaWeb.com WP Framework
 *
 * Basic framework functions - Full software not included
 *
 * @author CostaWeb
 * @link http://costaweb.com.br
 * @version 0.1
 */

/**
 * Retrieves a block, if it exists
 *
 * @param string $block_name Block name to include
 * @return boolean Wheter included or not
 */
function get_block($block_name, $data = array()) {
	global $post;

	$block_file = dirname(realpath(__FILE__)) . '/../blocks/' . $block_name . '.php';

	return file_exists($block_file) ? include($block_file) : false;
}


/**
 * Includes function files
 *
 * @param array $files Array os files to include
 * @return null
 */
function include_functions($files) {
	foreach ($files as $file)
		include(dirname(__FILE__) . '/../functions/' . $file . '.php');
}


/**
 * Retrieves a sidebar, if it exists
 *
 * @param type $widget_area_id Widget area id (same as sidebar-id)
 */
function widget_area($widget_area_id) {
	if (is_active_sidebar($widget_area_id)) :
?>
	<div id="widget_area-<?php echo $widget_area_id; ?>" class="widget_area">
<?php
		dynamic_sidebar($widget_area_id);
?>
	</div>
<?php
	endif;
}


/**
 * Retrieves the terms associated with the given object(s), in the supplied taxonomies, filtering by term's parent(s) and optionally pulling data from a given object.
 *
 * @param int|array $terms The terms to filter or the ID(s) of the object(s) to retrieve.
 * @param array|string $parents ID(s) of the parent(s) to filter terms.
 * @param string|array $taxonomies The taxonomies to retrieve terms from.
 * @param array|string $args Change what is returned.
 */
function get_object_terms_by_parent($terms, $parents = array(), $taxonomies = array(), $args = array()) {
	if (!is_object($terms[0]))
		$terms = wp_get_object_terms($terms, $taxonomies, $args);

	if (is_string($parents) || is_numeric($parents))
		$parents = explode(',', $parents);

	foreach ($terms as $term_key => $term) {
		if (!in_array($term->parent, $parents)) {
			unset ($terms[$term_key]);
		}
	}

	return $terms;
}


/**
 * Returns a truncated string, preserving words
 *
 * @copyright Chirp Internet: www.chirp.com.au
 *
 * @param string $string The string to truncate.
 * @param int $limit The limit (in letters) to truncate the string.
 * @param string $pad The char(s) to put at the end of the truncated string.
 */
function truncate_string($string, $limit, $pad = '...') {
	// return with no change if string is shorter than $limit
	if (strlen($string) <= $limit)
		return $string;

	$string = substr($string, 0, $limit);

	$string = substr($string, 0, strrpos($string, ' ')) . $pad;

	return $string;
}

/**
 * Retrieves a file extension
 */
function get_file_extension($filename) {
    $path_info = pathinfo($filename);
    return $path_info['extension'];
}

function get_file_dir($file_path) {
	return str_replace(basename($file_path), '', $file_path);
}

?>