<?php

// BEGIN iThemes Security - Do not modify or remove this line
// iThemes Security Config Details: 2
define( 'DISALLOW_FILE_EDIT', true ); // Disable File Editor - Security > Settings > WordPress Tweaks > File Editor
// END iThemes Security - Do not modify or remove this line

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
define('DB_NAME', 'ehaitior_4dd');

/** MySQL database username */
define('DB_USER', 'ehaitior_4dd');

/** MySQL database password */
define('DB_PASSWORD', 'FC018EBDo7h9x6y4r5zu3i2');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         '$_DgW{hmWs|q_FwO[,Tr+{m 0Fv^Lj#*#F;-NsQDx6)e-S@-10+Mi2}i4Bi2ZF~C');
define('SECURE_AUTH_KEY',  ')RqwVO}(,so&F?p#/^c)eIJ];|eC[ e[NwHT4U2m>M4aA*+r!GK};dH~g9r]kXbR');
define('LOGGED_IN_KEY',    'D()L2<UF+/F^ e<M5wNxCW,OTC6`m]|5uNw{k#lA%pV48SE(0J%E&|h9I:TiR@d0');
define('NONCE_KEY',        '$Olt%2-!;4oT|i]O,FaaFP~8PP<N B+A[u-GR)Er~g#V:0F6T2HKcw}5Q[8=WnOo');
define('AUTH_SALT',        'dO^^`?+f12vNobaw^fy4iGwy+L*uzk^??icHd!{pQ@>oS^(BlIUvkq./w&W;C.!a');
define('SECURE_AUTH_SALT', 'Dwv-^?|I81XKO}gjwv3UtjvyCncF)l#U!iY+N2h}4-Xu,;C8/`<-`T9NL|K e/,t');
define('LOGGED_IN_SALT',   '+_v{3=RFl@bocLfpcF1)+ IWt+]j(IGR]0|fI_OFHcC0lN1i:d-XycK@92MHTBiR');
define('NONCE_SALT',       '/zbq92?K3(bUWQ)Hz}qYSQY(0|L;y^=b:oTgDEHf; AyU?DhBB|+2OGzd5+xn0Ij');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'ehbrd6_';

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

define( 'AUTOSAVE_INTERVAL',    300  );
define( 'WP_POST_REVISIONS',    5    );
define( 'EMPTY_TRASH_DAYS',     7    );
define( 'WP_AUTO_UPDATE_CORE',  true );
define( 'WP_CRON_LOCK_TIMEOUT', 120  );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
