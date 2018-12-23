<?php
if (!class_exists('WPKitCN'))
{
class WPKitCN{
	var $version = '8.12.19';
	
	var $options;
	var $default_options;
	var $db_options = 'wp_kit_cn';
	
	var $base_name;

	function WPKitCN()
	{
		$base_name  = dirname(__FILE__) . '/';
		
		// Localization
		$locale = get_locale();
		if ( !empty( $locale ) ) {
			$mofile = $base_name . 'languages/wpkitcn-'.$locale.'.mo';
			load_textdomain('wpkitcn', $mofile);
		}
		
		$default_options = array(
			'enable_excerpt_algorithm'				=> 1,
			'excerpt_words_number' 					=> 250,
			'excerpt_paragraphs_number' 			=> 3,
			'add_related_posts_to_feed'				=> 0,
			'add_recent_comments_to_feed'			=> 0,
			'display_order_of_related_posts_list'	=> 0,
			'display_order_of_recent_comments_list'	=> 1,
			'no_related_posts_tips'					=> 'No Related Posts',
			'related_posts_list_title'				=> 'Related Posts',
			'recent_comments_list_title'			=> 'Recent Comments'
		);
		
		$this->default_options = $default_options;
		
		// Get options from WP options
		$options_from_table = get_option( $this->db_options );

		// Update default options by getting not empty values from options table
		foreach( (array) $default_options as $default_options_name => $default_options_value ) {
			if ( !is_null($options_from_table[$default_options_name]) ) {
				if ( is_int($default_options_value) ) {
					$default_options[$default_options_name] = (int) $options_from_table[$default_options_name];
				} else {
					$default_options[$default_options_name] = $options_from_table[$default_options_name];
				}
			}
		}

		// Set the class property and unset no used variable
		$this->options = $default_options;
		
		// Clean memory
		$default_options = array();
		$options_from_table = array();
		unset($default_options);
		unset($options_from_table);
		unset($default_options_value);
		
		if ($this->options['enable_excerpt_algorithm'])
		{
			add_filter('get_the_excerpt', array(&$this,'WKC_excerpt'), 9);
		}
	}
	
	function get_recent_comments($limit = 5, $show_pass_post = false, $skipuser = 'admin', $offset = 0, $postid = false) {
		global $wpdb;

		$skips = explode(',',$skipuser);
		$skips = implode('\',\'',$skips);
		$skips = "AND comment_author NOT IN('" . $skips . "') ";
		
		if (!$show_pass_post) {
			$show_pass_post = "AND post_password = ''";
		} else {
			$show_pass_post = "";
		}
		
		$limit = intval($limit);
		$limit = $limit < 0 ? 0 : $limit;
		
		$offset = intval($offset);
		$offset = $offset < 0 ? 0 : $offset;

		if ($postid != false){
			$postid = (int) $postid;
			$postid = 'AND ID = ' . $postid ;
		}else{
			$postid = '';
		}
		
		$query = "SELECT ID, comment_ID, comment_content, comment_author, comment_author_url, comment_author_email, post_title, comment_count
				  FROM {$wpdb->posts},{$wpdb->comments}
				  WHERE ID = comment_post_ID 
				  {$postid}
				  AND (post_status = 'publish' OR post_status = 'static') 
				  AND comment_type = ''
				  {$show_pass_post}
				  {$skips} 
				  AND (comment_author != '')
				  AND comment_approved = '1' 
				  ORDER BY comment_date DESC 
				  LIMIT {$offset}, {$limit}";

		$comments = $wpdb->get_results($query);
		
		return $comments;
	}

	function get_recent_pings($no_comments = 5, $show_pass_post = false, $type = 'both') {
		global $wpdb;
		
		if ($type == 'pingback') {
			$type = '(comment_type = \'pingback\')';
		} else if ($type == 'trackback') {
			$type = '(comment_type = \'trackback\')';
		} else {
			$type = '(comment_type = \'trackback\' OR comment_type = \'pingback\')';
		}
		
		if (!$show_pass_post) {
			$show_pass_post = 'AND post_password = \'\' ';
		} else {
			$show_pass_post = '';
		}
		$query  = "SELECT ID, comment_ID, comment_content, comment_author, post_name
				   FROM {$wpdb->posts}, {$wpdb->comments}
				   WHERE ID = comment_post_ID AND (post_status = 'publish' OR post_status = 'static') AND {$type}
				   {$show_pass_post}
				   AND comment_approved = '1'
				   ORDER BY comment_date DESC
				   LIMIT {$no_comments}";
		$comments = $wpdb->get_results($query);
		
		return $comments;
	}

	function get_recent_posts($limit = 5, $show_pass_post = false, $offset = 0, $post_type='post') {
		global $wpdb;
		
		if (!$show_pass_post) {
			$show_pass_post = "AND post_password = ''";
		} else {
			$show_pass_post = "";
		}
		
		$query  = "SELECT ID, post_title, post_date, post_content, post_name 
				   FROM {$wpdb->posts} 
				   WHERE post_status = 'publish'
				   AND post_type = '$post_type'
				   {$show_pass_post}
				   ORDER BY post_date DESC 
				   LIMIT $offset, $limit";
		$posts = $wpdb->get_results($query);
		return $posts;
	}

	function get_most_commented_posts($limit = 5, $days = 7, $ptype = 'post', $offset = 0) {
	    global $wpdb;
	    
	    if ('post' == $ptype) {
	    	$ptype = 'AND post_type = \'post\'';
	    } else if ('page' == $ptype) {
	    	$ptype = 'AND post_type = \'page\'';
	    } else {
	    	$ptype = '';
	    }
	    
	    $days = intval($days);
		if ($days > 0){
			$limit_date = current_time('timestamp') - ($days*86400);
			$limit_date = date('Y-m-d H:i:s', $limit_date);
			$days = 'AND post_date < "'.current_time('mysql').'" AND post_date > "'.$limit_date.'" ';
		}else{
			$days = '';
		}
	    
	    $limit = intval($limit);
	    if ($limit < 0) $limit = 5;
	    
	    $offset = intval($offset);
	    if ($offset < 0) $offset = 0;
	    
	    $query  = "SELECT ID, post_title, post_name, COUNT(comment_post_ID) AS comment_total
	    		   FROM {$wpdb->posts} 
	    		   LEFT JOIN {$wpdb->comments} ON ID = comment_post_ID
	    		   WHERE comment_approved = 1
	    		   {$ptype}
	    		   {$days}
	    		   AND post_status = 'publish' AND post_password = ''
	    		   GROUP BY comment_post_ID
	    		   ORDER BY comment_total DESC
	    		   LIMIT {$offset},{$limit}";
	    		   
	    $mostcommenteds = $wpdb->get_results($query);
	    return $mostcommenteds;
	}

	function get_random_posts($limit = 5, $show_pass_post = false, $ptype = 'post') {
		global $wpdb;
		
		if ('post' == $ptype) {
	    	$ptype = 'AND post_type = \'post\'';
	    } else if ('page' == $ptype) {
	    	$ptype = 'AND post_type = \'page\'';
	    } else {
	    	$ptype = '';
	    }
	    
		if (!$show_pass_post) {
			$show_pass_post = "AND post_password = ''";
		} else {
			$show_pass_post = "";
		}
		
		$query = "SELECT ID, post_title, post_date, post_content, post_name 
				  FROM {$wpdb->posts} 
				  WHERE post_status = 'publish' 
				  {$show_pass_post} 
				  {$ptype}
				  ORDER BY RAND() 
				  LIMIT $limit";
		$posts = $wpdb->get_results($query);
		
		return $posts;
	}

	function get_most_active_commentors($threshhold = 5, $days = 7, $skipuser = 'admin') {
		global $wpdb;
		
		$skips = explode(',',$skipuser);
		$skips = implode('\',\'',$skips);
		$skips = "AND comment_author NOT IN('" . $skips . "') ";
		
		if ($days > 0){
			$limit_date = current_time('timestamp') - ($days*86400);
			$limit_date = date('Y-m-d H:i:s', $limit_date);
			$days = 'AND comment_date > "'.$limit_date.'" ';
		}
		
		$query  = "SELECT comment_author, comment_author_url, COUNT(comment_ID) AS 'comment_total' 
				   FROM {$wpdb->comments}
				   WHERE comment_approved = '1'
				   {$skips}
				   AND (comment_author != '') AND (comment_type = '')
				   {$days}
				   GROUP BY comment_author 
				   ORDER BY comment_total DESC";
		
		$comments = $wpdb->get_results($query);
		
		return $comments;
	}

	function get_recent_commentors($threshhold = -1, $type = 'week', $skipuser = 'admin') {
		global $wpdb;
		
		$skips = explode(',',$skipuser);
		$skips = implode('\',\'',$skips);
		$skips = "AND comment_author NOT IN('" . $skips . "') ";
		
		if ($type == 'week'){
			$type = 'AND YEARWEEK(comment_date) = YEARWEEK(NOW())';
		}elseif ($type == 'month'){
			$type = 'AND (MONTH(comment_date) = MONTH(NOW()) AND YEAR(comment_date) = YEAR(NOW()))';
		}
		
		$query  = "SELECT comment_author, comment_author_url, COUNT(comment_ID) AS 'comment_total' 
				   FROM {$wpdb->comments}
				   WHERE comment_approved = '1'
				   {$skips}
				   AND (comment_author != '') AND (comment_type = '')
				   {$type}
				   GROUP BY comment_author 
				   ORDER BY comment_total DESC";
		
		$comments = $wpdb->get_results($query);
		
		return $comments;
	}

	function get_same_categories_posts($postid = false, $limit = 5, $offset = 0, $orderby = 'rand', $order = 'asc') {
		global $wpdb,$post;
		
		$postid = (int) $postid;
		if (!$postid) {
			$postid = $post->ID;
		}
		
		$categories = wp_get_object_terms($postid,'category');
		$cat_ids = '';
		foreach($categories as $cat) {
			$cat_ids .= '"' . $cat->term_id . '", ';
		}
		$cat_ids = substr($cat_ids, 0, strlen($cat_ids) - 2);
		
		if ('rand' == $orderby)
		{
			$orderby = 'RAND()';
		} else {
			if ('asc' == $order) {
				$order = 'ASC';
			} else {
				$order = 'DESC';
			}
			if ('date' == $orderby) {
				$orderby = "p.post_date $order";
			} else if ('comment_count' == $orderby) {
				$orderby = 'p.comment_count $order';
			} else {
				$orderby = 'RAND()';
			}
		}
		
		$limit = (int) $limit;
		if ($limit < 1) $limit = 5;
		if ($limit > 25) $limit = 15;
		
		$offset = (int) $offset;
		if ($offset < 0) $offset = 0;
		
		$query  = "SELECT p.ID, p.post_title, p.post_date, p.comment_count, p.post_name
				   FROM {$wpdb->posts} AS p
				   INNER JOIN {$wpdb->term_relationships} AS tr ON (p.ID = tr.object_id)
				   INNER JOIN {$wpdb->term_taxonomy} AS tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id)
				   WHERE tt.taxonomy = 'category'
				   AND p.ID <> {$postid}
				   AND p.post_status = 'publish'
				   AND tt.term_id IN ({$cat_ids})
				   GROUP BY tr.object_id
				   ORDER BY $orderby
				   LIMIT $offset, $limit ";
		
		$posts = $wpdb->get_results($query);
		return $posts;
	}

	function get_related_posts($postid = false, $limit = 5, $offset = 0, $orderby = 'date', $order = 'desc') {
            global $wpdb;

            $postid = (int) $postid;
            if (!$postid) {
                global $post;
                $postid = $post->ID;
            }

            $tags = wp_get_object_terms($postid, 'post_tag');

            $tag_cond = '';
            if (!empty($tags)) {
                $tag_ids = '';
                foreach ($tags as $tag) {
                    $tag_ids .= '"' . $tag->term_id . '", ';
                }
                $tag_ids = substr($tag_ids, 0, strlen($tag_ids) - 2);
                $tag_cond = "AND tt.term_id IN ({$tag_ids})";
            }

            if ('rand' == $orderby) {
                $orderby = 'RAND()';
            } else {
                if ('asc' == $order) {
                    $order = 'ASC';
                } else {
                    $order = 'DESC';
                }
                if ('date' == $orderby) {
                    $orderby = "p.post_date $order";
                } else if ('comment_count' == $orderby) {
                    $orderby = 'p.comment_count $order';
                } else {
                    $orderby = 'RAND()';
                }
            }

            $limit = (int) $limit;
            if ($limit < 1)
                $limit = 1;

            $offset = (int) $offset;
            if ($offset < 0)
                $offset = 0;

            $query = '';
            $query = "SELECT p.ID, p.post_title, p.post_date, p.comment_count, p.post_name, COUNT(tr.object_id) AS max_share
				   FROM {$wpdb->posts} AS p 
				   INNER JOIN {$wpdb->term_relationships} AS tr ON (p.ID = tr.object_id)
				   INNER JOIN {$wpdb->term_taxonomy} AS tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id)
				   WHERE tt.taxonomy = 'post_tag'
				   AND p.ID <> {$postid}
				   AND p.post_status = 'publish'
				   {$tag_cond}
				   GROUP BY tr.object_id
				   ORDER BY max_share DESC, {$orderby}
				   LIMIT {$offset}, {$limit} ";

            $posts = $wpdb->get_results($query);
            return $posts;
        }

	function cut_str($string, $sublen, $start = 0, $code = 'UTF-8')
	{
		if($code == 'UTF-8')
		{
			$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
			preg_match_all($pa, $string, $t_string);
			if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen))."...";
			return join('', array_slice($t_string[0], $start, $sublen));
		}
		else
		{
			$start = $start*2;
			$sublen = $sublen*2;
			$strlen = strlen($string);
			$tmpstr = '';
			for($i=0; $i<$strlen; $i++)
			{
				if($i>=$start && $i<($start+$sublen))
				{
					if(ord(substr($string, $i, 1))>129) $tmpstr.= substr($string, $i, 2);
					else $tmpstr.= substr($string, $i, 1);
				} 
				if(ord(substr($string, $i, 1))>129) $i++;
			}
			if(strlen($tmpstr)<$strlen ) $tmpstr.= "...";
			return $tmpstr;
		}
	}
	
	function mb_strlen ($text, $encode) 
	{
		if ($encode=='UTF-8') {
			return preg_match_all('%(?:
					  [\x09\x0A\x0D\x20-\x7E]           # ASCII
					| [\xC2-\xDF][\x80-\xBF]            # non-overlong 2-byte
					|  \xE0[\xA0-\xBF][\x80-\xBF]       # excluding overlongs
					| [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} # straight 3-byte
					|  \xED[\x80-\x9F][\x80-\xBF]       # excluding surrogates
					|  \xF0[\x90-\xBF][\x80-\xBF]{2}    # planes 1-3
					| [\xF1-\xF3][\x80-\xBF]{3}         # planes 4-15
					|  \xF4[\x80-\x8F][\x80-\xBF]{2}    # plane 16
					)%xs',$text,$out);
		}else{
			return strlen($text);
		}
	}
	
	function WKC_excerpt($text)
	{
		global $post;

		//禁用中文工具箱对摘要的处理
		remove_filter('the_excerpt', 'mul_excerpt');
		remove_filter('the_excerpt_rss', 'mul_excerpt');
		
		if ( '' == $text ) {
			$text = $post->post_content;
			$text = apply_filters('the_content', $text);
			$text = str_replace(']]>', ']]&gt;', $text);
			$text = strip_tags($text);

			$text = trim($text);

			//段落数
			$fragmentnum = $this->options['excerpt_paragraphs_number'];
			//文字数
			$wordnum = $this->options['excerpt_words_number'];
			$words = explode("\n", $text, $fragmentnum+1);
			$num = 0;
			$output = '';
			do {
				$output = $output . $words[$num] . "\n" . "\n";
				$num++;
			} while ( ($this->mb_strlen($output, 'UTF-8') < $wordnum) and ($num < min(count($words), $fragmentnum)) );

			if ($this->mb_strlen($output, 'UTF-8') < $this->mb_strlen($text, 'UTF-8')) {
				$output .= '<span class="readmore"><a href="' . get_permalink() . '" title="' . strip_tags(get_the_title()) . '">';
				$output .= __('Read More: ','wpkitcn') . $this->mb_strlen(preg_replace('/\s/','',html_entity_decode(strip_tags($post->post_content))),'UTF-8') . __(' Words Totally','wpkitcn') . '</a></span>';
			}

			return $output;
		}
		return $text;
	}
}
}

?>