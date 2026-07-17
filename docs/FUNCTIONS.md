<!--
SPDX-FileCopyrightText: 2026 kotoverse
SPDX-License-Identifier: MIT
-->

# Complete function reference

This generated inventory covers every named function, arrow function, class method, constructor, and named object method in the canonical source. Anonymous callbacks are described at their call sites rather than assigned artificial API names. Public stability is defined by [API.md](API.md); every other entry is implementation detail and may change in any release.

| Callable | Visibility | Responsibility | Location |
| --- | --- | --- | --- |
| `IS_ANDROID_CHROME(()` | Internal | Implements is android chrome behavior. | [source](../src/cleanselection.js#L104) |
| `getVisualViewportMetrics()` | Internal | Implements get visual viewport metrics behavior. | [source](../src/cleanselection.js#L115) |
| `addCssLengths(...values)` | Internal | Implements add css lengths behavior. | [source](../src/cleanselection.js#L136) |
| `getPopupClassTokens(popupClassName = '')` | Internal | Implements get popup class tokens behavior. | [source](../src/cleanselection.js#L285) |
| `applyPopupClassTokens(element, classTokens)` | Internal | Implements apply popup class tokens behavior. | [source](../src/cleanselection.js#L292) |
| `createPopupShell(popupClassName = '')` | Public | Provides create popup shell behavior. | [source](../src/cleanselection.js#L298) |
| `createDefaultPopupDom(popupClassName = '')` | Public | Provides create default popup dom behavior. | [source](../src/cleanselection.js#L316) |
| `ensureRegistryState(registryRef)` | Internal | Implements ensure registry state behavior. | [source](../src/cleanselection.js#L338) |
| `compareElementsInDom(a, b)` | Internal | Implements compare elements in dom behavior. | [source](../src/cleanselection.js#L352) |
| `getSelectionFragmentEdge(selection, edge = 'start')` | Internal | Implements get selection fragment edge behavior. | [source](../src/cleanselection.js#L363) |
| `compareSelectionsInDocument(a, b)` | Internal | Implements compare selections in document behavior. | [source](../src/cleanselection.js#L372) |
| `collectRegistrySelections(registryState, copiedOnly = false)` | Internal | Implements collect registry selections behavior. | [source](../src/cleanselection.js#L392) |
| `normalizeTouchEraseBarConfig(value)` | Internal | Implements normalize touch erase bar config behavior. | [source](../src/cleanselection.js#L410) |
| `normalizeCssLength(value, fallback)` | Internal | Implements normalize css length behavior. | [source](../src/cleanselection.js#L435) |
| `normalizeTouchEraseBarLayout(value)` | Internal | Implements normalize touch erase bar layout behavior. | [source](../src/cleanselection.js#L447) |
| `normalizeInteractiveElementRules(value)` | Internal | Implements normalize interactive element rules behavior. | [source](../src/cleanselection.js#L501) |
| `TouchEraseBarManager.constructor()` | Internal | Initializes a TouchEraseBarManager instance. | [source](../src/cleanselection.js#L543) |
| `TouchEraseBarManager.register(instance)` | Internal | Implements register behavior. | [source](../src/cleanselection.js#L571) |
| `TouchEraseBarManager.ensureHost()` | Internal | Implements ensure host behavior. | [source](../src/cleanselection.js#L577) |
| `TouchEraseBarManager.getEnabledInstances()` | Internal | Implements get enabled instances behavior. | [source](../src/cleanselection.js#L697) |
| `TouchEraseBarManager.supportsUi(config)` | Internal | Implements supports ui behavior. | [source](../src/cleanselection.js#L711) |
| `TouchEraseBarManager.getMediaQuery(queryText)` | Internal | Implements get media query behavior. | [source](../src/cleanselection.js#L716) |
| `TouchEraseBarManager.isInstanceVisible(instance)` | Internal | Implements is instance visible behavior. | [source](../src/cleanselection.js#L726) |
| `TouchEraseBarManager.hasAnyEraseTarget(instances)` | Internal | Implements has any erase target behavior. | [source](../src/cleanselection.js#L735) |
| `TouchEraseBarManager.applyConfig(config)` | Internal | Implements apply config behavior. | [source](../src/cleanselection.js#L739) |
| `TouchEraseBarManager.applyLayout(layout)` | Internal | Implements apply layout behavior. | [source](../src/cleanselection.js#L766) |
| `TouchEraseBarManager.inlineStart(value)` | Internal | Implements inline start behavior. | [source](../src/cleanselection.js#L776) |
| `TouchEraseBarManager.inlineEnd(value)` | Internal | Implements inline end behavior. | [source](../src/cleanselection.js#L777) |
| `TouchEraseBarManager.sync()` | Internal | Implements sync behavior. | [source](../src/cleanselection.js#L831) |
| `TouchEraseBarManager.requiresSelection(instances, barConfig = null)` | Internal | Implements requires selection behavior. | [source](../src/cleanselection.js#L866) |
| `TouchEraseBarManager.setVisible(visible, config, resetModeWhenHidden = true)` | Internal | Implements set visible behavior. | [source](../src/cleanselection.js#L872) |
| `TouchEraseBarManager.setMode(mode)` | Internal | Implements set mode behavior. | [source](../src/cleanselection.js#L896) |
| `TouchEraseBarManager.renderMode()` | Internal | Implements render mode behavior. | [source](../src/cleanselection.js#L908) |
| `TouchEraseBarManager.getState()` | Internal | Implements get state behavior. | [source](../src/cleanselection.js#L932) |
| `TouchEraseBarManager.subscribe(listener)` | Internal | Implements subscribe behavior. | [source](../src/cleanselection.js#L943) |
| `TouchEraseBarManager.publishState()` | Internal | Implements publish state behavior. | [source](../src/cleanselection.js#L951) |
| `TouchEraseBarManager.findTargetInstance(clientX, clientY)` | Internal | Implements find target instance behavior. | [source](../src/cleanselection.js#L966) |
| `TouchEraseBarManager.cancelPendingStarts(pointerId)` | Internal | Implements cancel pending starts behavior. | [source](../src/cleanselection.js#L1000) |
| `TouchEraseBarManager.handlePointerDown(event)` | Internal | Implements handle pointer down behavior. | [source](../src/cleanselection.js#L1012) |
| `TouchEraseBarManager.handlePointerMove(event)` | Internal | Implements handle pointer move behavior. | [source](../src/cleanselection.js#L1036) |
| `TouchEraseBarManager.handlePointerEnd(event)` | Internal | Implements handle pointer end behavior. | [source](../src/cleanselection.js#L1044) |
| `CleanSelection.attach(element, opts = {})` | Public | Provides attach behavior. | [source](../src/cleanselection.js#L1066) |
| `CleanSelection.constructor(element, opts)` | Public | Initializes a CleanSelection instance. | [source](../src/cleanselection.js#L1072) |
| `CleanSelection._setupCanvases()` | Internal | Implements setup canvases behavior. | [source](../src/cleanselection.js#L1205) |
| `CleanSelection._getConfiguredExternalPadding()` | Internal | Implements get configured external padding behavior. | [source](../src/cleanselection.js#L1265) |
| `CleanSelection._hasExternalVirtualPadding()` | Internal | Implements has external virtual padding behavior. | [source](../src/cleanselection.js#L1270) |
| `CleanSelection._getRenderPadding()` | Internal | Implements get render padding behavior. | [source](../src/cleanselection.js#L1274) |
| `CleanSelection._refreshCanvasPadding()` | Internal | Implements refresh canvas padding behavior. | [source](../src/cleanselection.js#L1281) |
| `CleanSelection._measureContentSize()` | Internal | Implements measure content size behavior. | [source](../src/cleanselection.js#L1287) |
| `CleanSelection._resizeCanvases()` | Internal | Implements resize canvases behavior. | [source](../src/cleanselection.js#L1324) |
| `CleanSelection._updateInteractionSurface()` | Internal | Implements update interaction surface behavior. | [source](../src/cleanselection.js#L1347) |
| `CleanSelection._clearFog()` | Internal | Implements clear fog behavior. | [source](../src/cleanselection.js#L1398) |
| `CleanSelection._startFogFade()` | Internal | Implements start fog fade behavior. | [source](../src/cleanselection.js#L1403) |
| `CleanSelection._getRestingUserSelectValue()` | Internal | Implements get resting user select value behavior. | [source](../src/cleanselection.js#L1417) |
| `CleanSelection._applyRestingInteractionStyles()` | Internal | Implements apply resting interaction styles behavior. | [source](../src/cleanselection.js#L1421) |
| `CleanSelection._applyCursorStyle()` | Internal | Implements apply cursor style behavior. | [source](../src/cleanselection.js#L1428) |
| `CleanSelection._setTouchEraseInputMode(active)` | Internal | Implements set touch erase input mode behavior. | [source](../src/cleanselection.js#L1445) |
| `CleanSelection._resetStrokeState()` | Internal | Implements reset stroke state behavior. | [source](../src/cleanselection.js#L1456) |
| `CleanSelection._clearSelectionState()` | Internal | Implements clear selection state behavior. | [source](../src/cleanselection.js#L1465) |
| `CleanSelection._shouldPreserveSelectionsOnResize()` | Internal | Implements should preserve selections on resize behavior. | [source](../src/cleanselection.js#L1475) |
| `CleanSelection._buildSelectionTextRuns(selection)` | Internal | Implements build selection text runs behavior. | [source](../src/cleanselection.js#L1481) |
| `CleanSelection._resolveSelectionTextRuns(runs)` | Internal | Implements resolve selection text runs behavior. | [source](../src/cleanselection.js#L1525) |
| `CleanSelection._remapSelectionReleasePoint(releasePoint, previousBounds, nextBounds)` | Internal | Implements remap selection release point behavior. | [source](../src/cleanselection.js#L1562) |
| `CleanSelection._discardSelectionAfterReflow(selection)` | Internal | Implements discard selection after reflow behavior. | [source](../src/cleanselection.js#L1578) |
| `CleanSelection._snapshotSelectionsForReflow()` | Internal | Implements snapshot selections for reflow behavior. | [source](../src/cleanselection.js#L1587) |
| `CleanSelection._restoreSelectionsAfterReflow(snapshot)` | Internal | Implements restore selections after reflow behavior. | [source](../src/cleanselection.js#L1611) |
| `CleanSelection._scheduleRefresh()` | Internal | Implements schedule refresh behavior. | [source](../src/cleanselection.js#L1675) |
| `CleanSelection._observe()` | Internal | Implements observe behavior. | [source](../src/cleanselection.js#L1702) |
| `CleanSelection.readElementSize()` | Internal | Implements read element size behavior. | [source](../src/cleanselection.js#L1703) |
| `CleanSelection.refreshForElementResize()` | Internal | Implements refresh for element resize behavior. | [source](../src/cleanselection.js#L1708) |
| `CleanSelection._segmentText(text)` | Internal | Implements segment text behavior. | [source](../src/cleanselection.js#L1736) |
| `CleanSelection._measureFragmentRect(range)` | Internal | Implements measure fragment rect behavior. | [source](../src/cleanselection.js#L1761) |
| `CleanSelection._collectFragments()` | Internal | Implements collect fragments behavior. | [source](../src/cleanselection.js#L1811) |
| `CleanSelection._isSelectableTextNode(node)` | Internal | Implements is selectable text node behavior. | [source](../src/cleanselection.js#L1865) |
| `CleanSelection._bindEvents()` | Internal | Implements bind events behavior. | [source](../src/cleanselection.js#L1893) |
| `CleanSelection._canUseErase()` | Internal | Implements can use erase behavior. | [source](../src/cleanselection.js#L1921) |
| `CleanSelection._getTouchEraseBarConfig()` | Internal | Implements get touch erase bar config behavior. | [source](../src/cleanselection.js#L1925) |
| `CleanSelection._getTouchEraseControlConfig()` | Internal | Implements get touch erase control config behavior. | [source](../src/cleanselection.js#L1931) |
| `CleanSelection._usesTouchEraseControl()` | Internal | Implements uses touch erase control behavior. | [source](../src/cleanselection.js#L1943) |
| `CleanSelection._usesExternalTouchEraseControl()` | Internal | Implements uses external touch erase control behavior. | [source](../src/cleanselection.js#L1947) |
| `CleanSelection._usesTouchEraseBar()` | Internal | Implements uses touch erase bar behavior. | [source](../src/cleanselection.js#L1951) |
| `CleanSelection._getExternalErasePointContext(event, localPoint = null, phase = 'move')` | Internal | Implements get external erase point context behavior. | [source](../src/cleanselection.js#L1955) |
| `CleanSelection._notifyExternalErasePoint(event, localPoint = null, phase = 'move')` | Internal | Implements notify external erase point behavior. | [source](../src/cleanselection.js#L1969) |
| `CleanSelection._hasAnyEraseTarget()` | Internal | Implements has any erase target behavior. | [source](../src/cleanselection.js#L1990) |
| `CleanSelection._syncTouchEraseBarRegistration()` | Internal | Implements sync touch erase bar registration behavior. | [source](../src/cleanselection.js#L2007) |
| `CleanSelection._isErasePointerEvent(event)` | Internal | Implements is erase pointer event behavior. | [source](../src/cleanselection.js#L2021) |
| `CleanSelection._isEraseMode()` | Internal | Implements is erase mode behavior. | [source](../src/cleanselection.js#L2030) |
| `CleanSelection._handleContextMenu(event)` | Internal | Implements handle context menu behavior. | [source](../src/cleanselection.js#L2034) |
| `CleanSelection._getInteractiveMatch(event)` | Internal | Implements get interactive match behavior. | [source](../src/cleanselection.js#L2049) |
| `CleanSelection._eventBelongsToElement(event, element)` | Internal | Implements event belongs to element behavior. | [source](../src/cleanselection.js#L2075) |
| `CleanSelection._handleInteractiveDragStart(event)` | Internal | Implements handle interactive drag start behavior. | [source](../src/cleanselection.js#L2085) |
| `CleanSelection._handleInteractiveClick(event)` | Internal | Implements handle interactive click behavior. | [source](../src/cleanselection.js#L2092) |
| `CleanSelection.activate()` | Internal | Implements activate behavior. | [source](../src/cleanselection.js#L2118) |
| `CleanSelection.cancel()` | Internal | Implements cancel behavior. | [source](../src/cleanselection.js#L2130) |
| `CleanSelection._start(e, allowExternalStart = false)` | Internal | Implements start behavior. | [source](../src/cleanselection.js#L2150) |
| `CleanSelection._startTouchErase(event, allowExternalStart = false)` | Internal | Implements start touch erase behavior. | [source](../src/cleanselection.js#L2198) |
| `CleanSelection.preventDefault()` | Internal | Implements prevent default behavior. | [source](../src/cleanselection.js#L2205) |
| `CleanSelection.composedPath()` | Internal | Implements composed path behavior. | [source](../src/cleanselection.js#L2206) |
| `CleanSelection._beginDrawing()` | Internal | Implements begin drawing behavior. | [source](../src/cleanselection.js#L2220) |
| `CleanSelection._getTouchIntent(point)` | Internal | Implements get touch intent behavior. | [source](../src/cleanselection.js#L2258) |
| `CleanSelection._cancelPendingPointer()` | Internal | Implements cancel pending pointer behavior. | [source](../src/cleanselection.js#L2301) |
| `CleanSelection._move(e)` | Internal | Implements move behavior. | [source](../src/cleanselection.js#L2321) |
| `CleanSelection._end(e)` | Internal | Implements end behavior. | [source](../src/cleanselection.js#L2362) |
| `CleanSelection._getContentBounds()` | Internal | Implements get content bounds behavior. | [source](../src/cleanselection.js#L2409) |
| `CleanSelection._getGestureBounds()` | Internal | Implements get gesture bounds behavior. | [source](../src/cleanselection.js#L2418) |
| `CleanSelection._isPointInsideBounds(point, bounds)` | Internal | Implements is point inside bounds behavior. | [source](../src/cleanselection.js#L2431) |
| `CleanSelection._getLocalPointFromClient(clientX, clientY)` | Internal | Implements get local point from client behavior. | [source](../src/cleanselection.js#L2442) |
| `CleanSelection._getClientRectDistance(clientX, clientY, rect)` | Internal | Implements get client rect distance behavior. | [source](../src/cleanselection.js#L2451) |
| `CleanSelection._isEventInsideAirbrushPopup(e)` | Internal | Implements is event inside airbrush popup behavior. | [source](../src/cleanselection.js#L2457) |
| `CleanSelection._containsClientPointInActualBounds(clientX, clientY)` | Internal | Implements contains client point in actual bounds behavior. | [source](../src/cleanselection.js#L2468) |
| `CleanSelection._canClaimExternalStartFromClientPoint(clientX, clientY)` | Internal | Implements can claim external start from client point behavior. | [source](../src/cleanselection.js#L2479) |
| `CleanSelection._ownsExternalStart(e)` | Internal | Implements owns external start behavior. | [source](../src/cleanselection.js#L2503) |
| `CleanSelection._getPoint(e, clamp = false, mode = 'default')` | Internal | Implements get point behavior. | [source](../src/cleanselection.js#L2556) |
| `CleanSelection._stampAlong(a, b)` | Internal | Implements stamp along behavior. | [source](../src/cleanselection.js#L2593) |
| `CleanSelection._stamp(x, y)` | Internal | Implements stamp behavior. | [source](../src/cleanselection.js#L2615) |
| `CleanSelection._detect(x, y)` | Internal | Implements detect behavior. | [source](../src/cleanselection.js#L2647) |
| `CleanSelection._finalizeSelection()` | Internal | Implements finalize selection behavior. | [source](../src/cleanselection.js#L2675) |
| `CleanSelection._normalizeErasedFragments(validFragments)` | Internal | Implements normalize erased fragments behavior. | [source](../src/cleanselection.js#L2739) |
| `CleanSelection.flushRun()` | Internal | Implements flush run behavior. | [source](../src/cleanselection.js#L2749) |
| `CleanSelection._computeLargestFragment()` | Internal | Implements compute largest fragment behavior. | [source](../src/cleanselection.js#L2785) |
| `CleanSelection._getFragmentScore(index)` | Internal | Implements get fragment score behavior. | [source](../src/cleanselection.js#L2798) |
| `CleanSelection._getFragmentDistanceToPoint(index, point)` | Internal | Implements get fragment distance to point behavior. | [source](../src/cleanselection.js#L2802) |
| `CleanSelection._extendStrokeBounds(x, y, radius)` | Internal | Implements extend stroke bounds behavior. | [source](../src/cleanselection.js#L2811) |
| `CleanSelection._getFogGeometrySnapshot()` | Internal | Implements get fog geometry snapshot behavior. | [source](../src/cleanselection.js#L2835) |
| `CleanSelection._getFogSnapshotAlpha(snapshot, x, y)` | Internal | Implements get fog snapshot alpha behavior. | [source](../src/cleanselection.js#L2868) |
| `CleanSelection._getLineResolverProfile()` | Internal | Implements get line resolver profile behavior. | [source](../src/cleanselection.js#L2961) |
| `CleanSelection._groupSortedIndicesByVisualLine(indices)` | Internal | Implements group sorted indices by visual line behavior. | [source](../src/cleanselection.js#L3055) |
| `CleanSelection._resolveTouchAnchoredFragmentSpan(indices)` | Internal | Implements resolve touch anchored fragment span behavior. | [source](../src/cleanselection.js#L3244) |
| `CleanSelection._selectLongestContinuousFragmentRun(validFragments)` | Internal | Implements select longest continuous fragment run behavior. | [source](../src/cleanselection.js#L3269) |
| `CleanSelection._normalizeSelectionContinuity(validFragments)` | Internal | Implements normalize selection continuity behavior. | [source](../src/cleanselection.js#L3312) |
| `CleanSelection._pickClosestAnchorIndex(point, indices)` | Internal | Implements pick closest anchor index behavior. | [source](../src/cleanselection.js#L3320) |
| `CleanSelection._pickAnchorIndex(point, indices)` | Internal | Implements pick anchor index behavior. | [source](../src/cleanselection.js#L3341) |
| `CleanSelection._resolveCoveredFragmentSpan(indices)` | Internal | Implements resolve covered fragment span behavior. | [source](../src/cleanselection.js#L3369) |
| `CleanSelection._buildFinalRects(fragments)` | Internal | Implements build final rects behavior. | [source](../src/cleanselection.js#L3394) |
| `CleanSelection._buildFinalStamps(fragments)` | Internal | Implements build final stamps behavior. | [source](../src/cleanselection.js#L3430) |
| `CleanSelection._normalizeRect(rect)` | Internal | Implements normalize rect behavior. | [source](../src/cleanselection.js#L3493) |
| `CleanSelection._buildPreviewText(validFragments)` | Internal | Implements build preview text behavior. | [source](../src/cleanselection.js#L3509) |
| `CleanSelection._isWordCoreText(text)` | Internal | Implements is word core text behavior. | [source](../src/cleanselection.js#L3549) |
| `CleanSelection._isWhitespaceText(text)` | Internal | Implements is whitespace text behavior. | [source](../src/cleanselection.js#L3563) |
| `CleanSelection._isSameVisualLineIndex(leftIndex, rightIndex)` | Internal | Implements is same visual line index behavior. | [source](../src/cleanselection.js#L3567) |
| `CleanSelection._isWordJoinerIndex(index)` | Internal | Implements is word joiner index behavior. | [source](../src/cleanselection.js#L3578) |
| `CleanSelection._isWordLikeIndex(index)` | Internal | Implements is word like index behavior. | [source](../src/cleanselection.js#L3597) |
| `CleanSelection._expandSelectionToWholeWords(start, end)` | Internal | Implements expand selection to whole words behavior. | [source](../src/cleanselection.js#L3604) |
| `CleanSelection._countSymmetricPairInRange(char, start, end)` | Internal | Implements count symmetric pair in range behavior. | [source](../src/cleanselection.js#L3634) |
| `CleanSelection._countAsymmetricPairBalance(open, close, start, end)` | Internal | Implements count asymmetric pair balance behavior. | [source](../src/cleanselection.js#L3649) |
| `CleanSelection._shouldIncludeLeadingPair(index, start, end)` | Internal | Implements should include leading pair behavior. | [source](../src/cleanselection.js#L3666) |
| `CleanSelection._shouldIncludeTrailingPair(index, start, end)` | Internal | Implements should include trailing pair behavior. | [source](../src/cleanselection.js#L3680) |
| `CleanSelection._expandSelectionWithPairs(start, end)` | Internal | Implements expand selection with pairs behavior. | [source](../src/cleanselection.js#L3694) |
| `CleanSelection._trimDetachedEdgeFragment(start, end, direction)` | Internal | Implements trim detached edge fragment behavior. | [source](../src/cleanselection.js#L3723) |
| `CleanSelection._trimDetachedEdgePunctuation(start, end)` | Internal | Implements trim detached edge punctuation behavior. | [source](../src/cleanselection.js#L3770) |
| `CleanSelection._expandFinalFragments(validFragments)` | Internal | Implements expand final fragments behavior. | [source](../src/cleanselection.js#L3780) |
| `CleanSelection._buildSelectionBounds(rects)` | Internal | Implements build selection bounds behavior. | [source](../src/cleanselection.js#L3836) |
| `CleanSelection._buildSelectionState(validFragments, finalRects)` | Internal | Implements build selection state behavior. | [source](../src/cleanselection.js#L3864) |
| `CleanSelection._compareLocalSelections(a, b)` | Internal | Implements compare local selections behavior. | [source](../src/cleanselection.js#L3887) |
| `CleanSelection._broadcastRegistryUpdate()` | Internal | Implements broadcast registry update behavior. | [source](../src/cleanselection.js#L3891) |
| `CleanSelection._syncRegistrySelections()` | Internal | Implements sync registry selections behavior. | [source](../src/cleanselection.js#L3904) |
| `CleanSelection._setSelectionCopied(selection, copied)` | Internal | Implements set selection copied behavior. | [source](../src/cleanselection.js#L3925) |
| `CleanSelection._buildPopupContext(selection)` | Internal | Implements build popup context behavior. | [source](../src/cleanselection.js#L3939) |
| `CleanSelection._createDefaultPopupController(selection)` | Internal | Implements create default popup controller behavior. | [source](../src/cleanselection.js#L3970) |
| `CleanSelection._normalizeCustomPopupController(selection, popupRenderer, controllerCandidate)` | Internal | Implements normalize custom popup controller behavior. | [source](../src/cleanselection.js#L4006) |
| `controller.update(context)` | Internal | Implements controller.update behavior. | [source](../src/cleanselection.js#L4017) |
| `controller.destroy(context)` | Internal | Implements controller.destroy behavior. | [source](../src/cleanselection.js#L4021) |
| `CleanSelection._resolvePopupController(selection)` | Internal | Implements resolve popup controller behavior. | [source](../src/cleanselection.js#L4032) |
| `CleanSelection._createSelectionPopup(selection)` | Internal | Implements create selection popup behavior. | [source](../src/cleanselection.js#L4060) |
| `CleanSelection._destroySelectionPopup(selection)` | Internal | Implements destroy selection popup behavior. | [source](../src/cleanselection.js#L4078) |
| `CleanSelection._createSelectionRecord(validFragments, order = null)` | Internal | Implements create selection record behavior. | [source](../src/cleanselection.js#L4105) |
| `CleanSelection._updateSelectionRecord(selection, validFragments)` | Internal | Implements update selection record behavior. | [source](../src/cleanselection.js#L4148) |
| `CleanSelection._findSelectionById(selectionId)` | Internal | Implements find selection by id behavior. | [source](../src/cleanselection.js#L4172) |
| `CleanSelection._getSelectionPageBounds(selection)` | Internal | Implements get selection page bounds behavior. | [source](../src/cleanselection.js#L4177) |
| `CleanSelection._isPageRectVisible(bounds)` | Internal | Implements is page rect visible behavior. | [source](../src/cleanselection.js#L4197) |
| `CleanSelection._getReleasePagePoint(selection)` | Internal | Implements get release page point behavior. | [source](../src/cleanselection.js#L4215) |
| `CleanSelection._getPopupOffsetGap()` | Internal | Implements get popup offset gap behavior. | [source](../src/cleanselection.js#L4226) |
| `CleanSelection._positionAllPopups()` | Internal | Implements position all popups behavior. | [source](../src/cleanselection.js#L4233) |
| `CleanSelection._positionPopup(selection)` | Internal | Implements position popup behavior. | [source](../src/cleanselection.js#L4239) |
| `CleanSelection._resolvePopupPlacement(selection, bounds, popupWidth, popupHeight)` | Internal | Implements resolve popup placement behavior. | [source](../src/cleanselection.js#L4267) |
| `CleanSelection.clamp(value, min, max)` | Internal | Implements clamp behavior. | [source](../src/cleanselection.js#L4281) |
| `CleanSelection.fits(position)` | Internal | Implements fits behavior. | [source](../src/cleanselection.js#L4323) |
| `CleanSelection._hasCopiedSelectionsInScope()` | Internal | Implements has copied selections in scope behavior. | [source](../src/cleanselection.js#L4360) |
| `CleanSelection._getCopyButtonLabel(selection)` | Internal | Implements get copy button label behavior. | [source](../src/cleanselection.js#L4368) |
| `CleanSelection._getPopupDelay()` | Internal | Implements get popup delay behavior. | [source](../src/cleanselection.js#L4375) |
| `CleanSelection._clearPopupTimer(selection)` | Internal | Implements clear popup timer behavior. | [source](../src/cleanselection.js#L4380) |
| `CleanSelection._schedulePopup(selection)` | Internal | Implements schedule popup behavior. | [source](../src/cleanselection.js#L4391) |
| `CleanSelection.revealWhenIdle()` | Internal | Implements reveal when idle behavior. | [source](../src/cleanselection.js#L4406) |
| `CleanSelection._showPopup(selection)` | Internal | Implements show popup behavior. | [source](../src/cleanselection.js#L4426) |
| `CleanSelection._hidePopup(selection)` | Internal | Implements hide popup behavior. | [source](../src/cleanselection.js#L4443) |
| `CleanSelection._hideAllPopups({ exceptSelection = null, cancelPending = false } = {})` | Internal | Implements hide all popups behavior. | [source](../src/cleanselection.js#L4449) |
| `CleanSelection._syncPopupState(selection)` | Internal | Implements sync popup state behavior. | [source](../src/cleanselection.js#L4467) |
| `CleanSelection._syncAllPopupStates()` | Internal | Implements sync all popup states behavior. | [source](../src/cleanselection.js#L4485) |
| `CleanSelection._rectDistance(rectA, rectB)` | Internal | Implements rect distance behavior. | [source](../src/cleanselection.js#L4491) |
| `CleanSelection._distanceBetweenRectSets(rectsA, rectsB)` | Internal | Implements distance between rect sets behavior. | [source](../src/cleanselection.js#L4500) |
| `CleanSelection._getStrokeMergeTolerance()` | Internal | Implements get stroke merge tolerance behavior. | [source](../src/cleanselection.js#L4512) |
| `CleanSelection._getStrokeMergeDomGap()` | Internal | Implements get stroke merge dom gap behavior. | [source](../src/cleanselection.js#L4516) |
| `CleanSelection._getFragmentRangeFromIndices(indices)` | Internal | Implements get fragment range from indices behavior. | [source](../src/cleanselection.js#L4520) |
| `CleanSelection._getFragmentRangeFromFragments(fragments)` | Internal | Implements get fragment range from fragments behavior. | [source](../src/cleanselection.js#L4529) |
| `CleanSelection._getFragmentRangeGap(rangeA, rangeB)` | Internal | Implements get fragment range gap behavior. | [source](../src/cleanselection.js#L4538) |
| `CleanSelection._hasWhitespaceOnlyBridge(rangeA, rangeB)` | Internal | Implements has whitespace only bridge behavior. | [source](../src/cleanselection.js#L4545) |
| `CleanSelection._findMergeTarget(candidateRects, validFragments = [])` | Internal | Implements find merge target behavior. | [source](../src/cleanselection.js#L4565) |
| `CleanSelection._findEraseTargets(eraseIndices)` | Internal | Implements find erase targets behavior. | [source](../src/cleanselection.js#L4626) |
| `CleanSelection._subtractSelectionFragments(selection, eraseIndices)` | Internal | Implements subtract selection fragments behavior. | [source](../src/cleanselection.js#L4637) |
| `CleanSelection._finalizeEraseSelection(validFragments)` | Internal | Implements finalize erase selection behavior. | [source](../src/cleanselection.js#L4652) |
| `CleanSelection._mergeSelectionFragments(selection, validFragments)` | Internal | Implements merge selection fragments behavior. | [source](../src/cleanselection.js#L4692) |
| `CleanSelection._addSelection(selection)` | Internal | Implements add selection behavior. | [source](../src/cleanselection.js#L4714) |
| `CleanSelection._removeSelection(selection)` | Internal | Implements remove selection behavior. | [source](../src/cleanselection.js#L4723) |
| `CleanSelection._dismissSelection(selection)` | Internal | Implements dismiss selection behavior. | [source](../src/cleanselection.js#L4740) |
| `CleanSelection._dismissAllSelections()` | Internal | Implements dismiss all selections behavior. | [source](../src/cleanselection.js#L4759) |
| `CleanSelection._dismissOtherSelections(exceptSelection)` | Internal | Implements dismiss other selections behavior. | [source](../src/cleanselection.js#L4765) |
| `CleanSelection._getLocalSelections(copiedOnly = false)` | Internal | Implements get local selections behavior. | [source](../src/cleanselection.js#L4773) |
| `CleanSelection._getWrapperConfig(selectionCount)` | Internal | Implements get wrapper config behavior. | [source](../src/cleanselection.js#L4781) |
| `CleanSelection._applyWrapper(text, wrapper)` | Internal | Implements apply wrapper behavior. | [source](../src/cleanselection.js#L4807) |
| `CleanSelection._buildClipboardText(selections)` | Internal | Implements build clipboard text behavior. | [source](../src/cleanselection.js#L4811) |
| `CleanSelection._writeClipboardText(text)` | Internal | Implements write clipboard text behavior. | [source](../src/cleanselection.js#L4820) |
| `CleanSelection.fallbackCopy()` | Internal | Implements fallback copy behavior. | [source](../src/cleanselection.js#L4821) |
| `CleanSelection.copySelection(selectionId = this.currentSelection?.id)` | Internal | Implements copy selection behavior. | [source](../src/cleanselection.js#L4880) |
| `CleanSelection._getSelectionsInScope(copiedOnly = false)` | Internal | Implements get selections in scope behavior. | [source](../src/cleanselection.js#L4920) |
| `CleanSelection._getSelectionOwner(selection)` | Internal | Implements get selection owner behavior. | [source](../src/cleanselection.js#L4926) |
| `CleanSelection.copyAllSelections()` | Internal | Implements copy all selections behavior. | [source](../src/cleanselection.js#L4930) |
| `CleanSelection.clearAllSelections()` | Public | Provides clear all selections behavior. | [source](../src/cleanselection.js#L4971) |
| `CleanSelection.cancelSelection(selectionId = this.currentSelection?.id)` | Public | Provides cancel selection behavior. | [source](../src/cleanselection.js#L4979) |
| `CleanSelection.destroy()` | Public | Provides destroy behavior. | [source](../src/cleanselection.js#L4989) |
| `CleanSelection.updateOptions(nextOpts = {})` | Public | Provides update options behavior. | [source](../src/cleanselection.js#L5047) |
| `CleanSelection.getSelectionState()` | Public | Provides get selection state behavior. | [source](../src/cleanselection.js#L5072) |
| `CleanSelection._render()` | Internal | Implements render behavior. | [source](../src/cleanselection.js#L5105) |
| `CleanSelection._drawFinalSelection(selection)` | Internal | Implements draw final selection behavior. | [source](../src/cleanselection.js#L5171) |
| `CleanSelection._sprayFinalCloud(ctx, stamps, { scale, expansion, alpha, edge, color })` | Internal | Implements spray final cloud behavior. | [source](../src/cleanselection.js#L5195) |
| `CleanSelection._getSelectionRenderColor(selection)` | Internal | Implements get selection render color behavior. | [source](../src/cleanselection.js#L5213) |
| `CleanSelection._signedNoise(a, b, c)` | Internal | Implements signed noise behavior. | [source](../src/cleanselection.js#L5225) |
| `CleanSelection._getActiveBrushColor()` | Internal | Implements get active brush color behavior. | [source](../src/cleanselection.js#L5230) |
| `CleanSelection._rgba(a, color = this.opts.color)` | Internal | Implements rgba behavior. | [source](../src/cleanselection.js#L5234) |
| `getTouchEraseModeManager()` | Internal | Implements get touch erase mode manager behavior. | [source](../src/cleanselection.js#L5240) |
| `object.setMode(mode)` | Public | Provides set mode behavior. | [source](../src/cleanselection.js#L5249) |
| `object.getMode()` | Public | Provides get mode behavior. | [source](../src/cleanselection.js#L5254) |
| `object.getState()` | Public | Provides get state behavior. | [source](../src/cleanselection.js#L5258) |
| `object.subscribe(listener)` | Public | Provides subscribe behavior. | [source](../src/cleanselection.js#L5262) |
| `CleanSelection.getModeController()` | Public | Provides clean selection.get mode controller behavior. | [source](../src/cleanselection.js#L5277) |

Total documented named callables: **234**.
