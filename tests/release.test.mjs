// SPDX-FileCopyrightText: 2026 kotoverse
// SPDX-License-Identifier: MIT

import assert from 'node:assert/strict';
import { readFile } from 'node:fs/promises';
import { test } from 'node:test';
import { dirname, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';

const root = resolve(dirname(fileURLToPath(import.meta.url)), '..');

test('browser source exposes the documented public surface', async () => {
  const source = await readFile(resolve(root, 'src/cleanselection.js'), 'utf8');
  for (const token of [
    'static attach(',
    'clearAllSelections()',
    'cancelSelection(',
    'updateOptions(',
    'getSelectionState()',
    'CleanSelection.createPopupShell',
    'CleanSelection.getModeController',
    "CleanSelection.version = '1.1.0'"
  ]) {
    assert.ok(source.includes(token), `missing ${token}`);
  }
});

test('WordPress core is generated from canonical source', async () => {
  const source = await readFile(resolve(root, 'src/cleanselection.js'));
  const wordpress = await readFile(resolve(root, 'wordpress/clean-selection/assets/js/cleanselection.js'));
  assert.deepEqual(wordpress, source);
});

test('WordPress operational core is generated from the canonical minified build', async () => {
  const minified = await readFile(resolve(root, 'dist/cleanselection.min.js'));
  const wordpress = await readFile(resolve(root, 'wordpress/clean-selection/assets/js/cleanselection.min.js'));
  assert.deepEqual(wordpress, minified);
});

test('all browser builds retain the MIT notice', async () => {
  for (const file of ['dist/cleanselection.js', 'dist/cleanselection.min.js']) {
    const contents = await readFile(resolve(root, file), 'utf8');
    assert.match(contents, /Copyright \(c\) 2026 kotoverse/);
    assert.match(contents, /@license MIT/);
  }
});

test('minified build remains public and smaller', async () => {
  const readable = await readFile(resolve(root, 'dist/cleanselection.js'), 'utf8');
  const minified = await readFile(resolve(root, 'dist/cleanselection.min.js'), 'utf8');
  assert.match(minified, /window\.CleanSelection/);
  assert.ok(Buffer.byteLength(minified) < Buffer.byteLength(readable));
});
