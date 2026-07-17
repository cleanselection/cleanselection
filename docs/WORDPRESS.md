<!-- SPDX-FileCopyrightText: 2026 kotoverse -->
<!-- SPDX-License-Identifier: MIT -->

# WordPress plugin

The plugin in `wordpress/clean-selection` is released with the library and uses the same `1.1.0` release version.

It supports public post types, post content, individual comments, copy, quote-in-reply, and multi-excerpt workflows. Settings include separate post/comment geometry, brush and cursor appearance, copied-fragment color, centered popup placement, and a viewport-aware touch controller. Settings are available under **Settings → Clean Selection**. Theme-controlled popups expose stable `clean-selection-wp-popup` classes while the default popup uses shadow DOM.

The plugin registers the browser library as `clean-selection-core`. Re:Likes uses the same handle and therefore does not load a second copy when both plugins are active.

The plugin makes no external requests and retains no selected text. WordPress integration code is GPL-2.0-or-later; the bundled browser core remains MIT-licensed and includes its readable source and notice. To package a committed release, run `npm run package:wordpress` after setting the repository version and generating builds.
