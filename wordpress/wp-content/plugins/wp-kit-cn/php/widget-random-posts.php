<?php
//WKC Random Posts Widget
//Description: 调用WP Kit CN的函数，在侧边栏显示随机文章。
//Version: 8.7.30

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


### Function: Init WKC Random Posts Widget
function widget_wkc_random_posts_init() {
	if (!function_exists('register_sidebar_widget')) {
		return;
	}

	### Function: WKC Random Posts Widget
	function widget_wkc_random_posts($args) {
		extract($args);
		$options = get_option('widget_wkc_random_posts');
		$title = htmlspecialchars(stripslashes($options['title']));	
		if (function_exists('wkc_random_posts')) {
			echo $before_widget.$before_title.$title.$after_title;
			echo '<ul>'."\n";
			$param  = '';
			$param .= 'number=' . $options['limit'];
			$param .= '&length=' . $options['length'];
			$param .= '&before=' . $options['before'];
			$param .= '&after=' . $options['after'];
			$param .= '&showpass=' . $options['show_pass'];
			$param .= '&showexcerpt=' . $options['show_excerpt_in_title'];
			wkc_random_posts($param);
			echo '</ul>'."\n";
			echo $after_widget;
		}
	}

	### Function: WKC Random Posts Widget Options
	function widget_wkc_random_posts_options() {
		$options = get_option('widget_wkc_random_posts');
		if (!is_array($options)) {
			$options = array('title' => __('Random Posts','wpkitcn'), 'limit' => 5, 'length' => 200, 'before' => '<li> + ', 'after' => '</li>', 'show_pass' => false, 'show_excerpt_in_title' => true);
		}
                if (isset($_POST['wkc_rp-submit']) && $_POST['wkc_rp-submit'] == 1) {
			$options['title'] = strip_tags($_POST['wkc_rp-title']);
			$options['limit'] = intval($_POST['wkc_rp-limit']);
			$options['length'] = intval($_POST['wkc_rp-length']);
			$options['before'] = $_POST['wkc_rp-befor'];
			$options['after'] = $_POST['wkc_rp-after'];
			$options['show_pass'] = ( $_POST['wkc_rp-show_pass'] == 'false' ? false : true );
			$options['show_excerpt_in_title'] = ( $_POST['wkc_rp-show_excerpt_in_title'] == 'true' ? true : false );
			update_option('widget_wkc_random_posts', $options);
		}
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_rp-title">';
		_e('Title: ','wpkitcn');
		echo '</label><input type="text" id="wkc_rp-title" name="wkc_rp-title" value="'.htmlspecialchars(stripslashes($options['title'])).'" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_rc-number">';
		_e('Number of Posts: ','wpkitcn');
		echo '</label><input type="text" id="wkc_rp-limit" name="wkc_rp-limit" value="'.intval($options['limit']).'" size="3" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_rp-days">';
		_e('Length of the Excerpt: ','wpkitcn');
		echo '</label><input type="text" id="wkc_rp-length" name="wkc_rp-length" value="'.intval($options['length']).'" size="3" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_rp-befor">';
		_e('Before a Record: ','wpkitcn');
		echo '</label><input type="text" id="wkc_rp-befor" name="wkc_rp-befor" value="'.$options['before'].'" size="3" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_rp-after">';
		_e('After a Record: ','wpkitcn');
		echo '</label><input type="text" id="wkc_rp-after" name="wkc_rp-after" value="'.$options['after'].'" size="3" /></p>'."\n";
		echo '<p style="text-align:left;font-size:12px"><label for="wkc_rp-shwo_pass">';
		_e('Show Password Protected Post: ','wpkitcn');
		echo '</label><input type="text" id="wkc_rp-show_pass" name="wkc_rp-show_pass" value="'.($options['show_pass'] ? 'true':'false').'" size="3" /></p>'."\n";
		echo '<p style="text-align:left;font-size:12px"><label for="wkc_rp-show_excerpt_in_title">';
		_e('Show Excerpt in the Link Title: ','wpkitcn');
		echo '</label><input type="text" id="wkc_rp-show_excerpt_in_title" name="wkc_rp-show_excerpt_in_title" value="'.($options['show_excerpt_in_title'] ? 'true':'false').'" size="3" /><br/>' . __('\'true\' means that the excerpt of the post will show in the title of link. <br/>\'false\' means that the excerpt will show directly follow the title.','wpkitcn') .'</p>'."\n";
		echo '<input type="hidden" id="wkc_rp-submit" name="wkc_rp-submit" value="1" />'."\n";
	}
	
	$widget_ops =  array('classname' => 'widget_wkc_random_posts', 'description' => __( 'The list of random posts.', 'wpkitcn'));
	// Register Widgets
	wp_register_sidebar_widget('wkc_random_posts',__('WKC Random Posts','wpkitcn'), 'widget_wkc_random_posts', $widget_ops);
	wp_register_widget_control('wkc_random_posts',__('WKC Random Posts','wpkitcn'), 'widget_wkc_random_posts_options', array('width'=>400,'height'=>200));
}
?>