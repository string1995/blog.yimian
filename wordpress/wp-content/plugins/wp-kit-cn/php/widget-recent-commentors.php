<?php
//WKC Recent Commentors Widget
//Description: 调用WP Kit CN的函数，在侧边栏显示最近若干天内（可设定）留言最多的用户。
//Version: 8.7.30

/*  
	Copyright 2008  Charles Tang  (email : charlestang@foxmail.com)

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


### Function: Init WKC Recent Commentors Widget
function widget_wkc_recent_commentors_init() {
	if (!function_exists('register_sidebar_widget')) {
		return;
	}

	### Function: WKC Recent Commentors Widget
	function widget_wkc_recent_commentors($args) {
		extract($args);
		$options = get_option('widget_wkc_recent_commentors');
		$title = htmlspecialchars(stripslashes($options['title']));	
		if (function_exists('wkc_recent_commentors')) {
			echo $before_widget.$before_title.$title.$after_title;
			echo '<ul>'."\n";
			$param  = '';
			$param .= 'threshhold=' . $options['threshhold'];
			$param .= '&type=' . $options['type'];
			$param .= '&skipuser=' . $options['skipuser'];
			$param .= '&before=' . $options['before'];
			$param .= '&after=' . $options['after'];
			$param .= '&number=' . $options['number'];
			wkc_recent_commentors($param); 
			echo '</ul>'."\n";
			echo $after_widget;
		}
	}

	### Function: WKC Recent Commentors Widget Options
	function widget_wkc_recent_commentors_options() {
		$options = get_option('widget_wkc_recent_commentors');
		if (!is_array($options)) {
			$options = array('title' => __('Recent Commentors','wpkitcn'), 'number' => 10, 'threshhold' => 2, 'type' => 'week', 'skipuser' => 'admin', 'before' => '<li>', 'after' => '</li>');
		}
		if (isset($_POST['wkc_rcr-submit']) && $_POST['wkc_rcr-submit'] == 1) {
			$options['title'] = strip_tags($_POST['wkc_rcr-title']);
			$options['number'] = intval($_POST['wkc_rcr-number']);
			$options['threshhold'] = intval($_POST['wkc_rcr-threshhold']);
			$options['type'] = $_POST['wkc_rcr-type'];
			$options['skipuser'] = $_POST['wkc_rcr-skipuser'];
			$options['before'] = $_POST['wkc_rcr-before'];
			$options['after'] = $_POST['wkc_rcr-after'];
			update_option('widget_wkc_recent_commentors', $options);
		}
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_rcr-title">';
		_e('Title: ','wpkitcn');
		echo '</label><input type="text" id="wkc_rcr-title" name="wkc_rcr-title" value="'.htmlspecialchars(stripslashes($options['title'])).'" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_rcr-threshhold">';
		_e('Threshhold of comments: ','wpkitcn');
		echo '</label><input type="text" id="wkc_rcr-threshhold" name="wkc_rcr-threshhold" value="'.intval($options['threshhold']).'" size="3" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_rcr-number">';
		_e('Number of commentors to show(-1 means no limit): ','wpkitcn');
		echo '</label><input type="text" id="wkc_rcr-number" name="wkc_rcr-number" value="'.intval($options['number']).'" size="3" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_rcr-type">';
		_e('Statistic type: ','wpkitcn');
		echo '</label><input type="text" id="wkc_rcr-type" name="wkc_rcr-type" value="'.$options['type'].'" size="5" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_rcr-skipuser">';
		_e('Exclude the user: ','wpkitcn');
		echo '</label><input type="text" id="wkc_rcr-skipuser" name="wkc_rcr-skipuser" value="'.$options['skipuser'].'" size="7" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_rcr-before">';
		_e('The tag before a item: ','wpkitcn');
		echo '</label><input type="text" id="wkc_rcr-before" name="wkc_rcr-before" value="'.$options['before'].'" size="10" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_rcr-after">';
		_e('The tag after a item: ','wpkitcn');
		echo '</label><input type="text" id="wkc_rcr-after" name="wkc_rcr-after" value="'.$options['after'].'" size="10" /></p>'."\n";
		echo '<input type="hidden" id="wkc_rcr-submit" name="wkc_rcr-submit" value="1" />'."\n";
	}
	
	$widget_ops =  array('classname' => 'widget_wkc_recent_commentors', 'description' => __( 'This week\'s or this month\'s commentors who reply most', 'wpkitcn'));
	// Register Widgets
	wp_register_sidebar_widget('wkc_recent_commentors', __('WKC Recent Commentors','wpkitcn'), 'widget_wkc_recent_commentors', $widget_ops);
	wp_register_widget_control('wkc_recent_commentors', __('WKC Recent Commentors','wpkitcn'), 'widget_wkc_recent_commentors_options', array('width'=>400,'height'=>200));
}
?>