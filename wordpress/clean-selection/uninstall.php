<?php
/**
 * Clean Selection uninstall handler.
 *
 * SPDX-FileCopyrightText: 2026 kotoverse
 * SPDX-License-Identifier: GPL-2.0-or-later
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'clean_selection_wp_settings' );

if ( is_multisite() ) {
	delete_site_option( 'clean_selection_wp_settings' );
}
