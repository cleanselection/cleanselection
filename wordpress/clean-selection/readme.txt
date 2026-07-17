=== Clean Selection ===
Contributors: kotoverse
Tags: selection, copy, comments, multiselect, accessibility
Requires at least: 6.0
Requires PHP: 7.4
Stable tag: 1.1.0
License: GPLv2 or later

Airbrush-style text selection with copy, WordPress comment quoting, and persistent multiselect workflows.

== Description ==

Clean Selection can be enabled for public post types, post content, and individual comments. It includes three workflows:

* Select and copy.
* Quote a selection into the WordPress comment form.
* Collect and copy multiple excerpts in document order.

The plugin does not restyle post or comment content. Its popup can use the accessible built-in appearance or expose stable classes for theme-controlled styling.

== Installation ==

1. Upload the `clean-selection` directory to `/wp-content/plugins/`.
2. Activate Clean Selection.
3. Open Settings > Clean Selection.
4. Choose post types, surfaces, and a workflow.

== Theme integration ==

Default selectors cover common classic and block themes. Sites with custom markup can configure content, comment, and comment-textarea selectors on the settings page.

When Theme-controlled classes is selected, use `.clean-selection-wp-popup` and its `__preview`, `__actions`, and `__button` elements in theme CSS.

== Source code ==

The operational Clean Selection core is minified with Terser. Its complete readable source is included beside it as `assets/js/cleanselection.js`. Project source and build tooling are published at https://github.com/cleanselection/cleanselection.

== Changelog ==

= 1.1.0 =
* Allowed 0.01 increments for fractional brush controls and 0.001 values for Fog fade speed.
* Added separate post and comment geometry, complete brush and cursor controls, copied-fragment color, centered popups, and a styled settings screen.
* Added block-theme comment defaults, excluded media attachments, and yielded overlapping pages to Re:Likes.
* Preserved collected fragments across resize and rotation while ordinary single selections remain destructive on reflow.
* Kept the touch control constrained to the visual viewport and visible only while configured selectable surfaces are onscreen.
* Loaded the Terser-minified core operationally while retaining its complete readable MIT-licensed source.
