<?php
function hermit_install()
{
	/**
	 * 插件数据库初始化
	 */
	global $wpdb, $hermit_table_name, $hermit_cat_name;

	if ($wpdb->get_var("show tables like '{$hermit_table_name}'") != $hermit_table_name) {
		$wpdb->query("CREATE TABLE {$hermit_table_name} (
				id          INT(10) NOT NULL AUTO_INCREMENT,
				song_name   VARCHAR(255) NOT NULL,
				song_author VARCHAR(255) NOT NULL,
				song_url    TEXT NOT NULL,
				song_cover  TEXT NOT NULL,
				created     DATETIME NOT NULL,
				UNIQUE KEY id (id)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");
	} else if (!$wpdb->query("show columns from `{$hermit_table_name}` like 'song_cover'")) {
		$wpdb->query("alter table `{$hermit_table_name}` add column `song_cover` text after `song_url`");

		if (!$wpdb->query("show columns from `{$hermit_table_name}` like 'song_cover'")) {
			printf("请前往数据库 wp_hermit 手动添加 song_cover 字段");
			die();
		}
	}

	if ($wpdb->get_var("show tables like '{$hermit_cat_name}'") != $hermit_cat_name) {
		$wpdb->query("CREATE TABLE {$hermit_cat_name} (
				id          INT(10) NOT NULL AUTO_INCREMENT,
				title   VARCHAR(125) NOT NULL,
				UNIQUE KEY id (id)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

		$wpdb->query("INSERT INTO `{$hermit_cat_name}` (`id`, `title`) VALUES (NULL, '未分类')");
		$wpdb->query("ALTER TABLE `{$hermit_table_name}` ADD `song_cat` INT(3) NOT NULL DEFAULT '1' AFTER `song_author`");
	}
}

function hermit_uninstall()
{
	global $wpdb, $hermit_table_name, $hermit_cat_name;

	$wpdb->query("DROP TABLE IF EXISTS {$hermit_table_name}");
	$wpdb->query("DROP TABLE IF EXISTS {$hermit_cat_name}");
}