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

## 2026-07-03 14:47 Asia/Dhaka
- current task: Made user-balance recall split dynamic for both admin and country-admin portal recall panels, and exposed the split in `System Setting` as `Recall Setting`.
- syntax notes: Recall split uses integer percentages from `settings`; `Portal % + Company %` is validated to equal exactly `100`; split amounts are calculated as `portalAmount = round(total * portal% / 100, 2)` and `companyAmount = total - portalAmount`.
- code pattern notes: Keep recall split rules in `settings` row `id=1`, and let runtime controllers fall back to `70/30/1` only if settings are missing or invalid.
- file pattern notes: Admin setting persistence is in `app/Http/Controllers/Admin/ProtalController.php`; admin recall flow is `app/Http/Controllers/Admin/ReCallController.php`; country-admin recall flow is `app/Http/Controllers/Author/ProtalController.php`; UI is `resources/views/backend/protal/system_setting.blade.php`.
- old behavior: Admin and country-admin recall subtracted the full amount from `users.balance` and credited the full amount to the selected portal as a recall recharge.
- new behavior: Admin can set `Portal %`, `Company %`, and `Company User ID`. On recall, full amount is deducted from the selected user balance, the portal share is credited to the selected portal recharge record, and the company share is added directly to the configured company user balance.
- changed files: `app/Http/Controllers/Admin/ProtalController.php`, `app/Http/Controllers/Admin/ReCallController.php`, `app/Http/Controllers/Author/ProtalController.php`, `resources/views/backend/protal/system_setting.blade.php`, `codex_memory.md`.
- validation: `php -l` passed on both app nodes for all three controllers. `php artisan view:clear` and `php artisan view:cache` passed on both nodes. Live DB defaults confirmed as `recall_portal_percentage=70`, `recall_company_percentage=30`, `recall_company_user_id=1`.
- rollback command: restore from `/var/www/broadlive/current/backup/20260703_143800_recall_dynamic/` on both app nodes, or restore local copies from `D:\backup\20260703_143800`.
- commit id: server-live-no-git-commit
- APK/build proof: not applicable

## 2026-07-03 15:00 Asia/Dhaka
- current task: Corrected `recall_company_user_id` after checking the live Broadlive DB and older recall code usage.
- syntax notes: Runtime fallback for `recall_company_user_id` was changed from `1` to `11111` in the admin and country-admin recall controllers.
- code pattern notes: Historical recall-related code referenced `555555`, but that user does not exist in the current Broadlive `users` table. The current live official account present in DB is `11111` (`OFFICIAL`), so that is now used as the company-user target.
- old behavior: Dynamic recall setting was saved with `recall_company_user_id = 1`, which is not a valid official/company target for this app.
- new behavior: Live setting row now uses `recall_company_user_id = 11111`, and controller fallbacks also default to `11111`.
- changed files: `app/Http/Controllers/Admin/ProtalController.php`, `app/Http/Controllers/Admin/ReCallController.php`, `app/Http/Controllers/Author/ProtalController.php`, `codex_memory.md`.
- validation: Live DB check returned `{"recall_portal_percentage":70,"recall_company_percentage":30,"recall_company_user_id":11111}`. `php -l` passed on both app nodes for the three recall-related controllers.
- rollback command: change the setting back from admin `System Setting`, or restore files from `/var/www/broadlive/current/backup/20260703_143800_recall_dynamic/`.
- commit id: server-live-no-git-commit
- APK/build proof: not applicable

## 2026-07-03 15:18 Asia/Dhaka
- current task: Aligned `Admin\ProtalController::Recall()` with the same dynamic recall split used by the other admin and country-admin recall flows.
- old behavior: This recall path still saved a recall record and deposited the full recall amount to hard-coded user `555555`.
- new behavior: This recall path now reads `recall_portal_percentage`, `recall_company_percentage`, and `recall_company_user_id`, credits the portal share to the selected portal, and credits the company share to the configured company user.
- changed files: `app/Http/Controllers/Admin/ProtalController.php`, `codex_memory.md`.
- validation: `php -l` passed on both app nodes for `app/Http/Controllers/Admin/ProtalController.php`. Live file no longer uses hard-coded `555555` in this recall method.
- rollback command: restore `/var/www/broadlive/current/backup/20260703_152000_protal_recall_align/ProtalController.Admin.php` on both app nodes, or restore local copy from `D:\backup\20260703_152000`.
- commit id: server-live-no-git-commit
- APK/build proof: not applicable

## 2026-07-07 Broadlive agency create and admin slider store fix
- current task: fix /var/www/broadlive/current admin agency create not storing/not showing in list and /admin-slider image storage path.
- findings: the live Broadlive root is /var/www/broadlive/current. Broadlive Nginx serves /store from /var/www/broadlive/current/store, but agency uploads were being written to public/store/agency. Slider rows used store/banner paths and files existed on only one app node, so the edge load balancer could hit the other node and return 404. The edge /store route also did not retry another origin on 404. Broadlive user 11130 exists; user 1111 does not exist in Broadlive.
- new behavior: Admin\AgencyController stores agency photo_id/selfie under store/agency, generates a unique agency code server-side if the readonly form code is missing/invalid/duplicate, and wraps the agency insert plus user flag update in a DB transaction. Admin\UserController returns a safe next agency code and clean user-not-found JSON. Admin\SliderController validates uploads, stores banners under store/banner, saves relative paths, and clears slider cache. Api\V4\SliderController handles missing auth/user safely and maps relative slider paths to the current request host. Existing agency and banner files were synced into the served store paths on both app nodes. Broadlive app-node Nginx /store now uses root instead of broken alias try_files. Broadlive edge /store now retries another origin on 404.
- changed files on both app nodes: /var/www/broadlive/current/app/Http/Controllers/Admin/AgencyController.php; app/Http/Controllers/Admin/UserController.php; app/Http/Controllers/Admin/SliderController.php; app/Http/Controllers/Api/V4/SliderController.php; resources/views/backend/agency/create.blade.php; resources/views/backend/slider/index.blade.php; /etc/nginx/sites-available/broadlive.conf; codex_memory.md.
- changed file on edge-01: /etc/nginx/sites-available/broadlive_edge.conf.
- validation: php -l passed for all changed controllers on both app nodes; php artisan view:clear and route:clear ran on both nodes; nginx -t passed and nginx reloaded on both app nodes and edge-01; /store/banner/6a4a8117a71ac.png returns 200 publicly; /store/agency/695cf0c57acd6.jpg returns 200 publicly; Admin\UserController direct check returns next_agency_code 100100 for user 11130 and clean user-not-found for 1111; changed app file hashes match between app01 and app02.
- backup path app nodes: /var/backups/jamboai/20260707_002650_broadlive_agency_slider_store_fix.
- backup path edge-01: /var/backups/jamboai/20260707_002650_broadlive_agency_slider_store_fix.
- rollback command per app node: cd /var/www/broadlive/current && cp -a /var/backups/jamboai/20260707_002650_broadlive_agency_slider_store_fix/AdminAgencyController.php.bak app/Http/Controllers/Admin/AgencyController.php && cp -a /var/backups/jamboai/20260707_002650_broadlive_agency_slider_store_fix/AdminUserController.php.bak app/Http/Controllers/Admin/UserController.php && cp -a /var/backups/jamboai/20260707_002650_broadlive_agency_slider_store_fix/AdminSliderController.php.bak app/Http/Controllers/Admin/SliderController.php && cp -a /var/backups/jamboai/20260707_002650_broadlive_agency_slider_store_fix/ApiV4SliderController.php.bak app/Http/Controllers/Api/V4/SliderController.php && cp -a /var/backups/jamboai/20260707_002650_broadlive_agency_slider_store_fix/agency_create.blade.php.bak resources/views/backend/agency/create.blade.php && cp -a /var/backups/jamboai/20260707_002650_broadlive_agency_slider_store_fix/slider_index.blade.php.bak resources/views/backend/slider/index.blade.php && cp -a /var/backups/jamboai/20260707_002650_broadlive_agency_slider_store_fix/broadlive.conf.available.bak /etc/nginx/sites-available/broadlive.conf && php artisan view:clear && php artisan route:clear && nginx -t && systemctl reload nginx
- rollback command edge-01: cp -a /var/backups/jamboai/20260707_002650_broadlive_agency_slider_store_fix/broadlive_edge.conf.available.bak /etc/nginx/sites-available/broadlive_edge.conf && nginx -t && systemctl reload nginx
- commit id: none; production directories are not Git repositories.
- APK/build proof: N/A.
## 2026-07-07 Codex - Broadlive admin sidebar professional arrangement and POP routing audit
- current task: Arrange Broadlive admin sidebar professionally with clearer menu names, section icons, and submenu grouping; audit requested BDIX/India/Singapore image/data routing.
- repo path: /var/www/broadlive/current on app01 159.223.42.204 and app02 152.42.223.173.
- git status: not a git repository in live release path; no local commit created.
- backup path: /var/backups/jamboai/20260707_003900_broadlive_sidebar_professional.
- changed files: resources/views/backend/layouts/sidebar.blade.php; codex_memory.md.
- old behavior: Sidebar used less professional labels such as Protal, ReCall, Ban ID, Live, Teenpati/Fruits Pattan and repeated generic book icons for major groups.
- new behavior: Sidebar now uses clearer groups such as Operations, Host Management, Agency Management, Portal & Recharge, Support Center, Reports & Rankings, Wallet Control, Coin Operations, Moderation, Live Monitoring, Game Operations, and System Settings, with matching typcn icons.
- routing audit: Edge Nginx currently sends static/image paths (/store/, /cdn-img/, static assets) for Bangladesh traffic to BDIX 103.174.153.40 and default traffic to Singapore POP 159.223.68.214. Dynamic/admin/API routes stay on origin. Other Asia entries currently map to origin, and static_pop=india is also origin because no dedicated India server target is configured.
- validation: php artisan view:clear and route:clear completed on both app nodes; sidebar sha256 matched on both nodes: 77a3d054630477e7fb3b39f335b4dc560b7c8050d4be6735146a265fce755b55.
- rollback command: cd /var/www/broadlive/current && cp -a /var/backups/jamboai/20260707_003900_broadlive_sidebar_professional/sidebar.blade.php.bak resources/views/backend/layouts/sidebar.blade.php && php artisan view:clear && php artisan route:clear.
- commit id: none; live path is not git.

## 2026-07-07 Codex - Broadlive dashboard realtime feeds and slider URL fix
- current task: Redesign Broadlive admin dashboard, move Available Coins out of sidebar, include Game Pro calculation in profit, add realtime comment/chat feeds, and fix admin/API slider image URLs.
- repo path: /var/www/broadlive/current on app01 159.223.42.204 and app02 152.42.223.173.
- git status: not a git repository in live release path; no local commit created.
- backup path: /var/backups/jamboai/20260707_005200_broadlive_dashboard_slider_fix.
- changed files: app/Http/Controllers/Admin/DashbordController.php; app/Http/Controllers/Admin/SliderController.php; app/Http/Controllers/Api/V4/SliderController.php; app/Http/Controllers/Api/V4/UserDataController.php; routes/api.php; routes/web.php; resources/views/backend/home.blade.php; resources/views/backend/layouts/sidebar.blade.php; resources/views/backend/layouts/topbar.blade.php; resources/views/backend/comment.blade.php; resources/views/backend/chat.blade.php; resources/views/backend/slider/index.blade.php; codex_memory.md.
- old behavior: Available Coins showed inside the sidebar, dashboard comment/chat panels were empty, profit did not show Game Pro calculation detail, /api/v4/slider redirected to login because the duplicate route was inside the Sanctum group, and slider images were exposed as raw relative paths in API/admin contexts.
- new behavior: Available Coins is shown in the top bar outside sidebar; dashboard has summary pills for available coins, Game Pro calculation, comments last hour, and chats last hour; profit uses base profit plus Game Pro balance and displays the formula; comment/chat panels poll existing admin routes every 5 seconds; admin slider previews use normalized public URLs; /api/v4/slider is a public read route with only the legacy access_token check and returns application/json with full https://broadlive.xyz/store/banner URLs; V4 user_data slider array also normalizes image URLs.
- validation: php -l passed for changed PHP files; php artisan route:clear/view:clear/view:cache passed on both nodes; route-list shows api/v4/slider middleware is only api; curl https://broadlive.xyz/api/v4/slider?access_token=0411f0028cfb768b3a3d96ac3aa37dw3e5&user_id=11130 returned 200 application/json with full banner URLs; curl https://broadlive.xyz/store/banner/6a4a8117a71ac.png returned 200; comment and chat partials rendered from controller without exceptions; changed file hashes match between both app nodes.
- rollback command: cd /var/www/broadlive/current && cp -a /var/backups/jamboai/20260707_005200_broadlive_dashboard_slider_fix/app__Http__Controllers__Admin__DashbordController.php.bak app/Http/Controllers/Admin/DashbordController.php && cp -a /var/backups/jamboai/20260707_005200_broadlive_dashboard_slider_fix/app__Http__Controllers__Admin__SliderController.php.bak app/Http/Controllers/Admin/SliderController.php && cp -a /var/backups/jamboai/20260707_005200_broadlive_dashboard_slider_fix/app__Http__Controllers__Api__V4__SliderController.php.bak app/Http/Controllers/Api/V4/SliderController.php && cp -a /var/backups/jamboai/20260707_005200_broadlive_dashboard_slider_fix/app__Http__Controllers__Api__V4__UserDataController.php.bak app/Http/Controllers/Api/V4/UserDataController.php && cp -a /var/backups/jamboai/20260707_005200_broadlive_dashboard_slider_fix/routes__api.php.bak routes/api.php && cp -a /var/backups/jamboai/20260707_005200_broadlive_dashboard_slider_fix/routes__web.php.bak routes/web.php && cp -a /var/backups/jamboai/20260707_005200_broadlive_dashboard_slider_fix/resources__views__backend__home.blade.php.bak resources/views/backend/home.blade.php && cp -a /var/backups/jamboai/20260707_005200_broadlive_dashboard_slider_fix/resources__views__backend__layouts__sidebar.blade.php.bak resources/views/backend/layouts/sidebar.blade.php && cp -a /var/backups/jamboai/20260707_005200_broadlive_dashboard_slider_fix/resources__views__backend__layouts__topbar.blade.php.bak resources/views/backend/layouts/topbar.blade.php && cp -a /var/backups/jamboai/20260707_005200_broadlive_dashboard_slider_fix/resources__views__backend__comment.blade.php.bak resources/views/backend/comment.blade.php && cp -a /var/backups/jamboai/20260707_005200_broadlive_dashboard_slider_fix/resources__views__backend__chat.blade.php.bak resources/views/backend/chat.blade.php && cp -a /var/backups/jamboai/20260707_005200_broadlive_dashboard_slider_fix/resources__views__backend__slider__index.blade.php.bak resources/views/backend/slider/index.blade.php && php artisan route:clear && php artisan view:clear.
- commit id: none; production directories are not Git repositories.
- APK/build proof: N/A.

## 2026-07-07 Codex - Broadlive dashboard responsive stat cards
- current task: Redesign Broadlive admin dashboard stat cards to look modern and be fully responsive.
- repo path: /var/www/broadlive/current on app01 159.223.42.204 and app02 152.42.223.173.
- git status: not a git repository in live release path; no local commit created.
- backup path: /var/backups/jamboai/20260707_011500_broadlive_dashboard_stat_cards.
- changed files: resources/views/backend/home.blade.php; codex_memory.md.
- old behavior: Dashboard stat cards used large 24px corners, fixed 280px grid tracks, heavy hover movement, large icons, and empty card footers that still consumed space on mobile.
- new behavior: Stat cards use compact 8px cards, fluid auto-fit grid tracks, clearer icon blocks, safer long-number wrapping, hidden empty footers, lighter hover movement, two-column tablet/mobile layout, and one-column layout for very small screens.
- validation: php artisan view:clear and php artisan view:cache passed on both app nodes; home.blade.php sha256 matched on both nodes: e5a3a01fc0e9d33a680700bc46aaf9d7db9e157d8ab6059d30bf0126303cf285.
- rollback command: cd /var/www/broadlive/current && cp -a /var/backups/jamboai/20260707_011500_broadlive_dashboard_stat_cards/resources__views__backend__home.blade.php.bak resources/views/backend/home.blade.php && php artisan view:clear && php artisan view:cache.
- commit id: none; production directories are not Git repositories.
- APK/build proof: N/A.

## 2026-07-07 Codex - Broadlive dashboard rounded card amounts
- current task: Fix unclear dashboard card amounts where decimals like 226793.8200 overflowed and displayed poorly; use rounded amounts only.
- repo path: /var/www/broadlive/current on app01 159.223.42.204 and app02 152.42.223.173.
- git status: not a git repository in live release path; no local commit created.
- backup path: /var/backups/jamboai/20260707_012400_broadlive_dashboard_round_amounts.
- changed files: resources/views/backend/home.blade.php; codex_memory.md.
- old behavior: Dashboard stat-card and game-card amounts printed raw values in several places, so decimal values could overflow or appear unclear in compact cards.
- new behavior: Dashboard uses a shared $money helper to round values and apply thousands separators across visible stat-card/game-card amounts; stat and game amount fonts use clamp sizing and wrapping to stay readable inside cards.
- validation: php artisan view:clear and php artisan view:cache passed on both app nodes; home.blade.php sha256 matched on both nodes: bf0c380fd46d9b7f39e50683d847ef25126204e4c7b48fae9821b4b4fe56aabd; formatter proof showed 226793.8200 displays as 226,794; Greedy card lines use $money on both stat-value and game-balance rows.
- rollback command: cd /var/www/broadlive/current && cp -a /var/backups/jamboai/20260707_012400_broadlive_dashboard_round_amounts/resources__views__backend__home.blade.php.bak resources/views/backend/home.blade.php && php artisan view:clear && php artisan view:cache.
- commit id: none; production directories are not Git repositories.
- APK/build proof: N/A.

## 2026-07-07 Codex - Broadlive admin agency/profile/dashboard UI refresh
- current task: Modernize `/agency_list`, `/agency_create`, and `id_search` profile result UI; make dashboard smaller, gray-white, and plain rounded amounts; permission-gate sidebar profile search; remove topbar server load display.
- syntax notes: Laravel Blade views only; kept existing route names, controller endpoints, forms, CSRF, modal POST actions, and permission helper patterns.
- code pattern notes: Used existing `AdminParmisiton::allowed()` / `$adminAny` style in layout files; dashboard money helper now returns rounded integer text without comma grouping.
- file pattern notes: Edited `resources/views/backend/agency/create.blade.php`, `resources/views/backend/agency/index.blade.php`, `resources/views/backend/profile/index.blade.php`, `resources/views/backend/home.blade.php`, `resources/views/backend/layouts/topbar.blade.php`, and `resources/views/backend/layouts/sidebar.blade.php`.
- old behavior: Agency pages were plain/dark legacy UI, profile result page was heavy dark UI, dashboard used larger dark cards and comma number formatting, sidebar profile search showed without profile permission gate, and topbar showed `Load : __ %`.
- new behavior: Agency create/list pages are modern responsive gray-white admin pages, profile search result has a light professional skin, dashboard uses smaller typography and gray-white cards with raw rounded amounts, sidebar profile search follows profile permissions, and topbar server load text/functions are removed.
- changed files: resources/views/backend/agency/create.blade.php; resources/views/backend/agency/index.blade.php; resources/views/backend/profile/index.blade.php; resources/views/backend/home.blade.php; resources/views/backend/layouts/topbar.blade.php; resources/views/backend/layouts/sidebar.blade.php; codex_memory.md.
- validation: On app01 and app02, source checks returned yes for topbar load removed, dashboard number format removed, dashboard gray-white marker, sidebar profile permission gate, agency create/list modern markers, and profile light skin marker. `php artisan view:clear && php artisan view:cache` succeeded on both nodes.
- rollback command: `cd /var/www/broadlive/current && cp -a /var/backups/jamboai/20260707_014200_broadlive_admin_ui_pages/resources__views__backend__agency__create.blade.php.bak resources/views/backend/agency/create.blade.php && cp -a /var/backups/jamboai/20260707_014200_broadlive_admin_ui_pages/resources__views__backend__agency__index.blade.php.bak resources/views/backend/agency/index.blade.php && cp -a /var/backups/jamboai/20260707_014200_broadlive_admin_ui_pages/resources__views__backend__profile__index.blade.php.bak resources/views/backend/profile/index.blade.php && cp -a /var/backups/jamboai/20260707_014200_broadlive_admin_ui_pages/resources__views__backend__home.blade.php.bak resources/views/backend/home.blade.php && cp -a /var/backups/jamboai/20260707_014200_broadlive_admin_ui_pages/resources__views__backend__layouts__topbar.blade.php.bak resources/views/backend/layouts/topbar.blade.php && cp -a /var/backups/jamboai/20260707_014200_broadlive_admin_ui_pages/resources__views__backend__layouts__sidebar.blade.php.bak resources/views/backend/layouts/sidebar.blade.php && php artisan view:clear && php artisan view:cache`.
- commit id: none; `/var/www/broadlive/current` is not a Git checkout on the app nodes.
- APK/build proof if any: Not applicable; Laravel Blade view cache rebuilt successfully on both app nodes.

## 2026-07-07 Codex - Broadlive dashboard smart UI refresh
- current task: Replace the remaining old dashboard visual style with a modern smart admin UI; standardize card layout, digit rendering, and button sizing/colors on `https://broadlive.xyz/dashboard`.
- syntax notes: Laravel Blade view only; existing dashboard data variables, permission checks, routes, modals, and polling JavaScript were preserved.
- code pattern notes: Added a final light-dashboard CSS override layer instead of changing controller logic. Numeric displays use the existing rounded `$money` helper plus CSS `font-variant-numeric: tabular-nums` for stable digit width.
- file pattern notes: Edited `resources/views/backend/home.blade.php` and appended this note to `codex_memory.md`.
- old behavior: Dashboard still showed legacy visual treatment through gradient text, heavy shadows, large rounded cards, mixed button colors, and inconsistent digit rendering.
- new behavior: Dashboard now uses a gray-white operations header, compact light metric panels, standard 6px buttons, smaller typography, tabular digits for amounts, cleaner chat/comment panels, and corrected modal text `Powered by JAMBOai`.
- changed files: resources/views/backend/home.blade.php; codex_memory.md.
- validation: Local `php -l` passed for `home.blade.php`. On app01 and app02, source checks returned yes for smart skin, dashboard header, standard digits, standard buttons, old `Powerd` text removed, `Powered by JAMBOai` present, and `number_format` absent. `php artisan view:clear && php artisan view:cache` succeeded on both nodes. Final dashboard file sha256 matched on both nodes: 445df270b2aecec1b862b1acc03160382b8fd7681e836fe10910be971f84f93d.
- rollback command: `cd /var/www/broadlive/current && cp -a /var/backups/jamboai/20260707_020600_broadlive_dashboard_smart_ui/resources__views__backend__home.blade.php.bak resources/views/backend/home.blade.php && php artisan view:clear && php artisan view:cache`.
- commit id: none; `/var/www/broadlive/current` is not a Git checkout on the app nodes.
- APK/build proof if any: Not applicable; Laravel Blade view cache rebuilt successfully on both app nodes.

## 2026-07-07 Codex - Broadlive Game Pro dashboard card cleanup
- current task: Recreate the Game Pro Balance dashboard card because the compact card looked messy and long deposit/withdraw amounts wrapped poorly.
- syntax notes: Laravel Blade view only; existing Game Pro permissions, values, action routes, and modals were preserved.
- code pattern notes: Replaced the generic two-column inline card layout with dedicated `.game-pro-*` classes. Deposit and withdraw are now shown as stacked rows with right-aligned tabular numeric amounts.
- file pattern notes: Edited `resources/views/backend/home.blade.php` and appended this note to `codex_memory.md`.
- old behavior: The Game Pro Balance card reused generic game-card layout, used a cramped two-column deposit/withdraw area, and long amounts could wrap into isolated digits.
- new behavior: The card has a cleaner header, stable main balance, compact deposit/withdraw summary, stacked ledger rows, full-width standard action buttons, and no old inline two-column grid inside the card.
- changed files: resources/views/backend/home.blade.php; codex_memory.md.
- validation: Local `php -l` passed for `home.blade.php`. On app01 and app02, source checks returned yes for game-pro card class, ledger rows, action wrapper, amount class, and old inline grid removed. `php artisan view:clear && php artisan view:cache` succeeded on both nodes. Final dashboard file sha256 matched on both nodes: ce39d0e04ba2df77fe67e325b1b7b9faeaf9d18d966f6eccc4dc908786960ece.
- rollback command: `cd /var/www/broadlive/current && cp -a /var/backups/jamboai/20260707_023300_broadlive_gamepro_card_cleanup/resources__views__backend__home.blade.php.bak resources/views/backend/home.blade.php && php artisan view:clear && php artisan view:cache`.
- commit id: none; `/var/www/broadlive/current` is not a Git checkout on the app nodes.
- APK/build proof if any: Not applicable; Laravel Blade view cache rebuilt successfully on both app nodes.

## 2026-07-07 Codex - Broadlive dashboard card height cleanup
- current task: Fix dashboard cards looking too long because the Game Pro card height stretched every card in the row.
- syntax notes: Laravel Blade view only; no controller, route, or permission changes.
- code pattern notes: Added final CSS to make the dashboard grid align items to start, keep cards at auto height, hide empty card footers, and tighten Game Pro balance/body/footer spacing.
- file pattern notes: Edited `resources/views/backend/home.blade.php` and appended this note to `codex_memory.md`.
- old behavior: The metric row stretched all cards to match the taller Game Pro card, so Profit, Wallet, Portal, Serve Coin, and Receiving cards looked oversized and empty.
- new behavior: Each card keeps its own natural compact height; empty footers are hidden; Game Pro balance and footer are smaller and tighter.
- changed files: resources/views/backend/home.blade.php; codex_memory.md.
- validation: Local `php -l` passed for `home.blade.php`. On app01 and app02, source checks returned yes for grid no-stretch, cards auto height, empty footers hidden, old 126px min-height removed, compact Game Pro balance, and compact Game Pro footer. `php artisan view:clear && php artisan view:cache` succeeded on both nodes. Final dashboard file sha256 matched on both nodes: a3769d56e8278e418b3a98123dc6d2afdd77829f207d7c1085b00a50850d5496.
- rollback command: `cd /var/www/broadlive/current && cp -a /var/backups/jamboai/20260707_024500_broadlive_dashboard_card_height_fix/resources__views__backend__home.blade.php.bak resources/views/backend/home.blade.php && php artisan view:clear && php artisan view:cache`.
- commit id: none; `/var/www/broadlive/current` is not a Git checkout on the app nodes.
- APK/build proof if any: Not applicable; Laravel Blade view cache rebuilt successfully on both app nodes.

## 2026-07-07 Codex - Broadlive Game Pro split metric cards
- current task: Split Game Pro Balance, Deposit, and Withdraw into separate serial dashboard cards so all cards keep the same row size and the old tall Game Pro card ends.
- syntax notes: Laravel Blade view only; existing Game Pro permissions, values, modals, and update routes were preserved.
- code pattern notes: Replaced the tall `game-card game-pro-card` markup with three regular `stat-card game-pro-metric-card` cards. The action buttons now sit in a same-grid compact `game-pro-control-strip` instead of inside the metric card.
- file pattern notes: Edited `resources/views/backend/home.blade.php` and appended this note to `codex_memory.md`.
- old behavior: Game Pro Balance, Deposit, Withdraw, ledger, and buttons were grouped into one taller card, making the row look uneven and messy.
- new behavior: Game Pro Balance, Game Pro Deposit, and Game Pro Withdraw are separate serial stat cards with the same sizing as the other metric cards. The Game Pro controls are separate and do not force a full-width grid break.
- changed files: resources/views/backend/home.blade.php; codex_memory.md.
- validation: Local `php -l` passed for `home.blade.php`. On app01 and app02, source checks returned yes for separate Game Pro Balance, Deposit, and Withdraw cards; old tall `game-card game-pro-card` removed; control card has same 112px minimum height; Game Pro control CSS has no full-width grid-column. `php artisan view:clear && php artisan view:cache` succeeded on both nodes. Final dashboard file sha256 matched on both nodes: 5d1352f11c20f1cbbaf973b9104926db7bcd168d8246eaf3b1293bba9e9d95da.
- rollback command: `cd /var/www/broadlive/current && cp -a /var/backups/jamboai/20260707_025700_broadlive_gamepro_split_cards/resources__views__backend__home.blade.php.bak resources/views/backend/home.blade.php && php artisan view:clear && php artisan view:cache`.
- commit id: none; `/var/www/broadlive/current` is not a Git checkout on the app nodes.
- APK/build proof if any: Not applicable; Laravel Blade view cache rebuilt successfully on both app nodes.

## 2026-07-07 Codex - Broadlive Game Pro buttons inside metric cards
- current task: Remove the extra Game Pro control card and place the Deposit and Withdraw buttons inside their matching Game Pro Deposit and Game Pro Withdraw cards.
- syntax notes: Laravel Blade view only; existing Game Pro permissions, modal IDs, values, and update route were preserved.
- code pattern notes: Removed `.game-pro-control-strip` and `.game-pro-control-actions`; added footer button handling to `.game-pro-metric-card` cards. Deposit button now lives in the Deposit card footer, and Withdraw button now lives in the Withdraw card footer.
- file pattern notes: Edited `resources/views/backend/home.blade.php` and appended this note to `codex_memory.md`.
- old behavior: Game Pro Balance, Deposit, and Withdraw were separate cards, but there was still an extra control card for Deposit/Withdraw buttons.
- new behavior: No extra Game Pro control card exists; Deposit and Withdraw buttons are integrated into their own balance cards.
- changed files: resources/views/backend/home.blade.php; codex_memory.md.
- validation: Local `php -l` passed for `home.blade.php`. On app01 and app02, source checks returned yes for no extra control card, deposit button in card, withdraw button in card, footer button style present, and old tall `game-card game-pro-card` removed. `php artisan view:clear && php artisan view:cache` succeeded on both nodes. Final dashboard file sha256 matched on both nodes: 1bde85af6ef2e3761340d66c2eecb0d0f353c69f6e1902cbcf420a80ab7d0a46.
- rollback command: `cd /var/www/broadlive/current && cp -a /var/backups/jamboai/20260707_031000_broadlive_gamepro_buttons_in_cards/resources__views__backend__home.blade.php.bak resources/views/backend/home.blade.php && php artisan view:clear && php artisan view:cache`.
- commit id: none; `/var/www/broadlive/current` is not a Git checkout on the app nodes.
- APK/build proof if any: Not applicable; Laravel Blade view cache rebuilt successfully on both app nodes.

## 2026-07-07 Codex - Broadlive Coin Generate second row
- current task: Move the Coin Generate metric so it starts on the second row instead of staying in the Game Pro row.
- syntax notes: Laravel Blade view only; no value, controller, route, permission, or modal changes.
- code pattern notes: Added `.coin-generate-card { grid-column-start: 1; }` for desktop and reset it to `auto` on mobile. Applied the class only to the Coin Generate stat card.
- file pattern notes: Edited `resources/views/backend/home.blade.php` and appended this note to `codex_memory.md`.
- old behavior: Coin Generate could continue in the same grid row after the Game Pro cards.
- new behavior: Coin Generate starts at the first column of the next available dashboard grid row on desktop while keeping normal mobile flow.
- changed files: resources/views/backend/home.blade.php; codex_memory.md.
- validation: Local `php -l` passed for `home.blade.php`. On app01 and app02, source checks returned yes for Coin Generate class, grid-column-start rule, mobile reset, and Greedy card not having the Coin Generate class. `php artisan view:clear && php artisan view:cache` succeeded on both nodes. Final dashboard file sha256 matched on both nodes: 1f6df5caab3338bfbf6d5fb044e80c45a1a055220b5f462daac911aa86bbf4c8.
- rollback command: `cd /var/www/broadlive/current && cp -a /var/backups/jamboai/20260707_032000_broadlive_coin_generate_second_row/resources__views__backend__home.blade.php.bak resources/views/backend/home.blade.php && php artisan view:clear && php artisan view:cache`.
- commit id: none; `/var/www/broadlive/current` is not a Git checkout on the app nodes.
- APK/build proof if any: Not applicable; Laravel Blade view cache rebuilt successfully on both app nodes.

## 2026-07-07 Codex - Broadlive Coin Generate row breaker
- current task: Use an explicit row breaker before Coin Generate instead of relying on the previous grid-column-start class.
- syntax notes: Laravel Blade view only; no value, controller, route, permission, or modal changes.
- code pattern notes: Removed the `coin-generate-card` placement class and old `grid-column-start` rule. Added a zero-height `.dashboard-row-break` grid item immediately before Coin Generate with `grid-column: 1 / -1`.
- file pattern notes: Edited `resources/views/backend/home.blade.php` and appended this note to `codex_memory.md`.
- old behavior: Coin Generate second-row placement depended on `grid-column-start`, which was less explicit and easier to misread.
- new behavior: Coin Generate is preceded by an explicit full-row breaker, then rendered as a normal stat card on the next row.
- changed files: resources/views/backend/home.blade.php; codex_memory.md.
- validation: Local `php -l` passed for `home.blade.php`. On app01 and app02, source checks returned yes for row breaker present before Coin Generate, row breaker CSS, Coin Generate as normal stat card, old coin-generate class removed, and old grid-column-start removed. `php artisan view:clear && php artisan view:cache` succeeded on both nodes. Final dashboard file sha256 matched on both nodes: 2ab6817eeabc3f221ce13800f0201113b098a375c89e50ac1637d42d0011aa79.
- rollback command: `cd /var/www/broadlive/current && cp -a /var/backups/jamboai/20260707_033000_broadlive_coin_generate_row_break/resources__views__backend__home.blade.php.bak resources/views/backend/home.blade.php && php artisan view:clear && php artisan view:cache`.
- commit id: none; `/var/www/broadlive/current` is not a Git checkout on the app nodes.
- APK/build proof if any: Not applicable; Laravel Blade view cache rebuilt successfully on both app nodes.
## 2026-07-07 - BroadLive subadmin dashboard game and realtime feed fix

- current task: Fix `subadmin@` dashboard so game data, comments, and chat list are visible on `/subadmin/dashboard`.
- old behavior: Subadmin dashboard only loaded active host, total user, total agency, and pending profile list. Game balances and realtime comment/chat feeds were not queried or rendered for subadmin users.
- new behavior: Subadmin dashboard now loads Fruits, Teen Patti, Greedy, and Five Star game balances, shows last-hour comment/chat counts, and renders live comment/chat lists with 5 second refresh and local search.
- permission note: Main admin dashboard game cards and realtime feeds were separated from the Coin Generate permission by adding `dashboard_game_data` and `dashboard_realtime_feeds` permission keys.
- changed files: `app/Models/AdminParmisiton.php`, `resources/views/backend/home.blade.php`, `routes/web.php`, `app/Http/Controllers/SubAdmin/DashbordController.php`, `resources/views/subadmin/home.blade.php`.
- backup path: `/var/backups/jamboai/20260707_174500_broadlive_subadmin_dashboard_feeds/`.
- validation: PHP syntax passed for changed PHP/Blade files on app nodes. Laravel route/view/cache cleared and Blade cache rebuilt. Subadmin route lines confirmed in `routes/web.php`; app01 `route:list` confirms `subadmin.dashboard`, `subadmin.comment.data`, and `subadmin.chat.data`. App02 `route:list` is blocked by pre-existing missing `App\Http\Controllers\Api\V4\RoomCommentController`, but changed file hashes match app01.
- rollback command: `cd /var/www/broadlive/current && cp /var/backups/jamboai/20260707_174500_broadlive_subadmin_dashboard_feeds/AdminParmisiton.php.before app/Models/AdminParmisiton.php && cp /var/backups/jamboai/20260707_174500_broadlive_subadmin_dashboard_feeds/home.blade.php.before resources/views/backend/home.blade.php && cp /var/backups/jamboai/20260707_174500_broadlive_subadmin_dashboard_feeds/web.php.before routes/web.php && cp /var/backups/jamboai/20260707_174500_broadlive_subadmin_dashboard_feeds/SubAdminDashbordController.php.before app/Http/Controllers/SubAdmin/DashbordController.php && cp /var/backups/jamboai/20260707_174500_broadlive_subadmin_dashboard_feeds/subadmin_home.blade.php.before resources/views/subadmin/home.blade.php && php artisan view:clear && php artisan cache:clear`
- commit id: N/A, direct production server change; `/var/www/broadlive/current` is not a git repository.
## 2026-07-07 - BroadLive profile phone and email permission

- current task: Show phone number and email on the BroadLive profile page with a permission rule.
- old behavior: `resources/views/subadmin/profile.blade.php` showed user name and ID but did not render email or phone. Admin permission definitions did not have a dedicated phone/email toggle.
- new behavior: Added `profile_contact_info` under the Profile permission group with label `Profile Phone / Email`. The subadmin profile page now shows a `Contact Information` table with email and phone only when `profile_contact_info` is allowed, falling back to existing `profile_sensitive_info` for old permission rows.
- changed files: `app/Models/AdminParmisiton.php`, `resources/views/subadmin/profile.blade.php`.
- validation: PHP syntax passed for both changed files on both app nodes. Laravel view/cache cleared and Blade cache rebuilt. Live files confirmed with matching SHA256 hashes on both nodes.
- backup path: `/var/backups/jamboai/20260707_183000_broadlive_profile_contact_permission/`.
- rollback command: `cd /var/www/broadlive/current && cp /var/backups/jamboai/20260707_183000_broadlive_profile_contact_permission/AdminParmisiton.php.before app/Models/AdminParmisiton.php && cp /var/backups/jamboai/20260707_183000_broadlive_profile_contact_permission/subadmin_profile.blade.php.before resources/views/subadmin/profile.blade.php && php artisan view:clear && php artisan cache:clear`
- commit id: N/A, direct production server change; `/var/www/broadlive/current` is not a git repository.
## 2026-07-07 - BroadLive hide game and realtime data for subadmin@admin.com

- current task: Hide all game data plus comment/chat data for `subadmin@admin.com`.
- old behavior: User `subadmin@admin.com` already had many game/sidebar permissions disabled, but newer `dashboard_game_data` and `dashboard_realtime_feeds` rows were missing. The subadmin dashboard also did not enforce these dashboard permission keys in `resources/views/subadmin/home.blade.php`.
- new behavior: Added explicit deny rows for user ID `11811` on `dashboard_game_data`, `dashboard_realtime_feeds`, `dashboard_coin_generate_game`, `dashboard_country_game_balance_cards`, `sidebar_menu_game_control`, and game sidebar permission keys. Updated the subadmin dashboard view so all game balance cards require `dashboard_game_data`, and comment/chat counters and feed lists require `dashboard_realtime_feeds`.
- changed files: `resources/views/subadmin/home.blade.php`.
- database changes: Updated `adminparmisiton` rows for user ID `11811` / `subadmin@admin.com`; before and after JSON backups were saved.
- validation: PHP syntax passed for the Blade file on both app nodes. Laravel view/cache cleared and Blade cache rebuilt. Both app nodes have matching `resources/views/subadmin/home.blade.php` SHA256 `ed6c47cd579d6c25122edab36b6f5852486fecf93c4d0f387b153dd63e4d3448`. Permission readback confirms `dashboard_game_data=0` and `dashboard_realtime_feeds=0`.
- backup path: `/var/backups/jamboai/20260707_184500_broadlive_hide_subadmin_game_chat/`.
- rollback command: `cd /var/www/broadlive/current && cp /var/backups/jamboai/20260707_184500_broadlive_hide_subadmin_game_chat/subadmin_home.blade.php.before resources/views/subadmin/home.blade.php && php artisan view:clear && php artisan cache:clear`
- DB rollback note: Permission row backup is `/var/backups/jamboai/20260707_184500_broadlive_hide_subadmin_game_chat/adminparmisiton_user_11811_before.json`.
- commit id: N/A, direct production server change; `/var/www/broadlive/current` is not a git repository.
## 2026-07-07 - BroadLive available coins rule and compact profile history

- current task: Make the `Available Coins` dashboard value permission-controlled and tighten the subadmin profile page so latest rows appear first with date values on one line.
- old behavior: The backend dashboard `Available Coins` pill was visible inside `resources/views/backend/home.blade.php` even when the topbar badge already used the `sidebar_coin_balance` permission rule. The subadmin profile page had large table spacing, a `dayTimeHistory` query without descending order, and date/time cells could wrap across lines.
- new behavior: The backend dashboard `Available Coins` pill now requires `sidebar_coin_balance`. The subadmin profile page now uses compact table/card spacing, no-wrap date/time/action cells, descending order for day-time history, and descending host list order.
- changed files: `resources/views/backend/home.blade.php`, `resources/views/subadmin/profile.blade.php`.
- validation: PHP syntax passed for both changed Blade files on both app nodes. Laravel view/cache cleared and Blade cache rebuilt. Both app nodes have matching SHA256 hashes: backend home `df41dfc09abb1d2d2556a57a23a666cd024a4a248f899fe1ed9d020713354bc1`, subadmin profile `e2c9b8ff16b1c71cf22bfac2d0ae53e86e354bb9be54db69659555342b77f778`.
- backup path: `/var/backups/jamboai/20260707_190000_broadlive_profile_compact_coin_rule/`.
- rollback command: `cd /var/www/broadlive/current && cp /var/backups/jamboai/20260707_190000_broadlive_profile_compact_coin_rule/backend_home.blade.php.before resources/views/backend/home.blade.php && cp /var/backups/jamboai/20260707_190000_broadlive_profile_compact_coin_rule/subadmin_profile.blade.php.before resources/views/subadmin/profile.blade.php && php artisan view:clear && php artisan cache:clear`
- commit id: N/A, direct production server change; `/var/www/broadlive/current` is not a git repository.
## 2026-07-07 - BroadLive split profile email and phone permissions

- current task: Split the combined `Profile Phone / Email` permission into separate rules so email-only or phone-only access can be granted.
- old behavior: `app/Models/AdminParmisiton.php` exposed one `profile_contact_info` rule labeled `Profile Phone / Email`, and `resources/views/subadmin/profile.blade.php` showed both email and phone together when that rule was allowed.
- new behavior: Added separate permission rules `profile_email_info` (`Profile Email`) and `profile_phone_info` (`Profile Phone`). The profile page now renders Email and Phone rows independently according to those rules. A legacy fallback still reads old `profile_contact_info` / `profile_sensitive_info` defaults only when the new explicit rows do not exist.
- database changes: Ran a sync script to copy old `profile_contact_info` rows into both new keys if present. On this deployment there were `0` legacy combined rows, so no permission data needed copying. Before/after JSON snapshots were saved on app01.
- changed files: `app/Models/AdminParmisiton.php`, `resources/views/subadmin/profile.blade.php`.
- validation: PHP syntax passed for both changed files on both app nodes. Laravel view/cache cleared and Blade cache rebuilt. Both app nodes have matching hashes: AdminParmisiton `aed01908cc00f2045d0e3d8bf168bc48ce5ceb1e449858129dedfc3f57ac06b7`, subadmin profile `6a260cac410bb770950f3518d8e23e076c6e4b196568a56ab83018b0d6131fee`.
- backup path: `/var/backups/jamboai/20260707_191500_broadlive_split_profile_contact_permissions/`.
- rollback command: `cd /var/www/broadlive/current && cp /var/backups/jamboai/20260707_191500_broadlive_split_profile_contact_permissions/AdminParmisiton.php.before app/Models/AdminParmisiton.php && cp /var/backups/jamboai/20260707_191500_broadlive_split_profile_contact_permissions/subadmin_profile.blade.php.before resources/views/subadmin/profile.blade.php && php artisan view:clear && php artisan cache:clear`
- commit id: N/A, direct production server change; `/var/www/broadlive/current` is not a git repository.

## 2026-07-07 BroadLive id_search profile UI
- current task: Fix BroadLive admin id_search profile page readability for user balance and history tables.
- syntax notes: Blade view scoped CSS only; no controller or database changes.
- code pattern notes: Kept existing `jambo-profile-page` scope and permission gate `profile_balance`.
- file pattern notes: Updated `resources/views/backend/profile/index.blade.php` only.
- old behavior: Balance showed as plain text beside a mobile icon and transaction tables had cramped amount/date columns.
- new behavior: Balance is shown in a clear green balance chip; DataTables tables use compact padding, nowrap amount/date cells, visible borders, hover rows, and responsive horizontal overflow.
- changed files: resources/views/backend/profile/index.blade.php; codex_memory.md.
- validation: php -l passed; php artisan view:clear/cache:clear/view:cache passed; deployed file sha256 ef57bb91818b32e5d9aa2a92813efa482cf84bcc473961c2f78b32067d57fa36.
- rollback command: cp -a /var/backups/jamboai/20260707_195000_broadlive_id_search_ui/app01_backend_profile_index.blade.php.before /var/www/broadlive/current/resources/views/backend/profile/index.blade.php && chown www-data:www-data /var/www/broadlive/current/resources/views/backend/profile/index.blade.php && cd /var/www/broadlive/current && php artisan view:clear
- commit id: N/A direct server change; /var/www/broadlive/current is not a git working tree.
- APK/build proof if any: N/A.
## 2026-07-08 05:51 +06:00 - broadlive DNS restore
current task: Fix broadlive.xyz browser timeout.
old behavior: broadlive.xyz and www.broadlive.xyz A records pointed to BDIX 103.174.153.40; BDIX was unreachable on 80/443/22, causing browser timeout.
new behavior: DigitalOcean DNS A records updated to edge 168.144.146.68 for both apex and www.
changed files: codex_memory.md only; DNS provider records changed outside repo.
validation: DigitalOcean API shows @ and www A records 168.144.146.68 TTL 300; default resolver returns 168.144.146.68; curl https://broadlive.xyz/ returns HTTP 200 through nginx edge.
rollback command: in DigitalOcean DNS, set broadlive.xyz @ and www A records back to 103.174.153.40 if explicitly required.
commit id: N/A - production DNS operational change only, no Git commit.

## 2026-07-08 BroadLive profile search sidebar permission
- current task: Show the sidebar profile search bar for subadmin@admin.com without granting unrelated profile data permissions.
- syntax notes: Added a Blade/model permission key named profile_search and preserved existing profile permission fallback behavior.
- code pattern notes: resources/views/backend/layouts/sidebar.blade.php now shows the id_search form when profile_search or any existing profile visibility permission is allowed.
- file pattern notes: Updated app/Models/AdminParmisiton.php, resources/views/backend/layouts/sidebar.blade.php, resources/views/backend/setting/subadmin.blade.php, and codex_memory.md.
- old behavior: subadmin@admin.com user id 11811 had sidebar_access but no profile permissions, so the sidebar rendered without the profile search form.
- new behavior: profile_search is a standalone Profile permission; user 11811 has profile_search enabled and should see the sidebar search bar without receiving balance/email/phone permissions.
- changed data/files: adminparmisiton row for user_id 11811 permission_key profile_search; app/Models/AdminParmisiton.php; resources/views/backend/layouts/sidebar.blade.php; resources/views/backend/setting/subadmin.blade.php; codex_memory.md.
- validation: php -l passed for AdminParmisiton.php; backend sidebar and setting Blade compile outputs passed php -l; php artisan view:clear and optimize:clear completed on both app nodes; permission check for user 11811 returned profile_search=true.
- backup path: /var/backups/jamboai/20260708_181000_broadlive_profile_search_permission
- rollback command: cd /var/www/broadlive/current && cp -p /var/backups/jamboai/20260708_181000_broadlive_profile_search_permission/AdminParmisiton.php.before app/Models/AdminParmisiton.php && cp -p /var/backups/jamboai/20260708_181000_broadlive_profile_search_permission/sidebar.blade.php.before resources/views/backend/layouts/sidebar.blade.php && cp -p /var/backups/jamboai/20260708_181000_broadlive_profile_search_permission/setting_subadmin.blade.php.before resources/views/backend/setting/subadmin.blade.php && cp -p /var/backups/jamboai/20260708_181000_broadlive_profile_search_permission/codex_memory.md.before codex_memory.md && php /var/backups/jamboai/20260708_181000_broadlive_profile_search_permission/rollback_profile_search_permission_11811.php && php artisan optimize:clear
- commit id: N/A live server path is not a Git checkout.
- APK/build proof if any: N/A.
