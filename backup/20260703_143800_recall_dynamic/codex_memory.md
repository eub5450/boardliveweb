# Codex Memory

## 2026-07-03 13:20 Asia/Dhaka
- current task: Broadlive live server portal/protal dynamic setting follow-up. Existing direct transfer minimum setting was kept, and the remaining hard-coded portal-to-portal amount condition was made dynamic for API V3 and V4.
- syntax notes: PortalController now reads dynamic values from `settings` through helper methods. Portal-to-portal amount validation uses `min`, `max`, and `step` and requires `(amount - min) % step == 0`.
- code pattern notes: Keep portal business rules in `settings` row `id=1` and use controller fallbacks for safe defaults when a value is missing or invalid.
- file pattern notes: Admin setting page for portal rules lives at `resources/views/backend/protal/system_setting.blade.php`; admin write path is `App\Http\Controllers\Admin\ProtalController`; API consumers are `App\Http\Controllers\Api\V3\PortalController` and `App\Http\Controllers\Api\V4\PortalController`.
- old behavior: Direct transfer minimum was dynamic, but portal-to-portal transfer still allowed only fixed values from `500000` to `10000000` with step `100000`.
- new behavior: Admin can now change direct transfer minimum, portal-to-portal minimum, portal-to-portal maximum, and portal-to-portal step from `Setting -> System Setting -> Protal setting`. V3 and V4 use those values live.
- changed files: `app/Http/Controllers/Api/V3/PortalController.php`, `app/Http/Controllers/Api/V4/PortalController.php`, `app/Http/Controllers/Admin/ProtalController.php`, `resources/views/backend/protal/system_setting.blade.php`.
- validation: `php -l` passed on both app nodes for all three controllers. Blade setting page contains the new fields and tooltips. Live DB defaults confirmed as `50000`, `500000`, `10000000`, `100000`.
- rollback command: restore from `/var/www/broadlive/current/backup/20260703_130500_protal_dynamic/` on both app nodes, or copy the same backups back over the changed files. Local rollback source: `D:\backup\20260703_130500`.
- commit id: server-live-no-git-commit
- APK/build proof: not applicable

## 2026-07-03 13:55 Asia/Dhaka
- current task: Broadlive live server reward setup was moved into dynamic admin settings without collapsing the different defaults used by the active V4 and legacy video daytime endpoints.
- syntax notes: Reward settings are read from `settings` with controller-local helper methods for `int`, `string`, and `bool`; reward thresholds are stored in minutes in admin and converted to seconds in code.
- code pattern notes: Keep V4 reward settings separate from legacy reward settings to avoid changing current live behavior for older clients when admin edits V4 values.
- file pattern notes: Reward admin inputs were added to `resources/views/backend/protal/system_setting.blade.php`; admin persistence stays in `App\Http\Controllers\Admin\ProtalController`; live reward consumers are `App\Http\Controllers\Api\V4\VideoBrdController` and `App\Http\Controllers\Api\VideoBrdController`.
- old behavior: V4 reward was hard-coded at 60 minutes, 4000 coins, sender `11162`, gift `reward.svga`. Legacy reward was hard-coded at 50 minutes, 5000 coins, sender `11162`, gift `reward.svga`, with blocked time `05:00:00` to `11:00:00`.
- new behavior: Admin can now change V4 reward active state, target minutes, amount, sender ID, and gift name. Admin can also change legacy reward active state, target minutes, amount, sender ID, gift name, blocked-time active state, blocked start, and blocked end.
- changed files: `app/Http/Controllers/Api/V4/VideoBrdController.php`, `app/Http/Controllers/Api/VideoBrdController.php`, `app/Http/Controllers/Admin/ProtalController.php`, `resources/views/backend/protal/system_setting.blade.php`, `codex_memory.md`.
- validation: `php -l` passed on both app nodes for `app/Http/Controllers/Api/V4/VideoBrdController.php`, `app/Http/Controllers/Api/VideoBrdController.php`, and `app/Http/Controllers/Admin/ProtalController.php`. Blade setting page contains the new reward setup fields. Live DB defaults are V4 `enabled=1, minutes=60, amount=4000, sender=11162, gift=reward.svga`; legacy `enabled=1, minutes=50, amount=5000, sender=11162, gift=reward.svga, block_enabled=1, block_start=05:00:00, block_end=11:00:00`.
- rollback command: restore from `/var/www/broadlive/current/backup/20260703_134500_reward_dynamic/` on both app nodes, or copy local backup files from `D:\backup\20260703_134500`.
- commit id: server-live-no-git-commit
- APK/build proof: not applicable

## 2026-07-03 14:18 Asia/Dhaka
- current task: Modernized the Broadlive admin `System Setting` UI for the portal and reward setup page without changing any setting logic or route behavior.
- syntax notes: View-only blade refresh with scoped CSS inside the page; no controller or DB changes were required.
- code pattern notes: Keep admin system-setting UI self-contained in the blade so the rest of the backend theme is not affected.
- file pattern notes: The redesigned page remains at `resources/views/backend/protal/system_setting.blade.php`.
- old behavior: Page used a long inline form layout with repeated row groups and limited visual separation between portal and reward sections.
- new behavior: Page now uses a modern header band, grouped setting panels, responsive grid fields, clearer helper text, toggle-style switches, and a cleaner save area for mobile and desktop.
- changed files: `resources/views/backend/protal/system_setting.blade.php`, `codex_memory.md`.
- validation: `php artisan view:clear` and `php artisan view:cache` passed on both app nodes after deployment.
- rollback command: restore `/var/www/broadlive/current/backup/20260703_141500_system_setting_ui/system_setting.blade.php` on both app nodes, or restore local copy from `D:\backup\20260703_141500`.
- commit id: server-live-no-git-commit
- APK/build proof: not applicable
