<!-- SPDX-FileCopyrightText: 2026 kotoverse -->
<!-- SPDX-License-Identifier: MIT -->

# Agent guidance

- Work in English and preserve unrelated changes.
- `src/cleanselection.js` is the canonical browser source.
- Run `npm run build` after source changes. It regenerates the readable distribution and WordPress core copy.
- Run `npm run minify` after source changes. It regenerates the distribution and operational WordPress minified files. Use `npm run fetch:minifier` first if the pinned Terser bundle is not cached.
- Run `npm run docs` after functions are added, removed, or renamed. Do not manually edit generated `docs/FUNCTIONS.md`.
- Keep the package, core, WordPress plugin, types, documentation, and release metadata versions synchronized.
- The demo HTML is hosted at the live links in `README.md` and is intentionally not part of this repository.
- The core library is MIT licensed. WordPress integration PHP, CSS, and adapter code is GPL-2.0-or-later; its bundled core remains MIT licensed.
- Do not commit WordPress ZIP packages, operating-system metadata, runtime data, secrets, or downloaded build tools.
- Before handing off, run `npm test` and `npm run check` and inspect generated-file drift.
