/**
 * Clean Selection WordPress adapter.
 *
 * SPDX-FileCopyrightText: 2026 kotoverse
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
(function () {
  'use strict';

  const config = window.CleanSelectionWPConfig;
  if (!config || !window.CleanSelection) return;

  document.documentElement.classList.add('clean-selection-wp-active');

  const instances = new Map();
  const pending = new Map();
  const sharedRegistry = {};
  let intersectionObserver = null;
  let mutationObserver = null;
  const arbitration = window.CleanSelectionRelikesWPArbitration ||= {};
  arbitration.cleanRecords ||= new Map();
  arbitration.relikesClaims ||= new WeakSet();

  function hasRelikesPriority(element) {
    if (arbitration.relikesPageActive) return true;
    if (arbitration.relikesClaims.has(element)) return true;
    if (element.closest('[data-relikes-wp-attached], [data-relikes-wp-candidate]')) return true;
    return Boolean(element.querySelector('[data-relikes-wp-attached], [data-relikes-wp-candidate]'));
  }

  function queryAll(selector) {
    if (!selector) return [];

    try {
      return [...document.querySelectorAll(selector)];
    } catch (error) {
      console.warn('Clean Selection ignored an invalid selector.', selector, error);
      return [];
    }
  }

  function isEligibleSurface(element) {
    return element instanceof HTMLElement &&
      !element.dataset.cleanSelectionWpAttached &&
      !hasRelikesPriority(element);
  }

  function getCommentMetadata(element) {
    const root = element.closest('[id^="comment-"], .comment, [data-comment-id]');
    const rawId = root?.dataset.commentId || root?.id?.match(/comment-(\d+)/)?.[1] || '';
    const authorNode = root?.querySelector('.comment-author .fn, .comment-author-name, [rel="external nofollow ugc"]');

    return {
      id: rawId,
      author: authorNode?.textContent?.trim() || ''
    };
  }

  function discoverSurfaces() {
    const discovered = [];

    if (config.enableContent) {
      const content = queryAll(config.contentSelector).find(isEligibleSurface);
      if (content) discovered.push({ element: content, type: 'content', id: String(config.postId) });
    }

    if (config.enableComments) {
      const candidates = queryAll(config.commentSelector).filter(isEligibleSurface);
      const topLevel = candidates.filter(element =>
        !candidates.some(other => other !== element && other.contains(element))
      );

      for (const element of topLevel) {
        const metadata = getCommentMetadata(element);
        discovered.push({ element, type: 'comment', id: metadata.id, author: metadata.author });
      }
    }

    return discovered;
  }

  function createButton(label, className) {
    const button = document.createElement('button');
    button.type = 'button';
    button.className = className;
    button.textContent = label;
    return button;
  }

  function popupStyles() {
    if (config.appearance === 'theme') return '';

    return `
      .clean-selection-wp-popup {
        display: grid;
        gap: 12px;
        min-width: 240px;
        max-width: min(340px, calc(100vw - 28px));
        padding: 14px;
        border: 1px solid color-mix(in srgb, ${config.popupText} 18%, transparent);
        border-radius: ${Number(config.popupRadius) || 0}px;
        background: ${config.popupBackground};
        color: ${config.popupText};
        box-shadow: 0 18px 50px rgba(24, 37, 58, 0.2);
        box-sizing: border-box;
        font: 500 15px/1.4 sans-serif;
      }
      .clean-selection-wp-popup__preview {
        margin: 0;
        color: inherit;
        opacity: 0.78;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
        overflow: hidden;
      }
      .clean-selection-wp-popup__actions { display: grid; gap: 8px; }
      .clean-selection-wp-popup__button {
        appearance: none;
        width: 100%;
        border: 1px solid color-mix(in srgb, ${config.popupText} 22%, transparent);
        border-radius: max(6px, calc(${Number(config.popupRadius) || 0}px * .6));
        padding: .68rem .9rem;
        background: transparent;
        color: inherit;
        font: inherit;
        font-weight: 700;
        cursor: pointer;
      }
      .clean-selection-wp-popup__button--primary {
        border-color: ${config.accentColor};
        background: ${config.accentColor};
        color: #fff;
      }
    `;
  }

  function appendQuote(surface, text) {
    let textarea = null;

    try {
      textarea = document.querySelector(config.commentFormSelector);
    } catch (error) {
      console.warn('Clean Selection could not use the comment form selector.', error);
    }

    if (!(textarea instanceof HTMLTextAreaElement)) {
      window.alert(config.labels.noForm);
      return false;
    }

    const attribution = surface.author ? `\n<cite>${escapeHtml(surface.author)}</cite>` : '';
    const quote = `<blockquote><p>${escapeHtml(text).replace(/\n+/g, '</p><p>')}</p>${attribution}</blockquote>\n`;
    const prefix = textarea.value && !textarea.value.endsWith('\n') ? '\n' : '';
    textarea.value += prefix + quote;
    textarea.dispatchEvent(new Event('input', { bubbles: true }));

    if (surface.type === 'comment' && surface.id) {
      const parentField = textarea.form?.querySelector('input[name="comment_parent"]') || document.querySelector('input[name="comment_parent"]');
      if (parentField) parentField.value = surface.id;
    }

    textarea.scrollIntoView({ behavior: 'smooth', block: 'center' });
    window.setTimeout(() => textarea.focus({ preventScroll: true }), 350);
    return true;
  }

  function escapeHtml(value) {
    return String(value)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }

  function createPopupRenderer(surface) {
    return {
      create(context) {
        let current = context;
        const shell = config.appearance === 'theme'
          ? { host: document.createElement('div'), shadowRoot: null }
          : CleanSelection.createPopupShell('clean-selection-wp-popup-host');
        const host = shell.host;
        const popupRoot = shell.shadowRoot || host;
        const style = document.createElement('style');
        const card = document.createElement('div');
        const preview = document.createElement('p');
        const actions = document.createElement('div');
        const mode = config.mode;

        style.textContent = popupStyles();
        card.className = `clean-selection-wp-popup clean-selection-wp-popup--${mode} clean-selection-wp-popup--${config.appearance}`;
        preview.className = 'clean-selection-wp-popup__preview';
        actions.className = 'clean-selection-wp-popup__actions';

        if (mode !== 'multiselect') card.append(preview);

        if (mode === 'copy') {
          const copy = createButton(config.labels.copy, 'clean-selection-wp-popup__button clean-selection-wp-popup__button--primary');
          const cancel = createButton(config.labels.cancel, 'clean-selection-wp-popup__button');
          copy.addEventListener('click', () => current.copy());
          cancel.addEventListener('click', () => current.close());
          actions.append(copy, cancel);
        } else if (mode === 'reply') {
          const quote = createButton(config.labels.quote, 'clean-selection-wp-popup__button clean-selection-wp-popup__button--primary');
          const copy = createButton(config.labels.copy, 'clean-selection-wp-popup__button');
          const cancel = createButton(config.labels.cancel, 'clean-selection-wp-popup__button');
          quote.addEventListener('click', () => {
            if (appendQuote(surface, current.text)) current.close();
          });
          copy.addEventListener('click', () => current.copy());
          cancel.addEventListener('click', () => current.close());
          actions.append(quote, copy, cancel);
        } else {
          const next = createButton(config.labels.next, 'clean-selection-wp-popup__button');
          const copyAll = createButton(config.labels.copyAll, 'clean-selection-wp-popup__button clean-selection-wp-popup__button--primary');
          const clearAll = createButton(config.labels.clearAll, 'clean-selection-wp-popup__button');
          next.addEventListener('click', () => current.hidePopup());
          copyAll.addEventListener('click', () => current.instance.copyAllSelections());
          clearAll.addEventListener('click', () => current.instance.clearAllSelections());
          actions.append(next, copyAll, clearAll);
        }

        card.append(actions);
        if (style.textContent) popupRoot.append(style);
        popupRoot.append(card);

        return {
          element: host,
          update(next) {
            current = next;
            preview.textContent = next.text;
          }
        };
      }
    };
  }

  function touchBarOptions() {
    if (!config.touchBar) return false;

    const layout = config.touchBarPlacement === 'floating'
      ? { placement: 'floating', offset: { bottom: config.touchBarOffset, right: '16px' }, borderRadius: '999px' }
      : { placement: config.touchBarPlacement, offset: config.touchBarOffset };

    return {
      ariaLabel: 'Selection mode',
      layout,
      theme: config.appearance === 'theme' ? {} : {
        activeBackground: config.accentColor,
        eraseActiveBackground: config.accentColor,
        activeTextColor: '#ffffff'
      }
    };
  }

  function attachSurface(surface) {
    const { element } = surface;
    if (!isEligibleSurface(element) || instances.has(element)) {
      pending.delete(element);
      return;
    }

    element.dataset.cleanSelectionWpAttached = '1';

    const multiSelect = config.mode === 'multiselect';
    const instance = CleanSelection.attach(element, {
      ...selectionVisualOptions(surface, multiSelect),
      multiSelect,
      preserveSelectionsOnResize: multiSelect,
      mergeSelections: true,
      allowErase: true,
      includeCompleteWords: true,
      autoClose: config.mode !== 'multiselect',
      hidePopupsOnSelectionStart: multiSelect,
      showTextPreview: config.mode !== 'multiselect',
      centerPopup: Boolean(config.centerPopup),
      registry: multiSelect ? sharedRegistry : null,
      wrapper: multiSelect ? {
        single: { before: '', after: '' },
        multi: { before: '', after: '\n' }
      } : null,
      touchEraseBar: touchBarOptions(),
      interactiveElements: [
        { selector: 'button, input, textarea, select, summary, [contenteditable="true"]', behavior: 'native' },
        { selector: 'a[href]', behavior: 'tap-native-drag-select' }
      ],
      popupRenderer: createPopupRenderer(surface)
    });

    instances.set(element, instance);
    arbitration.cleanRecords.set(element, () => releaseInstance(element));
    pending.delete(element);
  }

  function hexToRgb(hex) {
    const match = String(hex).match(/^#([\da-f]{2})([\da-f]{2})([\da-f]{2})$/i);
    return match ? match.slice(1).map(value => Number.parseInt(value, 16)) : [30, 144, 255];
  }

  function numberOption(value, fallback) {
    const number = Number(value);
    return Number.isFinite(number) ? number : fallback;
  }

  function selectionVisualOptions(surface, multiSelect) {
    const visual = config.visual || {};
    const geometry = surface.type === 'comment'
      ? (visual.comment || {})
      : (visual.content || {});
    const overflowPadding = numberOption(geometry.overflowPadding, 0);

    return {
      color: hexToRgb(config.accentColor),
      copiedColor: multiSelect ? hexToRgb(visual.copiedColor || '#008f83') : null,
      hardness: numberOption(visual.hardness, 0.35),
      maxAlpha: numberOption(visual.maxAlpha, 0.18),
      spacing: numberOption(visual.spacing, 0.35),
      turbulence: numberOption(visual.turbulence, 0.25),
      turbulenceSpeed: numberOption(visual.turbulenceSpeed, 0.6),
      finalAlpha: numberOption(visual.finalAlpha, 0.34),
      fadeSpeed: numberOption(visual.fadeSpeed, 0.035),
      finalGrowSpeed: numberOption(visual.finalGrowSpeed, 0.04),
      finalPaddingRatio: numberOption(visual.paddingRatio, 0.3),
      radius: numberOption(geometry.radius, 24),
      overflowPadding: overflowPadding > 0 ? overflowPadding : null,
      externalVirtualPadding: numberOption(geometry.virtualPadding, 0),
      detectTolerance: numberOption(geometry.detectTolerance, 10),
      cursor: visual.cursor || null
    };
  }

  function releaseInstance(element) {
    const instance = instances.get(element);
    if (instance) instance.destroy();
    instances.delete(element);
    pending.delete(element);
    arbitration.cleanRecords.delete(element);
    delete element.dataset.cleanSelectionWpAttached;
  }

  function scheduleSurface(surface) {
    if (instances.has(surface.element) || pending.has(surface.element)) return;
    pending.set(surface.element, surface);

    if (intersectionObserver) {
      intersectionObserver.observe(surface.element);
    } else {
      attachSurface(surface);
    }
  }

  function cleanRemovedInstances() {
    for (const element of instances.keys()) {
      if (element.isConnected) continue;
      releaseInstance(element);
    }

    for (const element of pending.keys()) {
      if (!element.isConnected) pending.delete(element);
    }
  }

  function bootstrap() {
    if ('IntersectionObserver' in window) {
      intersectionObserver = new IntersectionObserver(entries => {
        for (const entry of entries) {
          if (!entry.isIntersecting) continue;
          const surface = pending.get(entry.target);
          intersectionObserver.unobserve(entry.target);
          if (surface) attachSurface(surface);
        }
      }, { rootMargin: '600px 0px' });
    }

    for (const surface of discoverSurfaces()) scheduleSurface(surface);

    mutationObserver = new MutationObserver(() => {
      cleanRemovedInstances();
      for (const surface of discoverSurfaces()) scheduleSurface(surface);
    });
    mutationObserver.observe(document.body, { childList: true, subtree: true });
  }

  function destroyAll() {
    mutationObserver?.disconnect();
    intersectionObserver?.disconnect();
    for (const element of [...instances.keys()]) releaseInstance(element);
    pending.clear();
  }

  window.addEventListener('pagehide', destroyAll, { once: true });

  const start = () => window.setTimeout(bootstrap, 0);
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', start, { once: true });
  } else {
    start();
  }
})();
