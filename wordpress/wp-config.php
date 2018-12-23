<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wp');

/** MySQL database username */
define('DB_USER', 'yimian');

/** MySQL database password */
define('DB_PASSWORD', 'Lymian0904@112');

/** MySQL hostname */
define('DB_HOST', '114.116.65.152');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'RzU_8.Lv?2%HT{el4b$DMO]eK}$>4^ILI>EeGY(bf< e$E{}~t31k;[xWv{cVqbQ');
define('SECURE_AUTH_KEY',  ';0TJ`By+O=XhmH]z}fZMfJL-?K9al^4`]9$c)$N4lMUUM@3zC|  TiYa?.WE qf*');
define('LOGGED_IN_KEY',    'wGQs}8uWZJ:% t|M|zg9T|LaA?rz@4jkGwvK<Xp`QPTGhG7*orPxfOW6ryVBtxbg');
define('NONCE_KEY',        'g8xMdsYMUEA}3j}TZhqOUjhmat>_j]eUrNSPW6|b$AnLnu-(g=)Zm[(DW-L/KA:W');
define('AUTH_SALT',        'r0N)QZNCj]AN2RmFr%o$MUj+*(CZD`pa(Y^7$G8^*yL5A;)J@N1.J6AuP5IrmM&#');
define('SECURE_AUTH_SALT', '=8>wJ$z>d0^iA>u>|K*u+O?cft,%,z}3y*?.k( (R>3`K7JqtqEDHqm%_/]i/SPM');
define('LOGGED_IN_SALT',   'Enz}vT0ha`t5d[H9QfsR@R%E93C]F!#6K2jE}Mek}zg:uh#|zH#%4k{gBcEZ!m8N');
define('NONCE_SALT',       'H5qVX5[{MQ&U.}D.{|}gb%7[Rg]l-{]uGA1(X(:vj[^d}7PR5.2>Bxo@PlE>Tb)4');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
define("FS_METHOD","direct");  
define("FS_CHMOD_DIR", 0777);  
define("FS_CHMOD_FILE", 0777);
