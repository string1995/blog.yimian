<?php
/**
 * 主题functions功能文件，此文件用户后台管理功能，前端不会加载
 * 
 * @author Lomu
 * @since Default - WP Mobile X 1.0
 */

// 注册主题设置相关信息
add_filter('mobx_form_options', 'mobx_form_options_default', 10);
function mobx_form_options_default( $options ){
    $options[] = array(
        'title' => '主题设置',
        'icon' => 'home',
        'option' => array(
            array(
                'title' => '幻灯滑块',
                'desc' => '主题首页幻灯滑块设置',
                'type' => 'title'
            ),
            array(
                "type" => "repeat",
                "name" => "slider",
                "options" => array(
                    array(
                        "name" => 'slider_img',
                        "title" => '图片',
                        "desc" => '图片尺寸自己统一即可',
                        "std" => '',
                        "type" => 'upload'
                    ),
                    array(
                        "name" => 'slider_title',
                        "title" => '标题',
                        "desc" => '幻灯滑块的标题',
                        "std" => '',
                        "type" => 'text'
                    ),
                    array(
                        "name" => 'slider_url',
                        "title" => '链接',
                        "desc" => '图片链接',
                        "std" => '',
                        "type" => 'text'
                    )
                )
            ),
            array(
                'name' => 'color',
                'title' => '主题颜色',
                'desc' => '主题整体颜色设置',
                'std' => '',
                'type' => 'color'
            ),
            array(
                'name' => 'hover',
                'title' => '点击颜色',
                'desc' => '例如点击、悬停等状态下的颜色',
                'std' => '',
                'type' => 'color'
            )
        )
    );
    return $options;
}