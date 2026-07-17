// SPDX-FileCopyrightText: 2026 kotoverse
// SPDX-License-Identifier: MIT

declare class CleanSelection {
  constructor(element: HTMLElement, options?: CleanSelection.Options);
  static readonly version: '1.1.0';
  static attach(element: HTMLElement, options?: CleanSelection.Options): CleanSelection;
  static readonly popupThemeTokens: Readonly<Record<string, string>>;
  static readonly touchEraseBarThemeTokens: Readonly<Record<string, string>>;
  static readonly touchEraseBarLayoutDefaults: Readonly<Record<string, string>>;
  static createPopupShell(className?: string): CleanSelection.PopupShell;
  static createDefaultPopupDom(className?: string): CleanSelection.DefaultPopupDom;
  static getModeController(): CleanSelection.ModeController;
  clearAllSelections(): void;
  cancelSelection(selectionId?: string): void;
  destroy(): void;
  updateOptions(options?: Partial<CleanSelection.Options>): void;
  getSelectionState(): CleanSelection.SelectionState | null;
}

declare namespace CleanSelection {
  type RGB = [number, number, number];
  type Placement = 'top' | 'bottom' | 'floating';
  type Mode = 'select' | 'erase';
  type CSSLength = string | number;

  interface PopupContext {
    instance: CleanSelection;
    selection: unknown;
    selectionId: string;
    text: string;
    copied: boolean;
    copy(): Promise<void>;
    cancel(): void;
    clearAll(): void;
  }

  interface PopupController {
    element: HTMLElement;
    update?(context: PopupContext): void;
    destroy?(context: PopupContext): void;
  }

  type PopupRenderer = ((context: PopupContext) => HTMLElement | PopupController) | {
    create(context: PopupContext): HTMLElement | PopupController;
    update?(element: HTMLElement, context: PopupContext): void;
    destroy?(element: HTMLElement, context: PopupContext): void;
  };

  interface TouchEraseBarLayoutOptions {
    placement?: Placement;
    offset?: CSSLength | { top?: CSSLength; right?: CSSLength; bottom?: CSSLength; left?: CSSLength };
    inlineInset?: CSSLength;
    align?: 'stretch' | 'start' | 'center' | 'end';
    width?: CSSLength;
    maxWidth?: CSSLength;
    borderRadius?: CSSLength;
  }

  interface TouchEraseBarOptions {
    enabled?: boolean;
    className?: string;
    bodyClassName?: string;
    mediaQuery?: string;
    ariaLabel?: string;
    requireSelection?: boolean;
    alwaysVisible?: boolean;
    labels?: { select?: string; erase?: string };
    layout?: TouchEraseBarLayoutOptions;
    theme?: Partial<Record<string, string>>;
  }

  interface Options {
    radius?: number;
    hardness?: number;
    maxAlpha?: number;
    spacing?: number;
    turbulence?: number;
    turbulenceSpeed?: number;
    color?: RGB;
    copiedColor?: RGB | null;
    copiedColorMorphSpeed?: number;
    eraseColor?: RGB;
    finalAlpha?: number;
    fadeSpeed?: number;
    finalGrowSpeed?: number;
    finalPaddingRatio?: number;
    detectTolerance?: number;
    movementThreshold?: number;
    touchActivationDistance?: number;
    touchMaxAngle?: number;
    overflowPadding?: number | null;
    externalVirtualPadding?: number;
    cursor?: string | null;
    preventSelection?: boolean;
    observeResize?: boolean;
    multiSelect?: boolean;
    preserveSelectionsOnResize?: boolean | null;
    mergeSelections?: boolean;
    allowErase?: boolean;
    strokeMergeTime?: number;
    strokeMergeTolerance?: number | null;
    strokeMergeDomGap?: number;
    includeCompleteWords?: boolean;
    continuousOnly?: boolean;
    dismissSpeed?: number;
    popupOffset?: number;
    androidChromePopupExtraOffset?: number;
    centerPopup?: boolean;
    showTextPreview?: boolean;
    hidePopupsOnSelectionStart?: boolean;
    popupRenderer?: PopupRenderer | null;
    autoClose?: boolean;
    wrapper?: string | ((text: string, context: unknown) => string) | null;
    registry?: object | null;
    popupClassName?: string;
    interactiveElements?: boolean | string | string[] | object;
    touchEraseControl?: boolean | object;
    touchEraseBar?: boolean | TouchEraseBarOptions;
    hasEraseTarget?: (() => boolean) | null;
    onErasePoint?: ((context: { clientX: number; clientY: number; phase: string }) => void) | null;
    debug?: boolean;
  }

  interface SelectionState {
    selectionCount: number;
    currentSelectionId: string;
    fragmentIndices: number[];
    fragmentCount: number;
    textPreview: string;
    bounds: DOMRectLike | null;
    copied: boolean;
    popupVisible: boolean;
    rects: DOMRectLike[];
    selections: Array<{
      id: string;
      order: number;
      textPreview: string;
      copied: boolean;
      bounds: DOMRectLike | null;
      rects: DOMRectLike[];
    }>;
  }

  interface DOMRectLike {
    x: number;
    y: number;
    width: number;
    height: number;
  }

  interface ModeController {
    setMode(mode: Mode): ModeController;
    getMode(): Mode;
    getState(): { mode: Mode; visible: boolean; enabled: boolean };
    subscribe(listener: (state: ReturnType<ModeController['getState']>) => void): () => void;
  }

  interface DefaultPopupDom {
    host: HTMLElement;
    popup: HTMLElement;
    preview: HTMLElement;
    copyButton: HTMLButtonElement;
    cancelButton: HTMLButtonElement;
  }

  interface PopupShell {
    host: HTMLElement;
    shadowRoot: ShadowRoot;
    classTokens: string[];
  }
}

export = CleanSelection;
export as namespace CleanSelection;
