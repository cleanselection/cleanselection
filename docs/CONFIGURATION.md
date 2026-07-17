<!-- SPDX-FileCopyrightText: 2026 kotoverse -->
<!-- SPDX-License-Identifier: MIT -->

# Configuration

All options are optional. Values below are the `1.1.0` defaults.

## Brush and rendering

| Option | Default | Purpose |
| --- | --- | --- |
| `radius` | `24` | Brush radius in CSS pixels. |
| `hardness` | `0.35` | Density near the center of a live brush stamp. |
| `maxAlpha` | `0.18` | Maximum live-stroke opacity. |
| `spacing` | `0.35` | Distance between stamps as a fraction of radius. |
| `turbulence` | `0.25` | Positional variation in the spray. |
| `turbulenceSpeed` | `0.6` | Evolution speed of spray noise. |
| `color` | `[30, 144, 255]` | Active and final RGB selection color. |
| `copiedColor` | `null` | Optional RGB color used after a selection is copied. |
| `copiedColorMorphSpeed` | `0.06` | Per-frame copied-color transition speed. |
| `eraseColor` | `[255, 255, 255]` | Erase-preview RGB color. |
| `finalAlpha` | `0.34` | Maximum settled-selection opacity. |
| `fadeSpeed` | `0.035` | Per-frame live-fog fade amount. |
| `finalGrowSpeed` | `0.04` | Settled-selection entrance speed. |
| `finalPaddingRatio` | `0.3` | Extra radius around final text fragments. |
| `overflowPadding` | `null` | Explicit canvas overflow; `null` derives it from brush geometry. |
| `externalVirtualPadding` | `0` | Selectable gesture area outside the content element. |

## Detection and gestures

| Option | Default | Purpose |
| --- | --- | --- |
| `detectTolerance` | `10` | Extra hit tolerance around measured fragments. |
| `movementThreshold` | `6` | Mouse movement required before drawing begins. |
| `touchActivationDistance` | `14` | Touch travel required before selection intent is accepted. |
| `touchMaxAngle` | `38` | Maximum mostly-horizontal touch angle before scrolling wins. |
| `cursor` | `null` | Cursor applied while idle; `null` preserves the site's cursor. |
| `preventSelection` | `true` | Suppress native text selection on the managed surface. |
| `observeResize` | `true` | Remeasure after element size changes. |
| `preserveSelectionsOnResize` | `null` | Preserve semantic selections across reflow. `null` enables preservation for multiselect and clears ordinary single selections. |
| `interactiveElements` | `false` | Rules for preserving clicks on links, controls, or custom elements. |
| `debug` | `false` | Emit recoverable integration failures to the console. |

## Selection rules

| Option | Default | Purpose |
| --- | --- | --- |
| `multiSelect` | `false` | Keep more than one local selection. |
| `mergeSelections` | `true` | Merge nearby strokes into an existing selection. |
| `allowErase` | `false` | Allow fragment removal in erase mode. |
| `strokeMergeTime` | `320` | Milliseconds in which a nearby stroke may merge. |
| `strokeMergeTolerance` | `null` | Geometry tolerance for merging; `null` derives it from radius. |
| `strokeMergeDomGap` | `18` | Maximum DOM-fragment gap allowed when merging. |
| `includeCompleteWords` | `false` | Expand detected fragments to word and paired-punctuation edges. |
| `continuousOnly` | `false` | Keep only the longest continuous detected fragment run. |
| `dismissSpeed` | `0.08` | Per-frame dismissal animation speed. |
| `autoClose` | `false` | Clear selections after a successful copy operation. |
| `wrapper` | `null` | String or function that wraps copied text. |
| `registry` | `null` | Shared object for selection state across multiple instances. |

## Popup behavior

| Option | Default | Purpose |
| --- | --- | --- |
| `popupOffset` | `24` | Preferred gap between selection and popup. |
| `androidChromePopupExtraOffset` | `12` | Additional placement allowance for Android Chrome. |
| `centerPopup` | `false` | Center the popup horizontally and vertically in the visible viewport. |
| `showTextPreview` | `true` | Show selected text in the default popup. |
| `hidePopupsOnSelectionStart` | `false` | Hide existing popups when a new stroke begins. |
| `popupRenderer` | `null` | Custom popup function or lifecycle object. |
| `popupClassName` | `''` | Classes copied to generated popup hosts and default markup. |

## Touch erase integration

| Option | Default | Purpose |
| --- | --- | --- |
| `touchEraseControl` | `false` | Enable erase input driven by an external mode controller. |
| `touchEraseBar` | `false` | Enable or configure the built-in Select/Deselect bar. |
| `hasEraseTarget` | `null` | Callback telling an external controller whether erasing is useful. |
| `onErasePoint` | `null` | Callback for erase points handled by another data model. |

`touchEraseBar` accepts `true` or an object. Top-level fields include `enabled`, `className`, `bodyClassName`, `mediaQuery`, `ariaLabel`, `requireSelection`, `alwaysVisible`, `labels`, `layout`, and `theme`. The nested `layout` object accepts `placement`, `offset`, `inlineInset`, `align`, `width`, `maxWidth`, and `borderRadius`. By default the bar is shown only while at least one configured selectable instance is visible; set `alwaysVisible: true` only for integrations that intentionally need a page-persistent control.

The configurator intentionally presents the common subset. Options such as `registry`, `wrapper`, custom popup lifecycle hooks, external erase callbacks, and diagnostic controls remain supported even though they are not shown there.
