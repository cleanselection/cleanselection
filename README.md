<!--
SPDX-FileCopyrightText: 2026 kotoverse
SPDX-License-Identifier: MIT
-->

# Clean Selection

Clean Selection replaces the browser's rigid text-selection gesture with a visual airbrush. Readers paint across rendered text, receive stable text fragments, and can copy, quote, collect, or erase selections without changing the document's typography.

[Live configurator](https://cleanselection.com) · [Forum demo](https://cleanselection.com/forum/) · [Multiple-region demo](https://cleanselection.com/multi/) · [API](docs/API.md) · [MIT license](LICENSE)

## Install

Use the release build directly in a browser:

```html
<script src="cleanselection.js"></script>
<script>
  const selection = CleanSelection.attach(document.querySelector('article'), {
    includeCompleteWords: true,
    multiSelect: true
  });
</script>
```

For package-manager consumers:

```sh
npm install cleanselection
```

The package is a browser-first global script. Loading it creates `window.CleanSelection`; TypeScript declarations are included.

## What the demos show

- [cleanselection.com](https://cleanselection.com) is the live configurator for brush behavior, selection rules, popup behavior, colors, and touch controls.
- [Forum demo](https://cleanselection.com/forum/) demonstrates quoting selections from posts and individual comments into a reply form.
- [Multiple-region demo](https://cleanselection.com/multi/) demonstrates shared selection state and document-order copying across several selectable regions.

The demo HTML is intentionally hosted separately and is not part of this repository.

## Builds

- `dist/cleanselection.js` is the readable browser build.
- `dist/cleanselection.min.js` is the minified browser build.
- `src/cleanselection.js` is the canonical source.

Run `node scripts/build.mjs` to regenerate the readable build and readable WordPress copy; it uses only Node.js built-ins and downloads nothing.

Minification does not require npm, esbuild, Java, or committed tool binaries. Run `node scripts/fetch-terser.mjs` once to download the pinned Terser `5.49.0` browser bundle into the operating system's temporary tool cache, then run `node scripts/minify.mjs`. The minifier writes both `dist/cleanselection.min.js` and the WordPress plugin's operational `assets/js/cleanselection.min.js`; the readable source remains alongside it for inspection. Both scripts verify the bundle's SHA-256 checksum. Set `TERSER_BUNDLE` to use a separately cached copy. CI regenerates all distributions and checks them for drift.

## WordPress

The maintained plugin is in [`wordpress/clean-selection`](wordpress/clean-selection).

[Download the latest WordPress plugin](https://github.com/cleanselection/cleanselection/releases/latest)

The release page contains the installable `clean-selection-VERSION.zip`. See [WordPress integration](docs/WORDPRESS.md).

## Documentation

- [Public API](docs/API.md)
- [All configuration options](docs/CONFIGURATION.md)
- [Integration patterns](docs/INTEGRATION.md)
- [Internal architecture](docs/INTERNALS.md)
- [Complete named-function inventory](docs/FUNCTIONS.md)

Names marked internal are documented for maintainers and debugging; they are not covered by semantic-versioning compatibility promises.

## Privacy

Clean Selection does not use cookies or browser storage, make network requests, collect telemetry, or retain selected text. Clipboard access occurs only after a reader activates a copy action.

## Author and license

Created by [kotoverse](https://github.com/kotoverse). Project home: [cleanselection.com](https://cleanselection.com).

Copyright © 2026 kotoverse. Released under the [MIT License](LICENSE).
