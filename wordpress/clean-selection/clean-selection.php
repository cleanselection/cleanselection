<?php
/**
 * Plugin Name: Clean Selection
 * Plugin URI: https://cleanselection.com/
 * Description: Airbrush-style text selection with copy, comment reply, and multiselect workflows.
 * Version: 1.1.0
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Author: kotoverse
 * Author URI: https://github.com/kotoverse
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: clean-selection
 *
 * Copyright (c) 2026 kotoverse
 * Source repository: https://github.com/cleanselection/cleanselection
 * Bundled Clean Selection core: MIT; see LICENSES/MIT.txt.
 * SPDX-FileCopyrightText: 2026 kotoverse
 * SPDX-License-Identifier: GPL-2.0-or-later
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CLEAN_SELECTION_WP_VERSION', '1.1.0' );
if ( ! defined( 'CLEAN_SELECTION_CORE_VERSION' ) ) {
	define( 'CLEAN_SELECTION_CORE_VERSION', '1.1.0' );
}
define( 'CLEAN_SELECTION_WP_FILE', __FILE__ );
define( 'CLEAN_SELECTION_WP_DIR', plugin_dir_path( __FILE__ ) );
define( 'CLEAN_SELECTION_WP_URL', plugin_dir_url( __FILE__ ) );

require_once CLEAN_SELECTION_WP_DIR . 'includes/class-clean-selection-plugin.php';

Clean_Selection_WP\Plugin::instance()->run();
