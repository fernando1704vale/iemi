<?php
/*
Plugin Name: Advanced Navigation Menus
Plugin URI: http://wordpress.org/extend/plugins/advanced-navigation-menus/
Description: Adds advanced functionality to the native Navigation Menus
Version: 0.6.5
Author: Caio Costa
Author URI: http://caiocosta.com
License: GPL2
*/

/* TODO:
 * Option to not print the link tag in the current item
 */

/**
 * Adds advanced functionality to the native Navigation Menus, featuring shortcodes,
 * new classes and dummy texts.
 *
 * @author Caio Costa <caio@caiocosta.com>
 */
class AdvancedNavigationMenus {
	public function __construct() {
		add_action('wp_nav_menu_args', array(&$this, 'update_args'));
	}

	/**
	 * Updates the arguments passed to wp_nav_menu
	 *
	 * @since 0.1
	 *
	 * @param array $args Array of arguments
	 */
	public function update_args($args) {
		// Change the walker.. only if it wasn't changed previously
		$args['walker'] = empty($args['walker']) ? new ANM_Walker_Nav_Menu : $args['walker'];

		add_filter('wp_nav_menu_objects', array(&$this, 'identify_first_and_last'));
		add_filter('wp_nav_menu_items', array(&$this, 'parse_shortcodes'));

		return $args;
	}

	/**
	 * Identifies first and last items on each sub-menu.
	 *
	 * @deprecated deprecated since 0.6
	 * @since 0.1
	 *
	 * @param array $items Passed by the system trough a hook
	 * @return array Identified nodes in each depth of menu.
	 */
	public function identify_first_and_last($items) {
		return $this->identify_nodes($items);
	}


	/**
	 * Identifies first and last items, menus with submenus and more.
	 *
	 * @since 0.6
	 *
	 * @param array $items Items to identify and organize
	 * @return array
	 */
	public function identify_nodes($items) {
		$sorted_items = array();
		$item_IDs = array();

		// Create an array to sort
		foreach ($items as $menu_id => $item) {
			$items[$menu_id]->advanced_menu_info = array(
				'first_item' => false,
				'last_item' => false,
				'has_sub-menu' => false
			);

			// Array key (for sorting): parent ID + order [i.e. 13.0003, 13.0004...]
			// No more than 10000 sub-items in the same menu
			$sorted_item_id = $item->menu_item_parent + ($menu_id / 10000);
			$sorted_items[(string)$sorted_item_id] = $menu_id;

			$item_IDs[$item->ID] = $menu_id;
		}
		ksort($sorted_items);

		$previous_item_parent_id = false;
		$previous_item_id = false;
		$total_items = count($sorted_items);
		$menu_order = 1;

		foreach ($sorted_items as $sorted_item_id => $item_id) {
			$item_count++;

			// Get only the integer from the item ID
			$parent_item_id = (int) $sorted_item_id;

			// If the current parent is not the same as the last parent...
			if ($parent_item_id !== $previous_item_parent_id) {
				$menu_order = 1;

				// current item is the first in its depth
				$items[$item_id]->advanced_menu_info['first_item'] = true;

				// previous item is last in its depth
				if ($items[$previous_item_id])
					$items[$previous_item_id]->advanced_menu_info['last_item'] = true;

				// If there's a parent, change the 'have_sub-menu' flag in the parent node
				if ($parent_item_id != 0)
					$items[$item_IDs[$parent_item_id]]->advanced_menu_info['has_sub-menu'] = true;
			}

			// if it's last... it's last.
			if ($total_items == $item_count)
				$items[$item_id]->advanced_menu_info['last_item'] = true;

			$items[$item_id]->advanced_menu_info['menu_order'] = $menu_order;
			$previous_item_id = $item_id;
			$previous_item_parent_id = $parent_item_id;

			$menu_order++;
		}

		return $items;
	}

	/**
	 * Parses shortcodes on a string
	 *
	 * @since 0.2
	 *
	 * @param string $list HTML string to be parsed
	 */
	public function parse_shortcodes($list) {
		$current_user = wp_get_current_user();

		$shortcodes = array(
			// Current logged-in user
			'[%user_login%]' => $current_user->user_login,
			'[%user_ID%]' => $current_user->ID,
			'[%user_firstname%]' => $current_user->user_firstname,
			'[%user_lastname%]' => $current_user->user_lastname,
			'[%user_displayname%]' => $current_user->display_name,
			'[%user_email%]' => $current_user->user_email,

			// Date and time
			'[%date%]' => date_i18n(get_option('date_format')),
		);

		$list = str_replace(array_keys($shortcodes), $shortcodes, $list);

		return $list;
	}
}

/**
 * Custom ANM walker
 *
 * @package AdvancedNavigationMenus
 * @since 0.1
 * @uses Walker_Nav_Menu
 */
class ANM_Walker_Nav_Menu extends Walker_Nav_Menu {
	/**
	 * @see Walker_Nav_Menu::start_lvl()
	 * @since 0.1
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	function start_lvl(&$output, $depth) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"sub-menu depth-".($depth + 1)."\">\n";
	}

	/**
	 * @see Walker_Nav_Menu::start_el()
	 * @since 0.1
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param int $current_page Menu item ID.
	 * @param object $args
	 */
	function start_el(&$output, $item, $depth, $args) {
		global $wp_query;

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$classes[] = ($item->post_parent != 0) ? 'parent_id-' . $item->post_parent : 'no_parent';
		if ($item->menu_item_parent)
			$classes[] = 'menu-parent_id-' . $item->menu_item_parent;

		//$classes[] = 'name-' . $item->post_name;
		//$classes[] = $item->object . '-name-' . $item->post_name;

		$classes[] = 'main-order-' . $item->menu_order;
		if ($item->advanced_menu_info['menu_order'])
			$classes[] = 'menu-order-' . $item->advanced_menu_info['menu_order'];

		if ($item->advanced_menu_info['first_item'])
			$classes[] = 'first-item';

		if ($item->advanced_menu_info['last_item'])
			$classes[] = 'last-item';

		if ($item->advanced_menu_info['has_sub-menu'])
			$classes[] = 'has_sub-menu';
		else
			$classes[] = 'no_sub-menu';

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names .'>';

		// Check whether the item has to be a link or not
		$no_link = ($item->url == '#nolink#');

		// Login/logout URL Replacements
		if ($item->url == '#login#')
			$item->url = wp_login_url(get_permalink());
		else if ($item->url == '#logout#')
			$item->url = wp_logout_url(get_permalink());

		// Attributes string
		$attributes = '';

		if (!$no_link && !empty($item->url)) {
			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		}

		$item_output = $args->before;
		$item_output .= (!$no_link ? '<a'. $attributes .'>' : '<span class="text">');
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= (!$no_link ? '</a>' : '</span>');
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

new AdvancedNavigationMenus;

?>