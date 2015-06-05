<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wp_edt');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'Zyae$}7dB-zf#`,nH66;5YISXcP+LTTV<#nZMx6pG42ydAOMpRg>Z OAj[*OJ4kv');
define('SECURE_AUTH_KEY',  '$;>|XLySf`!P-gyqhw3U,#eXr0Y_H%%VfNvu]BNd {dD;?+VW|cvw=W_gTuncKwS');
define('LOGGED_IN_KEY',    '|-~M$U:9Pn<a;no&@`cSl`T~Su~MOn&En]$nD+8PF)A?rrMzgG!-d3*SF&Bvq0x~');
define('NONCE_KEY',        '~CTv8u:b{TYm<,J,xQVc-1N8Bl:%fQHF/e%F-MiZlA<uep|A(FW}z|P;-N&gfx8>');
define('AUTH_SALT',        'Td}9)qhkXtm@jo|QAkU[dH2_]<-*11{zz|-!U!MMj$2cNSt&k8W-8y`=!|[;g$Br');
define('SECURE_AUTH_SALT', 'U|mzQr&>h,xH8%/B+j^^rU748^s/$TTN,))$,L^Z%}JVLh(g7Dp@8Ekdgi,~p0^H');
define('LOGGED_IN_SALT',   's~9-)=&[;#St:jCq:<?e)aQ;gC,xFG,Cg_Q<h:/O-gr9hs(;+&tf9Q2Ij:o&#i)0');
define('NONCE_SALT',       '_92TF+o~@# 5FNw-FrKU1JD)iqfl@a|Se}d?}IrsT]%X7g(0Ep}+{jaS/0-2^paa');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
