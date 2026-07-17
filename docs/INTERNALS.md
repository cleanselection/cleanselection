<!-- SPDX-FileCopyrightText: 2026 kotoverse -->
<!-- SPDX-License-Identifier: MIT -->

# Internal architecture

Clean Selection is intentionally dependency-free and ships as one IIFE.

1. Text nodes are segmented into measurable fragments.
2. Pointer samples paint a temporary fog canvas and accumulate fragment scores.
3. Gesture and continuity rules normalize the detected fragment set.
4. Final geometry and text are stored as a selection record.
5. A settled overlay and popup represent that record until it is copied, erased, cancelled, or cleared.

On responsive reflow, multiselection records are snapshotted by text-node offsets and rebuilt against current fragment geometry. Ordinary single selections remain destructive by default. `preserveSelectionsOnResize` can override either behavior.

`GLOBAL_STATE` coordinates registered instances, copy ordering, and the singleton touch erase manager. A caller-supplied `registry` adds a narrower shared selection scope without merging canvas rendering.

`TouchEraseBarManager` owns the built-in touch UI and routes gesture starts to the most appropriate visible instance. `CleanSelection` owns measurement, gesture arbitration, selection records, popup placement, clipboard operations, rendering, and teardown.

The complete source-level callable inventory is generated as [FUNCTIONS.md](FUNCTIONS.md). Internal names, selection-record fields, canvas layout, fragment scoring, and underscore-prefixed methods are not public contracts. Re:Likes currently uses a small number of measurement hooks; CI in both repositories checks that integration against the pinned Clean Selection release.
