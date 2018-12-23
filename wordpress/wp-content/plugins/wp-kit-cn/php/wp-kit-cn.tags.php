<?php
/*Hi, everybody!
 *I think the performance of the wp function the_permalink() is low.
 *so I give you this chance to use your own function to replace it.
 *If you know what I mean, you'll understand the following code.
 */

function get_permalink_replacer($post){
	//the argument $post is a object which contains
	//some infomation of the post, including post_name
	//ID,post_date, you can use the var_dump to see what in it
	if(function_exists('custom_get_permalink')){
		return custom_get_permalink($post);
	}else{
		return get_permalink($post->ID);
	}
}

/*You can find all the template tags you can use in this file.*/

### Recent Comments ###

function wkc_recent_comments($args='') {
    $defaults = array(
        'number' => 5,
        'before' => '<li>',
        'after' => '</li>',
        'showpass' => 0,
        'length' => 50,
        'skipuser' => 'admin',
        'avatarsize' => 16,
        'xformat' => '<a class="commentor" href="%comment_author_url%" >%comment_author%</a> : <a class="comment_content" href="%permalink%" title="View the entire comment by %comment_author%" >%comment_excerpt%</a>',
        'getrawdata' => 0,
        'postid' => false,
        'offset' => 0,
        'echo' => 1
    );

    $r = wp_parse_args($args, $defaults);

    global $ct_wp_kit_cn;
    $comments = $ct_wp_kit_cn->get_recent_comments($r['number'], $r['showpass'], $r['skipuser'], $r['offset'], $r['postid']);
    
    if ($r['getrawdata']) {
        return $comments;
    }

    $output = '';
    foreach ($comments as $comment) {
        $post_title = stripslashes($comment->post_title);
        $comment_author = stripslashes($comment->comment_author);
        $comment_content = strip_tags($comment->comment_content);
        $comment_content = stripslashes($comment_content);
        if ($r['length'] > 0)
            $comment_excerpt = $ct_wp_kit_cn->cut_str($comment_content, $r['length']);
        if (function_exists('convert_smilies')) {
            $comment_excerpt = convert_smilies($comment_excerpt);
        }
        $permalink = get_permalink($comment->ID) . "#comment-" . $comment->comment_ID;

//	if ($comment->comment_author_url)
//          $output .= $r['before'] . '<a class="commentor" href="' .$comment->comment_author_url .'">' . $comment_author . '</a> : ' .  '<a class="comment-content" href="' . $permalink . '" title="View the entire comment by ' . $comment_author . '">' . $comment_excerpt . '</a>'. $r['after'] . "\n";
//	else
//          $output .= $r['before'] . '<span class="commentor">' . $comment_author ."</span> : ". '<a class="comment-content" href="' . $permalink . '" title="View the entire comment by ' . $comment_author . '">' . $comment_excerpt . '</a>'. $r['after'] . "\n";
        $output .= $r['before'];
        $element_loop = $r['xformat'];
        $element_loop = str_replace('%gravatar%', get_avatar($comment->comment_author_email, $r['avatarsize']), $element_loop);
        $element_loop = str_replace('%comment_author_url%', $comment->comment_author_url, $element_loop);
        $element_loop = str_replace('%comment_author%', $comment_author, $element_loop);
        $element_loop = str_replace('%permalink%', $permalink, $element_loop);
        $element_loop = str_replace('%comment_excerpt%', $comment_excerpt, $element_loop);
        $element_loop = str_replace('%post_title%', $post_title, $element_loop);
        $element_loop = str_replace('%comment_count%', $comment->comment_count, $element_loop);
        $output .= $element_loop;
        $output .= $r['after'] . "\n";
    }
    if ($r['echo']) {
        echo $output;
    } else {
        return $output;
    }
}

### Recent Pings ###
function wkc_recent_pings($args=''){
	$defaults = array(
		'number'	=>	5,
		'before'	=>	'<li>',
		'after'		=>	'</li>',
		'showpass'	=>	0,
		'length'	=>	30,
		'type'		=>	'both',		//can also be 'pingback' or 'trackback'
		'nopings'	=>	'No Pings',
		'echo'		=>	1
	);
	
	$r = wp_parse_args($args,$defaults);
	
	global $ct_wp_kit_cn;
	$comments = $ct_wp_kit_cn->get_recent_pings($r['number'],$r['showpass'],$r['type']);
	
	if(!$r['echo'])
	{
		return $comments;
	}
	
	$output = '';
	if(count($comments) == 0)
	{
		echo $r['nopings'];
		return;
	}
	foreach ($comments as $comment) {
		$comment_author = stripslashes($comment->comment_author);
		$comment_content = strip_tags($comment->comment_content);
		$comment_content = stripslashes($comment_content);
		$comment_excerpt = $ct_wp_kit_cn->cut_str($comment_content,$r['length']);
		$permalink = get_permalink($comment->ID)."#comment-".$comment->comment_ID;
		$output .= $r['before'] . '<a href="' . $permalink . '" title="View the entire comment by ' . $comment_author . '">' . $comment_author . '</a>: ' . $comment_excerpt . '...' . $r['after'] . "\n";
	}
	
	echo $output;
}

### Recent Posts ###
function wkc_recent_posts($args=''){
	$defaults = array(
		'number' => 5, 
		'before' => '<li>+ ', 
		'after' => '</li>', 
		'showpass' => false, 
		'skip' => 0,
		'echo' => 1
	);
	
	$r = wp_parse_args($args,$defaults);
	
	global $ct_wp_kit_cn;
	
	$posts = $ct_wp_kit_cn->get_recent_posts($r['number'],$r['showpass'],$r['skip']);
	
	if(!$r['echo'])
	{
		return $posts;
	}
	
	$output = '';
	foreach ($posts as $post) {
	    $post_title = stripslashes($post->post_title);
	    $permalink = get_permalink_replacer($post);
	    $output .= $r['before'] . '<a href="' . $permalink . '" rel="bookmark" title="' . __('Permanent Link: ','wpkitcn') . $post_title . '">' . $post_title . '</a>'. $r['after'] . "\n";
	}
	echo $output;
}

### Most Commented Posts ###
function wkc_most_commented_posts($args='') {
	$defaults = array(
		'number'	=>	5,
		'days'		=>	7,
		'before'	=>	'+ ',
		'after'		=>	'<br />',
		'posttype'	=>	'post',
		'showcount' =>  1,
		'echo'		=>	1
	);
	
	$r = wp_parse_args($args,$defaults);
	
	global $ct_wp_kit_cn;
	
	$posts = $ct_wp_kit_cn->get_most_commented_posts($r['number'], $r['days'], $r['posttype']);
	
	if(!$r['echo'])
	{
		return $posts;
	}
	
	$output = '';
    foreach ($posts as $post) {
		$post_id = (int) $post->ID;
		$post_title = htmlspecialchars(stripslashes($post->post_title));
		$comment_total = (int) $post->comment_total;
        $permalink = get_permalink($post->ID);
		$output .= $r['before'] . "<a href=\"$permalink\">$post_title</a>";
		if ($r['showcount']) 
		{
			$output .= " ($comment_total)";
		}
		$output .= $r['after'] . "\n";
    }
    
    echo $output;
}

### Random Posts ###
function wkc_random_posts($args=''){
	$defaults = array(
		'number'	=>	5,
		'length'	=>	400, 
		'before'	=>	'<li>', 
		'after'		=>	'</li>', 
		'showpass'	=>	0,
		'showexcerpt'	=> 1,
		'type'		=>	'post',
		'echo'		=>	1
	);
	
	$r = wp_parse_args($args,$defaults);
	
	global $ct_wp_kit_cn;
	$posts = $ct_wp_kit_cn->get_random_posts($r['number'], $r['showpass'], $r['type']);
	
	if(!$r['echo'])
	{
		return $posts;
	}
	
	$output = '';
	foreach ($posts as $post) {
		$post_title = stripslashes($post->post_title);
		$post_date = mysql2date('Y.m.j', $post->post_date);
		$permalink = get_permalink_replacer($post);
		$post_content = strip_tags($post->post_content); 
		$post_content = stripslashes($post_content); 
		$post_strip = $ct_wp_kit_cn->cut_str($post_content,$r['length']);
		$post_strip = str_replace('"', '', $post_strip);
		$post_strip = str_replace("\n", ' ', $post_strip);
		$output .= $r['before'] . '<a href="' . $permalink . '" rel="bookmark" title="';
		if($r['showexcerpt']) {
			$output .= $post_strip . '...  ';
		} else  {
			$output .= 'Permanent Link: ' . str_replace('"', '', $post_title) . '...   ';
		}
		$output .= $post_date . '">' . $post_title . '</a>';
		if(!$r['showexcerpt']) {
			$output .= ': ' . $post_strip . '...  ';
		}
		$output .= $r['after'] . "\n";
	}
	echo $output;	
}

### Most Active Commentors ###
function wkc_most_active_commentors($args=''){
	$defaults = array(
		'number'		=> 10,
		'threshhold'	=>	5, 
		'days'			=>	7, 
		'skipuser'		=>	'admin',
		'before'		=> '<li class="wkc_most_active">',
		'after'			=> '</li>',
		'echo'			=>	1
	);
	
	$r = wp_parse_args($args,$defaults);
	
	global $ct_wp_kit_cn;
	
	$comments = $ct_wp_kit_cn->get_most_active_commentors($r['threshhold'], $r['days'],$r['skipuser']);
	
	if(!$r['echo']){
		return $comments;
	}
	
	$no = 0;
	
	$output = '';
    foreach ($comments as $comment) {
    	$output .= $r['before'];
		$comment_author = htmlspecialchars(stripslashes($comment->comment_author));
		$comment_author_url =stripslashes($comment->comment_author_url);
		$comment_total = (int) $comment->comment_total;
			if ($comment_author_url) {
				$comment_author_link = "<a href='$comment_author_url' target='_blank'>$comment_author</a>";
			} else {
				$comment_author_link = "$comment_author";
			}
		$output .= $comment_author_link . " ($comment_total)  ";
		$output .= $r['after'] . "\n";
		$no++;

		// If Total Comments Is Below Threshold
		if(($comment_total <= $r['threshhold'] && $r['threshhold'] != -1) || ($r['number'] != -1 && $no >= $r['number'])) {
			break;
		}
    }
    
    echo $output;
}

### Recent Commentors ###
function wkc_recent_commentors($args=''){
	$defaults = array(
		'number'		=> 10,
		'threshhold'	=>	-1, 
		'type'			=>	'week',
		'skipuser'		=>	'admin',
		'before'		=>  '<li class="wkc_recent_commentors">',
		'after'			=>  '</li>',
		'echo'			=>	1
	);
	
	$r = wp_parse_args($args,$defaults);
	
	global $ct_wp_kit_cn;
	
	$comments = $ct_wp_kit_cn->get_recent_commentors($r['threshhold'],$r['type'],$r['skipuser']);
	
	if(!$r['echo'])
	{
		return $comments;
	}
	
	$no = 0;
	
	$output = '';
    foreach ($comments as $comment) {
    	$output .= $r['before'];
		$comment_author = htmlspecialchars(stripslashes($comment->comment_author));
		$comment_author_url =stripslashes($comment->comment_author_url);
		$comment_total = (int) $comment->comment_total;
			if ($comment_author_url) {
				$comment_author_link = "<a href='$comment_author_url' target='_blank'>$comment_author</a>";
			} else {
				$comment_author_link = "$comment_author";
			}
		$output .= $comment_author_link . " ($comment_total)  ";
		$output .= $r['after'] . "\n";
		$no++;

		// If Total Comments Is Below Threshold
		if(($r['threshhold'] != -1 && $comment_total <= $r['threshhold']) || ($r['number'] != -1 && $no >= $r['number'])) {
			break;
		}
    }
    echo $output;
}

### Posts in the Same Categories ###
function wkc_posts_in_the_same_categories($args = '') {
	$defaults = array(
		'postid'		=>		false,
		'orderby'		=>		'rand', //'date', 'comment_count'
		'order'			=>		'asc', //'desc'
		'before'		=>		'<li>',
		'after'			=>		'</li>',
		'number'		=>		5,
		'offset'		=>		0,
		'showcommentcount'	=>		1,
		'echo'			=>		1
	);
	
	$r = wp_parse_args($args,$defaults);
	
	global $ct_wp_kit_cn;
	$posts = $ct_wp_kit_cn->get_same_categories_posts($r['postid'], $r['number'], $r['offset'], $r['orderby'], $r['order']);

	if (!$r['echo'])
		return $posts;
	
	$output = '';
	foreach($posts as $post) {
		$postdate = mysql2date('Y.m.j', $post->post_date);
		$output .= $r['before'];
		$output .= '<a href="' . get_permalink_replacer($post) . '" title="' . $post->post_title .' '. $postdate . '">';
		$output .= $post->post_title;
		$output .= '</a>';
		if ($r['showcommentcount'])
			$output .= __('(','wpkitcn') . $post->comment_count . __(')','wpkitcn') ;
		$output .= $r['after'] . "\n";
	}
	
	echo $output;
}

### Related Posts ###
function wkc_related_posts($args = '') {
    $defaults = array(
        'postid' => false,
        'number' => 10,
        'before' => '<li>',
        'after' => '</li>',
        'showcommentcount' => 1,
        'emptylisttip' => 'Related Posts Not Found',
        'getrawdata' => 0,
        'echo' => 1
    );

    $r = wp_parse_args($args, $defaults);

    global $ct_wp_kit_cn;
    $posts = $ct_wp_kit_cn->get_related_posts($r['postid'], $r['number']);

    if ($r['getrawdata'])
        return $posts;

    $output = '';
    foreach ($posts as $post) {
        $postdate = mysql2date('Y.m.j', $post->post_date);
        $output .= $r['before'];
        $output .= '<a href="' . get_permalink_replacer($post) . '" title="' . $post->post_title . ' ' . $postdate . '">';
        $output .= $post->post_title;
        $output .= '</a>';
        if ($r['showcommentcount'])
            $output .= __('(', 'wpkitcn') . $post->comment_count . __(')', 'wpkitcn');
        $output .= $r['after'] . "\n";
    };

    if (empty($posts)) {
        $output .= '<li>' . $r['emptylisttip'] . '</li>';
    }
    

    if ($r['echo'])
        echo $output;
    else
        return $output;
}
