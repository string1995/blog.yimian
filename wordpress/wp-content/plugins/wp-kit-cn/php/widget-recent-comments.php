<?php
//WKC Recent Comments Widget
//Description: 调用WP Kit CN的函数，在侧边栏显示最新留言。
//Version: 8.7.31

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


### Function: Init WKC Recent Comments Widget
function widget_wkc_recent_comments_init() {
	if (!function_exists('register_sidebar_widget')) {
		return;
	}

	### Function: WKC Recent Comments Widget
	function widget_wkc_recent_comments($args) {
		extract($args);
		$options = get_option('widget_wkc_recent_comments');
		$title = htmlspecialchars(stripslashes($options['title']));	
		if (function_exists('wkc_recent_comments')) {
			echo $before_widget.$before_title.$title.$after_title;
			echo '<ul>'."\n";
			$param  = '';
			$param .= 'number=' . $options['number'];
			$param .= '&before=' . $options['before'];
			$param .= '&after=' . $options['after'];
			$param .= '&showpass=' . $options['show_pass'];
			$param .= '&length=' . $options['sublen'];
			$param .= '&skipuser=' . $options['skipuser'];
			$param .= '&avatarsize=' . ($options['avatarsize']==''?16:$options['avatarsize']);
			if($options['xformat'] == '')
			{
				$options['xformat'] = '<a class="commentor" href="%comment_author_url%" >%comment_author%</a> : <a class="comment_content" href="%permalink%" title="View the entire comment by %comment_author%" >%comment_excerpt%</a>';
			}
			$param .= '&xformat=' . $options['xformat'];
			wkc_recent_comments($param); 
			echo '</ul>'."\n";
			echo $after_widget;
		}
	}

	### Function: WKC Recent Comments Widget Options
	function widget_wkc_recent_comments_options() {
		$options = get_option('widget_wkc_recent_comments');
		
		$default_options = array(
                    'title' => __('Recent Comments','wpkitcn'), 
                    'number' => 10, 'before' => '<li>', 
                    'after' => '</li>', 
                    'show_pass' => false, 
                    'sublen' => 50, 
                    'skipuser' => 'admin',
                    'xformat' => '<a class="commentor" href="%comment_author_url%" >%comment_author%</a> : <a class="comment_content" href="%permalink%" title="View the entire comment by %comment_author%" >%comment_excerpt%</a>',
                    'avatarsize' => 16
		);
		
		$options = wp_parse_args($options,$default_options);
		
		if (isset($_POST['wkc_rc-submit']) && $_POST['wkc_rc-submit'] == 1) {
			$options['title'] = strip_tags($_POST['wkc_rc-title']);
			$options['number'] = intval($_POST['wkc_rc-number']);
			$options['before'] = $_POST['wkc_rc-befor'];
			$options['after'] = $_POST['wkc_rc-after'];
			$options['show_pass'] = $_POST['wkc_rc-show_pass'] == 'true';
			$options['sublen'] = intval($_POST['wkc_rc-sublen']);
			$options['skipuser'] = $_POST['wkc_rc-skipuser'];
			$options['avatarsize'] = intval($_POST['wkc_rc-avatarsize']);
			$options['xformat'] = stripslashes($_POST['wkc_rc-xformat']);
			update_option('widget_wkc_recent_comments', $options);
		}
		echo '<p><label for="wkc_rc-title">';
		_e('Title: ','wpkitcn');
		echo '</label><input type="text" class="widefat" id="wkc_rc-title" name="wkc_rc-title" value="'.htmlspecialchars(stripslashes($options['title'])).'" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_rc-number">';
		_e('Number of Comments: ','wpkitcn');
		echo '</label><input type="text" id="wkc_rc-number" name="wkc_rc-number" value="'.intval($options['number']).'" size="3" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_rc-befor">';
		_e('Before a Record: ','wpkitcn');
		echo '</label><input type="text" id="wkc_rc-befor" name="wkc_rc-befor" value="'.$options['before'].'" size="3" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_rc-after">';
		_e('After a Record: ','wpkitcn');
		echo '</label><input type="text" id="wkc_rc-after" name="wkc_rc-after" value="'.$options['after'].'" size="3" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_rc-show_pass">';
		_e('Show Comments of Password-Protected Posts: ','wpkitcn');
		echo '</label><input type="text" id="wkc_rc-show_pass" name="wkc_rc-show_pass" value="'.($options['show_pass']?'true':'false').'" size="3" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_rc-sublen">';
		_e('Comments Content Length: ','wpkitcn');
		echo '</label><input type="text" id="wkc_rc-sublen" name="wkc_rc-sublen" value="'.intval($options['sublen']).'" size="5" />&nbsp;&nbsp;'."\n";
		_e('(<strong>0</strong> to disable)','wpkitcn');
		echo '</p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_rc-skipuser">';
		_e('Exclude the user: ','wpkitcn');
		echo '</label><input type="text" id="wkc_rc-skipuser" name="wkc_rc-skipuser" value="'.$options['skipuser'].'" size="7" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_rc-avatarsize">';
		_e('Gravatar size: ','wpkitcn');
		echo '</label><input type="text" id="wkc_rc-avatarsize" name="wkc_rc-avatarsize" value="'.intval($options['avatarsize']).'" size="3" /></p>'."\n";
		echo '<p style="text-align: left;font-size:12px"><label for="wkc_rc-xfomat">';
		_e('The custom format of the link: ','wpkitcn');
		echo '</label>';
		?>
		<textarea style="font-size: 100%" name="wkc_rc-xformat" id="wkc_rc-xformat" cols="60" rows="5" style="width:100%"><?php echo htmlspecialchars(stripslashes($options['xformat']));?></textarea>
		<?php
		_e('Please <span style="color:red"><strong>BE SURE</strong></span> to <span style="color:red"><strong>KNOW</strong></span> what you are doing!','wpkitcn');
		echo '</p>'."\n";
		echo '<input type="hidden" id="wkc_rc-submit" name="wkc_rc-submit" value="1" />'."\n";
	}
	
	$widget_ops =  array('classname' => 'widget_wkc_recent_comments', 'description' => __( 'This widget will list recently comments.', 'wpkitcn'));
	// Register Widgets
	wp_register_sidebar_widget('wkc_recent_comments',__('WKC Recent Comments','wpkitcn'), 'widget_wkc_recent_comments', $widget_ops);
	wp_register_widget_control('wkc_recent_comments',__('WKC Recent Comments','wpkitcn'), 'widget_wkc_recent_comments_options');
}

?>