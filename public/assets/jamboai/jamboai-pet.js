(function () {
  const cfg = window.JAMBOAI_PET_CONFIG || {};
  if (!cfg.enabled) return;
  const adminId = String(cfg.currentAdminId || "");
  const apiBase = String(cfg.apiBase || "/api/jambo-ai").replace(/\/+$/, "");
  const storageKey = `jamboai_pet_pos_${cfg.sourceApp || "app"}`;
  const iconSrc = String(cfg.iconSrc || "/assets/jamboai/jamboai-pet-icon.png");
  const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute("content") || "";
  const knownActive = new Set();
  let tooltipWords = [];
  let tooltipTimer = null;
  let tooltipHideTimer = null;
  let codeTimer = null;
  let closeTimer = null;
  let panelOpen = false;
  let lastTooltip = {};
  let firstTaskLoad = true;
  let workingTaskId = null;
  const quickMessages = [
    "Please check my domain issue.",
    "Start my job soon sir.",
    "Please check login/API problem.",
    "Need cache clear and status check.",
  ];
  const phpCodeLines = [
    "<?php",
    "Route::middleware(['auth'])->group(function () {",
    "    Cache::remember($key, 3, fn () => $service->safeRead());",
    "    DB::transaction(fn () => $task->markBusy());",
    "    dispatch(new JamboAiOpsReplyJob($taskId))->onQueue('redis');",
    "    Log::info('JAMBOai pet working safely', ['task' => $taskId]);",
    "});",
    "php artisan queue:work redis --sleep=1 --tries=1",
  ];

  function esc(value) {
    return String(value ?? "").replace(/[&<>"']/g, (ch) => ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[ch]));
  }
  function root() {
    let node = document.getElementById("jamboai-pet-root");
    if (!node) {
      node = document.createElement("div");
      node.id = "jamboai-pet-root";
      node.className = "jamboai-pet-root";
      document.body.appendChild(node);
    }
    return node;
  }
  function setMood(mood) {
    root().dataset.mood = mood || "pet";
  }
  function stopCoding() {
    clearInterval(codeTimer);
    codeTimer = null;
  }
  function hideTooltip() {
    const tip = document.getElementById("jamboai-tooltip");
    if (tip) tip.classList.add("is-quiet");
  }
  function scheduleTooltipHide(ms = 12000) {
    clearTimeout(tooltipHideTimer);
    tooltipHideTimer = setTimeout(hideTooltip, ms);
  }
  function schedulePanelClose(ms = 60000) {
    clearTimeout(closeTimer);
    closeTimer = setTimeout(closePanel, ms);
  }
  async function api(path, options = {}) {
    const res = await fetch(`${apiBase}${path}`, {
      credentials: "same-origin",
      ...options,
      headers: {
        "Accept": "application/json",
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": csrf,
        "X-Requested-With": "XMLHttpRequest",
        ...(options.headers || {}),
      },
    });
    const json = await res.json().catch(() => ({}));
    if (!res.ok || json.ok === false) throw new Error(json.error || `request_failed_${res.status}`);
    return json;
  }
  function say(text, mood = "reply", hideMs = 12000) {
    const tip = document.getElementById("jamboai-tooltip");
    if (!tip) return;
    setMood(mood);
    stopCoding();
    clearInterval(tooltipTimer);
    clearTimeout(tooltipHideTimer);
    tooltipWords = String(text || "").split(/\s+/).filter(Boolean);
    let i = 0;
    tip.textContent = "";
    tip.classList.remove("is-quiet");
    tooltipTimer = setInterval(() => {
      tip.textContent = tooltipWords.slice(0, i + 1).join(" ");
      i += 1;
      if (i >= tooltipWords.length) {
        clearInterval(tooltipTimer);
        scheduleTooltipHide(hideMs);
      }
    }, 90);
  }
  function startCoding(text = "Start my job soon. It is live sir.") {
    const tip = document.getElementById("jamboai-tooltip");
    if (!tip) return;
    setMood("working");
    clearInterval(tooltipTimer);
    clearTimeout(tooltipHideTimer);
    stopCoding();
    let line = 0;
    let char = 0;
    const heading = `${text}\n\n`;
    tip.textContent = heading;
    tip.classList.remove("is-quiet");
    codeTimer = setInterval(() => {
      const active = phpCodeLines[line % phpCodeLines.length];
      tip.textContent = heading + active.slice(0, char + 1);
      char += 1;
      if (char >= active.length) {
        char = 0;
        line += 1;
      }
    }, 42);
  }
  function moveIntoView() {
    const box = root();
    box.style.left = "";
    box.style.top = "";
    box.style.right = "22px";
    box.style.bottom = "22px";
    localStorage.removeItem(storageKey);
    say("I am here sir. Send task/message to ops.", "reply");
  }
  function savePos(left, top) {
    localStorage.setItem(storageKey, JSON.stringify({ left, top }));
  }
  function shouldStartCoding(text) {
    return /start|busy|job soon|live sir|working|coding/i.test(String(text || ""));
  }
  function applyPos() {
    try {
      const pos = JSON.parse(localStorage.getItem(storageKey) || "{}");
      if (Number.isFinite(pos.left) && Number.isFinite(pos.top)) {
        const box = root();
        box.style.left = `${Math.max(8, Math.min(window.innerWidth - 100, pos.left))}px`;
        box.style.top = `${Math.max(8, Math.min(window.innerHeight - 100, pos.top))}px`;
        box.style.right = "auto";
        box.style.bottom = "auto";
      }
    } catch {}
  }
  function enableDrag() {
    const pet = document.getElementById("jamboai-pet");
    if (!pet || pet.dataset.dragBound === "1") return;
    pet.dataset.dragBound = "1";
    let start = null;
    pet.addEventListener("pointerdown", (event) => {
      start = { x: event.clientX, y: event.clientY, rect: root().getBoundingClientRect(), moved: false };
      pet.setPointerCapture(event.pointerId);
    });
    pet.addEventListener("pointermove", (event) => {
      if (!start) return;
      const dx = event.clientX - start.x;
      const dy = event.clientY - start.y;
      if (Math.abs(dx) + Math.abs(dy) > 4) start.moved = true;
      const left = Math.max(8, Math.min(window.innerWidth - 100, start.rect.left + dx));
      const top = Math.max(8, Math.min(window.innerHeight - 100, start.rect.top + dy));
      const box = root();
      box.style.left = `${left}px`;
      box.style.top = `${top}px`;
      box.style.right = "auto";
      box.style.bottom = "auto";
      savePos(left, top);
    });
    pet.addEventListener("pointerup", () => {
      if (start && !start.moved) openPanel();
      start = null;
    });
  }
  function renderPanel(tasks = [], history = [], error = "") {
    const old = document.getElementById("jamboai-panel");
    if (old) old.remove();
    const panel = document.createElement("div");
    panel.id = "jamboai-panel";
    panel.className = "jamboai-panel";
    panel.innerHTML = `
      <button class="jamboai-close" type="button" aria-label="Close" onclick="JAMBOaiPet.close()">x</button>
      <h3>JAMBOai Communication</h3>
      <p class="jamboai-muted">Send task/message to ops. Ops replies show here like an agent. Text never runs shell commands.</p>
      <textarea id="jamboai-task-text" class="jamboai-textarea" maxlength="1000" placeholder="Write task/message for ops admin..."></textarea>
      <div style="display:flex;gap:8px;align-items:center;margin-top:10px;flex-wrap:wrap">
        <button class="jamboai-btn" type="button" onclick="JAMBOaiPet.submit()">Send to Ops</button>
        <button class="jamboai-mini" type="button" onclick="JAMBOaiPet.load()">Refresh</button>
      </div>
      <div class="jamboai-quick">
        ${quickMessages.map((message) => `<button class="jamboai-chip" type="button" onclick="JAMBOaiPet.quick('${esc(message).replace(/'/g, "\\'")}')">${esc(message)}</button>`).join("")}
      </div>
      ${error ? `<div class="jamboai-error">${esc(error)}</div>` : ""}
      <h4>Active Communication</h4>
      <div>${tasks.map((task) => `<div class="jamboai-row"><b>#${esc(task.id)} ${esc(task.status)}</b><small>Admin message: ${esc(task.message)}</small>${task.tooltip ? `<small class="jamboai-reply">Ops reply: ${esc(task.tooltip)}</small>` : `<small>Waiting for ops reply...</small>`}</div>`).join("") || `<div class="jamboai-row jamboai-muted">No active communication.</div>`}</div>
      <h4>Ops Reply History</h4>
      <div>${history.map((task) => `<div class="jamboai-row"><b>#${esc(task.id)} ${esc(task.status)}</b><small>Admin message: ${esc(task.message)}</small>${task.done_note ? `<small class="jamboai-reply">Ops note: ${esc(task.done_note)}</small>` : ""}</div>`).join("") || `<div class="jamboai-row jamboai-muted">No completed communication yet.</div>`}</div>
    `;
    document.body.appendChild(panel);
  }
  async function loadTasks() {
    try {
      const data = await api("/tasks");
      const tasks = data.tasks || [];
      const history = data.history || [];
      tasks.forEach((task) => {
        const key = String(task.id);
        knownActive.add(key);
        if (task.tooltip && lastTooltip[task.id] !== task.tooltip) {
          lastTooltip[task.id] = task.tooltip;
          if (!firstTaskLoad) {
            if (!panelOpen) openPanel(false);
            if (shouldStartCoding(task.tooltip)) {
              workingTaskId = key;
              startCoding(`Ops reply: ${task.tooltip}`);
            } else {
              say(`Ops reply: ${task.tooltip}`, "reply", 14000);
              schedulePanelClose(14000);
            }
          }
        }
      });
      history.forEach((task) => {
        const key = String(task.id);
        if ((knownActive.has(key) || workingTaskId === key) && task.status === "done") {
          knownActive.delete(key);
          if (!firstTaskLoad) {
            workingTaskId = null;
            stopCoding();
            if (!panelOpen) openPanel(false);
            say(task.done_note ? `Ops completed: ${task.done_note}` : "Ops completed: Your work completed sir.", "done", 12000);
            schedulePanelClose(12000);
          }
        }
      });
      firstTaskLoad = false;
      if (panelOpen) renderPanel(tasks, history);
      return data;
    } catch (error) {
      if (panelOpen) renderPanel([], [], error.message || "Task API unavailable");
      return null;
    }
  }
  async function submitTask() {
    const field = document.getElementById("jamboai-task-text");
    const message = String(field?.value || "").trim();
    if (!message) return say("Please write your task first sir.");
    try {
      await api("/tasks", { method: "POST", body: JSON.stringify({ message }) });
      if (field) field.value = "";
      say("Message sent to ops sir. I will follow that and wait for reply.");
      await loadTasks();
    } catch (error) {
      say("Task submit failed sir. Please check your admin session.");
      if (panelOpen) renderPanel([], [], error.message || "submit failed");
    }
  }
  function quick(message) {
    const field = document.getElementById("jamboai-task-text");
    if (field) field.value = message;
    say(message);
  }
  function openPanel(load = true) {
    panelOpen = true;
    renderPanel([], [], "");
    schedulePanelClose(60000);
    if (load) loadTasks();
  }
  function closePanel() {
    panelOpen = false;
    clearTimeout(closeTimer);
    document.getElementById("jamboai-panel")?.remove();
  }
  function boot() {
    const box = root();
    box.innerHTML = `
      <div id="jamboai-tooltip" class="jamboai-tooltip is-quiet"></div>
      <div id="jamboai-pet" class="jamboai-pet" title="JAMBOai Pet"><img src="${esc(iconSrc)}" alt="JAMBOai Pet"></div>
      <div class="jamboai-actions"><button class="jamboai-mini" type="button" onclick="JAMBOaiPet.find()">Find Pet</button></div>
    `;
    applyPos();
    enableDrag();
    setInterval(loadTasks, Number(cfg.pollMs || 15000));
  }
  window.JAMBOaiPet = { say, open: openPanel, close: closePanel, load: loadTasks, submit: submitTask, quick, find: moveIntoView };
  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", boot);
  else boot();
})();
