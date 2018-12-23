<?php

/*
  Plugin Name: WP Kit CN
  Plugin URI: http://sexywp.com/wp-kit-cn.htm
  Description: 侧边栏挂件集合，如最近评论，热评文章等等共6个挂件供选用，为主题开发者提供9个模版函数，接口简单稳定，此外增加了文章自动摘要，对中文兼容良好。从【中文WordPress工具箱】改进而来，在原有插件功能基础上，规范统一了模版函数接口，提供了侧边栏挂件。
  Version: 11.10.6
  Author: Charles Tang
  Author URI: http://sexywp.com/
 */

/*
  Copyright 2011  Charles Tang  (email : charlestang@foxmail.com)

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

require(dirname(__FILE__) . '/php/wp-kit-cn.class.php');
require(dirname(__FILE__) . '/php/WHtml.php');

global $ct_wp_kit_cn;

add_action('plugins_loaded', 'wkc_init');
function wkc_init() {
    global $ct_wp_kit_cn;

    $base_name = dirname(__FILE__) . '/php/';
    if (!isset($ct_wp_kit_cn)) {
        $ct_wp_kit_cn = new WPKitCN();
    }

    if (is_admin()) {
        require($base_name . 'wp-kit-cn.admin.php');
        $ct_wp_kit_cn_admin = new WPKitCNAdmin($ct_wp_kit_cn->default_options, $ct_wp_kit_cn->version);
        add_filter('plugin_action_links', 'wkc_pluginAction', -10, 2);
    }

    require($base_name . 'wp-kit-cn.tags.php');

    $options = $ct_wp_kit_cn->default_options;


    include_once($base_name . 'widget-most-commented-posts.php');
    //include_once($base_name . 'widget-recent-comments.php');
    include_once($base_name . 'WKC_Widget_Recent_Comments.class.php');
    include_once($base_name . 'widget-random-posts.php');
    include_once($base_name . 'widget-most-active-commentors.php');
    include_once($base_name . 'widget-recent-commentors.php');
    include_once($base_name . 'widget-advanced-blogroll.php');
    
    ### Function: Load The WKC Most Commented Posts Widget
    add_action('widgets_init', 'widget_wkc_most_commented_posts_init');
    ### Function: Load The WKC Advanced Blogroll Widget
    add_action('widgets_init', 'widget_wkc_advanced_blogroll_init');
    ### Function: Load The WKC Recent Comments Widget
    //add_action('widgets_init', 'widget_wkc_recent_comments_init');
    add_action( 'widgets_init', create_function( '', 'register_widget("WKC_Widget_Recent_Comments");' ) );
    ### Function: Load The WKC Most Active Commentors Widget
    add_action('widgets_init', 'widget_wkc_most_active_commentors_init');
    ### Function: Load The WKC Recent Commentors Widget
    add_action('widgets_init', 'widget_wkc_recent_commentors_init');
    ### Function: Load The WKC Random Posts Widget
    add_action('widgets_init', 'widget_wkc_random_posts_init');

    $wkc_rss_use_excerpt = get_option('rss_use_excerpt');
    if ($wkc_rss_use_excerpt) {
        add_filter('the_excerpt_rss', 'wkc_add_related_posts_to_feed', 600 + $ct_wp_kit_cn->options['display_order_of_related_posts_list']);
        add_filter('the_excerpt_rss', 'wkc_add_recent_comments_to_feed', 600 + $ct_wp_kit_cn->options['display_order_of_recent_comments_list']);
    } else {
        add_filter('the_content', 'wkc_add_related_posts_to_feed', 600 + $ct_wp_kit_cn->options['display_order_of_related_posts_list']);
        add_filter('the_content', 'wkc_add_recent_comments_to_feed', 600 + $ct_wp_kit_cn->options['display_order_of_recent_comments_list']);
    }
}


add_filter('ozh_adminmenu_icon_wkc_options', 'wp_kit_cn_icon');

function wp_kit_cn_icon($hook) {
    return WP_CONTENT_URL . '/plugins/wp-kit-cn/img/wkcicon.png';
}

/**
 * Adds an action link to the plugins page
 */
function wkc_pluginAction($links, $file) {
    static $this_plugin;

    if (!$this_plugin)
        $this_plugin = plugin_basename(__FILE__);

    if ($file == $this_plugin) {
        $settings_link = '<a href="options-general.php?page=wkc_options">' . __('Settings', 'wpkitcn') . '</a>';
        $links = array_merge(array($settings_link), $links); // before other links
    }
    return $links;
}

function wkc_add_related_posts_to_feed($content) {
    global $ct_wp_kit_cn;
    if (is_feed() && $ct_wp_kit_cn->options['add_related_posts_to_feed']) {
        $tips = $ct_wp_kit_cn->options['no_related_posts_tips'];
        return $content . '<h3>' . $ct_wp_kit_cn->options['related_posts_list_title'] . '</h3><ul>' . wkc_related_posts('echo=0&emptylisttip=' . $tips) . '</ul>';
    } else {
        return $content;
    }
}

function wkc_add_recent_comments_to_feed($content) {
    global $ct_wp_kit_cn;
    global $post;
    if (is_feed() && $ct_wp_kit_cn->options['add_recent_comments_to_feed']) {
        return $content . '<h3>' . $ct_wp_kit_cn->options['recent_comments_list_title'] . '</h3><ul>' . wkc_recent_comments('echo=0&skipuser=&postid=' . $post->ID) . '</ul>';
    } else {
        return $content;
    }
}
