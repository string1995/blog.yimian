<?php

/**
 * Recent Comments Widget
 * @author Charles <charlestang@foxmail.com>
 * @version 1.0
 */
class WKC_Widget_Recent_Comments extends WP_Widget {

    function __construct() {
        $widget_ops = array(
            'classname' => 'widget_wkc_recent_comments',
            'description' => __('This widget will list recently comments.', 'wpkitcn'),
        );
        parent::__construct('wkc_recent_comments', __('WKC Recent Comments', 'wpkitcn'), $widget_ops);
    }

    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);

        if (function_exists('wkc_recent_comments')) {
            echo $before_widget;
            if ($title) {
                echo $before_title . $title . $after_title;
            }
            echo '<ul>', "\n";
            $param = '';
            $param .= 'number=' . $instance['number'];
            $param .= '&before=' . $instance['before'];
            $param .= '&after=' . $instance['after'];
            $param .= '&showpass=' . $instance['show_pass'];
            $param .= '&length=' . $instance['sublen'];
            $param .= '&skipuser=' . $instance['skipuser'];
            $param .= '&avatarsize=' . ($instance['avatarsize'] == '' ? 16 : $instance['avatarsize']);
            if ($instance['xformat'] == '') {
                $instance['xformat'] = '<a class="commentor" href="%comment_author_url%" >%comment_author%</a> : <a class="comment_content" href="%permalink%" title="View the entire comment by %comment_author%" >%comment_excerpt%</a>';
            }
            $param .= '&xformat=' . $instance['xformat'];
            wkc_recent_comments($param);
            echo '</ul>', "\n", $after_widget;
        }
    }

    function form($instance) {
        if (empty($instance)) {
            $instance = array(
                'title' => __('Recent Comments', 'wpkitcn'),
                'number' => 10, 'before' => '<li>',
                'after' => '</li>',
                'show_pass' => false,
                'sublen' => 50,
                'skipuser' => 'admin',
                'xformat' => '<a class="commentor" href="%comment_author_url%" >%comment_author%</a> : <a class="comment_content" href="%permalink%" title="View the entire comment by %comment_author%" >%comment_excerpt%</a>',
                'avatarsize' => 16
            );
        }
        //<editor-fold defaultstate="collapsed" desc="widget html controls">
        ?>
        <p>
            <?php echo WHtml::widgetTextField($this, 'title', $instance, array(), __('Title: ', 'wpkitcn')); ?>
        </p>
        <p>
            <?php echo WHtml::widgetTextField($this, 'number', $instance, array(), __('Number of Comments: ', 'wpkitcn')); ?>
        </p>
        <p>
            <?php echo WHtml::widgetTextField($this, 'before', $instance, array(), __('Before a Record: ', 'wpkitcn')); ?>
        </p>
        <p>
            <?php echo WHtml::widgetTextField($this, 'after', $instance, array(), __('After a Record: ', 'wpkitcn')); ?>
        </p>
        <p>
            <?php echo WHtml::widgetCheckBox($this, 'show_pass', $instance, array(), __('Show Comments of Password-Protected Posts: ', 'wpkitcn')); ?>
        </p>
        <p>
            <?php echo WHtml::widgetTextField($this, 'sublen', $instance, array(), __('Comments Content Length: ', 'wpkitcn')); ?>
        </p>
        <p>
            <?php echo WHtml::widgetTextField($this, 'skipuser', $instance, array(), __('Exclude the user: ', 'wpkitcn')); ?>
        </p>
        <p>
            <?php echo WHtml::widgetTextField($this, 'avatarsize', $instance, array(), __('Gravatar size: ', 'wpkitcn')); ?>
        </p>
        <p>
            <?php echo WHtml::widgetTextArea($this, 'xformat', $instance, array('rows'=>5), __('The custom format of the link: ', 'wpkitcn')); ?>
            %comment_count%<br/>
            %comment_author_url%<br/>
            %comment_author%<br/>
            %gravatar%<br/>
            %post_title%<br/>
            %permalink%<br/>
            %comment_excerpt%
        </p>

        <?php
        //</editor-fold>
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = intval($new_instance['number']);
        $instance['before'] = $new_instance['before'];
        $instance['after'] = $new_instance['after'];
        $instance['show_pass'] = isset($new_instance['show_pass']) ? $new_instance['show_pass'] : 0;
        $instance['sublen'] = intval($new_instance['sublen']);
        $instance['skipuser'] = $new_instance['skipuser'];
        $instance['avatarsize'] = intval($new_instance['avatarsize']);
        $instance['xformat'] = stripslashes($new_instance['xformat']);
        return $instance;
    }

}
