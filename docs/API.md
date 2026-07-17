<!-- SPDX-FileCopyrightText: 2026 kotoverse -->
<!-- SPDX-License-Identifier: MIT -->

# Public API

Clean Selection is distributed as an IIFE browser script and exposes one global, `window.CleanSelection`. The declarations in `types/index.d.ts` describe the same contract.

## Create an instance

```js
const instance = CleanSelection.attach(element, options);
```

`element` must be an `HTMLElement`. `options` is described in [CONFIGURATION.md](CONFIGURATION.md). `new CleanSelection(element, options)` is supported, but `attach()` is preferred because it also registers the instance for shared touch controls and cross-instance behavior.

## Static members

### `CleanSelection.version`

The library version string, currently `1.1.0`.

### `CleanSelection.attach(element, options?)`

Creates, registers, measures, and starts a selection instance. Returns the instance.

### Theme and layout tokens

- `popupThemeTokens` contains the default CSS values used by the built-in popup.
- `touchEraseBarThemeTokens` contains the default touch-bar theme values.
- `touchEraseBarLayoutDefaults` contains the default touch-bar placement and sizing values.

The three objects are frozen. Copy them before changing values.

### `createPopupShell(className?)`

Returns `{ host, shadowRoot, classTokens }`. The host contains the shared popup stylesheet but no controls. Use it when building a custom popup that should retain the default CSS-variable contract.

### `createDefaultPopupDom(className?)`

Returns `{ host, shadowRoot, popup, preview, copyButton, cancelButton }`. This is a customization baseline for renderers that want the built-in markup.

### `getModeController()`

Returns the shared touch erase controller:

- `setMode('select' | 'erase')` changes the mode.
- `getMode()` returns the current mode.
- `getState()` returns the current shared UI state.
- `subscribe(listener)` receives state changes and returns an unsubscribe function.

## Instance methods

### `clearAllSelections()`

Dismisses every selection in the instance's scope. With a shared `registry`, the scope includes all registered instances.

### `cancelSelection(selectionId?)`

Dismisses the identified selection. Without an ID, it dismisses the current selection.

### `updateOptions(partialOptions?)`

Merges new options, remeasures text, clears current selection state, and reapplies interaction styles. Returns the instance. Treat this as a reconfiguration operation rather than a lightweight animation setter.

### `getSelectionState()`

Returns `null` when there is no visible selection. Otherwise returns the current selection summary:

```js
{
  selectionCount,
  currentSelectionId,
  fragmentIndices,
  fragmentCount,
  textPreview,
  bounds,
  copied,
  popupVisible,
  rects,
  selections
}
```

Geometry is expressed in CSS pixels relative to the selectable element unless the property name explicitly says otherwise.

### `destroy()`

Stops animation and observers, removes generated canvases and controls, unregisters events, restores the element's inline interaction styles, and returns the instance. Do not reuse a destroyed instance.

## Popup renderer contract

`popupRenderer` can be a function or an object with `create`, `update`, and `destroy` hooks. A renderer receives a context containing the live selection, text, copied state, instance, and selection actions. The core owns popup placement; the renderer owns markup, styles, and action binding.

Consumers should use only the members documented here. Underscore-prefixed methods and every name classified as internal in [FUNCTIONS.md](FUNCTIONS.md) may change without a major release.
