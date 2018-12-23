<?php 
class WPKitCNAdmin {
	var $version = '';
	
	#options
	var $options;
	var $default_options;
	var $db_options = 'wp_kit_cn';
	
	#path
	var $admin_base_url;
	
	#message
	var $message = '';
	var $status = '';
	
	function WPKitCNAdmin($default_options = array(), $version = '')
	{
		// 1. load version number
		$this->version = $version;
		unset($version);
		
		// 2. Set class property for default options
		$this->default_options = $default_options;
		
		// 3. Get options from WP
		$options_from_table = get_option( $this->db_options );
		
		// 4. Update default options by getting not empty values from options table
		foreach( (array) $default_options as $default_options_name => $default_options_value ) {
			if ( !is_null($options_from_table[$default_options_name]) ) {
				if ( is_int($default_options_value) ) {
					$default_options[$default_options_name] = (int) $options_from_table[$default_options_name];
				} else {
					$default_options[$default_options_name] = $options_from_table[$default_options_name];
				}
			}
		}

		// 5. Set the class property and unset no used variable
		$this->options = $default_options;
		unset($default_options);
		unset($options_from_table);
		unset($default_options_value);
		
		$this->admin_base_url = get_option('siteurl') . '/wp-admin/admin.php?page=';
		
		// 6. Admin Capabilities
		add_action('init', array(&$this, 'initRoles'));
		
		// 7. Admin menu
		add_action('admin_menu', array(&$this, 'adminMenu'));
		add_action('admin_notices', array(&$this, 'displayMessage'));
	}
	
	function initRoles()
	{
		if ( function_exists('get_role') ) {
			$role = get_role('administrator');
			if( $role != null && !$role->has_cap('admin_wp_cn_kit') ) {
				$role->add_cap('admin_wp_cn_kit');
			}
			// Clean var
			unset($role);
		}
	}

	function adminMenu()
	{
		add_options_page( __('WP Kit CN: Options', 'wpkitcn'), __('WP Kit CN', 'wpkitcn'), 'admin_wp_cn_kit', 'wkc_options', array(&$this, 'pageOptions'));
	}
	
	function pageOptions()
	{
		// Update or reset options
		if ( isset($_POST['updateoptions']) ) {
			foreach((array) $this->options as $key => $value) {
				$newval = ( isset($_POST[$key]) ) ? stripslashes($_POST[$key]) : '0';
				if ( $newval != $value ) {
					$this->setOption( $key, $newval );
				}
			}
			$this->saveOptions();
			$this->message = __('Options saved', 'wpkitcn');
			$this->status = 'updated';
		}
		if ( isset($_POST['deletealloptions']) ) {
			wp_unregister_sidebar_widget('wkc_advanced_blogroll');
			wp_unregister_widget_control('wkc_advanced_blogroll');
			wp_unregister_sidebar_widget('wkc_most_active_commentors');
			wp_unregister_widget_control('wkc_most_active_commentors');
			wp_unregister_sidebar_widget('wkc_most_commented');
			wp_unregister_widget_control('wkc_most_commented');
			wp_unregister_sidebar_widget('wkc_random_posts');
			wp_unregister_widget_control('wkc_random_posts');
			wp_unregister_sidebar_widget('wkc_recent_commentors');
			wp_unregister_widget_control('wkc_recent_commentors');
			wp_unregister_sidebar_widget('wkc_recent_comments');
			wp_unregister_widget_control('wkc_recent_comments');
			delete_option($this->db_options);
			delete_option('widget_wkc_advanced_blogroll');
			delete_option('widget_wkc_most_active_commentors');
			delete_option('widget_wkc_most_commented_posts');
			delete_option('widget_wkc_random_posts');
			delete_option('widget_wkc_recent_commentors');
			delete_option('widget_wkc_recent_comments');
			deactivate_plugins('wp-kit-cn/wp-kit-cn.php');
			$this->message = __('Options of WP Kit CN have been removed, and the plugin has been deactivated.', 'wpkitcn');
		}
		$this->displayMessage();
		?>
        <style type="text/css">
        legend {display:none!important;}
        fieldset {border:0 none;margin:0;padding:0;}
        </style>
        <div class="wrap">
            <h2><?php _e('WP Kit CN Options', 'wpkitcn'); ?></h2>
            <p><?php _e('Visit the <a href="http://sexywp.com/wp-kit-cn.htm">plugin\'s homepage</a> for further details. If you find a bug, or have a fantastic idea for this plugin, <a href="mailto:charlestang@foxmail.com">ask me</a> !', 'wpkitcn'); ?></p>
            <form method="post" action="<?php echo $this->admin_base_url . 'wkc_options'; ?>">
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row"><?php _e('Auto Excerpt Settings', 'wpkitcn'); ?></th>
                            <td><fieldset>
                                    <legend><?php _e('Auto Excerpt Settings', 'wpkitcn'); ?></legend>
                                    <input type="hidden" name="enable_excerpt_algorithm" id="enable_excerpt_algorithm" value="0" />
                                    <p><label for="enable_excerpt_algorithm"><input type="checkbox" name="enable_excerpt_algorithm" id="enable_excerpt_algorithm" value="1" <?php echo $this->options['enable_excerpt_algorithm'] ? 'checked="checked"' : ''; ?> /><?php _e('Enable the Excerpt Algorithm', 'wpkitcn'); ?></label></p>
                                    <p><?php _e('The excerpt algorithm in this plugin will replace the original excerpt algorithm. This algorithm allows you customize how many paragraphs or how many words you want use to excerpt the post.', 'wpkitcn'); ?></p>
                                    <p><label for="excerpt_words_number">
                                            <?php _e('How many words?', 'wpkitcn'); ?>
                                        </label>
                                        <input type="text" name="excerpt_words_number" id="excerpt_words_number" value="<?php echo $this->options['excerpt_words_number']; ?>" size="5" />
                                        <?php _e('words.', 'wpkitcn'); ?>
                                    </p>
                                    <p><label for="excerpt_paragraphs_number">
                                            <?php _e('or How many paragraphs?', 'wpkitcn'); ?>
                                        </label>
                                        <input type="text" name="excerpt_paragraphs_number" id="excerpt_paragraphs_number" value="<?php echo $this->options['excerpt_paragraphs_number']; ?>" size="5" />
                                        <?php _e('paragraphs.', 'wpkitcn'); ?>
                                    </p>
                                </fieldset></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php _e('Feed Enhancement', 'wpkitcn'); ?></th>
                            <td>
                                <fieldset>
                                    <legend><?php _e('Related Posts Settings', 'wpkitcn'); ?></legend>
                                    <input type="hidden" name="add_related_posts_to_feed" id="add_related_posts_to_feed" value="0" />
                                    <p><label for="add_related_posts_to_feed">
                                            <input type="checkbox" name="add_related_posts_to_feed" id="add_related_posts_to_feed" value="1" <?php echo $this->options['add_related_posts_to_feed'] ? 'checked="checked"' : ''; ?> /><?php _e('Add related posts list to your feed.', 'wpkitcn'); ?>
                                        </label></p>
                                    <p><label for="related_posts_list_title">
                                            <?php _e('The title of related posts\' list', 'wpkitcn'); ?>
                                        </label>
                                        <input type="text" name="related_posts_list_title" id="related_posts_list_title" value="<?php echo $this->options['related_posts_list_title']; ?>">
                                    </p>
                                    <p><label for="no_related_posts_tips">
                                            <?php _e('No related post, then show: ', 'wpkitcn'); ?>
                                        </label>
                                        <input type="text" name="no_related_posts_tips" id="no_related_posts_tips" value="<?php echo $this->options['no_related_posts_tips']; ?>">
                                    </p>
                                    <p><label for="display_order_of_related_posts_list">
                                        <?php _e('The display order of related posts\' list', 'wpkitcn'); ?>
                                        </label>
                                        <input type="text" name="display_order_of_related_posts_list" id="display_order_of_related_posts_list" value="<?php echo $this->options['display_order_of_related_posts_list']; ?>" />
                                    </p>
                                </fieldset>
                                <fieldset>
                                    <legend><?php _e('Add Recent Comments to Feed', 'wpkitcn'); ?></legend>
                                    <input type="hidden" name="add_recent_comments_to_feed" id="add_recent_comments_to_feed" value="0" />
                                    <p><label for="add_recent_comments_to_feed"><input type="checkbox" name="add_recent_comments_to_feed" id="add_recent_comments_to_feed" value="1" <?php echo $this->options['add_recent_comments_to_feed'] ? 'checked="checked"' : ''; ?> /><?php _e('Add recent comments list to your feed.', 'wpkitcn'); ?></label></p>
                                    <p><label for="recent_comments_list_title"><?php _e('The title of recent comments\' list', 'wpkitcn'); ?></label><input type="text" name="recent_comments_list_title" id="recent_comments_list_title" value="<?php echo $this->options['recent_comments_list_title']; ?>"></p>
                                    <p><label for="display_order_of_recent_commets_list"><?php _e('The display order of recent comments\' list', 'wpkitcn'); ?></label><input type="text" name="display_order_of_recent_comments_list" id="display_order_of_recent_comments_list" value="<?php echo $this->options['display_order_of_recent_comments_list']; ?>" /></p>
                                </fieldset>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <input type="hidden" name="action" value="update" />			
                <p class="submit">
                    <input type="submit" name="updateoptions" value="<?php _e('Save Changes', 'wpkitcn') ?>" />
                </p>
                <h3><?php _e("Uninstall", 'wpkitcn') ?></h3>
                <p><?php _e("Click the button, the options of this plugin will be removed, include the widget.", 'wpkitcn') ?></p>
                <p class="submit">
                    <input type="submit" name="deletealloptions" value="<?php _e('Delete All Options', 'wpkitcn') ?>" />
                </p>
            </form>
            <?php $this->printAdminFooter(); ?>
        </div><!--/wrap-->
		<?php
	}
	
	
	############## WP Options ##############
	/**
	 * Update an option value  -- note that this will NOT save the options.
	 *
	 * @param string $optname
	 * @param string $optval
	 */
	function setOption($optname, $optval) {
		$this->options[$optname] = $optval;
	}

	/**
	 * Save all current options
	 *
	 */
	function saveOptions() {
		update_option($this->db_options, $this->options);
	}
	
	############## Admin WP Helper ##############
	/**
	 * Display plugin Copyright
	 *
	 */
	function printAdminFooter() {
		?>
		<p class="footer_st" style="font-size:0.8em;text-align:center;"><?php printf(__('&copy; Copyright 2008 <a href="http://www.charlestang.cn/" title="Here With Me">Charles Tang</a> | <a href="http://wordpress.org/extend/plugins/wp-kit-cn">WP Kit CN</a> | Version %s', 'wpkitcn'), $this->version); ?></p>
		<?php
	} 
	
	/**
	 * Display WP alert
	 *
	 */
	function displayMessage() {
		if ( $this->message != '') {
			$message = $this->message;
			$status = $this->status;
			$this->message = $this->status = ''; // Reset
		}

		if ( isset($message) ) {
		?>
			<div id="message" class="<?php echo ($status != '') ? $status :'updated'; ?> fade">
				<p><strong><?php echo $message; ?></strong></p>
			</div>
		<?php
		}
	}
}
?>