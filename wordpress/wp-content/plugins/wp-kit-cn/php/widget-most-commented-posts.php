<?php
//WKC Most Commented Posts Widget
//Description: 调用WP Kit CN的函数，在侧边栏显示留言最多的文章标题。
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


### Function: Init WKC Most Commented Posts Widget
function widget_wkc_most_commented_posts_init() {
	
	if (!function_exists('register_sidebar_widget')) return;
	
	### Function: WKC Most Commented Posts Widget
	function widget_wkc_most_commented_posts($args) {
		extract($args);
		$options = get_option('widget_wkc_most_commented_posts');
		$title = htmlspecialchars(stripslashes($options['title']));	
		if (function_exists('wkc_most_commented_posts')) {
			echo $before_widget.$before_title.$title.$after_title;
			echo '<ul>'."\n";
			$param  = '';
			$param .= 'number=' . $options['limit'];
			$param .= '&days=' . $options['days'];
			$param .= '&before=' . $options['before'];
			$param .= '&after=' . $options['after'];
			$param .= '&posttype=' . $options['posttype'];
			$param .= '&showcount=' . $options['showcount'];
			wkc_most_commented_posts($param); 
			echo '</ul>'."\n";
			echo $after_widget;
		}
	}

	### Function: WKC Most Commented Posts Widget Options
	function widget_wkc_most_commented_posts_options() {
		$options = get_option('widget_wkc_most_commented_posts');
		if (!is_array($options)) {
			$options = array('title' => __('Most Commented','wpkitcn'), 'limit' => 10, 'days' => 15, 'before' => '<li> + ', 'after' => '</li>', 'showcount' => 1, 'posttype'=>'both');
		}
		if (isset($_POST['wkc_mcp-submit']) && $_POST['wkc_mcp-submit'] == 1) {
			$options['title'] = strip_tags($_POST['wkc_mcp-title']);
			$options['limit'] = intval($_POST['wkc_mcp-limit']);
			$options['days'] = intval($_POST['wkc_mcp-days']);
			$options['before'] = $_POST['wkc_mcp-befor'];
			$options['after'] = $_POST['wkc_mcp-after'];
			$options['posttype'] = $_POST['wkc_mcp-posttype'];
			$options['showcount'] = intval($_POST['wkc_mcp-showcount']?1:0);
			update_option('widget_wkc_most_commented_posts', $options);

		}
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_mcp-title">';
		_e('Title: ','wpkitcn');
		echo '</label><input type="text" id="wkc_mcp-title" name="wkc_mcp-title" value="'.htmlspecialchars(stripslashes($options['title'])).'" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_rc-number">';
		_e('Number of Posts: ','wpkitcn');
		echo '</label><input type="text" id="wkc_mcp-limit" name="wkc_mcp-limit" value="'.intval($options['limit']).'" size="3" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_mcp-days">';
		_e('Timespan of Days: ','wpkitcn');
		echo '</label><input type="text" id="wkc_mcp-days" name="wkc_mcp-days" value="'.intval($options['days']).'" size="3" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_mcp-befor">';
		_e('Before a Record: ','wpkitcn');
		echo '</label><input type="text" id="wkc_mcp-befor" name="wkc_mcp-befor" value="'.$options['before'].'" size="3" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_mcp-after">';
		_e('After a Record: ','wpkitcn');
		echo '</label><input type="text" id="wkc_mcp-after" name="wkc_mcp-after" value="'.$options['after'].'" size="3" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_mcp-posttype">';
		_e('Post Type to Display(page, post, or both): ','wpkitcn');
		echo '</label><input type="text" id="wkc_mcp-posttype" name="wkc_mcp-posttype" value="'.$options['posttype'].'" size="4" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_mcp-showcount">';
		echo '<input type="checkbox" id="wkc_mcp-showcount" name="wkc_mcp-showcount" value="'.($options['showcount']!=0?'true" checked="checked':'false') .'" />';
		_e('Show the count number after the post name. ','wpkitcn');
		echo '</label></p>'."\n";
		echo '<input type="hidden" id="wkc_mcp-submit" name="wkc_mcp-submit" value="1" />'."\n";
	}
	
	$widget_ops =  array('classname' => 'widget_wkc_most_commented', 'description' => __( 'The list of your most commented posts.', 'wpkitcn'));
	// Register Widgets
	wp_register_sidebar_widget('wkc_most_commented', __('WKC Most Commented','wpkitcn'), 'widget_wkc_most_commented_posts', $widget_ops);
	wp_register_widget_control('wkc_most_commented', __('WKC Most Commented','wpkitcn'), 'widget_wkc_most_commented_posts_options', array('width'=>400,'height'=>200));
}

?>