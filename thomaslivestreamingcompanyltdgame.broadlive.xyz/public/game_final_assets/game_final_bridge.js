(function(){
  if(!window.BD_GAME_BOOTSTRAP){ return; }
  var bootstrap = window.BD_GAME_BOOTSTRAP;
  try {
    if (window.history && window.history.replaceState && (window.location.search || window.location.hash)) {
      window.history.replaceState({}, document.title, window.location.pathname);
    }
  } catch(e){}
  var stateListeners = [];
  var connectionListeners = [];
  var lastStatePayload = null;
  var wakeResumeAt = 0;
  var hiddenAt = 0;
  var offlineAt = 0;
  var reloadAt = 0;
  var heartbeatTimer = null;
  var heartbeatKickTimer = null;
  var heartbeatNetworkMsProvider = null;
  var fxActive = 0;
  var fxWindowStartedAt = Date.now();
  var fxWindowCost = 0;
  var requestTimeoutMs = Number(bootstrap.requestTimeoutMs || 15000);
  if (!Number.isFinite(requestTimeoutMs) || requestTimeoutMs < 5000) requestTimeoutMs = 15000;
  var requestRetryDelayMs = Number(bootstrap.requestRetryDelayMs || 350);
  if (!Number.isFinite(requestRetryDelayMs) || requestRetryDelayMs < 0) requestRetryDelayMs = 350;
  var lastResumeGapMs = 0;
  var bootstrapConfigVersion = Number(bootstrap.configVersion || 0);
  var adoptedStorageKey = 'bdgf:adopted_config_version:' + (bootstrap.gameCode || bootstrap.roomKey || 'default');
  var storedAdoptedConfigVersion = 0;
  try {
    storedAdoptedConfigVersion = Number(window.sessionStorage.getItem(adoptedStorageKey) || '0');
  } catch(e){}
  if (!Number.isFinite(bootstrapConfigVersion)) bootstrapConfigVersion = 0;
  if (!Number.isFinite(storedAdoptedConfigVersion)) storedAdoptedConfigVersion = 0;
  var initialAdoptedConfigVersion = Math.max(bootstrapConfigVersion, storedAdoptedConfigVersion);
  function activityMeta(){
    var now = Date.now();
    var hiddenGapMs = hiddenAt ? Math.max(0, now - hiddenAt) : 0;
    var offlineGapMs = offlineAt ? Math.max(0, now - offlineAt) : 0;
    return {
      client_visibility: document.hidden ? 'hidden' : 'visible',
      client_hidden_ms: hiddenGapMs,
      client_offline_ms: offlineGapMs,
      client_inactive_ms: Math.max(hiddenGapMs, offlineGapMs, Number(lastResumeGapMs || 0)),
      client_round_no: lastStatePayload && lastStatePayload.round_no ? String(lastStatePayload.round_no) : '',
      client_phase: lastStatePayload && lastStatePayload.phase ? String(lastStatePayload.phase) : ''
    };
  }
  function withSession(params){
    return Object.assign({}, params || {}, activityMeta());
  }
  function adoptConfigVersion(payload){
    if (!payload || payload.config_version === undefined || payload.config_version === null) return;
    var incoming = Number(payload.config_version || 0);
    if (!Number.isFinite(incoming) || incoming <= 0) return;
    var current = api ? Number(api._adoptedConfigVersion || 0) : initialAdoptedConfigVersion;
    if (!Number.isFinite(current)) current = 0;
    if (incoming <= current) return;
    bootstrap.configVersion = incoming;
    bootstrap.configUpdatedAt = payload.config_updated_at || bootstrap.configUpdatedAt || null;
    if (api) {
      api._adoptedConfigVersion = incoming;
      api._lastConfigAdoptedAt = Date.now();
    }
    try {
      window.sessionStorage.setItem(adoptedStorageKey, String(incoming));
      window.dispatchEvent(new CustomEvent('bdgf:config-adopted', {
        detail: {
          config_version: incoming,
          game_key: payload.game_key || payload.game_code || bootstrap.gameKey || bootstrap.gameCode,
          room_key: payload.room_key || bootstrap.roomKey || bootstrap.gameCode
        }
      }));
    } catch(e){}
    if (api && !api._configRefreshQueued) {
      api._configRefreshQueued = true;
      window.setTimeout(function(){ requestRefresh('config_version_changed'); }, 80);
    }
  }
  function createBetAudioController(){
    var AudioContextCtor = window.AudioContext || window.webkitAudioContext;
    var ctx = null;
    var master = null;
    var media = null;
    var beatTimer = null;
    var closeTimer = null;
    var active = false;
    var pendingStart = false;
    var unlocked = false;
    var unlockBound = false;
    var lastPayload = null;
    var serverOffsetSec = 0;
    var disabledMedia = false;
    var explicitEnabled = null;
    var trackUrl = '';
    try {
      trackUrl = String(bootstrap.betAudioUrl || bootstrap.betTimeAudioUrl || window.BD_GAME_BET_AUDIO_URL || '').trim();
    } catch(e){}
    if (!trackUrl) trackUrl = '/game_final_assets/audio/bet_time_loop.mp3';
    function storageValue(key){
      try { return window.localStorage ? window.localStorage.getItem(key) : null; } catch(e){ return null; }
    }
    function isOffValue(value){
      if (value === null || value === undefined) return false;
      var normalized = String(value).trim().toLowerCase();
      return normalized === 'off' || normalized === '0' || normalized === 'false' || normalized === 'muted' || normalized === 'mute' || normalized === 'disabled' || normalized === 'no';
    }
    function isMutedValue(value){
      if (value === null || value === undefined) return false;
      var normalized = String(value).trim().toLowerCase();
      return normalized === '1' || normalized === 'true' || normalized === 'on' || normalized === 'yes' || normalized === 'muted' || normalized === 'mute';
    }
    function isZeroLevel(value){
      if (value === null || value === undefined || value === '') return false;
      var normalized = Number(value);
      return Number.isFinite(normalized) && normalized <= 0;
    }
    function controlLooksMuted(node){
      if (!node) return false;
      var text = String(node.textContent || '').trim().toLowerCase();
      return node.classList.contains('off')
        || node.classList.contains('muted')
        || node.getAttribute('aria-pressed') === 'false'
        || node.getAttribute('aria-checked') === 'false'
        || text === 'off'
        || text === 'muted'
        || text === 'disabled';
    }
    function domControlsAllowAudio(){
      var teenSound = document.querySelector('#audioPopup [data-audio="sound"]');
      var teenMusic = document.querySelector('#audioPopup [data-audio="music"]');
      if (teenSound && !teenSound.classList.contains('on')) return false;
      if (teenMusic && !teenMusic.classList.contains('on')) return false;
      var luckySound = document.getElementById('toggleSound');
      var luckyMusic = document.getElementById('toggleMusic');
      if (luckySound && !luckySound.classList.contains('on')) return false;
      if (luckyMusic && !luckyMusic.classList.contains('on')) return false;
      var proMusic = document.getElementById('musicAction');
      if (proMusic && !proMusic.classList.contains('active')) return false;
      var modalSoundToggle = document.getElementById('soundToggle')
        || document.getElementById('settingsSoundToggle')
        || document.getElementById('fruitsLoopSoundToggle')
        || document.getElementById('codexSoundToggle')
        || document.getElementById('codexInlineSoundToggle')
        || document.getElementById('codexLastSoundToggle');
      if (controlLooksMuted(modalSoundToggle)) return false;
      return true;
    }
    function clamp(value, min, max){
      value = Number(value);
      if (!Number.isFinite(value)) value = min;
      return Math.max(min, Math.min(max, value));
    }
    function audioVolume(){
      var configured = bootstrap.betAudioVolume !== undefined && bootstrap.betAudioVolume !== null
        ? bootstrap.betAudioVolume
        : (window.BD_GAME_BET_AUDIO_VOLUME !== undefined && window.BD_GAME_BET_AUDIO_VOLUME !== null ? window.BD_GAME_BET_AUDIO_VOLUME : 0.2);
      var value = clamp(configured, 0, 0.45);
      var loopLevel = storageValue('fruitsLoopMusicLevel');
      if (loopLevel !== null) value *= clamp(Number(loopLevel) / 100, 0, 1);
      var slotVolume = storageValue('fruitSlotVolume');
      if (slotVolume !== null) value *= clamp(Number(slotVolume), 0, 1);
      return clamp(value, 0, 0.45);
    }
    function savedPrefsAllowAudio(){
      if (explicitEnabled !== null) return !!explicitEnabled;
      if (!domControlsAllowAudio()) return false;
      if (isMutedValue(storageValue('bdgfBetAudioMuted'))) return false;
      if (isOffValue(storageValue('bdgf:bet_audio'))) return false;
      if (isOffValue(storageValue('bdgf:music'))) return false;
      if (isOffValue(storageValue('fruits_loop_sound_enabled'))) return false;
      if (isOffValue(storageValue('fruitSlotSound'))) return false;
      if (isOffValue(storageValue('lucky7Sound')) || isOffValue(storageValue('lucky77Sound')) || isOffValue(storageValue('lucky7ProSound'))) return false;
      var code = String(bootstrap.gameCode || bootstrap.roomKey || '').trim();
      var teenKey = code === 'teen_patti' ? 'tp_prefs' : 'tp_prefs_' + code;
      var teenPrefs = storageValue(teenKey);
      if (teenPrefs) {
        try {
          var parsed = JSON.parse(teenPrefs);
          if (parsed && (parsed.music === false || parsed.sound === false)) return false;
        } catch(e){}
      }
      var musicLevel = storageValue('fruitsLoopMusicLevel');
      if (isZeroLevel(musicLevel)) return false;
      if (isZeroLevel(storageValue('fruitsLoopSoundEffectLevel'))) return false;
      if (isZeroLevel(storageValue('fruits_loop_sound_volume'))) return false;
      return true;
    }
    function serverNow(){
      return (Date.now() / 1000) + serverOffsetSec;
    }
    function updateClock(payload){
      if (!payload || typeof payload.server_time !== 'number') return;
      var incoming = Number(payload.server_time);
      if (Number.isFinite(incoming)) serverOffsetSec = incoming - (Date.now() / 1000);
    }
    function numericMarker(payload, key){
      var value = Number(payload && payload[key]);
      return Number.isFinite(value) && value > 0 ? value : 0;
    }
    function bettingOpen(payload){
      if (!payload || payload.st === false || payload.phase !== 'betting') return false;
      if (document.hidden) return false;
      if (!savedPrefsAllowAudio()) return false;
      var opensAt = numericMarker(payload, 'bet_countdown_start_at') || numericMarker(payload, 'start_at');
      var closesAt = numericMarker(payload, 'bet_close_at');
      var now = serverNow();
      if (opensAt && now + 0.25 < opensAt) return false;
      if (closesAt && now >= closesAt) return false;
      return true;
    }
    function clearCloseTimer(){
      if (closeTimer) {
        window.clearTimeout(closeTimer);
        closeTimer = null;
      }
    }
    function scheduleCloseStop(payload){
      clearCloseTimer();
      var closesAt = numericMarker(payload, 'bet_close_at');
      if (!closesAt) return;
      var ms = Math.max(0, Math.ceil((closesAt - serverNow()) * 1000));
      closeTimer = window.setTimeout(function(){ stop('bet_close_at'); }, ms + 80);
    }
    function ensureContext(){
      if (!AudioContextCtor) return null;
      if (!ctx) ctx = new AudioContextCtor();
      if (!master) {
        master = ctx.createGain();
        master.gain.value = audioVolume();
        master.connect(ctx.destination);
      }
      return ctx;
    }
    function resumeContext(callback){
      var c = ensureContext();
      if (!c) return false;
      if (master) {
        try { master.gain.cancelScheduledValues(c.currentTime || 0); } catch(e){}
        master.gain.value = audioVolume();
      }
      if (c.state === 'suspended' && typeof c.resume === 'function') {
        var resumed = null;
        try { resumed = c.resume(); } catch(e){}
        if (resumed && typeof resumed.then === 'function') {
          resumed.then(function(){ if (typeof callback === 'function') callback(); }).catch(function(){ pendingStart = true; bindUnlock(); });
        }
      }
      if (c.state === 'suspended') {
        pendingStart = true;
        bindUnlock();
        return false;
      }
      return true;
    }
    function makeTone(freq, startAt, duration, gain, type){
      var c = ensureContext();
      if (!c || !master) return;
      var osc = c.createOscillator();
      var envelope = c.createGain();
      osc.type = type || 'triangle';
      osc.frequency.setValueAtTime(freq, startAt);
      envelope.gain.setValueAtTime(0.0001, startAt);
      envelope.gain.exponentialRampToValueAtTime(Math.max(0.0002, gain), startAt + 0.018);
      envelope.gain.exponentialRampToValueAtTime(0.0001, startAt + Math.max(0.04, duration));
      osc.connect(envelope);
      envelope.connect(master);
      osc.start(startAt);
      osc.stop(startAt + Math.max(0.05, duration) + 0.04);
    }
    function playGeneratedBeat(){
      if (!active || !savedPrefsAllowAudio()) return;
      var c = ensureContext();
      if (!c || c.state === 'suspended') return;
      var code = String(bootstrap.gameCode || bootstrap.roomKey || 'bdgf');
      var seed = 0;
      for (var i = 0; i < code.length; i++) seed = (seed + code.charCodeAt(i) * (i + 3)) % 97;
      var base = 174 + (seed % 6) * 8;
      var t = c.currentTime + 0.025;
      makeTone(82 + (seed % 4) * 4, t, 0.12, 0.05, 'sine');
      makeTone(base, t + 0.02, 0.12, 0.045, 'triangle');
      makeTone(base * 1.5, t + 0.2, 0.1, 0.035, 'sine');
      makeTone(base * 2, t + 0.39, 0.12, 0.03, 'triangle');
    }
    function startGeneratedLoop(){
      if (!resumeContext(function(){ if (pendingStart && bettingOpen(lastPayload)) start('unlock_resume', lastPayload); })) return;
      if (beatTimer) window.clearInterval(beatTimer);
      active = true;
      pendingStart = false;
      playGeneratedBeat();
      beatTimer = window.setInterval(playGeneratedBeat, 680);
    }
    function ensureMedia(){
      if (!trackUrl || disabledMedia) return null;
      if (media) return media;
      media = document.createElement('audio');
      media.loop = true;
      media.preload = 'auto';
      media.src = trackUrl;
      media.volume = audioVolume();
      media.setAttribute('playsinline', 'playsinline');
      media.setAttribute('data-bdgf-bet-audio', '1');
      media.style.display = 'none';
      media.addEventListener('error', function(){
        disabledMedia = true;
        media = null;
        if (active && bettingOpen(lastPayload)) startGeneratedLoop();
      }, { once: true });
      document.body.appendChild(media);
      return media;
    }
    function start(reason, payload){
      lastPayload = payload || lastPayload;
      if (!bettingOpen(lastPayload)) {
        stop('not_betting');
        return;
      }
      scheduleCloseStop(lastPayload);
      bindUnlock();
      if (trackUrl && !disabledMedia) {
        var node = ensureMedia();
        if (node) {
          active = true;
          pendingStart = false;
          node.volume = audioVolume();
          var played = null;
          try { played = node.play(); } catch(e){}
          if (played && typeof played.catch === 'function') {
            played.catch(function(){
              pendingStart = true;
              bindUnlock();
              startGeneratedLoop();
            });
          }
          return;
        }
      }
      startGeneratedLoop();
    }
    function stop(reason){
      pendingStart = false;
      active = false;
      clearCloseTimer();
      if (beatTimer) {
        window.clearInterval(beatTimer);
        beatTimer = null;
      }
      if (media) {
        try { media.pause(); media.currentTime = 0; } catch(e){}
      }
      if (ctx && master) {
        try {
          var now = ctx.currentTime || 0;
          master.gain.cancelScheduledValues(now);
          master.gain.setValueAtTime(master.gain.value, now);
          master.gain.linearRampToValueAtTime(0.0001, now + 0.08);
          window.setTimeout(function(){
            if (!active && ctx && typeof ctx.suspend === 'function' && ctx.state === 'running') {
              ctx.suspend().catch(function(){});
            }
          }, 120);
        } catch(e){}
      }
    }
    function sync(payload){
      if (payload) {
        lastPayload = payload;
        updateClock(payload);
      }
      if (bettingOpen(lastPayload)) start('phase_betting', lastPayload);
      else stop('phase_' + String(lastPayload && lastPayload.phase || 'unknown'));
    }
    function unlock(){
      unlocked = true;
      if (ctx && ctx.state === 'suspended' && typeof ctx.resume === 'function') {
        try { ctx.resume().catch(function(){}); } catch(e){}
      }
      if (pendingStart && bettingOpen(lastPayload)) start('user_unlock', lastPayload);
    }
    function bindUnlock(){
      if (unlockBound) return;
      unlockBound = true;
      ['pointerdown','touchstart','keydown'].forEach(function(type){
        document.addEventListener(type, unlock, { capture: true, passive: true });
      });
      document.addEventListener('click', function(){
        window.setTimeout(function(){ if (lastPayload) sync(lastPayload); }, 0);
      }, true);
      ['input','change'].forEach(function(type){
        document.addEventListener(type, function(){
          window.setTimeout(function(){ if (lastPayload) sync(lastPayload); }, 0);
        }, true);
      });
      window.addEventListener('storage', function(){ if (lastPayload) sync(lastPayload); });
    }
    bindUnlock();
    return {
      sync: sync,
      stop: stop,
      start: start,
      setEnabled: function(next){
        explicitEnabled = next === null || next === undefined ? null : !!next;
        if (!explicitEnabled) stop('disabled');
        else if (lastPayload) sync(lastPayload);
      },
      status: function(){
        return {
          active: active,
          pending: pendingStart,
          unlocked: unlocked,
          phase: lastPayload && lastPayload.phase ? String(lastPayload.phase) : '',
          mode: trackUrl && !disabledMedia ? 'media' : 'generated',
          muted: !savedPrefsAllowAudio()
        };
      }
    };
  }
  var betAudioController = createBetAudioController();
  function notifyState(data){
    adoptConfigVersion(data);
    lastStatePayload = data || lastStatePayload;
    if (betAudioController && data && data.st) betAudioController.sync(data);
    try { window.dispatchEvent(new CustomEvent('bdgf:state', { detail: data })); } catch(e){}
    stateListeners.forEach(function(fn){ try { fn(data); } catch(e){} });
  }
  function notifyConnection(data){
    var status = data && data.status ? String(data.status) : '';
    if (betAudioController && ['expired','session_retry','security_lock','maintenance','reloading','offline'].indexOf(status) !== -1) {
      betAudioController.stop('connection_' + status);
    }
    try { window.dispatchEvent(new CustomEvent('bdgf:connection', { detail: data })); } catch(e){}
    connectionListeners.forEach(function(fn){ try { fn(data); } catch(e){} });
  }
  function lobbyUrl(){
    if (bootstrap.lobbyUrl) return bootstrap.lobbyUrl;
    try {
      var params = new URLSearchParams(window.location.search || '');
      var forwardedLobby = params.get('lobby');
      if (forwardedLobby) return forwardedLobby;
    } catch(e){}
    return window.location.origin + '/play_bd_game';
  }
  var badgeHideTimer = null;
  function flashProtectionBadge(){
    var badge = document.getElementById('bdgf-protected-badge');
    if (!badge) return;
    badge.classList.add('is-visible');
    if (badgeHideTimer) window.clearTimeout(badgeHideTimer);
    badgeHideTimer = window.setTimeout(function(){
      badge.classList.remove('is-visible');
    }, 2800);
  }
  function installBrandingLayer(){
    if (bootstrap.watermarkEnabled === false || document.getElementById('bdgf-watermark-layer')) return;
    var userId = bootstrap.userId != null && String(bootstrap.userId).trim() !== '' ? String(bootstrap.userId).trim() : '0000';
    var numericId = userId.replace(/\D+/g, '') || userId;
    var label = numericId;
    var layer = document.createElement('div');
    layer.id = 'bdgf-watermark-layer';
    var positions = [
      ['8%','12%'], ['36%','8%'], ['68%','14%'],
      ['16%','42%'], ['47%','47%'], ['76%','41%'],
      ['12%','76%'], ['42%','79%'], ['72%','74%']
    ];
    layer.innerHTML = positions.map(function(pos, index){
      return '<span class="bdgf-watermark bdgf-watermark-' + index + '" style="left:' + pos[0] + ';top:' + pos[1] + ';">' + label + '</span>';
    }).join('') + '<div class="bdgf-protected-badge" id="bdgf-protected-badge">protected via JAMBOai</div>';
    document.body.appendChild(layer);
    var style = document.createElement('style');
    style.textContent = '#bdgf-watermark-layer{position:fixed;inset:0;pointer-events:none;z-index:180}.bdgf-watermark{position:absolute;transform:translate(-50%,-50%) rotate(-18deg);font-size:10px;font-weight:400;line-height:1;font-family:Inter,Arial,sans-serif;letter-spacing:.08em;color:rgba(255,255,255,.10);text-shadow:0 0 14px rgba(0,0,0,.18);white-space:nowrap;user-select:none}.bdgf-protected-badge{position:fixed;left:50%;bottom:max(8px,env(safe-area-inset-bottom));transform:translateX(-50%) translateY(10px);padding:4px 10px;border-radius:999px;background:rgba(8,11,20,.38);border:1px solid rgba(255,215,107,.18);backdrop-filter:blur(8px);font:400 7px/1 Inter,Arial,sans-serif;letter-spacing:.12em;text-transform:uppercase;color:rgba(255,245,214,.82);text-align:center;user-select:none;opacity:0;transition:opacity .18s ease,transform .18s ease}.bdgf-protected-badge.is-visible{opacity:.05;transform:translateX(-50%) translateY(0)}@media (max-width: 720px){.bdgf-watermark{font-size:10px}.bdgf-protected-badge{font-size:7px;padding:4px 8px}}';
    document.head.appendChild(style);
  }
  function isCompactViewport(){
    return Math.min(window.innerWidth || 0, window.innerHeight || 0) <= 480
      || (window.innerHeight || 0) <= 520;
  }
  function isLowPowerClient(){
    var cores = Number(navigator.hardwareConcurrency || 0);
    var memory = Number(navigator.deviceMemory || 0);
    return isCompactViewport()
      || (cores > 0 && cores <= 4)
      || (memory > 0 && memory <= 4)
      || (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches);
  }
  function maxFxCost(){
    return isLowPowerClient() ? 14 : 36;
  }
  function resetFxWindowIfNeeded(){
    var now = Date.now();
    if (now - fxWindowStartedAt > 1000) {
      fxWindowStartedAt = now;
      fxWindowCost = 0;
    }
  }
  function canPlayFx(cost){
    if (document.hidden) return false;
    resetFxWindowIfNeeded();
    cost = Math.max(1, Number(cost || 1));
    var max = maxFxCost();
    if (fxActive + cost > max || fxWindowCost + cost > max * 2) return false;
    fxWindowCost += cost;
    return true;
  }
  function registerFxNode(node, ttlMs){
    if (!node || node.__bdgfFxRegistered) return node;
    node.__bdgfFxRegistered = true;
    fxActive += 1;
    try { node.setAttribute('data-bdgf-fx', '1'); } catch(e){}
    var cleaned = false;
    var cleanup = function(){
      if (cleaned) return;
      cleaned = true;
      fxActive = Math.max(0, fxActive - 1);
      try {
        node.removeEventListener('animationend', cleanup);
        node.removeEventListener('transitionend', cleanup);
      } catch(e){}
    };
    try {
      node.addEventListener('animationend', cleanup, { once: true });
      node.addEventListener('transitionend', cleanup, { once: true });
    } catch(e){}
    window.setTimeout(cleanup, Math.max(600, Number(ttlMs || 1800)));
    return node;
  }
  function fxBudget(){
    var compact = isLowPowerClient();
    return {
      compact: compact,
      active: fxActive,
      max: maxFxCost(),
      betCoins: compact ? 2 : 5,
      betSparks: compact ? 2 : 8,
      winCoins: compact ? 4 : 10,
      winParticles: compact ? 6 : 18
    };
  }
  function installPerformanceLayer(){
    if (document.getElementById('bdgf-performance-layer')) return;
    var style = document.createElement('style');
    style.id = 'bdgf-performance-layer';
    style.textContent = '[data-bdgf-fx],.route-coin,.coin-fly,.spark,.fruit-rain,.cinema-fruit,.winner-spark,.flying-coin,.coin-rain,.divine-ring,.payout-fly-amount{contain:layout paint;will-change:transform,opacity;pointer-events:none!important}.board,.pot,.bet-card,.slot-board,.fruit-board{touch-action:manipulation}@media (max-height:520px),(max-width:430px),(prefers-reduced-motion:reduce){.cinema-fruit:nth-child(n+7),.fruit-rain:nth-child(n+9),.spark:nth-child(n+5),.coin-rain:nth-child(n+9){display:none!important}}';
    document.head.appendChild(style);
  }
  function securityEndpoint(){
    if (bootstrap.endpoints && bootstrap.endpoints.securityReport) return bootstrap.endpoints.securityReport;
    var stateUrl = bootstrap.endpoints && bootstrap.endpoints.state ? String(bootstrap.endpoints.state) : '';
    return stateUrl ? stateUrl.replace(/\/state(\?.*)?$/, '/security-report$1') : '';
  }
  function isSecurityPayload(payload){
    var code = payload && (payload.code || payload.error);
    return code === 'duplicate_device' || code === 'blocked_by_jamboai' || !!(payload && payload.blocked);
  }
  function isRetryPayload(payload){
    var code = payload && (payload.code || payload.error);
    return code === 'invalid_session' || code === 'session_retry_required' || code === 'user_required' || code === 'game_session_required';
  }
  function showSecurityOverlay(payload){
    payload = payload || {};
    var code = payload.code || payload.error || (payload.blocked ? 'blocked_by_jamboai' : 'security_lock');
    var title = code === 'duplicate_device' ? 'User Active' : (code === 'session_retry_required' ? 'Session Refresh' : 'JAMBOai Security');
    var message = payload.message || payload.msg || (code === 'duplicate_device'
      ? 'Your account is active on another device. Returning to lobby.'
      : 'Security lock is active. Returning to lobby.');
    var reason = payload.reason ? String(payload.reason) : '';
    var existing = document.getElementById('bdgf-security-lock');
    if (!existing) {
      existing = document.createElement('div');
      existing.id = 'bdgf-security-lock';
      existing.innerHTML = '<div class="bdgf-security-card"><div class="bdgf-security-title"></div><div class="bdgf-security-msg"></div><div class="bdgf-security-reason"></div><div class="bdgf-security-ring"></div></div>';
      document.body.appendChild(existing);
      var style = document.createElement('style');
      style.textContent = '#bdgf-security-lock{position:fixed;inset:0;z-index:2147483647;display:grid;place-items:center;background:radial-gradient(circle at 50% 30%,rgba(121,19,39,.35),rgba(2,4,12,.92) 58%,rgba(0,0,0,.98));backdrop-filter:blur(12px);font-family:Inter,Arial,sans-serif}.bdgf-security-card{position:relative;width:min(90vw,430px);overflow:hidden;border:1px solid rgba(255,211,107,.55);border-radius:22px;padding:28px 24px 30px;text-align:center;color:#fff;background:linear-gradient(145deg,rgba(36,12,23,.96),rgba(7,24,39,.96));box-shadow:0 32px 110px rgba(0,0,0,.55),0 0 45px rgba(255,199,92,.22)}.bdgf-security-card:before{content:"";position:absolute;inset:-1px;background:linear-gradient(120deg,transparent,rgba(255,231,156,.26),transparent);transform:translateX(-70%);animation:bdgfSweep 2.2s linear infinite}.bdgf-security-title{position:relative;font-size:24px;font-weight:1000;letter-spacing:.02em;color:#ffd66f;text-shadow:0 2px 14px rgba(255,60,60,.45)}.bdgf-security-msg{position:relative;margin-top:12px;font-size:16px;font-weight:800;line-height:1.45}.bdgf-security-reason{position:relative;margin-top:10px;color:#f7dca0;font-size:13px;line-height:1.35}.bdgf-security-ring{position:relative;margin:22px auto 0;width:52px;height:52px;border-radius:50%;border:4px solid rgba(255,211,107,.22);border-top-color:#ffd66f;animation:bdgfSpin .9s linear infinite}@keyframes bdgfSpin{to{transform:rotate(360deg)}}@keyframes bdgfSweep{to{transform:translateX(70%)}}';
      document.head.appendChild(style);
    }
    existing.querySelector('.bdgf-security-title').textContent = title;
    existing.querySelector('.bdgf-security-msg').textContent = message;
    existing.querySelector('.bdgf-security-reason').textContent = reason;
    api._sessionExpired = true;
    api.stopPollingState();
    api.stopWebSocketState();
    api.stopHeartbeat();
    window.setTimeout(function(){
      window.location.href = payload.lobby_url || lobbyUrl();
    }, code === 'blocked_by_jamboai' ? 3200 : 2200);
  }
  function handleSecurityPayload(payload){
    if (!isSecurityPayload(payload)) return false;
    showSecurityOverlay(payload);
    notifyConnection({ status: 'security_lock', code: payload.code || payload.error, message: payload.message || payload.msg });
    return true;
  }
  function handleRetryPayload(payload){
    if (!isRetryPayload(payload)) return false;
    showSecurityOverlay({
      code: 'session_retry_required',
      message: (payload && (payload.message || payload.msg)) || 'Session expired. Sending you to lobby for a new token.',
      reason: 'Please start again from the lobby.',
      lobby_url: payload && (payload.lobby_url || payload.refresh_url)
    });
    notifyConnection({ status: 'session_retry', code: payload.code || payload.error, message: payload.message || payload.msg });
    return true;
  }
  function isMaintenancePayload(payload){
    var code = payload && (payload.code || payload.error);
    return code === 'game_maintenance' || !!(payload && payload.maintenance);
  }
  function requestRefresh(reason){
    if (api._sessionExpired || api._isReloading) return;
    var now = Date.now();
    var minGap = 12000;
    var last = Number((typeof window.sessionStorage !== 'undefined' && window.sessionStorage.getItem('bdgf:last_refresh_at')) || '0');
    if (!Number.isFinite(last)) last = 0;
    if (api._refreshAt && now - api._refreshAt < minGap) return;
    if (last && now - last < minGap) return;
    api._isReloading = true;
    api._refreshAt = now;
    reloadAt = now;
    if (typeof window.sessionStorage !== 'undefined') {
      try { window.sessionStorage.setItem('bdgf:last_refresh_at', String(now)); } catch(e){}
    }
    api.stopPollingState();
    api.stopWebSocketState();
    notifyConnection({ status: 'reloading', message: reason || 'reconnect_refresh' });
    window.setTimeout(function(){ location.reload(); }, 150);
  }
  function recoverFromInactivity(){
    if (api._sessionExpired) return;
    lastResumeGapMs = Math.max(hiddenAt ? Math.max(0, wakeResumeAt - hiddenAt) : 0, offlineAt ? Math.max(0, wakeResumeAt - offlineAt) : 0);
    if (hiddenAt && wakeResumeAt && wakeResumeAt - hiddenAt > 30000) {
      return requestRefresh('tab_inactive_long');
    }
    if (offlineAt && wakeResumeAt && wakeResumeAt - offlineAt > 12000) {
      return requestRefresh('network_restore');
    }
    if (api._transport === 'idle') {
      api.connectRealtime();
    } else {
      api.connectRealtime();
    }
  }
  function showMaintenanceOverlay(payload){
    payload = payload || {};
    var existing = document.getElementById('bdgf-maintenance-lock');
    if (!existing) {
      existing = document.createElement('div');
      existing.id = 'bdgf-maintenance-lock';
      existing.innerHTML = '<div class="bdgf-maintenance-card"><div class="bdgf-maintenance-light"></div><div class="bdgf-maintenance-title">Game Maintenance</div><div class="bdgf-maintenance-msg"></div><div class="bdgf-maintenance-wait">Waiting for room to open</div></div>';
      document.body.appendChild(existing);
      var style = document.createElement('style');
      style.textContent = '#bdgf-maintenance-lock{position:fixed;inset:0;z-index:2147483646;display:grid;place-items:center;background:radial-gradient(circle at 50% 20%,rgba(255,188,66,.22),rgba(4,8,18,.88) 58%,rgba(0,0,0,.96));backdrop-filter:blur(10px);font-family:Inter,Arial,sans-serif}.bdgf-maintenance-card{width:min(90vw,430px);text-align:center;border:1px solid rgba(255,207,102,.52);border-radius:22px;padding:30px 24px;background:linear-gradient(145deg,rgba(27,34,54,.96),rgba(7,11,20,.98));box-shadow:0 32px 110px rgba(0,0,0,.55)}.bdgf-maintenance-light{width:58px;height:58px;margin:0 auto 18px;border-radius:50%;background:#ffb703;animation:bdgfMaintPulse 1.35s ease-in-out infinite}.bdgf-maintenance-title{font-size:24px;font-weight:1000;color:#fff}.bdgf-maintenance-msg{margin-top:12px;color:#dce7ff;font-size:16px;line-height:1.45;font-weight:800}.bdgf-maintenance-wait{display:inline-flex;margin-top:18px;border-radius:999px;padding:9px 13px;background:rgba(255,255,255,.08);color:#ffd166;font-weight:900}@keyframes bdgfMaintPulse{0%{box-shadow:0 0 0 0 rgba(255,183,3,.55);filter:hue-rotate(0)}70%{box-shadow:0 0 0 18px rgba(255,183,3,0);filter:hue-rotate(70deg)}100%{box-shadow:0 0 0 0 rgba(255,183,3,0);filter:hue-rotate(0)}}';
      document.head.appendChild(style);
    }
    existing.querySelector('.bdgf-maintenance-msg').textContent = payload.message || payload.msg || 'This game is in maintenance. Please wait.';
    notifyConnection({ status: 'maintenance', code: 'game_maintenance', message: payload.message || payload.msg });
  }
  function hideMaintenanceOverlay(){
    var existing = document.getElementById('bdgf-maintenance-lock');
    if (existing) existing.remove();
  }
  function handleMaintenancePayload(payload){
    if (!isMaintenancePayload(payload)) {
      hideMaintenanceOverlay();
      return false;
    }
    showMaintenanceOverlay(payload);
    return true;
  }
  function expireSession(url, statusCode){
    var payload = {
      st:false,
      code:'invalid_session',
      error:'invalid_session',
      message:'Session expired. Sending you to lobby for a new token.',
      lobby_url:lobbyUrl(),
      refresh_url:lobbyUrl(),
      status:statusCode || 409
    };
    handleRetryPayload(payload);
    notifyConnection({ status: 'expired', url: url, code: statusCode || 409 });
    return payload;
  }
  function wait(ms){
    return new Promise(function(resolve){ window.setTimeout(resolve, Math.max(0, ms || 0)); });
  }
  function requestMethod(opts){
    return String((opts && opts.method) || 'GET').toUpperCase();
  }
  function formValue(body, key){
    try {
      return body && typeof body.get === 'function' ? body.get(key) : null;
    } catch(e){
      return null;
    }
  }
  function hasIdempotencyKey(opts){
    return !!formValue(opts && opts.body, 'request_uid');
  }
  function isRetryableStatus(status){
    return status === 408 || status === 425 || status === 429 || status === 500 || status === 502 || status === 503 || status === 504;
  }
  function canRetryRequest(opts, status, error){
    var method = requestMethod(opts);
    if (method === 'GET') return !status || isRetryableStatus(status);
    if (method === 'POST' && hasIdempotencyKey(opts)) return !status || isRetryableStatus(status);
    return false;
  }
  async function fetchJson(url, opts){
    var baseOpts = Object.assign({}, opts || {});
    delete baseOpts.signal;
    var attempt = 0;
    while (attempt < 2) {
      var controller = typeof AbortController !== 'undefined' ? new AbortController() : null;
      var timeoutId = null;
      var requestOpts = Object.assign({}, baseOpts);
      try {
        if (api._sessionExpired) {
          return { st:false, error:'invalid_session', status:409, lobby_url:lobbyUrl(), refresh_url:lobbyUrl() };
        }
        notifyConnection({ status: attempt > 0 ? 'retrying' : 'pending', url: url, attempt: attempt + 1 });
        if (controller) {
          requestOpts.signal = controller.signal;
          timeoutId = window.setTimeout(function(){ controller.abort(); }, requestTimeoutMs);
        }
        var res = await fetch(url, requestOpts);
        if (timeoutId) window.clearTimeout(timeoutId);
        if (!res.ok) {
          var errorPayload = null;
          try { errorPayload = await res.clone().json(); } catch(e){}
          if (handleMaintenancePayload(errorPayload)) return errorPayload;
          if (handleSecurityPayload(errorPayload)) return errorPayload;
          if (handleRetryPayload(errorPayload)) return errorPayload;
          if (res.status === 401 || res.status === 419) {
            return expireSession(url, res.status);
          }
          if (attempt === 0 && canRetryRequest(baseOpts, res.status, null)) {
            attempt += 1;
            notifyConnection({ status: 'retrying', url: url, code: res.status, attempt: attempt + 1 });
            await wait(requestRetryDelayMs);
            continue;
          }
          notifyConnection({ status: 'error', url: url, code: res.status });
          return { st:false, error:'http_' + res.status, status:res.status };
        }
        notifyConnection({ status: 'ok', url: url, code: res.status, attempt: attempt + 1 });
        var payload = await res.json();
        handleMaintenancePayload(payload);
        handleSecurityPayload(payload);
        handleRetryPayload(payload);
        return payload;
      } catch(e) {
        if (timeoutId) window.clearTimeout(timeoutId);
        if (attempt === 0 && canRetryRequest(baseOpts, 0, e)) {
          attempt += 1;
          notifyConnection({ status: 'retrying', url: url, message: e && e.message ? e.message : 'request_failed', attempt: attempt + 1 });
          await wait(requestRetryDelayMs);
          continue;
        }
        notifyConnection({ status: 'error', url: url, message: e && e.message ? e.message : 'request_failed' });
        return { st:false, error:e && e.message ? e.message : 'request_failed' };
      }
    }
    return { st:false, error:'request_retry_failed' };
  }
  var api = {
    bootstrap: bootstrap,
    betAudio: betAudioController,
    _transport: 'idle',
    _configVersion: bootstrapConfigVersion,
    _adoptedConfigVersion: initialAdoptedConfigVersion,
    _configRefreshQueued: false,
    onState: function(fn){ if (typeof fn === 'function') stateListeners.push(fn); return api; },
    onConnection: function(fn){ if (typeof fn === 'function') connectionListeners.push(fn); return api; },
    stopPollingState: function(){ if (api._poller) { clearInterval(api._poller); api._poller = null; } return null; },
    stopHeartbeat: function(){ if (heartbeatTimer) { clearInterval(heartbeatTimer); heartbeatTimer = null; } if (heartbeatKickTimer) { clearTimeout(heartbeatKickTimer); heartbeatKickTimer = null; } heartbeatNetworkMsProvider = null; return null; },
    stopWebSocketState: function(){
      if (api._wsReconnectTimer) { clearTimeout(api._wsReconnectTimer); api._wsReconnectTimer = null; }
      if (api._ws) {
        try { api._ws.onopen = null; api._ws.onmessage = null; api._ws.onerror = null; api._ws.onclose = null; api._ws.close(); } catch(e){}
        api._ws = null;
      }
      return null;
    },
    get: async function(url, params){
      var payload = Object.assign({}, params || {});
      var q = new URLSearchParams(payload).toString();
      return fetchJson(q ? (url + (url.indexOf('?')>-1?'&':'?') + q) : url, {
        credentials:'same-origin',
        cache:'no-store',
        headers: bootstrap.sessionToken ? { 'X-Game-Session': bootstrap.sessionToken } : {}
      });
    },
    post: async function(url, payload){
      var fd = new FormData();
      var data = withSession(payload);
      Object.keys(data || {}).forEach(function(k){ if (data[k] !== undefined && data[k] !== null) fd.append(k, data[k]); });
      return fetchJson(url, {
        method:'POST', body:fd, credentials:'same-origin',
        headers: bootstrap.sessionToken ? { 'X-Game-Session': bootstrap.sessionToken } : {}
      });
    },
    startToPlay: async function(){ return api.post(bootstrap.endpoints.startToPlay, {}); },
    heartbeat: async function(networkMs){ return api.post(bootstrap.endpoints.heartbeat, { network_ms: networkMs }); },
    startHeartbeat: function(intervalMs, networkMsProvider){
      if (api._sessionExpired || !bootstrap.endpoints || !bootstrap.endpoints.heartbeat) return null;
      api.stopHeartbeat();
      heartbeatNetworkMsProvider = networkMsProvider || null;
      intervalMs = Math.max(12000, Number(intervalMs || 15000));
      var beat = function(){
        if (api._sessionExpired || document.hidden || offlineAt) return;
        var networkMs = 0;
        try {
          networkMs = typeof heartbeatNetworkMsProvider === 'function' ? heartbeatNetworkMsProvider() : heartbeatNetworkMsProvider;
        } catch(e){}
        api.heartbeat(Number(networkMs) || 0);
      };
      heartbeatTimer = window.setInterval(beat, intervalMs);
      heartbeatKickTimer = window.setTimeout(function(){ heartbeatKickTimer = null; beat(); }, 1200);
      return heartbeatTimer;
    },
    canPlayFx: canPlayFx,
    registerFxNode: registerFxNode,
    fxBudget: fxBudget,
    reportTamper: async function(reason){
      if (api._tamperReported) return { st:false, skipped:true };
      var endpoint = securityEndpoint();
      if (!endpoint) return { st:false, error:'security_endpoint_missing' };
      api._tamperReported = true;
      return api.post(endpoint, { reason: reason || 'browser tamper attempt detected' });
    },
    hasPusherConfig: function(){
      var accounts = bootstrap && bootstrap.realtime && bootstrap.realtime.pusher && bootstrap.realtime.pusher.accounts;
      if (Array.isArray(accounts) && accounts.some(function(account){ return account && account.key && String(account.key).trim(); })) return true;
      return !!(bootstrap && bootstrap.realtime && bootstrap.realtime.pusher && bootstrap.realtime.pusher.key && String(bootstrap.realtime.pusher.key).trim());
    },
    hasWebSocketConfig: function(){
      return !!(bootstrap && bootstrap.realtime && bootstrap.realtime.websocket && bootstrap.realtime.websocket.enabled !== false && bootstrap.realtime.websocket.url && String(bootstrap.realtime.websocket.url).trim());
    },
    startWebSocketState: function(){
      if (!api.hasWebSocketConfig() || typeof window.WebSocket === 'undefined' || api._sessionExpired) return false;
      api.stopWebSocketState();
      var reconnectMs = Number((bootstrap.realtime.websocket && bootstrap.realtime.websocket.reconnectMs) || 1500);
      var wsUrl = String(bootstrap.realtime.websocket.url || '').trim();
      if (!wsUrl) return false;
      if (bootstrap.gameCode) wsUrl += (wsUrl.indexOf('?') > -1 ? '&' : '?') + 'game_code=' + encodeURIComponent(bootstrap.gameCode);
      try {
        var protocols = (bootstrap.realtime.websocket && bootstrap.realtime.websocket.protocols) || [];
        api._ws = Array.isArray(protocols) && protocols.length ? new window.WebSocket(wsUrl, protocols) : new window.WebSocket(wsUrl);
      } catch (e) {
        notifyConnection({ status: 'error', transport: 'websocket', message: e && e.message ? e.message : 'ws_init_failed' });
        return false;
      }
      api._transport = 'websocket';
      api._ws.onopen = function(){ notifyConnection({ status: 'ok', transport: 'websocket' }); };
      api._ws.onmessage = function(evt){
        var data = null;
        try { data = JSON.parse(evt.data); } catch(e){}
        if (!data) return;
        var payload = data;
        if (data.data && typeof data.data === 'object') payload = data.data;
        handleMaintenancePayload(payload);
        handleSecurityPayload(payload);
        handleRetryPayload(payload);
        if (payload && payload.st) {
          api._lastRealtimeStateAt = Date.now();
          notifyState(payload);
        }
      };
      api._ws.onerror = function(){ notifyConnection({ status: 'error', transport: 'websocket' }); };
      api._ws.onclose = function(){
        notifyConnection({ status: 'disconnected', transport: 'websocket' });
        if (!api._sessionExpired && !api.hasPusherConfig()) {
          api._wsReconnectTimer = window.setTimeout(function(){ api.startWebSocketState(); }, Math.max(600, reconnectMs));
        }
      };
      return true;
    },
    connectRealtime: function(){
      var mode = bootstrap.realtime && bootstrap.realtime.mode ? String(bootstrap.realtime.mode) : (bootstrap.realtime && bootstrap.realtime.enabled ? 'pusher' : 'polling');
      var fallbackToPolling = function(message){
        notifyConnection({ status: message ? 'fallback' : 'ok', transport: 'polling', message: message || 'polling' });
        api.startPollingState((bootstrap.realtime && bootstrap.realtime.pollFallbackMs) || 1500);
        api._transport = 'polling';
        return true;
      };
      api.stopWebSocketState();
      api.stopPollingState();

      if (mode === 'polling' || !bootstrap.realtime) {
        return fallbackToPolling();
      }

      if (mode === 'pusher' && window.Pusher && bootstrap.realtime.pusher && api.hasPusherConfig()) {
        var pusherCfg = bootstrap.realtime.pusher || {};
        var accounts = Array.isArray(pusherCfg.accounts) && pusherCfg.accounts.length ? pusherCfg.accounts.slice() : [{
          key: pusherCfg.key,
          cluster: pusherCfg.options && pusherCfg.options.cluster,
          host: pusherCfg.options && pusherCfg.options.wsHost,
          port: pusherCfg.options && (pusherCfg.options.forceTLS ? pusherCfg.options.wssPort : pusherCfg.options.wsPort),
          scheme: pusherCfg.options && pusherCfg.options.forceTLS ? 'https' : 'http'
        }];
        var startIndex = Number(pusherCfg.activeIndex || 0);
        var ordered = accounts.slice(startIndex).concat(accounts.slice(0, startIndex));
        var tryPusherAccount = function(account, index){
          account = account || {};
          if (!account.key) return false;
          try {
          var options = Object.assign({}, pusherCfg.options || {}, {
            cluster: account.cluster || (pusherCfg.options && pusherCfg.options.cluster) || 'mt1'
          });
          if (account.host) options.wsHost = account.host;
          if (account.port) {
            options.wsPort = Number(account.port);
            options.wssPort = Number(account.port);
          }
          if (account.scheme) {
            options.forceTLS = account.scheme === 'https';
            options.encrypted = account.scheme === 'https';
          }
          var p = new window.Pusher(account.key, options);
          var ch = p.subscribe(bootstrap.realtime.channel);
          ch.bind(bootstrap.realtime.event, function(data){
            handleMaintenancePayload(data);
            handleSecurityPayload(data);
            handleRetryPayload(data);
            if (data && data.st) {
              api._lastRealtimeStateAt = Date.now();
              notifyState(data);
            }
          });
          if (p.connection && typeof p.connection.bind === 'function') {
            p.connection.bind('connected', function(){ notifyConnection({ status: 'ok', transport: 'pusher', account: (account.slot || index || 0) + 1 }); });
            p.connection.bind('error', function(err){ notifyConnection({ status: 'error', transport: 'pusher', account: (account.slot || index || 0) + 1, message: (err && err.error && err.error.data) ? String(err.error.data) : 'pusher_error' }); });
            p.connection.bind('failed', function(){ notifyConnection({ status: 'error', transport: 'pusher', account: (account.slot || index || 0) + 1, message: 'pusher_failed' }); });
            p.connection.bind('unavailable', function(){ notifyConnection({ status: 'error', transport: 'pusher', account: (account.slot || index || 0) + 1, message: 'pusher_unavailable' }); });
            p.connection.bind('disconnected', function(){ notifyConnection({ status: 'disconnected', transport: 'pusher' }); });
          }
          api._transport = 'pusher';
          api._pusher = p;
          api._channel = ch;
          api.startPollingState((bootstrap.realtime && bootstrap.realtime.pollFallbackMs) || 1500);
          return true;
        } catch (e) {
          notifyConnection({ status: 'error', transport: 'pusher', message: e && e.message ? e.message : 'pusher_init_failed' });
          return false;
        }
        };
        for (var i = 0; i < ordered.length; i++) {
          if (tryPusherAccount(ordered[i], i)) return true;
        }
      }

      if (mode === 'websocket' && api.hasWebSocketConfig()) {
        if (api.startWebSocketState()) {
          api.startPollingState((bootstrap.realtime && bootstrap.realtime.pollFallbackMs) || 1500);
          return true;
        }
      }

      return fallbackToPolling(mode + '_not_configured');
    },
    startPollingState: function(intervalMs){
      intervalMs = intervalMs || 1500;
      if (api._poller) clearInterval(api._poller);
      if (api._sessionExpired) return null;
      api._pollBusy = false;
      var poll = async function(){
        if (api._pollBusy) return;
        if (api._sessionExpired) {
          api.stopPollingState();
          return;
        }
        api._pollBusy = true;
        var res = await api.get(bootstrap.endpoints.state, {});
        if (res && res.st) {
          hideMaintenanceOverlay();
          notifyState(res);
        }
        api._pollBusy = false;
      };
      poll();
      api._poller = setInterval(poll, intervalMs);
      if (api._transport === 'idle') api._transport = 'polling';
      return api._poller;
    }
  };
  window.BDGameFinal = api;
  window.BDGameFinalBetAudio = betAudioController;
  installBrandingLayer();
  installPerformanceLayer();
  (function installInactivityHooks(){
    if (!window.addEventListener) return;
    window.addEventListener('visibilitychange', function(){
      if (document.hidden) {
        hiddenAt = Date.now();
        if (betAudioController) betAudioController.stop('hidden');
        api.stopPollingState();
        api.stopWebSocketState();
        return;
      }
      wakeResumeAt = Date.now();
      recoverFromInactivity();
      if (betAudioController && lastStatePayload) betAudioController.sync(lastStatePayload);
      hiddenAt = 0;
    });
    window.addEventListener('focus', function(){
      wakeResumeAt = Date.now();
      recoverFromInactivity();
      if (betAudioController && lastStatePayload) betAudioController.sync(lastStatePayload);
      hiddenAt = 0;
    });
    window.addEventListener('blur', function(){
      hiddenAt = Date.now();
      if (betAudioController) betAudioController.stop('blur');
      api.stopPollingState();
      api.stopWebSocketState();
    });
    window.addEventListener('pagehide', function(event){
      if (betAudioController) betAudioController.stop('pagehide');
      api.stopHeartbeat();
      if (event.persisted) {
        requestRefresh('pagehide_bfcache');
        return;
      }
      hiddenAt = Date.now();
      api.stopPollingState();
      api.stopWebSocketState();
    }, { capture: true });
    window.addEventListener('beforeunload', function(){
      if (betAudioController) betAudioController.stop('beforeunload');
      api.stopHeartbeat();
    }, { capture: true });
    window.addEventListener('pageshow', function(event){
      if (!event.persisted) return;
      requestRefresh('pageshow_bfcache_restore');
    }, { capture: true });
    window.addEventListener('offline', function(){
      offlineAt = Date.now();
      if (betAudioController) betAudioController.stop('offline');
      api.stopPollingState();
      api.stopWebSocketState();
      notifyConnection({ status: 'offline', message: 'offline_detected' });
    });
    window.addEventListener('online', function(){
      wakeResumeAt = Date.now();
      notifyConnection({ status: 'online', message: 'network_back' });
      recoverFromInactivity();
      offlineAt = 0;
    });
  })();
  (function installSecurityHooks(){
    if (bootstrap.clientSecurityHooks === false) return;
    if (window.__BDGF_SECURITY_HOOKS__) return;
    window.__BDGF_SECURITY_HOOKS__ = true;
    function report(reason){
      if (!api || api._sessionExpired) return;
      flashProtectionBadge();
      api.reportTamper(reason);
    }
    document.addEventListener('contextmenu', function(e){
      e.preventDefault();
      report('context menu or inspect menu attempt');
    }, true);
    document.addEventListener('copy', function(e){
      if (window.getSelection && String(window.getSelection()).trim()) {
        e.preventDefault();
        report('copy source or game data attempt');
      }
    }, true);
    document.addEventListener('dragstart', function(e){
      e.preventDefault();
      report('drag or asset save attempt');
    }, true);
    document.addEventListener('keydown', function(e){
      var key = String(e.key || '').toLowerCase();
      var blocked = key === 'f12'
        || (e.ctrlKey && key === 'u')
        || (e.ctrlKey && key === 's')
        || (e.ctrlKey && key === 'p')
        || (e.ctrlKey && e.shiftKey && ['i','j','c'].indexOf(key) !== -1);
      if (blocked) {
        e.preventDefault();
        e.stopPropagation();
        if (key === 'printscreen' || (e.metaKey && e.shiftKey && key === '3') || (e.metaKey && e.shiftKey && key === '4')) {
          flashProtectionBadge();
        }
        report('browser developer tool or source shortcut attempt');
      }
    }, true);
    window.addEventListener('keyup', function(e){
      var key = String(e.key || '').toLowerCase();
      if (key === 'printscreen') {
        flashProtectionBadge();
        report('screenshot shortcut attempt');
      }
    }, true);
  })();
  api.connectRealtime();
})();
