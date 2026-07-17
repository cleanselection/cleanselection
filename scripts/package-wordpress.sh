#!/usr/bin/env bash
# SPDX-FileCopyrightText: 2026 kotoverse
# SPDX-License-Identifier: MIT

set -euo pipefail

version="$(node -p "require('./package.json').version")"
mkdir -p release
git archive --format=zip --output="release/clean-selection-${version}.zip" --prefix=clean-selection/ HEAD:wordpress/clean-selection
echo "Created release/clean-selection-${version}.zip"
