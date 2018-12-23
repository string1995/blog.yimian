<?php
defined( 'ABSPATH' ) || exit;

class MOBILE_X {
    function __construct() {
        register_theme_directory( MobX_DIR . 'themes' );
        add_action( 'plugins_loaded', array(&$this, 'init') );
        add_filter( 'get_post_metadata', array( $this, 'meta_filter' ), 20, 4 );
        add_filter( 'add_post_metadata', array( $this, 'add_metadata' ), 20, 4 );
        add_filter( 'update_post_metadata', array( $this, 'add_metadata' ), 20, 4 );
        add_filter( 'get_term_metadata', array( $this, 'meta_filter' ), 20, 4 );
    }

    function init() {
        // 语言包支持
        load_plugin_textdomain( 'wpcom', false, basename( MobX_DIR ) . '/lang' ); 

        $mobile_theme = $this->init_theme();
        $theme = wp_get_theme( $mobile_theme );
        $parent_theme = $theme && $theme->get('Template') ? $theme->template : '';

        if( is_admin() ) {
            require_once MobX_DIR . 'includes/functions-admin.php';
            if( $parent_theme && file_exists( $parent_file = get_theme_root( $parent_theme ) . '/' . $mobile_theme . '/functions-admin.php' ) )
                require_once $parent_file;

            if( $mobile_theme && file_exists( $theme_file = get_theme_root( $mobile_theme ) . '/' . $mobile_theme . '/functions-admin.php' ) )
                require_once $theme_file;
        }else{
            if( $parent_theme && file_exists( $parent_file = get_theme_root( $parent_theme ) . '/' . $mobile_theme . '/functions-common.php' ) )
                require_once $parent_file;

            if( $mobile_theme && file_exists( $theme_file = get_theme_root( $mobile_theme ) . '/' . $mobile_theme . '/functions-common.php' ) )
                require_once $theme_file;
        }

        if( !wp_is_mobile() || !$mobile_theme ) return; // 移动端主题，只在移动端启用；并且需要启用了手机主题

        add_action( 'setup_theme', array( &$this, 'setup_theme' ), 20 );
        add_filter( 'stylesheet', array( &$this, 'stylesheet' ), 20 );
        add_filter( 'template', array( &$this, 'template' ), 20 );
    }

    function init_theme(){
        global $mobx_options, $mobile_theme;
        if(isset($mobx_options['theme']) && $mobx_options['theme']){
            $mobile_theme = $mobx_options['theme'];
        }
        return $mobile_theme;
    }

    function setup_theme(){
        global $mobile_theme;
        if($mobile_theme) require_once MobX_DIR . 'includes/functions-theme.php';
    }

    function stylesheet( $stylesheet='' ){
        global $mobile_theme;
        if($mobile_theme) $stylesheet = $mobile_theme;
        return $stylesheet;
    }

    function template( $template='' ){
        global $mobile_theme;
        if($mobile_theme){
            $theme = wp_get_theme( $mobile_theme );
            $template = $theme && $theme->get('Template') ? $theme->template : $mobile_theme;
        }
        return $template;
    }

    function meta_filter( $res, $object_id, $meta_key, $single){
        if( !class_exists('WPCOM_Meta') ) {
            $key = preg_replace('/^wpcom_/i', '', $meta_key);
            if ( $key !== $meta_key ) {
                $filter = current_filter();
                if( $filter=='get_post_metadata' ){
                    $metas = get_post_meta( $object_id, '_wpcom_metas', true);
                }else if( $filter=='get_term_metadata' ){
                    $metas = get_term_meta( $object_id, '_wpcom_metas', true);
                    //向下兼容
                    if( $metas=='' ) {
                        $term = get_term($object_id);
                        if( $term && isset($term->term_id) ) $metas = get_option('_'.$term->taxonomy.'_'.$object_id);
                        if( $metas!='' ){
                            update_term_meta( $object_id, '_wpcom_metas', $metas );
                        }
                    }
                }

                if( isset($metas) && isset($metas[$key]) ) {
                    if( $single && is_array($metas[$key]) )
                        return array( $metas[$key] );
                    else if( !$single && empty($metas[$key]) )
                        return array();
                    else
                        return array($metas[$key]);
                }
            }
        }
        return $res;
    }

    function add_metadata(  $check, $object_id, $meta_key, $meta_value ){
        if( !class_exists('WPCOM_Meta') ) {
            $key = preg_replace('/^wpcom_/i', '', $meta_key);
            if ( $key !== $meta_key ) {
                global $wpdb;
                $filter = current_filter();
                $table = _get_meta_table( 'post' );
                $column = sanitize_key('post_id');
                $pre_key = '_wpcom_metas';
                $metas = get_post_meta( $object_id, $pre_key, true);
                $meta_type = 'post';

                $pre_value = '';
                if( $metas ) {
                    if( isset($metas[$key]) ) $pre_value = $metas[$key];
                    $metas[$key] = $meta_value;
                } else {
                    $metas = array(
                        $key => $meta_value
                    );
                }

                if( $wpdb->get_var( $wpdb->prepare(
                    "SELECT COUNT(*) FROM $table WHERE meta_key = %s AND $column = %d",
                    $pre_key, $object_id ) ) ){
                    $where = array( $column => $object_id, 'meta_key' => $pre_key );
                    $result = $wpdb->update( $table, array('meta_value'=>maybe_serialize($metas)), $where );
                }else{
                    $result = $wpdb->insert( $table, array(
                        $column => $object_id,
                        'meta_key' => $pre_key,
                        'meta_value' => maybe_serialize($metas)
                    ) );
                }

                if($result) {
                    wp_cache_delete($object_id, $meta_type . '_meta');
                    return true;
                }
            }
        }
        return $check;
    }
}

new MOBILE_X();