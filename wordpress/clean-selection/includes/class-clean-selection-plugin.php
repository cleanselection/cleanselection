<?php
/**
 * Clean Selection WordPress integration.
 *
 * SPDX-FileCopyrightText: 2026 kotoverse
 * SPDX-License-Identifier: GPL-2.0-or-later
 */

namespace Clean_Selection_WP;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Plugin {
	const OPTION           = 'clean_selection_wp_settings';
	const SETTINGS_VERSION = 3;

	private static $instance;

	public static function instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function run() {
		add_action( 'admin_init', array( $this, 'maybe_upgrade_settings' ), 5 );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend' ), 20 );
	}

	public static function defaults() {
		return array(
			'settings_version'         => self::SETTINGS_VERSION,
			'post_types'               => array( 'post', 'page' ),
			'additional_post_types'    => '',
			'enable_content'           => true,
			'enable_comments'          => false,
			'mode'                     => 'copy',
			'content_selector'         => '.entry-content, .wp-block-post-content',
			'comment_selector'         => '.comment-content, .wp-block-comment-content',
			'comment_form_selector'    => '#comment',
			'appearance'               => 'default',
			'accent_color'             => '#1e90ff',
			'copied_color'             => '#008f83',
			'brush_hardness'           => 0.35,
			'brush_max_alpha'          => 0.18,
			'brush_spacing'            => 0.35,
			'brush_turbulence'         => 0.25,
			'brush_turbulence_speed'   => 0.6,
			'brush_final_alpha'        => 0.34,
			'brush_fade_speed'         => 0.035,
			'brush_grow_speed'         => 0.04,
			'brush_padding_ratio'      => 0.3,
			'cursor'                   => '',
			'content_radius'           => 24,
			'content_overflow_padding' => 0,
			'content_virtual_padding'  => 0,
			'content_detect_tolerance' => 10,
			'comment_radius'           => 24,
			'comment_overflow_padding' => 0,
			'comment_virtual_padding'  => 0,
			'comment_detect_tolerance' => 10,
			'popup_background'         => '#ffffff',
			'popup_text'               => '#21314f',
			'popup_radius'             => 14,
			'center_popup'             => false,
			'touch_bar'                => false,
			'touch_bar_placement'      => 'top',
			'touch_bar_offset'         => '0px',
		);
	}

	private function normalize_legacy_settings( $settings ) {
		$settings = is_array( $settings ) ? $settings : array();
		$version  = isset( $settings['settings_version'] ) ? absint( $settings['settings_version'] ) : 1;

		if ( $version < 2 ) {
			if ( isset( $settings['comment_selector'] ) && '.comment-content' === trim( $settings['comment_selector'] ) ) {
				$settings['comment_selector'] = '.comment-content, .wp-block-comment-content';
			}

			if ( isset( $settings['post_types'] ) && is_array( $settings['post_types'] ) ) {
				$settings['post_types'] = array_values( array_diff( $settings['post_types'], array( 'attachment' ) ) );
			}

			$settings['settings_version'] = self::SETTINGS_VERSION;
		}

		if ( $version < 3 ) {
			$settings['center_popup']     = ! empty( $settings['center_popup'] );
			$settings['settings_version'] = self::SETTINGS_VERSION;
		}

		return $settings;
	}

	public function maybe_upgrade_settings() {
		$stored     = get_option( self::OPTION, array() );
		$normalized = $this->normalize_legacy_settings( $stored );

		if ( $normalized !== $stored ) {
			update_option( self::OPTION, $normalized );
		}
	}

	public function settings() {
		return wp_parse_args(
			$this->normalize_legacy_settings( get_option( self::OPTION, array() ) ),
			self::defaults()
		);
	}

	public function register_settings() {
		register_setting(
			'clean_selection_wp',
			self::OPTION,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( $this, 'sanitize_settings' ),
				'default'           => self::defaults(),
			)
		);
	}

	private function clamp_number( $value, $default, $minimum, $maximum ) {
		$number = is_numeric( $value ) ? (float) $value : (float) $default;
		return min( $maximum, max( $minimum, $number ) );
	}

	private function sanitize_cursor( $value ) {
		$value = sanitize_key( (string) $value );
		return in_array( $value, array( 'crosshair', 'default', 'text' ), true ) ? $value : '';
	}

	public function sanitize_settings( $input ) {
		$defaults = self::defaults();
		$input    = is_array( $input ) ? $input : array();
		$types    = isset( $input['post_types'] ) && is_array( $input['post_types'] )
			? array_map( 'sanitize_key', $input['post_types'] )
			: array();
		$types    = array_values( array_diff( array_unique( array_filter( $types ) ), array( 'attachment' ) ) );

		return array(
			'settings_version'         => self::SETTINGS_VERSION,
			'post_types'               => $types,
			'additional_post_types'    => $this->sanitize_post_type_list( $input['additional_post_types'] ?? '' ),
			'enable_content'           => ! empty( $input['enable_content'] ),
			'enable_comments'          => ! empty( $input['enable_comments'] ),
			'mode'                     => in_array( $input['mode'] ?? '', array( 'copy', 'reply', 'multiselect' ), true ) ? $input['mode'] : $defaults['mode'],
			'content_selector'         => sanitize_text_field( $input['content_selector'] ?? $defaults['content_selector'] ),
			'comment_selector'         => sanitize_text_field( $input['comment_selector'] ?? $defaults['comment_selector'] ),
			'comment_form_selector'    => sanitize_text_field( $input['comment_form_selector'] ?? $defaults['comment_form_selector'] ),
			'appearance'               => 'theme' === ( $input['appearance'] ?? '' ) ? 'theme' : 'default',
			'accent_color'             => sanitize_hex_color( $input['accent_color'] ?? '' ) ?: $defaults['accent_color'],
			'copied_color'             => sanitize_hex_color( $input['copied_color'] ?? '' ) ?: $defaults['copied_color'],
			'brush_hardness'           => $this->clamp_number( $input['brush_hardness'] ?? null, $defaults['brush_hardness'], 0.05, 0.85 ),
			'brush_max_alpha'          => $this->clamp_number( $input['brush_max_alpha'] ?? null, $defaults['brush_max_alpha'], 0.05, 0.4 ),
			'brush_spacing'            => $this->clamp_number( $input['brush_spacing'] ?? null, $defaults['brush_spacing'], 0.15, 0.75 ),
			'brush_turbulence'         => $this->clamp_number( $input['brush_turbulence'] ?? null, $defaults['brush_turbulence'], 0, 0.6 ),
			'brush_turbulence_speed'   => $this->clamp_number( $input['brush_turbulence_speed'] ?? null, $defaults['brush_turbulence_speed'], 0.1, 1.2 ),
			'brush_final_alpha'        => $this->clamp_number( $input['brush_final_alpha'] ?? null, $defaults['brush_final_alpha'], 0.1, 0.6 ),
			'brush_fade_speed'         => $this->clamp_number( $input['brush_fade_speed'] ?? null, $defaults['brush_fade_speed'], 0.001, 0.08 ),
			'brush_grow_speed'         => $this->clamp_number( $input['brush_grow_speed'] ?? null, $defaults['brush_grow_speed'], 0.01, 0.08 ),
			'brush_padding_ratio'      => $this->clamp_number( $input['brush_padding_ratio'] ?? null, $defaults['brush_padding_ratio'], 0.1, 0.6 ),
			'cursor'                   => $this->sanitize_cursor( $input['cursor'] ?? '' ),
			'content_radius'           => $this->clamp_number( $input['content_radius'] ?? null, $defaults['content_radius'], 12, 42 ),
			'content_overflow_padding' => $this->clamp_number( $input['content_overflow_padding'] ?? null, $defaults['content_overflow_padding'], 0, 48 ),
			'content_virtual_padding'  => $this->clamp_number( $input['content_virtual_padding'] ?? null, $defaults['content_virtual_padding'], 0, 48 ),
			'content_detect_tolerance' => $this->clamp_number( $input['content_detect_tolerance'] ?? null, $defaults['content_detect_tolerance'], 0, 18 ),
			'comment_radius'           => $this->clamp_number( $input['comment_radius'] ?? null, $defaults['comment_radius'], 12, 42 ),
			'comment_overflow_padding' => $this->clamp_number( $input['comment_overflow_padding'] ?? null, $defaults['comment_overflow_padding'], 0, 48 ),
			'comment_virtual_padding'  => $this->clamp_number( $input['comment_virtual_padding'] ?? null, $defaults['comment_virtual_padding'], 0, 48 ),
			'comment_detect_tolerance' => $this->clamp_number( $input['comment_detect_tolerance'] ?? null, $defaults['comment_detect_tolerance'], 0, 18 ),
			'popup_background'         => sanitize_hex_color( $input['popup_background'] ?? '' ) ?: $defaults['popup_background'],
			'popup_text'               => sanitize_hex_color( $input['popup_text'] ?? '' ) ?: $defaults['popup_text'],
			'popup_radius'             => min( 40, absint( $input['popup_radius'] ?? $defaults['popup_radius'] ) ),
			'center_popup'             => ! empty( $input['center_popup'] ),
			'touch_bar'                => ! empty( $input['touch_bar'] ),
			'touch_bar_placement'      => in_array( $input['touch_bar_placement'] ?? '', array( 'top', 'bottom', 'floating' ), true ) ? $input['touch_bar_placement'] : $defaults['touch_bar_placement'],
			'touch_bar_offset'         => sanitize_text_field( $input['touch_bar_offset'] ?? $defaults['touch_bar_offset'] ),
		);
	}

	private function sanitize_post_type_list( $value ) {
		$items = preg_split( '/[\s,]+/', (string) $value, -1, PREG_SPLIT_NO_EMPTY );
		$items = array_values( array_diff( array_unique( array_filter( array_map( 'sanitize_key', $items ) ) ), array( 'attachment' ) ) );

		return implode( ', ', $items );
	}

	public function add_settings_page() {
		add_options_page(
			__( 'Clean Selection', 'clean-selection' ),
			__( 'Clean Selection', 'clean-selection' ),
			'manage_options',
			'clean-selection',
			array( $this, 'render_settings_page' )
		);
	}

	public function enqueue_admin_assets( $hook_suffix ) {
		if ( 'settings_page_clean-selection' !== $hook_suffix ) {
			return;
		}

		wp_enqueue_style( 'clean-selection-admin', CLEAN_SELECTION_WP_URL . 'assets/css/admin.css', array(), CLEAN_SELECTION_WP_VERSION );
	}

	private function render_number_field( $settings, $key, $label, $minimum, $maximum, $step, $suffix = '', $description = '' ) {
		?>
		<label class="cswp-field">
			<span class="cswp-field__label"><?php echo esc_html( $label ); ?></span>
			<span class="cswp-input-with-unit">
				<input type="number" min="<?php echo esc_attr( $minimum ); ?>" max="<?php echo esc_attr( $maximum ); ?>" step="<?php echo esc_attr( $step ); ?>" name="<?php echo esc_attr( self::OPTION ); ?>[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $settings[ $key ] ); ?>">
				<?php if ( $suffix ) : ?><span><?php echo esc_html( $suffix ); ?></span><?php endif; ?>
			</span>
			<?php if ( $description ) : ?><small><?php echo esc_html( $description ); ?></small><?php endif; ?>
		</label>
		<?php
	}

	private function render_color_field( $settings, $key, $label, $description = '' ) {
		?>
		<label class="cswp-field cswp-field--color">
			<span class="cswp-field__label"><?php echo esc_html( $label ); ?></span>
			<span class="cswp-color-input"><input type="color" name="<?php echo esc_attr( self::OPTION ); ?>[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $settings[ $key ] ); ?>"><code><?php echo esc_html( strtoupper( $settings[ $key ] ) ); ?></code></span>
			<?php if ( $description ) : ?><small><?php echo esc_html( $description ); ?></small><?php endif; ?>
		</label>
		<?php
	}

	private function render_geometry_card( $settings, $prefix, $title, $description ) {
		?>
		<div class="cswp-subcard">
			<h3><?php echo esc_html( $title ); ?></h3>
			<p><?php echo esc_html( $description ); ?></p>
			<div class="cswp-field-grid cswp-field-grid--compact">
				<?php $this->render_number_field( $settings, $prefix . '_radius', __( 'Radius', 'clean-selection' ), 12, 42, 1, 'px', __( 'Brush footprint and cloud size.', 'clean-selection' ) ); ?>
				<?php $this->render_number_field( $settings, $prefix . '_overflow_padding', __( 'Overflow padding', 'clean-selection' ), 0, 48, 1, 'px', __( 'Zero keeps the automatic buffer.', 'clean-selection' ) ); ?>
				<?php $this->render_number_field( $settings, $prefix . '_virtual_padding', __( 'Virtual padding', 'clean-selection' ), 0, 48, 1, 'px', __( 'Gesture reach outside the content box.', 'clean-selection' ) ); ?>
				<?php $this->render_number_field( $settings, $prefix . '_detect_tolerance', __( 'Detect tolerance', 'clean-selection' ), 0, 18, 1, 'px', __( 'Extra reach around rendered text.', 'clean-selection' ) ); ?>
			</div>
		</div>
		<?php
	}

	public function render_settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$settings   = $this->settings();
		$post_types = get_post_types( array( 'public' => true, 'show_ui' => true ), 'objects', 'and' );
		unset( $post_types['attachment'] );
		?>
		<div class="wrap cswp-settings">
			<header class="cswp-hero">
				<div><span class="cswp-kicker"><?php esc_html_e( 'Airbrush selection for WordPress', 'clean-selection' ); ?></span><h1><?php esc_html_e( 'Clean Selection', 'clean-selection' ); ?></h1><p><?php esc_html_e( 'Configure where selection appears, tune the cloud for posts and comments, and style the copy experience.', 'clean-selection' ); ?></p></div>
				<div class="cswp-hero__swatch" style="--cswp-accent:<?php echo esc_attr( $settings['accent_color'] ); ?>"><span></span><span></span><span></span></div>
			</header>

			<form method="post" action="options.php">
				<?php settings_fields( 'clean_selection_wp' ); ?>
				<div class="cswp-layout">
					<section class="cswp-card">
						<div class="cswp-card__heading"><span>1</span><div><h2><?php esc_html_e( 'Placement', 'clean-selection' ); ?></h2><p><?php esc_html_e( 'Choose the public content where Clean Selection can run.', 'clean-selection' ); ?></p></div></div>
						<div class="cswp-check-grid">
							<?php foreach ( $post_types as $post_type ) : ?>
								<label><input type="checkbox" name="<?php echo esc_attr( self::OPTION ); ?>[post_types][]" value="<?php echo esc_attr( $post_type->name ); ?>" <?php checked( in_array( $post_type->name, $settings['post_types'], true ) ); ?>><span><?php echo esc_html( $post_type->labels->name ); ?><code><?php echo esc_html( $post_type->name ); ?></code></span></label>
							<?php endforeach; ?>
						</div>
						<label class="cswp-field cswp-field--wide"><span class="cswp-field__label"><?php esc_html_e( 'Additional post-type slugs', 'clean-selection' ); ?></span><input type="text" name="<?php echo esc_attr( self::OPTION ); ?>[additional_post_types]" value="<?php echo esc_attr( $settings['additional_post_types'] ); ?>" placeholder="book, lesson"><small><?php esc_html_e( 'Comma-separated. Media attachments are intentionally excluded.', 'clean-selection' ); ?></small></label>
						<div class="cswp-toggle-row"><label><input type="checkbox" name="<?php echo esc_attr( self::OPTION ); ?>[enable_content]" value="1" <?php checked( $settings['enable_content'] ); ?>><span><?php esc_html_e( 'Post content', 'clean-selection' ); ?></span></label><label><input type="checkbox" name="<?php echo esc_attr( self::OPTION ); ?>[enable_comments]" value="1" <?php checked( $settings['enable_comments'] ); ?>><span><?php esc_html_e( 'Individual comments', 'clean-selection' ); ?></span></label></div>
					</section>

					<section class="cswp-card">
						<div class="cswp-card__heading"><span>2</span><div><h2><?php esc_html_e( 'Workflow', 'clean-selection' ); ?></h2><p><?php esc_html_e( 'The interaction behavior stays curated; choose only the intended publishing workflow.', 'clean-selection' ); ?></p></div></div>
						<div class="cswp-choice-grid">
							<?php $modes = array( 'copy' => array( __( 'Select and copy', 'clean-selection' ), __( 'Copy one excerpt at a time.', 'clean-selection' ) ), 'reply' => array( __( 'Quote in comments', 'clean-selection' ), __( 'Insert the excerpt into the comment form.', 'clean-selection' ) ), 'multiselect' => array( __( 'Collect fragments', 'clean-selection' ), __( 'Keep multiple excerpts and copy them together.', 'clean-selection' ) ) ); ?>
							<?php foreach ( $modes as $value => $mode ) : ?><label><input type="radio" name="<?php echo esc_attr( self::OPTION ); ?>[mode]" value="<?php echo esc_attr( $value ); ?>" <?php checked( $settings['mode'], $value ); ?>><span><strong><?php echo esc_html( $mode[0] ); ?></strong><small><?php echo esc_html( $mode[1] ); ?></small></span></label><?php endforeach; ?>
						</div>
					</section>

					<section class="cswp-card cswp-card--wide">
						<div class="cswp-card__heading"><span>3</span><div><h2><?php esc_html_e( 'Selection appearance', 'clean-selection' ); ?></h2><p><?php esc_html_e( 'Tune the shared cloud texture, then scale its geometry independently for posts and comments.', 'clean-selection' ); ?></p></div></div>
						<div class="cswp-field-grid">
							<?php $this->render_color_field( $settings, 'accent_color', __( 'Selection and accent color', 'clean-selection' ), __( 'Used by the cloud and primary popup action.', 'clean-selection' ) ); ?>
							<?php $this->render_color_field( $settings, 'copied_color', __( 'Copied-fragment color', 'clean-selection' ), __( 'Distinguishes already-copied excerpts in fragment mode.', 'clean-selection' ) ); ?>
							<label class="cswp-field"><span class="cswp-field__label"><?php esc_html_e( 'Cursor', 'clean-selection' ); ?></span><select name="<?php echo esc_attr( self::OPTION ); ?>[cursor]"><option value="" <?php selected( $settings['cursor'], '' ); ?>><?php esc_html_e( 'Browser / theme default', 'clean-selection' ); ?></option><option value="crosshair" <?php selected( $settings['cursor'], 'crosshair' ); ?>><?php esc_html_e( 'Crosshair', 'clean-selection' ); ?></option><option value="default" <?php selected( $settings['cursor'], 'default' ); ?>><?php esc_html_e( 'Arrow', 'clean-selection' ); ?></option><option value="text" <?php selected( $settings['cursor'], 'text' ); ?>><?php esc_html_e( 'Text cursor', 'clean-selection' ); ?></option></select></label>
							<?php $this->render_number_field( $settings, 'brush_hardness', __( 'Hardness', 'clean-selection' ), 0.05, 0.85, 0.01 ); ?>
							<?php $this->render_number_field( $settings, 'brush_max_alpha', __( 'In-progress opacity', 'clean-selection' ), 0.05, 0.4, 0.01 ); ?>
							<?php $this->render_number_field( $settings, 'brush_spacing', __( 'Stamp spacing', 'clean-selection' ), 0.15, 0.75, 0.01 ); ?>
							<?php $this->render_number_field( $settings, 'brush_turbulence', __( 'Turbulence', 'clean-selection' ), 0, 0.6, 0.01 ); ?>
							<?php $this->render_number_field( $settings, 'brush_turbulence_speed', __( 'Turbulence speed', 'clean-selection' ), 0.1, 1.2, 0.01 ); ?>
							<?php $this->render_number_field( $settings, 'brush_final_alpha', __( 'Final opacity', 'clean-selection' ), 0.1, 0.6, 0.01 ); ?>
							<?php $this->render_number_field( $settings, 'brush_fade_speed', __( 'Fog fade speed', 'clean-selection' ), 0.001, 0.08, 0.001 ); ?>
							<?php $this->render_number_field( $settings, 'brush_grow_speed', __( 'Cloud grow speed', 'clean-selection' ), 0.01, 0.08, 0.005 ); ?>
							<?php $this->render_number_field( $settings, 'brush_padding_ratio', __( 'Cloud padding ratio', 'clean-selection' ), 0.1, 0.6, 0.01 ); ?>
						</div>
						<div class="cswp-subcard-grid"><?php $this->render_geometry_card( $settings, 'content', __( 'Post geometry', 'clean-selection' ), __( 'For regular post and page typography.', 'clean-selection' ) ); ?><?php $this->render_geometry_card( $settings, 'comment', __( 'Comment geometry', 'clean-selection' ), __( 'For typically smaller comment typography.', 'clean-selection' ) ); ?></div>
					</section>

					<section class="cswp-card">
						<div class="cswp-card__heading"><span>4</span><div><h2><?php esc_html_e( 'Popup', 'clean-selection' ); ?></h2><p><?php esc_html_e( 'Style the action panel without changing its accessible structure.', 'clean-selection' ); ?></p></div></div>
						<label class="cswp-field"><span class="cswp-field__label"><?php esc_html_e( 'Appearance', 'clean-selection' ); ?></span><select name="<?php echo esc_attr( self::OPTION ); ?>[appearance]"><option value="default" <?php selected( $settings['appearance'], 'default' ); ?>><?php esc_html_e( 'Styled default', 'clean-selection' ); ?></option><option value="theme" <?php selected( $settings['appearance'], 'theme' ); ?>><?php esc_html_e( 'Theme-controlled classes', 'clean-selection' ); ?></option></select></label>
						<div class="cswp-field-grid cswp-field-grid--compact"><?php $this->render_color_field( $settings, 'popup_background', __( 'Background', 'clean-selection' ) ); ?><?php $this->render_color_field( $settings, 'popup_text', __( 'Text', 'clean-selection' ) ); ?><?php $this->render_number_field( $settings, 'popup_radius', __( 'Corner radius', 'clean-selection' ), 0, 40, 1, 'px' ); ?></div>
						<label class="cswp-switch cswp-switch--spaced"><input type="checkbox" name="<?php echo esc_attr( self::OPTION ); ?>[center_popup]" value="1" <?php checked( $settings['center_popup'] ); ?>><span><?php esc_html_e( 'Always center the popup in the visible viewport', 'clean-selection' ); ?></span></label>
					</section>

					<section class="cswp-card">
						<div class="cswp-card__heading"><span>5</span><div><h2><?php esc_html_e( 'Touch control', 'clean-selection' ); ?></h2><p><?php esc_html_e( 'Optional Select/Deselect control for touchscreens.', 'clean-selection' ); ?></p></div></div>
						<label class="cswp-switch"><input type="checkbox" name="<?php echo esc_attr( self::OPTION ); ?>[touch_bar]" value="1" <?php checked( $settings['touch_bar'] ); ?>><span><?php esc_html_e( 'Show the built-in touch control', 'clean-selection' ); ?></span></label>
						<div class="cswp-field-grid cswp-field-grid--compact"><label class="cswp-field"><span class="cswp-field__label"><?php esc_html_e( 'Placement', 'clean-selection' ); ?></span><select name="<?php echo esc_attr( self::OPTION ); ?>[touch_bar_placement]"><option value="top" <?php selected( $settings['touch_bar_placement'], 'top' ); ?>><?php esc_html_e( 'Top', 'clean-selection' ); ?></option><option value="bottom" <?php selected( $settings['touch_bar_placement'], 'bottom' ); ?>><?php esc_html_e( 'Bottom', 'clean-selection' ); ?></option><option value="floating" <?php selected( $settings['touch_bar_placement'], 'floating' ); ?>><?php esc_html_e( 'Floating island', 'clean-selection' ); ?></option></select></label><label class="cswp-field"><span class="cswp-field__label"><?php esc_html_e( 'Edge offset', 'clean-selection' ); ?></span><input type="text" class="code" name="<?php echo esc_attr( self::OPTION ); ?>[touch_bar_offset]" value="<?php echo esc_attr( $settings['touch_bar_offset'] ); ?>"></label></div>
					</section>

					<details class="cswp-card cswp-card--wide cswp-advanced"><summary><?php esc_html_e( 'Advanced theme selectors', 'clean-selection' ); ?></summary><div class="cswp-field-grid"><label class="cswp-field"><span class="cswp-field__label"><?php esc_html_e( 'Post content selector', 'clean-selection' ); ?></span><input class="code" type="text" name="<?php echo esc_attr( self::OPTION ); ?>[content_selector]" value="<?php echo esc_attr( $settings['content_selector'] ); ?>"></label><label class="cswp-field"><span class="cswp-field__label"><?php esc_html_e( 'Comment content selector', 'clean-selection' ); ?></span><input class="code" type="text" name="<?php echo esc_attr( self::OPTION ); ?>[comment_selector]" value="<?php echo esc_attr( $settings['comment_selector'] ); ?>"></label><label class="cswp-field"><span class="cswp-field__label"><?php esc_html_e( 'Comment textarea selector', 'clean-selection' ); ?></span><input class="code" type="text" name="<?php echo esc_attr( self::OPTION ); ?>[comment_form_selector]" value="<?php echo esc_attr( $settings['comment_form_selector'] ); ?>"></label></div></details>
				</div>
				<div class="cswp-save"><div><strong><?php esc_html_e( 'Ready to apply your selection style?', 'clean-selection' ); ?></strong><span><?php esc_html_e( 'Settings are sanitized and applied on the next page load.', 'clean-selection' ); ?></span></div><?php submit_button( __( 'Save Clean Selection settings', 'clean-selection' ), 'primary', 'submit', false ); ?></div>
			</form>
		</div>
		<?php
	}

	private function selected_post_types( $settings ) {
		$extra = preg_split( '/[\s,]+/', $settings['additional_post_types'], -1, PREG_SPLIT_NO_EMPTY );
		$extra = array_map( 'sanitize_key', $extra );

		return array_values( array_diff( array_unique( array_merge( $settings['post_types'], $extra ) ), array( 'attachment' ) ) );
	}

	public function enqueue_frontend() {
		if ( is_admin() || is_feed() || ! is_singular() ) {
			return;
		}

		// Re:Likes embeds Clean Selection and owns the full page when both plugins target it.
		if ( wp_script_is( 'relikes-wp', 'enqueued' ) ) {
			return;
		}

		$settings  = $this->settings();
		$post_type = get_post_type( get_queried_object_id() );

		if ( ! in_array( $post_type, $this->selected_post_types( $settings ), true ) ) {
			return;
		}

		if ( ! $settings['enable_content'] && ! $settings['enable_comments'] ) {
			return;
		}

		if ( ! wp_script_is( 'clean-selection-core', 'registered' ) ) {
			// The readable cleanselection.js source ships beside this operational minified build.
			wp_register_script( 'clean-selection-core', CLEAN_SELECTION_WP_URL . 'assets/js/cleanselection.min.js', array(), CLEAN_SELECTION_CORE_VERSION, true );
		}

		wp_enqueue_script( 'clean-selection-core' );
		wp_enqueue_style( 'clean-selection-wp', CLEAN_SELECTION_WP_URL . 'assets/css/clean-selection-wp.css', array(), CLEAN_SELECTION_WP_VERSION );
		wp_enqueue_script( 'clean-selection-wp', CLEAN_SELECTION_WP_URL . 'assets/js/clean-selection-wp.js', array( 'clean-selection-core' ), CLEAN_SELECTION_WP_VERSION, true );

		$config = array(
			'postId'              => get_queried_object_id(),
			'postType'            => $post_type,
			'enableContent'       => (bool) $settings['enable_content'],
			'enableComments'      => (bool) $settings['enable_comments'],
			'mode'                => $settings['mode'],
			'contentSelector'     => $settings['content_selector'],
			'commentSelector'     => $settings['comment_selector'],
			'commentFormSelector' => $settings['comment_form_selector'],
			'appearance'          => $settings['appearance'],
			'accentColor'         => $settings['accent_color'],
			'popupBackground'     => $settings['popup_background'],
			'popupText'           => $settings['popup_text'],
			'popupRadius'         => (int) $settings['popup_radius'],
			'centerPopup'         => (bool) $settings['center_popup'],
			'touchBar'            => (bool) $settings['touch_bar'],
			'touchBarPlacement'   => $settings['touch_bar_placement'],
			'touchBarOffset'      => $settings['touch_bar_offset'],
			'visual'              => array(
				'copiedColor'    => $settings['copied_color'],
				'hardness'       => (float) $settings['brush_hardness'],
				'maxAlpha'       => (float) $settings['brush_max_alpha'],
				'spacing'        => (float) $settings['brush_spacing'],
				'turbulence'     => (float) $settings['brush_turbulence'],
				'turbulenceSpeed'=> (float) $settings['brush_turbulence_speed'],
				'finalAlpha'     => (float) $settings['brush_final_alpha'],
				'fadeSpeed'      => (float) $settings['brush_fade_speed'],
				'finalGrowSpeed' => (float) $settings['brush_grow_speed'],
				'paddingRatio'   => (float) $settings['brush_padding_ratio'],
				'cursor'         => $settings['cursor'],
				'content'        => array(
					'radius'          => (float) $settings['content_radius'],
					'overflowPadding' => (float) $settings['content_overflow_padding'],
					'virtualPadding'  => (float) $settings['content_virtual_padding'],
					'detectTolerance' => (float) $settings['content_detect_tolerance'],
				),
				'comment'        => array(
					'radius'          => (float) $settings['comment_radius'],
					'overflowPadding' => (float) $settings['comment_overflow_padding'],
					'virtualPadding'  => (float) $settings['comment_virtual_padding'],
					'detectTolerance' => (float) $settings['comment_detect_tolerance'],
				),
			),
			'labels'              => array(
				'copy'     => __( 'Copy', 'clean-selection' ),
				'cancel'   => __( 'Cancel', 'clean-selection' ),
				'quote'    => __( 'Quote in reply', 'clean-selection' ),
				'next'     => __( 'Next', 'clean-selection' ),
				'copyAll'  => __( 'Copy all', 'clean-selection' ),
				'clearAll' => __( 'Clear all', 'clean-selection' ),
				'noForm'   => __( 'The comment form is not available.', 'clean-selection' ),
			),
		);

		$config = apply_filters( 'clean_selection_wp_frontend_config', $config, $settings );
		wp_add_inline_script( 'clean-selection-wp', 'window.CleanSelectionWPConfig = ' . wp_json_encode( $config ) . ';', 'before' );
	}
}
