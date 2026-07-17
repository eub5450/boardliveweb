<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VipSetupConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VipSetupController extends Controller
{
    protected function defaultConfig()
    {
        return [
            'hero' => [
                'progress_current'     => 650,
                'progress_target'      => 1000,
                'renew_days_from_now'  => 30,
            ],
            'tiers' => [
                ['name' => 'VIP 1', 'crown_color' => '#C0C0C0'],
                ['name' => 'VIP 2', 'crown_color' => '#B0B7C6'],
                ['name' => 'VIP 3', 'crown_color' => '#8CC5FF'],
                ['name' => 'VIP 4', 'crown_color' => '#A855F7'],
                ['name' => 'VIP 5', 'crown_color' => '#F97316'],
                ['name' => 'VIP 6', 'crown_color' => '#EC4899'],
                ['name' => 'VIP 7', 'crown_color' => '#FACC15'],
            ],
            'benefits' => [
                ['title' => 'VIP Profile Frame',       'subtitle' => 'Stand out in style',   'icon_asset' => 'sheet3_cell5.png',  'color' => '#A855F7'],
                ['title' => 'Exclusive Chat Bubble',   'subtitle' => 'Premium look in chat', 'icon_asset' => 'sheet3_cell6.png',  'color' => '#EC4899'],
                ['title' => 'Custom Entry Effect',     'subtitle' => 'Grand room entrance',  'icon_asset' => 'sheet3_cell7.png',  'color' => '#F97316'],
                ['title' => 'Daily Bonus Points',      'subtitle' => 'Earn more every day',  'icon_asset' => 'sheet3_cell8.png',  'color' => '#F59E0B'],
                ['title' => 'Priority Support',        'subtitle' => 'Skip the wait',        'icon_asset' => 'sheet3_cell9.png',  'color' => '#22C55E'],
                ['title' => 'Ad-Free Experience',      'subtitle' => 'Zero interruptions',   'icon_asset' => 'sheet3_cell10.png', 'color' => '#0EA5E9'],
                ['title' => 'Exclusive Gifts',         'subtitle' => 'VIP-only catalog',     'icon_asset' => 'sheet3_cell11.png', 'color' => '#8B5CF6'],
                ['title' => 'Higher Level Cap',        'subtitle' => 'Grow faster, farther', 'icon_asset' => 'sheet3_cell12.png', 'color' => '#EF4444'],
            ],
            'comparison' => [
                'columns'         => ['VIP 1', 'VIP 3', 'VIP 4', 'VIP 5', 'VIP 7'],
                'highlight_index' => 2,
                'rows' => [
                    ['label' => 'Daily Bonus Points', 'values' => ['50', '150', '200', '300', '500']],
                    ['label' => 'Profile Frame',      'values' => ['Basic', 'Silver', 'Gold', 'Ruby', 'Diamond']],
                    ['label' => 'Entry Effect',       'values' => ['-', 'Simple', 'Animated', 'Premium', 'Legendary']],
                    ['label' => 'Exclusive Gifts',    'values' => ['-', '5', '10', '20', 'All']],
                    ['label' => 'Ad-Free',            'values' => ['-', 'Yes', 'Yes', 'Yes', 'Yes']],
                    ['label' => 'Priority Support',   'values' => ['-', '-', 'Yes', 'Yes', 'Yes']],
                    ['label' => 'Level Cap Boost',    'values' => ['-', '+5', '+10', '+15', '+25']],
                ],
            ],
            'plans' => [
                ['id' => 'monthly', 'title' => 'Monthly Plan', 'price_display' => '$6.99',  'unit' => '/ month', 'subtitle' => 'Billed monthly. Cancel anytime.',  'best_value' => false],
                ['id' => 'yearly',  'title' => 'Yearly Plan',  'price_display' => '$59.99', 'unit' => '/ year',  'subtitle' => 'Save 28% compared to monthly.',    'best_value' => true],
            ],
            'parental_notice' => [
                'title' => 'Parental / Purchase Confirmation',
                'body'  => 'If you are under 18, please obtain permission from a parent or guardian. By upgrading, you agree to our Terms of Service and Privacy Policy.',
            ],
            'upgrade_button' => [
                'label'    => 'Upgrade VIP',
                'gradient' => ['#F97316', '#EC4899', '#A855F7'],
            ],
            'secure_note' => 'Secure payment. Your information is always protected.',
        ];
    }

    protected function loadOrCreateRow()
    {
        $row = VipSetupConfig::where('config_key', 'vip_setup')->first();
        if (!$row) {
            $row = VipSetupConfig::create([
                'config_key'  => 'vip_setup',
                'config_json' => json_encode($this->defaultConfig(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            ]);
        }
        return $row;
    }

    public function Index()
    {
        $row    = $this->loadOrCreateRow();
        $config = $row->config_array;
        if (empty($config)) {
            $config = $this->defaultConfig();
        }
        $prettyJson = json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return view('backend.setting.vip_setup', [
            'config'      => $config,
            'prettyJson'  => $prettyJson,
        ]);
    }

    public function Update(Request $request)
    {
        // The admin form ships the authoritative config as a JSON blob (config_json_raw)
        // plus a handful of structured shortcut inputs for the most-edited fields.
        // We prefer the raw JSON if it is present and valid; otherwise we rebuild the
        // config by merging the structured fields into the current stored config.

        $rawJson = trim((string) $request->input('config_json_raw', ''));

        $current = $this->loadOrCreateRow();
        $config  = $current->config_array;
        if (empty($config)) {
            $config = $this->defaultConfig();
        }

        if ($rawJson !== '') {
            $decoded = json_decode($rawJson, true);
            if (!is_array($decoded)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Config JSON is invalid. Please fix and try again.');
            }
            $config = $decoded;
        }

        // Structured shortcuts (only override when explicitly present in the request).
        $validated = $request->validate([
            'hero_progress_current'    => ['nullable', 'integer', 'min:0'],
            'hero_progress_target'     => ['nullable', 'integer', 'min:1'],
            'hero_renew_days_from_now' => ['nullable', 'integer', 'min:0'],

            'plan_monthly_price'       => ['nullable', 'string', 'max:32'],
            'plan_monthly_subtitle'    => ['nullable', 'string', 'max:255'],
            'plan_yearly_price'        => ['nullable', 'string', 'max:32'],
            'plan_yearly_subtitle'     => ['nullable', 'string', 'max:255'],

            'upgrade_label'            => ['nullable', 'string', 'max:64'],
            'secure_note'              => ['nullable', 'string', 'max:255'],

            'parental_title'           => ['nullable', 'string', 'max:128'],
            'parental_body'            => ['nullable', 'string', 'max:1024'],
        ]);

        if (isset($validated['hero_progress_current'])) {
            $config['hero']['progress_current'] = (int) $validated['hero_progress_current'];
        }
        if (isset($validated['hero_progress_target'])) {
            $config['hero']['progress_target'] = (int) $validated['hero_progress_target'];
        }
        if (isset($validated['hero_renew_days_from_now'])) {
            $config['hero']['renew_days_from_now'] = (int) $validated['hero_renew_days_from_now'];
        }

        if (!empty($config['plans']) && is_array($config['plans'])) {
            foreach ($config['plans'] as $idx => $plan) {
                $id = $plan['id'] ?? '';
                if ($id === 'monthly') {
                    if (isset($validated['plan_monthly_price']))    { $config['plans'][$idx]['price_display'] = $validated['plan_monthly_price']; }
                    if (isset($validated['plan_monthly_subtitle'])) { $config['plans'][$idx]['subtitle']      = $validated['plan_monthly_subtitle']; }
                } elseif ($id === 'yearly') {
                    if (isset($validated['plan_yearly_price']))     { $config['plans'][$idx]['price_display'] = $validated['plan_yearly_price']; }
                    if (isset($validated['plan_yearly_subtitle']))  { $config['plans'][$idx]['subtitle']      = $validated['plan_yearly_subtitle']; }
                }
            }
        }

        if (isset($validated['upgrade_label'])) {
            $config['upgrade_button']['label'] = $validated['upgrade_label'];
        }
        if (isset($validated['secure_note'])) {
            $config['secure_note'] = $validated['secure_note'];
        }
        if (isset($validated['parental_title'])) {
            $config['parental_notice']['title'] = $validated['parental_title'];
        }
        if (isset($validated['parental_body'])) {
            $config['parental_notice']['body'] = $validated['parental_body'];
        }

        // Sanity-check the resulting shape (best-effort).
        $required = ['hero', 'tiers', 'benefits', 'comparison', 'plans', 'parental_notice', 'upgrade_button', 'secure_note'];
        foreach ($required as $key) {
            if (!array_key_exists($key, $config)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', "Config JSON is missing the required key: {$key}");
            }
        }

        $current->config_json = json_encode($config, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $current->save();

        // Invalidate the public API cache.
        Cache::forget('vip_setup_config');

        return redirect('setting/vip-setup')->with('success', 'VIP Setup saved successfully.');
    }
}
