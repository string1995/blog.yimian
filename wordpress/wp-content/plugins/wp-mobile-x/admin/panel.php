<?php
class MOBILE_X_PANEL{

    function __construct(){
        $this->key = 'mobx_options';
        $this->options = get_option($this->key);
        $GLOBALS[$this->key] = $this->options;

        add_action('admin_menu', array($this, 'init'));
    }

    function init(){
        add_menu_page( __('Mobile Theme', 'wpcom'), __('Mobile Theme', 'wpcom'), 'edit_theme_options', 'wp-mobile-x', array( &$this, 'options'), 'dashicons-smartphone', '88');
        if (is_admin() && isset($_GET['page']) && ( $_GET['page'] == 'wp-mobile-x' ) ) {
            // Load CSS
            wp_enqueue_style( "panel", MobX_URL . "admin/css/panel.css", false, MobX_VERSION, "all");
            wp_enqueue_style( 'wp-color-picker' );

            // Load JS
            wp_enqueue_script("panel", MobX_URL . "admin/js/panel.min.js", array('jquery', 'jquery-ui-core', 'wp-color-picker'), MobX_VERSION, true);
            wp_enqueue_media();
        }
    }

    function options(){
        require_once MobX_DIR . 'admin/utils.php';
        
        $this->settings = $this->form_options();

        $this->form_action();
        $pages = MobX_Utils::get_all_pages();
        ?>
        <div class="wrap wpcom-wrap">
            <div class="wpcom-panel-head">
                <div class="wpcom-panel-copy">V<?php echo MobX_VERSION;?></div>
                <h1><?php _e('Mobile Theme', 'wpcom');?><small>WP Mobile X</small></h1>
            </div>
            <?php echo $this->build_form();?>
        </div>
    <?php }

    private function build_form(){
        $active = 0;
        if(isset($_COOKIE['mobx_panel_nav']) && $_COOKIE['mobx_panel_nav'])
            $active = $_COOKIE['mobx_panel_nav'];
        ?>
        <div class="wpcom-panel-form" id="j-panel-form">
            <ul class="wpcom-panel-nav">
                <?php foreach ($this->settings as $i => $item) { if($item){ ?>
                    <li<?php echo $i==$active?' class="active"':''?>><?php if(isset($item['icon'])){?><i class="fa fa-<?php echo $item['icon']?>"></i> <?php } ?><?php echo $item['title'];?></li>
                <?php }} ?>
                <?php foreach ($this->settings as $i => $item) { if($item===false){ ?>
                    <li<?php echo $i==$active?' class="theme-active active"':' class="theme-active"'?>><i class="fa fa-key"></i> 主题激活</li>
                <?php } } ?>
                <li<?php echo ($i+1)==$active?' class="more-themes active"':' class="more-themes"'?>><i class="fa fa-magic"></i> <?php _e('More Themes', 'wpcom');?></li>
            </ul>
            <div class="wpcom-panel-content">
                <form action="" method="post" id="wpcom-panel-form">
                    <?php foreach ($this->settings as $i => $item) { if($item){ ?>
                    <div class="wpcom-panel-item<?php echo $i==$active?' active':''?>">
                        <?php if(isset($item['option'])) { $x=0; foreach ($item['option'] as $input) {
                            $this->option_item($input, $x);
                            $x++;
                        }} ?>
                    </div>
                    <?php }}?>
                    <div class="wpcom-panel-submit" style="display: none;">
                        <?php wp_nonce_field( $this->key . '_options', $this->key . '_nonce', true );?>
                        <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes', 'wpcom');?>">
                    </div>
                </form>
                <?php foreach ($this->settings as $i => $item) { if($item===false){
                    $this->active_form($i);
                } } ?>
                <div class="wpcom-panel-item more-theme-wrap<?php echo $i+1==$active?' active':''?>"></div>
            </div>
        </div>
        <?php
    }

    private function active_form($index){
        $res = apply_filters('mobx_active_form', array());
        if(isset($_POST['email'])){
            $email = trim($_POST['email']);
            $token = trim($_POST['token']);
        }
        $cur = 0;
        if(isset($_COOKIE['mobx_panel_nav']) && $_COOKIE['mobx_panel_nav'])
            $cur = $_COOKIE['mobx_panel_nav'];
        ?>
        <form class="form-horizontal active-form wpcom-panel-item<?php echo $index==$cur?' active':''?>" id="wpcom-active-form" method="post" action="">
            <h2 class="active-title">主题激活</h2>
            <div id="wpcom-panel-main" class="clearfix">
                <div class="form-horizontal">
                    <?php if (isset($res['active'])) { ?><p class="col-xs-offset-3 col-xs-9" style="<?php echo ($res['active']->result==0||$res['active']->result==1?'color:green;':'color:#F33A3A;');?>"><?php echo $res['active']->msg; ?></p><?php } ?>
                    <div class="form-group">
                        <label for="email" class="col-xs-3 control-label">登录邮箱</label>
                        <div class="col-xs-9">
                            <input type="email" name="email" class="form-control" id="email" value="<?php echo isset($email)?$email:''; ?>" placeholder="请输入WPCOM登录邮箱">
                            <?php if(isset($res['err_email'])){ ?><div class="j-msg" style="color:#F33A3A;font-size:12px;margin-top:3px;margin-left:3px;"><?php echo $res['err_email'];?></div><?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="token" class="col-xs-3 control-label">激活码</label>
                        <div class="col-xs-9">
                            <input type="password" name="token" class="form-control" id="token" value="<?php echo isset($token)?$token:'';?>" placeholder="请输入激活码" autocomplete="off">
                            <?php if(isset($res['err_token'])){ ?><div class="j-msg" style="color:#F33A3A;font-size:12px;margin-top:3px;margin-left:3px;"><?php echo $res['err_token'];?></div><?php } ?>
                        </div>
                        <div class="col-xs-9">
                            <p style="margin: 10px 0;color:#666;">激活相关问题可以参考<a href="https://www.wpcom.cn/docs/themer/auth.html" target="_blank">主题激活教程</a>
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label"></label>
                        <div class="col-xs-9">
                            <input type="submit" class="button button-primary button-active" value="提 交">
                        </div>
                    </div>
                </div>
            </div><!--#wpcom-panel-main-->
        </form>
    <?php }

    private function option_item($option, $i, $repeat='-1'){
        $type = $option['type'];
        $title = isset($option['title'])?$option['title']:'';
        $desc = isset($option['desc'])?$option['desc']:'';
        $name = isset($option['name'])?$option['name']:'';
        $id = isset($option['id'])?$option['id']:$name;
        $rows = isset($option['rows'])?$option['rows']:3;
        $value = isset($option['std'])?$option['std']:'';
        $notice = $desc?'<small class="input-notice">'.$desc.'</small>':'';
        $tax = isset($option['tax'])?$option['tax']:'category';

        if($repeat>-1){
            $value = isset($this->options[$option['oname']]) && isset($this->options[$option['oname']][$repeat]) ? $this->options[$option['oname']][$repeat] : $value;
        }else{
            $value = isset($this->options[$name]) ? $this->options[$name] : $value;
        }

        switch ($type) {
            case 'title':
                $first = $i==0?' section-hd-first':'';
                echo '<div class="section-hd'.$first.'"><h3 class="section-title">'.$title.' <small>'.$desc.'</small></h3></div>';
                break;

            case 'text':
                echo '<div class="form-group clearfix"><label for="wpcom_'.$id.'" class="form-label">'.$title.'</label><div class="form-input"><input type="text" class="form-control" id="wpcom_'.$id.'" name="'.$name.'" value="'.esc_attr($value).'">'.$notice.'</div></div>';
                break;

            case 'radio':
                $html = '';
                foreach ($option['options'] as $opk=>$opv) {
                    $html.=$opk==$value?'<label class="radio-inline"><input type="radio" name="'.$name.'" checked value="'.$opk.'">'.$opv.'</label>':'<label class="radio-inline"><input type="radio" name="'.$name.'" value="'.$opk.'">'.$opv.'</label>';
                }
                echo '<div class="form-group clearfix"><label for="wpcom_'.$id.'" class="form-label">'.$title.'</label><div class="form-input">'.$html . $notice.'</div></div>';
                break;

            case 'checkbox':
                $html = '';
                foreach ($option['options'] as $opk=>$opv) {
                    $checked = '';
                    if(is_array($value)){
                        foreach($value as $v){
                            if($opk==$v) $checked = ' checked';
                        }
                    }else{
                        if($opk==$value) $checked = ' checked';
                    }
                    $html .= '<label class="checkbox-inline"><input type="checkbox" name="'.$name.'[]"'.$checked.' value="'.$opk.'">'.$opv.'</label>';
                }
                echo '<div class="form-group clearfix"><label for="wpcom_'.$id.'" class="form-label">'.$title.'</label><div class="form-input">'.$html . $notice.'</div></div>';
                break;

            case 'info':
                echo '<div class="form-group clearfix"><label class="form-label">'.$title.'</label><div class="form-input" style="padding-top:7px;">'.$value . $notice.'</div></div>';
                break;

            case 'select':
                $html = '';
                foreach ($option['options'] as $opk=>$opv) {
                    $html.=$opk==$value?'<option selected value="'.$opk.'">'.$opv.'</option>':'<option value="'.$opk.'">'.$opv.'</option>';
                }
                echo '<div class="form-group clearfix"><label for="wpcom_'.$id.'" class="form-label">'.$title.'</label><div class="form-input"><select class="form-control" id="wpcom_'.$id.'" name="'.$name.'">'.$html.'</select>'.$notice.'</div></div>';
                break;

            case 'textarea':
                echo '<div class="form-group clearfix"><label for="wpcom_'.$id.'" class="form-label">'.$title.'</label><div class="form-input"><textarea class="form-control" rows="'.$rows.'" id="wpcom_'.$id.'" name="'.$name.'">'.esc_html($value).'</textarea>'.$notice.'</div></div>';
                break;

            case 'editor':
                echo '<div class="form-group clearfix"><label for="wpcom_'.$id.'" class="form-label">'.$title.'</label><div class="form-input">';
                wp_editor( wpautop( $value ), 'wpcom_'.$id, MobX_Utils::editor_settings(array('textarea_name'=>$name, 'textarea_rows'=>$rows)) );
                echo $notice.'</div></div>';
                break;

            case 'upload':
                echo '<div class="form-group clearfix"><label for="wpcom_'.$id.'" class="form-label">'.$title.'</label><div class="form-input"><input type="text" class="form-control" id="wpcom_'.$id.'" name="'.$name.'" value="'.esc_attr($value).'">'.$notice.'</div><div class="form-input-btn"><button id="wpcom_'.$id.'_upload" type="button" class="button upload-btn"><i class="fa fa-image"></i> 上传</button></div></div>';
                break;

            case 'color':
                echo '<div class="form-group clearfix"><label for="wpcom_'.$id.'" class="form-label">'.$title.'</label><div class="form-input"><input class="color-picker" type="text"  name="'.$name.'" value="'.esc_attr($value).'">'.$notice.'</div></div>';
                break;

            case 'page':
                $html = '<option value="">--请选择--</option>';
                $pages = MobX_Utils::get_all_pages();
                foreach ($pages as $page) {
                    $html.=$page['ID']==$value?'<option selected value="'.$page['ID'].'">'.$page['title'].'</option>':'<option value="'.$page['ID'].'">'.$page['title'].'</option>';
                }
                echo '<div class="form-group clearfix"><label for="wpcom_'.$id.'" class="form-label">'.$title.'</label><div class="form-input"><select class="form-control" id="wpcom_'.$id.'" name="'.$name.'">'.$html.'</select>'.$notice.'</div></div>';
                break;


            case 'cat_single':
                $html = '<option value="">--请选择--</option>';
                $items = MobX_Utils::category($tax);
                foreach ($items as $key => $val) {
                    $html.=$key==$value?'<option selected value="'.$key.'">'.$val.'</option>':'<option value="'.$key.'">'.$val.'</option>';
                }
                echo '<div class="form-group clearfix"><label for="wpcom_'.$id.'" class="form-label">'.$title.'</label><div class="form-input"><select class="form-control" id="wpcom_'.$id.'" name="'.$name.'">'.$html.'</select>'.$notice.'</div></div>';
                break;

            case 'cat_multi':
                $html = '';
                $items = MobX_Utils::category($tax);
                foreach ($items as $key => $val) {
                    $checked = '';
                    if(is_array($value)){
                        foreach($value as $v){
                            if($key==$v) $checked = ' checked';
                        }
                    }else{
                        if($key==$value) $checked = ' checked';
                    }
                    $html.='<label class="checkbox-inline"><input name="'.$name.'[]"'.$checked.' type="checkbox" value="'.$key.'"> '.$val.'</label>';
                }
                echo '<div class="form-group clearfix"><label for="wpcom_'.$id.'" class="form-label">'.$title.'</label><div class="form-input cat-checkbox-list" data-name="'.$name.'">'.$html.$notice.'</div></div>';
                break;
            case 'cat_multi_sort':
                $html = '';
                $items = MobX_Utils::category($tax);
                $value = $value ? $value : array();
                foreach ($value as $item) {
                    $category = get_term( $item, $tax );
                    $html.='<label class="checkbox-inline"><input name="'.$name.'[]" checked type="checkbox" value="'.$item.'"> '.$category->name.'</label>';
                }
                foreach ($items as $key => $val) {
                    if(!in_array($key, $value)){
                        $html.='<label class="checkbox-inline"><input name="'.$name.'[]" type="checkbox" value="'.$key.'"> '.$val.'</label>';
                    }
                }
                echo '<div class="form-group clearfix"><label for="wpcom_'.$id.'" class="form-label">'.$title.'</label><div class="form-input"><div class="cat-checkbox-list j-cat-sort" data-name="'.$name.'">'.$html.'</div><div>'.$notice.'</div></div></div>';
                break;
            case 'toggle':
                echo '<div class="form-group clearfix"><label for="wpcom_'.$id.'" class="form-label">'.$title.'</label><div class="form-input toggle-wrap">';
                if($value=='1'){
                    echo '<div class="toggle active"></div>';
                }else{
                    echo '<div class="toggle"></div>';
                }
                echo '<input type="hidden" id="wpcom_'.$id.'" name="'.$name.'" value="'.esc_attr($value).'">'.$notice.'</div></div>';
                break;
            case 'repeat':
                /*
                 * $this->options 保存的数据
                 * $this->options[$option->options[0]->name] 重复数据的第一个属性保持的值
                 * 每个属性根据添加个数会有多个，以数组形式保存
                 */
                $len = count(isset($this->options[$option['options'][0]['name']])?$this->options[$option['options'][0]['name']]:array());
                $len = $len ? $len : 1;
                $index = array();
                if(isset($this->options[$option['options'][0]['name']])){
                    foreach ($this->options[$option['options'][0]['name']] as $a=>$b) {
                        $index[] = $a;
                    }
                }
                echo '<div class="wpcom-panel-repeat">';
                for($i=0; $i<$len; $i++) {
                    $j = isset($index[$i]) ? $index[$i] : $i;
                    echo '<div class="repeat-wrap" data-id="'.$i.'">';
                    $x = 0;
                    $arg = array();
                    foreach ($option['options'] as $o) {
                        foreach($o as $k=>$v){
                            $arg[$k] = $v;
                        }
                        $arg['id'] = $o['name'] . '_' . $i;
                        $arg['name'] = $o['name'] . '['.$i.']';
                        $arg['oname'] = $o['name'];
                        $this->option_item($arg, 1, $j);
                        $x++;
                    }
                    echo $i==0? '</div>':'<div class="repeat-action"><div class="repeat-item repeat-up j-repeat-up"><i class="dashicons dashicons-arrow-up-alt"></i></div><div class="repeat-item repeat-down j-repeat-down"><i class="dashicons dashicons-arrow-down-alt"></i></div><div class="repeat-item repeat-del j-repeat-del"><i class="dashicons dashicons-no-alt"></i></div></div></div>';
                }
                echo '<div class="repeat-btn-wrap"><button type="button" class="button j-repeat-add" id="wpcom_'.$name.'"><i class="dashicons dashicons-plus"></i> 添加选项</button></div></div>';
                break;
            case 'version':
                echo '<div class="form-group clearfix"><label class="form-label">'.$title.'</label><div class="form-input" style="padding-top:5px;">'.MX_THEME_VERSION.' <a class="check-version" id="j-check-version" href="javascript:;">检查更新</a>'.$notice.'</div></div>';
                break;
            default:
                break;
        }
    }

    private function form_options(){
        $options = array();
        $options = apply_filters('mobx_form_options', $options);

        return $options;
    }

    function form_action(){
        $nonce = isset($_POST[$this->key . '_nonce']) ? $_POST[$this->key . '_nonce'] : '';

        // Check nonce
        if ( ! $nonce || ! wp_verify_nonce( $nonce, $this->key . '_options' ) ){
            return;
        }

        $data = $_POST;
        $options = array();

        if( isset($data) && $data && isset($data['theme'])) {

            unset($data[$this->key . '_nonce']);
            unset($data['_wp_http_referer']);

            foreach($data as $key => $value){
                $options[$key] = $value && is_string($value) ? stripcslashes($value) : $value;
            }
        }

        do_action('mobx_panel_form');

        $theme = $this->options['theme'];
        update_option($this->key, $options);
        $this->options = $options;

        if( $theme != $options['theme'] ) {
            echo '<meta http-equiv="refresh" content="0">';
            exit;
        }
    }

}


new MOBILE_X_PANEL();