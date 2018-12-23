<?php
//WKC Advanced Blogroll Widget
//Description: 在侧边栏按照随机顺序显示blogroll。
//Version: 8.8.31


/*  
	Copyright 2008  Charles Tang  (email : tngchao@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

### Function: Init WKC Advanced Blogroll Widget
function widget_wkc_advanced_blogroll_init() {
	if (!function_exists('wp_register_sidebar_widget')) {
		return;
	}

	### Function: WKC Advanced Blogroll Widget
	function widget_wkc_advanced_blogroll($args) {
		extract($args);
		$options = get_option('widget_wkc_advanced_blogroll');
		if (function_exists('wp_list_bookmarks')) {
			$param = array(
				'title_before' => $before_title, 
				'title_after' => $after_title,
				'category_before' => $before_widget, 
				'category_after' => $after_widget,
				'orderby' => $options['orderby'],
				'category' => $options['category'],
				'limit' => $options['limit'],
				'show_images' => true, 
				'class' => 'linkcat widget',
				'echo' => 0
			);
			echo wp_list_bookmarks($param); 
		}
	}

	### Function: WKC Advanced Blogroll Widget Options
	function widget_wkc_advanced_blogroll_options() {
		$options = get_option('widget_wkc_advanced_blogroll');
		if (!is_array($options)) {
			$options = array(
				'orderby' => 'name', 
				'limit' => '-1', 
				'category' => '');
		}
		if (isset($_POST['wkc_ab-submit']) && $_POST['wkc_ab-submit'] == 1 ) {
			$options['orderby'] = $_POST['wkc_ab-orderby'];
			$options['limit'] = $_POST['wkc_ab-limit'];
			$options['category'] = $_POST['wkc_ab-category'];
			update_option('widget_wkc_advanced_blogroll', $options);
		}
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_ab-limit">';
		_e('Number of Links: ','wpkitcn');
		echo '</label><input type="text" id="wkc_ab-limit" name="wkc_ab-limit" value="'.intval($options['limit']).'" size="3" /><br/>' . __('-1 means disable number limitation.','wpkitcn') . '</p>'."\n";		
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_ab-orderby">';
		_e('Order by: ','wpkitcn');
		echo '</label><input type="text" id="wkc_ab-orderby" name="wkc_ab-orderby" value="'.$options['orderby'].'" size="5" /><br/>' . __("Optional ways:<br />name,rand,id,url,lenght etc.",'wpkitcn') . '</p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_ab-category">';
		_e('Category to display: ','wpkitcn');
		echo '</label><input type="text" id="wkc_ab-category" name="wkc_ab-category" value="'.$options['category'].'" size="5" /><br/>' . __('Comma separated list of numeric Category IDs to be displayed. ','wpkitcn') . '</p>'."\n";
		echo '<input type="hidden" id="wkc_ab-submit" name="wkc_ab-submit" value="1" />'."\n";
	}
	
	$widget_ops =  array('classname' => 'widget_wkc_advanced_blogroll', 'description' => __( 'List links in specified categories through specified way.', 'wpkitcn'));
	// Register Widgets
	wp_register_sidebar_widget('wkc_advanced_blogroll', __('WKC Advanced Blogroll','wpkitcn'), 'widget_wkc_advanced_blogroll', $widget_ops);
	wp_register_widget_control('wkc_advanced_blogroll', __('WKC Advanced Blogroll','wpkitcn'), 'widget_wkc_advanced_blogroll_options', array('width'=>400,'height'=>200));
}



?>