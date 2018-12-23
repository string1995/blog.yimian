<?php
//WKC Most Active Commentors Widget
//Description: 调用WP Kit CN的函数，在侧边栏显示最近若干天内（可设定）留言最多的用户。
//Version: 8.9.20

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


### Function: Init WKC Most Active Commentors Widget
function widget_wkc_most_active_commentors_init() {
	if (!function_exists('register_sidebar_widget')) {
		return;
	}

	### Function: WKC Most Active Commentors Widget
	function widget_wkc_most_active_commentors($args) {
		extract($args);
		$options = get_option('widget_wkc_most_active_commentors');
		$title = htmlspecialchars(stripslashes($options['title']));	
		if (function_exists('wkc_most_active_commentors')) {
			echo $before_widget.$before_title.$title.$after_title;
			echo '<ul>'."\n";
			$param  = '';
			$param .= 'threshhold=' . $options['threshhold'];
			$param .= '&days=' . $options['days'];
			$param .= '&skipuser=' . $options['skipuser'];
			$param .= '&before=' . $options['before'];
			$param .= '&after=' . $options['after'];
			$param .= '&number=' . $options['number'];
			wkc_most_active_commentors($param); 
			echo '</ul>'."\n";
			echo $after_widget;
		}
	}

	### Function: WKC Most Active Commentors Widget Options
	function widget_wkc_most_active_commentors_options() {
		$options = get_option('widget_wkc_most_active_commentors');
		if (!is_array($options)) {
			$options = array('title' => __('Most Active Commentors','wpkitcn'), 'number' => 10, 'threshhold' => 2, 'days' => 15, 'skipuser' => 'admin', 'before' => '<li class="wkc_most_active">', 'after' => '</li>');
		}
		if (isset($_POST['wkc_mac-submit']) && $_POST['wkc_mac-submit'] == 1) {
			$options['title'] = strip_tags($_POST['wkc_mac-title']);
			$options['threshhold'] = intval($_POST['wkc_mac-threshhold']);
			$options['number'] = intval($_POST['wkc_mac-number']);
			$options['days'] = intval($_POST['wkc_mac-days']);
			$options['skipuser'] = $_POST['wkc_mac-skipuser'];
			$options['before'] = stripslashes($_POST['wkc_mac-before']);
			$options['after'] = stripslashes($_POST['wkc_mac-after']);
			update_option('widget_wkc_most_active_commentors', $options);
		}
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_mac-title">';
		_e('Title: ','wpkitcn');
		echo '</label><input type="text" id="wkc_mac-title" name="wkc_mac-title" value="'.htmlspecialchars(stripslashes($options['title'])).'" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_mac-threshhold">';
		_e('Number of Posts: ','wpkitcn');
		echo '</label><input type="text" id="wkc_mac-threshhold" name="wkc_mac-threshhold" value="'.intval($options['threshhold']).'" size="3" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_mac-number">';
		_e('Number of commentors to show(-1 means no limit): ','wpkitcn');
		echo '</label><input type="text" id="wkc_mac-number" name="wkc_mac-number" value="'.intval($options['number']).'" size="3" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_mac-days">';
		_e('Timespan of Days: ','wpkitcn');
		echo '</label><input type="text" id="wkc_mac-days" name="wkc_mac-days" value="'.intval($options['days']).'" size="3" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_mac-skipuser">';
		_e('Exclude the user: ','wpkitcn');
		echo '</label><input type="text" id="wkc_mac-skipuser" name="wkc_mac-skipuser" value="'.$options['skipuser'].'" size="7" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_mac-before">';
		_e('The tag before a item: ','wpkitcn');
		echo '</label><input type="text" id="wkc_mac-before" name="wkc_mac-before" value="'.htmlspecialchars(stripslashes($options['before'])).'" size="10" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_mac-after">';
		_e('The tag after a item: ','wpkitcn');
		echo '</label><input type="text" id="wkc_mac-after" name="wkc_mac-after" value="'.htmlspecialchars(stripslashes($options['after'])).'" size="10" /></p>'."\n";
		echo '<input type="hidden" id="wkc_mac-submit" name="wkc_mac-submit" value="1" />'."\n";
	}
	
	$widget_ops =  array('classname' => 'widget_wkc_most_active_commentors', 'description' => __( 'List the most active users in last few days.', 'wpkitcn'));
	// Register Widgets
	wp_register_sidebar_widget('wkc_most_active_commentors', __('WKC Most Active Commentors','wpkitcn'), 'widget_wkc_most_active_commentors', $widget_ops);
	wp_register_widget_control('wkc_most_active_commentors', __('WKC Most Active Commentors','wpkitcn'), 'widget_wkc_most_active_commentors_options', array('width'=>400,'height'=>200));
}
?>