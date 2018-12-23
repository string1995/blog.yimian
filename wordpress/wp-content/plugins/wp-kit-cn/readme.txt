=== WP Kit CN ===
Contributors: Charles
Donate link: http://sexywp.com/
Tags: widget, sidebar, excerpt, comments, template tags
Requires at least: 3.2.1
Tested up to: 3.2.1
Stable tag: 11.10.6

This plugin extends wordpress by a series of template tags and sidebar widgets.

== Upgrade Notice ==

= 11.10.6 =
Update immediately. The 11.10.5 release contains a malicious backdoor. - The WordPress team.
 
最新版的WP Kit CN没有重大更新，追求稳定的童鞋请勿更新，谢谢合作！
There is no big change, please don't update if you don't want try beta version.

== Description ==

This plugin extends wordpress by a series of template tags and a few sidebar widgets.

此插件通过一系列模板标签和侧边栏Widget扩展了WordPress的功能。这些扩展都加强了多中文的支持。

插件页面关闭评论以后在论坛提供技术支持，论坛网址 http://sexywp.com/forum/

= Documentation =

See the detail in http://sexywp.com/wp-kit-cn-doc

The English version is available at http://sexywp.com/wp-kit-cn-doc-en

= Extended Tags: =

* `wkc_recent_comments()` this tag will display a list of latest comments
* `wkc_recent_pings()` this tag will display a list of recent pingbacks or trackbacks
* `wkc_recent_posts()` this tag will display a list of recent posts' name
* `wkc_most_commented_posts()` this tag will display a list of posts which have most comments
* `wkc_random_posts()` this tag will display a list of posts of random order
* `wkc_most_active_commentors()` this tag will display a list of commentors who leave most replies in a few days, i.e. 15 days
* `wkc_recent_commentors()` this tag will display a list of commentors who leave most replies in this week or month
* `wkc_related_posts()` this tag output related posts
* `wkc_posts_in_the_same_categories()` this tag output posts in the same category

= 扩展的标签： =

* `wkc_recent_comments()` 显示最新评论的标签
* `wkc_recent_pings()` 显示最新回响的标签，包括pingback和trackback
* `wkc_recent_posts()` 显示最新文章的标签
* `wkc_most_commented_posts()` 显示评论最多的文章的标签
* `wkc_random_posts()` 显示随机文章的标签
* `wkc_most_active_commentors()` 显示n天内，评论最多的用户的标签
* `wkc_recent_commentors()` 显示本周或者本月内评论最多的用户的标签
* `wkc_related_posts()` 显示相关文章
* `wkc_posts_in_the_same_categories()` 输出同一个分类下的文章

= Sidebar Widgets: =

* Most Active Commentors Widget
* Most Commented Posts Widget
* Random Posts Widget
* Recent Commentors Widget
* Recent Comments Widget
* Advanced Blogroll Widget

= 侧边栏Widget： =

* 最近n天评论最多用户Widget
* 评论最多的文章Widget
* 随机文章Widget
* 本周或本月评论之星Widget
* 最新评论Widget
* 高级友情链接Widget

== Installation ==
= Installation Instruction =

1. Upload `wp-kit-cn` folder to the `/wp-content/plugins/` directory
1. Activate the plugin `WP Kit CN` through the 'Plugins' menu in WordPress
1. Setup the plugin under administation panel `options/WP Kit CN` (check option configurations section below).

= 安装步骤 =

1. 将 `wp-kit-cn` 文件夹上传到 `/wp-content/plugins/` 目录
1. 在 '插件' 菜单中启用插件 `WP Kit CN` 
1. 在面板 `设置/WP Kit CN` 设定相关选项（详见选项设置小节）

= Options Configuration =

You can deside display the widgets in the available widgets list or not.

The other thing you can customize is the excerpt algorithm. For example, a post will be automaticly excerpted to 4 paragraphs and at most 400 words.

= 选项设置 =

您可以在后台通过设置来决定启用的Widget。

您可以选择是否启用插件中带有的摘要算法。

您还可以在后台设定自动摘要算法的参数，例如，文章摘要不超过3段，且不超过400字。

== Frequently Asked Questions ==

= 为什么我看不到高级友链Widget =
对于这个问题，我相当无奈，目前没有发现好的解决办法。根据一些用户的经验，在全新的WP上安装此插件是没有问题的，但是从低版本升级上来，这个最新的Widget可能会看不到。原因，我正在紧张地调查当中。

= 升级了你的插件，出现了Fatal Error? =
目前为止，已经出现了几例类似的事故，错误提示中说，是高级友链Widget内部发生了函数重复定义问题。而我本人在WP2.5和WP2.6下调试，并未碰到此问题，所以，我根据猜测调整了插件的代码结构，请您升级到最新版本，如果仍然不奏效，我只能很遗憾地请您使用ftp在插件目录删除此插件，此步操作是安全的。

== Screenshots ==

1. This screenshot is the effect of the sidebar widgets cotained in this plugin. 如图为侧边栏Widget在Default模板的使用效果。
2. This screenshot is the effect of the admin page. 如图为后台管理页面。
3. This screenshot is the effect of the sidebar widget control panel. 侧栏Widget管理面板的效果图。


== Changelog == 

2011年10月3日 22:51:00

 * 最近评论Widget有bug，导致HTML标签不配对，修复

2011年10月3日 20:09:00
 
 * 最新评论Widget用新的Widget API重写
 * 在Feed中添加相关文章列表功能 experimental
 * 在Feed中添加最新评论列表功能 experimental
 * 消除了一些后台Notice错误
 * 修复了插件在ozh admin menu下的菜单图标显示

2008年12月19日20:48:40

1. 在Feed中输出相关文章功能
2. 在Feed中输出最近评论功能
3. 更换了边栏挂件的hook方式，希望解决升级后不能自动启用问题
4. 改进了相关文章算法，正式公开
5. 输出同一分类下的文章的函数
6. 插件作者更换了域名，希望各位即时更新

2008年10月29日19:45:58

1. 评论最多文章的bug已经消除。
2. 给最近评论增加了屏蔽多个用户的功能。
3. 给随机文章标签增加了选择类型的功能，区分“日志”和“页面”。

2008年10月23日13:35:39

1. 输出最近评论者功能不能区分年份，已解决。
2. 在没有mb_strlen函数的系统中出现调用错误，已解决。

2008年9月19日19:12:48

1. 更改了构造函数的写法，兼容了PHP 4.0
2. 添加了输出某个分类下的文章的模板标签
3. 添加了输出相关文章的模板标签
4. 给有能力的用户提供了一个可以替换默认get_permalink函数的接口
5. 修正了文章字数很短的时候，仍旧会出现Read More的bug

2008年9月1日18:16:23

1. 增加了对ozh的admin drop down menu的支持；
2. 改变了插件结构，去除了后台启用Widget的功能，此功能多余。
3. 增加了widget加载条件预判，解决redeclare的问题
4. 修改了语言包，捕获了几个没有翻译的串；

2008年8月30日12:46:57

1. 将所有的widget后台页面的字体都调整到12px；

2008年8月29日21:30:42

1. 给`wkc_recent_comments()`标签增加了xformat的支持，允许用户自己指定链接的格式；
2. 给最新评论Widget添加了xformat支持，允许用户自己指定链接的格式；
3. 修改了最新评论Widget后台界面的字号，看得更清楚了^_^；
4. 修改了对应更新的语言包；
5. 版本号上升到8.8.29，但是我认为这些更新还不足够升级哦~~；

2008年8月28日23:59:27

以下为尝试解决的问题的列表（√代表解决，×代表为解决）

1. 评论榜widget添加两个选项before和after——√
2. 摘要算法自定义“按照字数”“按照段落数”“综合控制”——×
3. 调查一下是否与wp-statistics冲突——×
4. 活跃评论者中要过滤掉PB/TB——√
5. 升级后，新的widget无法显示的问题——×
6. 热评文章增加“是否显示评论数”的选项——√
7. 最近留言用户应该可以控制数量——√
8. 允许关闭摘要算法——√
