  <?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
$services_json = json_decode(getenv("VCAP_SERVICES"),true);
$mysql_config = $services_json["mysql-5.1"][0]["credentials"];

define('WP_CACHE', true); //Added by WP-Cache Manager

define('DB_NAME', $mysql_config["name"]);
define('DB_USER', $mysql_config["user"]);
define('DB_PASSWORD', $mysql_config["password"]);
define('DB_HOST', $mysql_config["hostname"]);
define('DB_PORT', $mysql_config["port"]);


// define('DB_NAME', 'd7b97208e9f2042a89e80a8b6ff9fae3f');
// define('DB_USER', 'uNh4EVs2TE072');
// define('DB_PASSWORD', 'pqpcBI5Uak7sP');
// define('DB_HOST', '127.0.0.1:10000'); 
// define('DB_PORT', 10000);

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'pkCzXyXrh{H:SC~[V3|c_/1{eDS2d@#>fcbW|],4wB3uspsHLo7q[LZf8=X20QaL');
define('SECURE_AUTH_KEY',  '1`l]_f-$(I%khJN4lPceBo|<u8s`-^w!|mZjDTr)wfmpXt;D@y`s=qsDGdfnyf^=');
define('LOGGED_IN_KEY',    'rOWP&qJY %OXEd*.-KV6Wg;[y_:.|;tjexFk?]Y~N{#4(F+ ts_R+WLRTSV7bj6*');
define('NONCE_KEY',        '-IiE6IpBNF7!DX=[n4|@UwrGl7c,b)2rTIP+fg:|Hn9z_!{03JEi%~8N+HrYC`&(');
define('AUTH_SALT',        ')mNqkE8--Wv.f<ZPq5S-?P1P0$D+7vMhc]?*3Hp+s5W.P-Z9Sbp{hv;p&`T|7z*Q');
define('SECURE_AUTH_SALT', 'Sh{P~L}NZ6Bk~iPLE!w8v/:)4.qW+66bh-=zo/u|uV$o__0&uiq}N37::Mhn(LaJ');
define('LOGGED_IN_SALT',   '%l456+e``H~lXUy@u)Tt6K3QNx$t0_U)A-WA=k:w4-w?mM|d6vE@UzRYW8-D#(H<');
define('NONCE_SALT',       '6OWTXN:O,TrSXiNvf=SqCc(F{vM*.s|6BPZ}C5hg7t@#XfyJ#eZh_9bR&a|SLz@4');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
