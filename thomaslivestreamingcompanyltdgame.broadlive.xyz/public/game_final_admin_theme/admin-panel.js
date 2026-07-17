(function () {
    'use strict';

    function ready(fn) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', fn, { once: true });
            return;
        }
        fn();
    }

        function escapeHtml(value) {
            return String(value == null ? '' : value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function looksBrokenText(value) {
            return /à¦|Ã|�/.test(String(value || ''));
        }

        function safeUiText(value, fallback) {
            var text = String(value == null ? '' : value).trim();
            if (!text || looksBrokenText(text)) {
                return fallback;
            }
            return text;
        }

    function isSameOriginUrl(url) {
        try {
            return new URL(url, window.location.href).origin === window.location.origin;
        } catch (error) {
            return false;
        }
    }

    function isAjaxEligibleUrl(url) {
        try {
            var parsed = new URL(url, window.location.href);
            return parsed.origin === window.location.origin && parsed.pathname.indexOf('/admin') === 0;
        } catch (error) {
            return false;
        }
    }

    ready(function () {
        var toastStack = document.querySelector('[data-toast-stack]');
        var confirmModal = document.querySelector('[data-confirm-modal]');
        var confirmMessage = confirmModal ? confirmModal.querySelector('[data-confirm-message]') : null;
        var confirmWarning = confirmModal ? confirmModal.querySelector('[data-confirm-warning]') : null;
        var confirmAccept = confirmModal ? confirmModal.querySelector('[data-confirm-accept]') : null;
        var confirmCancel = confirmModal ? confirmModal.querySelector('[data-confirm-cancel]') : null;
        var pendingAction = null;
        var tourOverlay = null;
        var tooltipNode = null;
        var monitorTimer = null;
        var toastQueueKey = 'game-final-admin:toast-queue';

        function showToast(type, title, message, timeout) {
            if (!toastStack) {
                return;
            }

            var item = document.createElement('div');
            item.className = 'toast ' + (type || 'info');
            item.innerHTML = '<div><strong>' + escapeHtml(title || 'Notice') + '</strong><p>' + escapeHtml(message || '') + '</p></div><button type="button" aria-label="Close notification">×</button>';
            toastStack.appendChild(item);

            var close = function () {
                if (item.parentNode) {
                    item.parentNode.removeChild(item);
                }
            };

            item.querySelector('button').addEventListener('click', close);
            window.setTimeout(close, timeout || 4200);
        }

        function stripHtml(value) {
            var node = document.createElement('div');
            node.innerHTML = String(value == null ? '' : value);
            return String(node.textContent || node.innerText || '').trim();
        }

        function readToastQueue() {
            try {
                var raw = window.sessionStorage ? window.sessionStorage.getItem(toastQueueKey) : '';
                var parsed = raw ? JSON.parse(raw) : [];
                return Array.isArray(parsed) ? parsed : [];
            } catch (error) {
                return [];
            }
        }

        function writeToastQueue(items) {
            if (!window.sessionStorage) {
                return;
            }

            try {
                if (!items.length) {
                    window.sessionStorage.removeItem(toastQueueKey);
                    return;
                }

                window.sessionStorage.setItem(toastQueueKey, JSON.stringify(items));
            } catch (error) {}
        }

        function queueToast(type, title, message, timeout) {
            var items = readToastQueue();
            items.push({
                type: type || 'info',
                title: title || 'Notice',
                message: message || '',
                timeout: timeout || 4200
            });
            writeToastQueue(items);
        }

        function flushQueuedToasts() {
            var items = readToastQueue();
            if (!items.length) {
                return;
            }

            writeToastQueue([]);
            items.forEach(function (item) {
                showToast(item.type, item.title, item.message, item.timeout);
            });
        }

        function responseContentType(response) {
            return String(response && response.headers ? (response.headers.get('content-type') || '') : '').toLowerCase();
        }

        function looksLikeJsonText(text) {
            var trimmed = String(text || '').trim();
            return trimmed.charAt(0) === '{' || trimmed.charAt(0) === '[';
        }

        function parseJsonText(text) {
            try {
                return JSON.parse(text);
            } catch (error) {
                return null;
            }
        }

        function defaultToastTitle(type, response) {
            if (type === 'success') {
                return 'Saved';
            }

            if (response && response.status === 422) {
                return 'Validation error';
            }

            if (response && response.status === 419) {
                return 'Session expired';
            }

            if (response && response.status === 403) {
                return 'Access denied';
            }

            return 'Request failed';
        }

        function defaultResponseMessage(response) {
            if (!response) {
                return 'The admin request could not be completed.';
            }

            if (response.status === 422) {
                return 'Please review the fields and try again.';
            }

            if (response.status === 419) {
                return 'Your admin session expired. Reload and try again.';
            }

            if (response.status === 403) {
                return 'You do not have permission to complete this action.';
            }

            if (response.status >= 500) {
                return 'The server returned an unexpected error.';
            }

            return response.ok
                ? 'The admin action completed successfully.'
                : 'The admin request could not be completed.';
        }

        function pushUniqueToast(messages, type, title, message) {
            var cleanMessage = stripHtml(message);
            if (!cleanMessage) {
                return;
            }

            var exists = messages.some(function (item) {
                return item.type === type && item.title === title && item.message === cleanMessage;
            });

            if (!exists) {
                messages.push({
                    type: type,
                    title: title,
                    message: cleanMessage
                });
            }
        }

        function extractJsonToasts(payload, response) {
            var messages = [];
            var type = response && response.ok ? 'success' : 'error';
            var title = defaultToastTitle(type, response);
            var errorCount = 0;
            var hasSummaryMessage = false;

            if (payload && typeof payload === 'object') {
                if (typeof payload.message === 'string') {
                    hasSummaryMessage = stripHtml(payload.message) !== '';
                    pushUniqueToast(messages, type, title, payload.message);
                }

                if (payload.errors && typeof payload.errors === 'object') {
                    Object.keys(payload.errors).forEach(function (key) {
                        var fieldErrors = payload.errors[key];
                        if (Array.isArray(fieldErrors)) {
                            errorCount += fieldErrors.length;
                        } else if (fieldErrors) {
                            errorCount += 1;
                        }
                    });

                    if (!hasSummaryMessage) {
                        var shown = 0;
                        Object.keys(payload.errors).forEach(function (key) {
                            if (shown >= 3) {
                                return;
                            }
                            var fieldErrors = payload.errors[key];
                            if (Array.isArray(fieldErrors)) {
                                fieldErrors.forEach(function (entry) {
                                    if (shown >= 3) {
                                        return;
                                    }
                                    pushUniqueToast(messages, 'error', 'Validation error', entry);
                                    shown += 1;
                                });
                            } else if (fieldErrors && shown < 3) {
                                pushUniqueToast(messages, 'error', 'Validation error', fieldErrors);
                                shown += 1;
                            }
                        });

                        if (errorCount > 3) {
                            pushUniqueToast(messages, 'error', 'Validation error', 'There are ' + String(errorCount) + ' validation errors in this save request.');
                        }
                    }
                }

                if (typeof payload.error === 'string') {
                    pushUniqueToast(messages, 'error', 'Request failed', payload.error);
                }
            }

            if (!messages.length) {
                pushUniqueToast(messages, type, title, defaultResponseMessage(response));
            }

            return messages;
        }

        function upgradeFlashMessagesToToasts() {
            document.querySelectorAll('.notice.status, .notice.warning, .notice.error, .notice.info, .alert.status, .alert.error, .error-text').forEach(function (node) {
                if (!node || node.hidden || node.getAttribute('data-toast-upgraded') === '1' || node.closest('[data-confirm-modal]')) {
                    return;
                }

                var type = 'info';
                if (node.classList.contains('status')) {
                    type = 'success';
                } else if (node.classList.contains('warning')) {
                    type = 'warning';
                } else if (node.classList.contains('error') || node.classList.contains('error-text')) {
                    type = 'error';
                }

                var strong = node.querySelector('strong');
                var title = strong ? stripHtml(strong.textContent) : defaultToastTitle(type === 'success' ? 'success' : type, null);
                var message = strong ? stripHtml(node.textContent.replace(strong.textContent, '')) : stripHtml(node.textContent);
                if (!message) {
                    message = title;
                    title = defaultToastTitle(type === 'success' ? 'success' : type, null);
                }

                node.setAttribute('data-toast-upgraded', '1');
                showToast(type, title, message);
                node.style.display = 'none';
            });
        }

        async function handleJsonAdminResponse(response, bodyText, targetUrl, options) {
            var payload = parseJsonText(bodyText) || {};
            var messages = extractJsonToasts(payload, response);
            var finalUrl = response.url || targetUrl || window.location.href;
            var reloadUrl = options && options.reloadUrl ? options.reloadUrl : window.location.href;

            if (response.ok) {
                messages.forEach(function (item) {
                    queueToast(item.type, item.title, item.message);
                });

                if ((options && options.method) === 'GET') {
                    window.location.href = finalUrl;
                    return;
                }

                if (reloadUrl && isAjaxEligibleUrl(reloadUrl)) {
                    await loadDocument(reloadUrl, {
                        historyMode: 'replace'
                    });
                    return;
                }

                window.location.href = finalUrl;
                return;
            }

            messages.forEach(function (item) {
                showToast(item.type, item.title, item.message, 5600);
            });

            if (response.status === 401 || response.status === 403 || response.status === 419) {
                window.setTimeout(function () {
                    window.location.href = finalUrl;
                }, 200);
            }
        }

        window.GameFinalAdminToast = { show: showToast };
        flushQueuedToasts();
        upgradeFlashMessagesToToasts();

        function openConfirm(options) {
            if (!confirmModal || !confirmMessage || !confirmAccept) {
                return false;
            }

            pendingAction = options.onAccept || null;
            confirmMessage.textContent = options.message || 'Please confirm this action.';
            confirmAccept.textContent = options.confirmLabel || 'Continue';

            if (confirmWarning) {
                if (options.warning) {
                    confirmWarning.hidden = false;
                    confirmWarning.textContent = options.warning;
                } else {
                    confirmWarning.hidden = true;
                    confirmWarning.textContent = '';
                }
            }

            confirmModal.showModal();
            return true;
        }

        if (confirmAccept) {
            confirmAccept.addEventListener('click', function () {
                var action = pendingAction;
                pendingAction = null;
                confirmModal.close();
                if (typeof action === 'function') {
                    action();
                }
            });
        }

        if (confirmCancel) {
            confirmCancel.addEventListener('click', function () {
                pendingAction = null;
                confirmModal.close();
            });
        }

        if (confirmModal) {
            confirmModal.addEventListener('cancel', function () {
                pendingAction = null;
            });
        }

        async function loadDocument(url, options) {
            options = options || {};
            var targetUrl = url || window.location.href;
            var method = String(options.method || 'GET').toUpperCase();
            var fetchOptions = {
                method: method,
                credentials: 'same-origin',
                headers: {
                    'Accept': 'text/html, application/xhtml+xml',
                    'X-Admin-App': '1'
                }
            };

            if (options.body) {
                fetchOptions.body = options.body;
            }

            if (options.headers) {
                Object.keys(options.headers).forEach(function (key) {
                    fetchOptions.headers[key] = options.headers[key];
                });
            }

            document.body.classList.add('admin-app-loading');

            try {
                var response = await fetch(targetUrl, fetchOptions);
                var bodyText = await response.text();
                var finalUrl = response.url || targetUrl;
                var contentType = responseContentType(response);

                if (contentType.indexOf('json') !== -1 || looksLikeJsonText(bodyText)) {
                    await handleJsonAdminResponse(response, bodyText, targetUrl, {
                        method: method,
                        historyMode: options.historyMode || 'replace',
                        reloadUrl: options.reloadUrl || window.location.href
                    });
                    return;
                }

                if (options.historyMode === 'push') {
                    window.history.pushState({}, '', finalUrl);
                } else if (options.historyMode === 'replace') {
                    window.history.replaceState({}, '', finalUrl);
                }

                document.open();
                document.write(bodyText);
                document.close();
            } catch (error) {
                window.location.href = targetUrl;
            }
        }

        function submitFormAjax(form) {
            var method = String(form.getAttribute('method') || 'GET').toUpperCase();
            var action = form.getAttribute('action') || window.location.href;
            var formData = new FormData(form);

            if (method === 'GET') {
                var params = new URLSearchParams();
                formData.forEach(function (value, key) {
                    params.append(key, value);
                });
                var joiner = action.indexOf('?') === -1 ? '?' : '&';
                return loadDocument(action + (String(params) ? joiner + params.toString() : ''), { historyMode: 'push' });
            }

            return loadDocument(action, {
                method: method,
                body: formData,
                historyMode: 'replace',
                reloadUrl: window.location.href
            });
        }

        window.GameFinalAdminApp = {
            navigate: function (url, replace) {
                return loadDocument(url, { historyMode: replace ? 'replace' : 'push' });
            },
            submit: submitFormAjax,
            confirm: openConfirm
        };

        document.querySelectorAll('[data-fast-find-input]').forEach(function (input) {
            var targetSelector = input.getAttribute('data-fast-find-input');
            var target = document.querySelector(targetSelector);
            if (!target) {
                return;
            }

            var rows = Array.prototype.slice.call(target.querySelectorAll('tbody tr'));
            var emptyRow = target.querySelector('[data-empty-row]');

            input.addEventListener('input', function () {
                var term = input.value.toLowerCase().trim();
                var visible = 0;

                rows.forEach(function (row) {
                    if (row === emptyRow) {
                        return;
                    }

                    var haystack = row.innerText.toLowerCase();
                    var match = term === '' || haystack.indexOf(term) !== -1;
                    row.style.display = match ? '' : 'none';
                    if (match) {
                        visible += 1;
                    }
                });

                if (emptyRow) {
                    emptyRow.style.display = visible === 0 ? '' : 'none';
                    emptyRow.classList.toggle('hidden-by-search', visible !== 0);
                }
            });
        });

        document.querySelectorAll('[data-row-link]').forEach(function (row) {
            row.addEventListener('click', function (event) {
                if (event.target.closest('a,button,input,select,textarea,label,form')) {
                    return;
                }

                var href = row.getAttribute('data-row-link');
                if (!href) {
                    return;
                }

                if (isAjaxEligibleUrl(href)) {
                    loadDocument(href, { historyMode: 'push' });
                    return;
                }

                window.location.href = href;
            });
        });

        document.querySelectorAll('[data-notice]').forEach(function (node) {
            node.addEventListener('click', function () {
                showToast(node.getAttribute('data-notice-type') || 'info', 'Notice', node.getAttribute('data-notice') || 'Action is not available right now.');
            });
        });

        document.addEventListener('click', function (event) {
            var anchor = event.target.closest('a[href]');
            if (!anchor || anchor.hasAttribute('download') || anchor.getAttribute('target') === '_blank' || anchor.getAttribute('data-no-ajax') === '1') {
                return;
            }

            var href = anchor.getAttribute('href');
            if (!href || href.indexOf('mailto:') === 0 || href.indexOf('tel:') === 0 || href.charAt(0) === '#') {
                return;
            }

            if (!isAjaxEligibleUrl(href)) {
                return;
            }

            event.preventDefault();
            loadDocument(href, { historyMode: 'push' });
        });

        document.addEventListener('submit', function (event) {
            var form = event.target;
            if (!(form instanceof HTMLFormElement) || form.getAttribute('data-no-ajax') === '1') {
                return;
            }

            var action = form.getAttribute('action') || window.location.href;
            if (!isAjaxEligibleUrl(action)) {
                return;
            }

            var confirmMessageText = form.getAttribute('data-confirm');
            if (confirmMessageText && form.getAttribute('data-confirmed') !== '1') {
                event.preventDefault();
                openConfirm({
                    message: confirmMessageText,
                    warning: form.getAttribute('data-confirm-warning') || '',
                    confirmLabel: form.getAttribute('data-confirm-label') || 'Continue',
                    onAccept: function () {
                        form.setAttribute('data-confirmed', '1');
                        submitFormAjax(form);
                    }
                });
                return;
            }

            form.removeAttribute('data-confirmed');
            event.preventDefault();
            submitFormAjax(form);
        }, true);

        document.querySelectorAll('[data-confirm]').forEach(function (node) {
            if (node.tagName === 'FORM') {
                return;
            }
            node.addEventListener('click', function (event) {
                event.preventDefault();
                openConfirm({
                    message: node.getAttribute('data-confirm') || 'Please confirm this action.',
                    warning: node.getAttribute('data-confirm-warning') || '',
                    confirmLabel: node.getAttribute('data-confirm-label') || 'Continue',
                    onAccept: function () {
                        if (node.tagName === 'A' && node.href) {
                            if (isAjaxEligibleUrl(node.href)) {
                                loadDocument(node.href, { historyMode: 'push' });
                            } else {
                                window.location.href = node.href;
                            }
                            return;
                        }

                        var form = node.closest('form');
                        if (form) {
                            submitFormAjax(form);
                        }
                    }
                });
            });
        });

        var lobbyForm = document.getElementById('lobby-control');
        if (lobbyForm) {
            lobbyForm.addEventListener('submit', function (event) {
                var realtimeMode = document.querySelector('[data-realtime-mode]');
                var pollInput = document.querySelector('input[name="poll_interval_ms"]');
                var invalidPayout = lobbyForm.querySelector('input[name*="[payout_multiplier]"]:invalid');
                var completePusherCount = document.querySelector('[data-pusher-complete-count]');
                var redisEnabled = document.querySelector('input[name="redis_enabled"]');
                var developerModes = Array.prototype.slice.call(lobbyForm.querySelectorAll('[data-game-mode]')).filter(function (field) {
                    return field.value === 'developer';
                });
                var maintenanceModes = Array.prototype.slice.call(lobbyForm.querySelectorAll('[data-game-mode]')).filter(function (field) {
                    return field.value === 'maintenance';
                });
                var invalidDeveloperField = developerModes.find(function (field) {
                    var row = field.closest('[data-game-row]');
                    var output = row ? row.querySelector('[data-developer-id-output]') : null;
                    return !output || String(output.value || '').trim() === '';
                });

                if (pollInput) {
                    var pollValue = parseInt(pollInput.value, 10);
                    if (isNaN(pollValue) || pollValue < 500 || pollValue > 10000) {
                        event.preventDefault();
                        pollInput.focus();
                        showToast('error', 'Invalid poll interval', 'Polling interval must be between 500 and 10000 milliseconds.');
                        return;
                    }
                }

                if (invalidPayout) {
                    event.preventDefault();
                    invalidPayout.focus();
                    showToast('error', 'Invalid payout value', 'Every board payout must be filled with a valid positive number.');
                    return;
                }

                if (invalidDeveloperField) {
                    event.preventDefault();
                    invalidDeveloperField.focus();
                    showToast('error', 'Developer IDs required', 'Add at least one approved user ID before saving developer mode.');
                    return;
                }

                if (realtimeMode && realtimeMode.value === 'pusher' && completePusherCount && parseInt(completePusherCount.textContent || '0', 10) < 1) {
                    event.preventDefault();
                    showToast('error', 'Pusher configuration required', 'Select Pusher only when at least one complete Pusher account is configured.');
                    return;
                }

                if (realtimeMode && realtimeMode.value !== 'polling' && redisEnabled && !redisEnabled.checked) {
                    showToast('warning', 'Redis is disabled', 'Realtime mode works best with cache support. Review your runtime setup before continuing.');
                }

                if (maintenanceModes.length > 0) {
                    showToast('warning', 'Maintenance enabled', 'Users may be blocked from entering this game.');
                }
            });
        }

        document.querySelectorAll('[data-game-mode]').forEach(function (field) {
            field.addEventListener('change', function () {
                if (field.value === 'maintenance') {
                    showToast('warning', 'Maintenance mode enabled', 'Users may be blocked from entering this game.');
                    return;
                }

                if (field.value === 'developer') {
                    showToast('info', 'Developer mode enabled', 'Only approved developer IDs can enter this room.');
                }
            });
        });

        function ensureTooltip() {
            if (tooltipNode) {
                return tooltipNode;
            }
            tooltipNode = document.createElement('div');
            tooltipNode.style.cssText = 'position:fixed;z-index:2147483640;max-width:320px;padding:12px 14px;border-radius:16px;border:1px solid rgba(255,255,255,.12);background:rgba(8,14,29,.96);box-shadow:0 20px 50px rgba(0,0,0,.34);color:#f4f7ff;pointer-events:none;opacity:0;transform:translateY(6px);transition:opacity .16s ease,transform .16s ease';
            tooltipNode.innerHTML = '<strong style="display:block;margin-bottom:6px;font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:#ffd86b"></strong><div style="font-size:13px;line-height:1.6;color:#c9d6f3"></div>';
            document.body.appendChild(tooltipNode);
            return tooltipNode;
        }

        function showTooltip(target) {
            var title = target.getAttribute('data-help-title');
            var body = target.getAttribute('data-help-body');
            if (!title && !body) {
                return;
            }
            var node = ensureTooltip();
            var titleNode = node.querySelector('strong');
            var bodyNode = node.querySelector('div');
            titleNode.textContent = safeUiText(title, 'Help');
            bodyNode.textContent = safeUiText(body, 'Review this field to understand how the current admin option works.');
            var rect = target.getBoundingClientRect();
            node.style.left = Math.min(window.innerWidth - 340, Math.max(12, rect.left)) + 'px';
            node.style.top = Math.max(12, rect.bottom + 12) + 'px';
            node.style.opacity = '1';
            node.style.transform = 'translateY(0)';
        }

        function hideTooltip() {
            if (!tooltipNode) {
                return;
            }
            tooltipNode.style.opacity = '0';
            tooltipNode.style.transform = 'translateY(6px)';
        }

        document.querySelectorAll('[data-help-title],[data-help-body]').forEach(function (node) {
            node.addEventListener('mouseenter', function () { showTooltip(node); });
            node.addEventListener('focus', function () { showTooltip(node); });
            node.addEventListener('mouseleave', hideTooltip);
            node.addEventListener('blur', hideTooltip);
        });

        function startTour(options) {
            options = options || {};
            var force = !!options.force;
            var storageKey = 'game-final-tour:' + window.location.pathname;
            var storage = null;
            try {
                storage = window.localStorage || null;
            } catch (error) {
                storage = null;
            }
            [
                {
                    selector: 'main h1, .content h1, .content h2',
                    title: 'Page Overview',
                    body: 'Use this section to understand the main purpose of the current admin page.'
                },
                {
                    selector: '.filter-bar',
                    title: 'Filter Bar',
                    body: 'Use these controls to search, narrow results, and reset the current list quickly.'
                },
                {
                    selector: '.scan-table, .table-shell, .panel',
                    title: 'Data Section',
                    body: 'This area contains the main records, controls, or audit details for the current page.'
                },
                {
                    selector: '.button-primary, button[type=\"submit\"]',
                    title: 'Primary Action',
                    body: 'This action saves or runs the main task for the current page. Review inputs before continuing.'
                }
            ].forEach(function (entry) {
                var node = document.querySelector(entry.selector);
                if (node && !node.getAttribute('data-tour-title')) {
                    node.setAttribute('data-tour-title', entry.title);
                    node.setAttribute('data-tour-body', entry.body);
                }
            });

            var items = Array.prototype.slice.call(document.querySelectorAll('[data-tour-title]')).filter(function (node) {
                return node.offsetParent !== null;
            });

            var alreadySeen = false;
            if (storage) {
                try {
                    alreadySeen = storage.getItem(storageKey) === '1';
                } catch (error) {
                    alreadySeen = false;
                }
            }

            if (!items.length || (alreadySeen && !force) || tourOverlay) {
                return;
            }

            var index = 0;
            var highlightedNode = null;
            var tourMarker = document.createElement('div');
            var tourCard = document.createElement('div');
            tourCard.setAttribute('role', 'dialog');
            tourCard.setAttribute('aria-live', 'polite');
            tourCard.style.cssText = 'position:fixed;z-index:2147483641;width:min(360px,calc(100vw - 24px));padding:18px 18px 16px;border-radius:20px;border:1px solid rgba(255,255,255,.12);background:linear-gradient(160deg,rgba(18,26,54,.98),rgba(8,14,29,.96));box-shadow:0 24px 70px rgba(0,0,0,.34);color:#f4f7ff';
            document.body.appendChild(tourCard);
            tourMarker.style.cssText = 'position:fixed;z-index:2147483642;display:inline-flex;align-items:center;justify-content:center;min-width:28px;height:28px;padding:0 8px;border-radius:999px;background:linear-gradient(135deg,#ffd86b,#ffb44d);color:#2a1800;font-size:12px;font-weight:900;box-shadow:0 10px 28px rgba(255,180,77,.32)';
            document.body.appendChild(tourMarker);
            tourOverlay = tourCard;

            var clearHighlight = function () {
                if (!highlightedNode) {
                    return;
                }
                highlightedNode.style.removeProperty('outline');
                highlightedNode.style.removeProperty('outline-offset');
                highlightedNode.style.removeProperty('border-radius');
                highlightedNode.style.removeProperty('box-shadow');
                highlightedNode.removeAttribute('data-tour-active');
                highlightedNode = null;
            };

            var closeTour = function () {
                if (storage) {
                    try {
                        storage.setItem(storageKey, '1');
                    } catch (error) {}
                }
                clearHighlight();
                if (tourCard.parentNode) {
                    tourCard.parentNode.removeChild(tourCard);
                }
                if (tourMarker.parentNode) {
                    tourMarker.parentNode.removeChild(tourMarker);
                }
                window.removeEventListener('resize', repositionCard);
                window.removeEventListener('scroll', repositionCard, true);
                document.removeEventListener('keydown', onKeydown, true);
            };

            var repositionCard = function () {
                var node = items[index];
                if (!node || !tourCard.parentNode) {
                    return;
                }
                var rect = node.getBoundingClientRect();
                var spacing = 14;
                var width = Math.min(360, window.innerWidth - 24);
                var placeRight = true;
                var left = rect.right + spacing;
                if (left + width > window.innerWidth - 12) {
                    placeRight = false;
                    left = Math.max(12, rect.left - width - spacing);
                }
                if (left < 12) {
                    left = 12;
                }
                var top = rect.top;
                var maxTop = window.innerHeight - tourCard.offsetHeight - 12;
                if (top > maxTop) {
                    top = maxTop;
                }
                if (top < 12) {
                    top = 12;
                }
                tourCard.style.left = left + 'px';
                tourCard.style.top = top + 'px';
                tourCard.setAttribute('data-tour-side', placeRight ? 'right' : 'left');

                var arrow = tourCard.querySelector('[data-tour-arrow]');
                if (arrow) {
                    arrow.style.top = Math.max(18, Math.min(tourCard.offsetHeight - 28, rect.top - top + 16)) + 'px';
                    if (placeRight) {
                        arrow.style.left = '-7px';
                        arrow.style.right = 'auto';
                    } else {
                        arrow.style.right = '-7px';
                        arrow.style.left = 'auto';
                    }
                }

                tourMarker.textContent = String(index + 1);
                tourMarker.style.left = Math.max(12, rect.left - 4) + 'px';
                tourMarker.style.top = Math.max(12, rect.top - 12) + 'px';
            };

            var onKeydown = function (event) {
                if (event.key === 'Escape') {
                    closeTour();
                    return;
                }
                if (event.key === 'Enter' && !event.shiftKey) {
                    event.preventDefault();
                    index += 1;
                    render();
                }
            };

            var render = function () {
                var node = items[index];
                if (!node) {
                    closeTour();
                    return;
                }

                clearHighlight();
                highlightedNode = node;
                highlightedNode.setAttribute('data-tour-active', '1');
                highlightedNode.style.outline = '2px solid rgba(255,216,107,.82)';
                highlightedNode.style.outlineOffset = '4px';
                highlightedNode.style.borderRadius = '16px';
                highlightedNode.style.boxShadow = '0 0 0 6px rgba(255,216,107,.10)';
                highlightedNode.scrollIntoView({ behavior: 'smooth', block: 'center', inline: 'nearest' });

                tourCard.innerHTML = '<div data-tour-arrow style="position:absolute;width:14px;height:14px;transform:rotate(45deg);background:linear-gradient(160deg,rgba(18,26,54,.98),rgba(8,14,29,.96));border-left:1px solid rgba(255,255,255,.12);border-top:1px solid rgba(255,255,255,.12)"></div>' +
                    '<div style="display:flex;align-items:center;justify-content:space-between;gap:10px;margin-bottom:8px"><div style="font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:#ffd86b">Guide ' + String(index + 1) + '/' + String(items.length) + '</div><div style="display:inline-flex;align-items:center;justify-content:center;width:12px;height:12px;border-radius:999px;background:#ffd86b;box-shadow:0 0 0 6px rgba(255,216,107,.18)"></div></div>' +
                    '<h3 style="margin:0 0 8px;font-size:20px;line-height:1.25">' + escapeHtml(safeUiText(node.getAttribute('data-tour-title'), 'Guide')) + '</h3>' +
                    '<p style="margin:0 0 14px;line-height:1.65;color:#d2def7;font-size:13px">' + escapeHtml(safeUiText(node.getAttribute('data-tour-body'), 'Review this section before making changes.')) + '</p>' +
                    '<div style="display:flex;gap:8px;justify-content:flex-end;flex-wrap:wrap"><button type="button" data-tour-close style="min-height:38px;padding:0 14px;border-radius:12px;border:1px solid rgba(255,255,255,.12);background:rgba(255,255,255,.06);color:#fff;font-weight:700">Close</button><button type="button" data-tour-next style="min-height:38px;padding:0 14px;border-radius:12px;border:0;background:linear-gradient(135deg,#ffd86b,#ffb44d);color:#2a1800;font-weight:800">' + (index === items.length - 1 ? 'Finish' : 'Next') + '</button></div>';

                repositionCard();

                tourCard.querySelector('[data-tour-close]').addEventListener('click', closeTour);
                tourCard.querySelector('[data-tour-next]').addEventListener('click', function () {
                    index += 1;
                    render();
                });
            };

            window.addEventListener('resize', repositionCard);
            window.addEventListener('scroll', repositionCard, true);
            document.addEventListener('keydown', onKeydown, true);
            render();
        }

        function startLiveMonitorRefresh() {
            var monitorShell = document.querySelector('[data-live-monitor-shell]');
            var pageShell = document.querySelector('[data-live-monitor-page]');
            if (!monitorShell || !pageShell) {
                return;
            }

            monitorTimer = window.setInterval(function () {
                fetch(window.location.href, {
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'text/html, application/xhtml+xml',
                        'X-Admin-App': '1'
                    }
                }).then(function (response) {
                    return response.text();
                }).then(function (html) {
                    var parser = new DOMParser();
                    var nextDoc = parser.parseFromString(html, 'text/html');
                    var nextShell = nextDoc.querySelector('[data-live-monitor-shell]');
                    if (nextShell && monitorShell) {
                        monitorShell.innerHTML = nextShell.innerHTML;
                    }
                }).catch(function () {});
            }, 5000);
        }

        window.addEventListener('popstate', function () {
            loadDocument(window.location.href, { historyMode: 'replace' });
        });

        document.querySelectorAll('[data-tour-start]').forEach(function (node) {
            node.addEventListener('click', function (event) {
                event.preventDefault();
                startTour({ force: true });
            });
        });

        startLiveMonitorRefresh();
    });
})();

