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
