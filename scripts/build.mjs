// SPDX-FileCopyrightText: 2026 kotoverse
// SPDX-License-Identifier: MIT

import { mkdir, readFile, writeFile } from 'node:fs/promises';
import { dirname, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';

const root = resolve(dirname(fileURLToPath(import.meta.url)), '..');
const sourcePath = resolve(root, 'src/cleanselection.js');
const source = (await readFile(sourcePath, 'utf8')).replace(/\r\n/g, '\n').trimEnd() + '\n';

if (!source.includes("CleanSelection.version = '1.1.0'")) {
  throw new Error('The source version does not match package version 1.1.0.');
}

await mkdir(resolve(root, 'dist'), { recursive: true });
await writeFile(resolve(root, 'dist/cleanselection.js'), source);
await writeFile(resolve(root, 'wordpress/clean-selection/assets/js/cleanselection.js'), source);
