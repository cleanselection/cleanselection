<!-- SPDX-FileCopyrightText: 2026 kotoverse -->
<!-- SPDX-License-Identifier: MIT -->

# Integration guide

## Choose stable surfaces

Attach to a content container whose text and dimensions are stable. Call `updateOptions({})` after replacing its content, or destroy and recreate the instance when the element itself is replaced.

## Multiple regions

Pass the same plain object as `registry` to every participating instance. Copy ordering then follows document order and `clearAllSelections()` applies to the shared scope.

```js
const registry = {};
document.querySelectorAll('[data-selectable]').forEach(element => {
  CleanSelection.attach(element, { registry, multiSelect: true });
});
```

## Interactive content

By default the managed surface prioritizes selection. Configure `interactiveElements` when it contains links, buttons, form controls, or custom interactive descendants that must retain native activation. Verify both deliberate drags and ordinary taps on touch devices.

## Custom popups

Use `createPopupShell()` for shared styling without default controls, or `createDefaultPopupDom()` as a complete baseline. Bind actions from the supplied popup context rather than calling underscore-prefixed instance methods.

## Lifecycle

Create one instance per live element, retain the returned value, and call `destroy()` before removing the element. Single-page applications should recreate instances after route content is replaced.

## Content security policy

The core injects inline style elements into shadow roots for its popup and touch control. A site with a restrictive `style-src` policy should test the built-in UI or provide an allowed custom renderer. The library loads no remote assets.
