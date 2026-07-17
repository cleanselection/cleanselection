// SPDX-FileCopyrightText: 2026 kotoverse
// SPDX-License-Identifier: MIT

import { createHash } from 'node:crypto';
import { mkdir, readFile, writeFile } from 'node:fs/promises';
import { tmpdir } from 'node:os';
import { dirname, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';
import vm from 'node:vm';

const terserVersion = '5.49.0';
const expectedSha256 = '0c6e7bcbe21927c8c9a62dffa9ee2eaf83c63cfef8c2e40fd9b511fdf4a3b30b';
const root = resolve(dirname(fileURLToPath(import.meta.url)), '..');
const bundlePath = resolve(
  process.env.TERSER_BUNDLE ||
  resolve(tmpdir(), 'kotoverse-js-tools', `terser-${terserVersion}.bundle.min.js`)
);

async function loadTerser() {
  let bundle;
  try {
    bundle = await readFile(bundlePath);
  } catch {
    throw new Error(`Terser ${terserVersion} is not cached. Run node scripts/fetch-terser.mjs first.`);
  }

  const actualSha256 = createHash('sha256').update(bundle).digest('hex');
  if (actualSha256 !== expectedSha256) {
    throw new Error(`Terser bundle checksum mismatch at ${bundlePath}.`);
  }

  const sandbox = {};
  sandbox.globalThis = sandbox;
  sandbox.self = sandbox;
  vm.createContext(sandbox);
  vm.runInContext(bundle.toString('utf8'), sandbox, { filename: bundlePath });
  if (typeof sandbox.Terser?.minify !== 'function') {
    throw new Error('The pinned Terser bundle did not expose its minify API.');
  }
  return sandbox.Terser;
}

const source = (await readFile(resolve(root, 'src/cleanselection.js'), 'utf8'))
  .replace(/\r\n/g, '\n')
  .trimEnd() + '\n';
if (!source.includes("CleanSelection.version = '1.1.0'")) {
  throw new Error('The source version does not match package version 1.1.0.');
}

const terser = await loadTerser();
const result = await terser.minify(source, {
  compress: true,
  ecma: 2020,
  mangle: true,
  safari10: true,
  format: {
    comments: 'some'
  }
});
const minified = result.code.trimEnd() + '\n';
if (!minified.includes('@license MIT') || !minified.includes('window.CleanSelection')) {
  throw new Error('Minified output lost the license notice or public CleanSelection global.');
}

await mkdir(resolve(root, 'dist'), { recursive: true });
await writeFile(resolve(root, 'dist/cleanselection.min.js'), minified);
await writeFile(resolve(root, 'wordpress/clean-selection/assets/js/cleanselection.min.js'), minified);
