// SPDX-FileCopyrightText: 2026 kotoverse
// SPDX-License-Identifier: MIT

import { readFile } from 'node:fs/promises';
import { dirname, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';

const root = resolve(dirname(fileURLToPath(import.meta.url)), '..');
const required = [
  'AGENTS.md',
  'LICENSE',
  'README.md',
  'dist/cleanselection.js',
  'dist/cleanselection.min.js',
  'types/index.d.ts',
  'wordpress/clean-selection/LICENSE',
  'wordpress/clean-selection/LICENSES/MIT.txt',
  'wordpress/clean-selection/assets/css/admin.css',
  'wordpress/clean-selection/assets/css/clean-selection-wp.css',
  'wordpress/clean-selection/assets/js/cleanselection.min.js'
];

for (const file of required) {
  await readFile(resolve(root, file));
}

const packageJson = JSON.parse(await readFile(resolve(root, 'package.json'), 'utf8'));
const source = await readFile(resolve(root, 'src/cleanselection.js'), 'utf8');
const readable = await readFile(resolve(root, 'dist/cleanselection.js'), 'utf8');
const minified = await readFile(resolve(root, 'dist/cleanselection.min.js'), 'utf8');
const plugin = await readFile(resolve(root, 'wordpress/clean-selection/clean-selection.php'), 'utf8');
if (packageJson.version !== '1.1.0' || !source.includes("version = '1.1.0'") || !plugin.includes('Version: 1.1.0')) {
  throw new Error('Release versions are not synchronized.');
}
if (!minified.includes('@license MIT') || !minified.includes('window.CleanSelection')) {
  throw new Error('The minified build is missing its license or public global.');
}
if (Buffer.byteLength(minified) >= Buffer.byteLength(readable)) {
  throw new Error('The minified build is not smaller than the readable build.');
}
