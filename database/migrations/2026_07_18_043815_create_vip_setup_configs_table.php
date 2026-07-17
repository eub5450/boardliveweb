<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateVipSetupConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('vip_setup_configs')) {
            Schema::create('vip_setup_configs', function (Blueprint $t) {
                $t->id();
                $t->string('config_key', 100)->unique();
                $t->longText('config_json');
                $t->timestamps();
            });
        }

        // Seed the default vip_setup row mirroring the current hardcoded Flutter VIP page.
        $default = [
            'hero' => [
                'progress_current' => 650,
                'progress_target' => 1000,
                'renew_days_from_now' => 30,
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
                ['title' => 'VIP Profile Frame', 'subtitle' => 'Stand out in style', 'icon_asset' => 'sheet3_cell5.png', 'color' => '#A855F7'],
                ['title' => 'Exclusive Chat Bubble', 'subtitle' => 'Premium look in chat', 'icon_asset' => 'sheet3_cell6.png', 'color' => '#EC4899'],
                ['title' => 'Custom Entry Effect', 'subtitle' => 'Grand room entrance', 'icon_asset' => 'sheet3_cell7.png', 'color' => '#F97316'],
                ['title' => 'Daily Bonus Points', 'subtitle' => 'Earn more every day', 'icon_asset' => 'sheet3_cell8.png', 'color' => '#F59E0B'],
                ['title' => 'Priority Support', 'subtitle' => 'Skip the wait', 'icon_asset' => 'sheet3_cell9.png', 'color' => '#22C55E'],
                ['title' => 'Ad-Free Experience', 'subtitle' => 'Zero interruptions', 'icon_asset' => 'sheet3_cell10.png', 'color' => '#0EA5E9'],
                ['title' => 'Exclusive Gifts', 'subtitle' => 'VIP-only catalog', 'icon_asset' => 'sheet3_cell11.png', 'color' => '#8B5CF6'],
                ['title' => 'Higher Level Cap', 'subtitle' => 'Grow faster, farther', 'icon_asset' => 'sheet3_cell12.png', 'color' => '#EF4444'],
            ],
            'comparison' => [
                'columns' => ['VIP 1', 'VIP 3', 'VIP 4', 'VIP 5', 'VIP 7'],
                'highlight_index' => 2,
                'rows' => [
                    ['label' => 'Daily Bonus Points', 'values' => ['50', '150', '200', '300', '500']],
                    ['label' => 'Profile Frame', 'values' => ['Basic', 'Silver', 'Gold', 'Ruby', 'Diamond']],
                    ['label' => 'Entry Effect', 'values' => ['-', 'Simple', 'Animated', 'Premium', 'Legendary']],
                    ['label' => 'Exclusive Gifts', 'values' => ['-', '5', '10', '20', 'All']],
                    ['label' => 'Ad-Free', 'values' => ['-', 'Yes', 'Yes', 'Yes', 'Yes']],
                    ['label' => 'Priority Support', 'values' => ['-', '-', 'Yes', 'Yes', 'Yes']],
                    ['label' => 'Level Cap Boost', 'values' => ['-', '+5', '+10', '+15', '+25']],
                ],
            ],
            'plans' => [
                [
                    'id' => 'monthly',
                    'title' => 'Monthly Plan',
                    'price_display' => '$6.99',
                    'unit' => '/ month',
                    'subtitle' => 'Billed monthly. Cancel anytime.',
                    'best_value' => false,
                ],
                [
                    'id' => 'yearly',
                    'title' => 'Yearly Plan',
                    'price_display' => '$59.99',
                    'unit' => '/ year',
                    'subtitle' => 'Save 28% compared to monthly.',
                    'best_value' => true,
                ],
            ],
            'parental_notice' => [
                'title' => 'Parental / Purchase Confirmation',
                'body' => 'If you are under 18, please obtain permission from a parent or guardian. By upgrading, you agree to our Terms of Service and Privacy Policy.',
            ],
            'upgrade_button' => [
                'label' => 'Upgrade VIP',
                'gradient' => ['#F97316', '#EC4899', '#A855F7'],
            ],
            'secure_note' => 'Secure payment. Your information is always protected.',
        ];

        $exists = DB::table('vip_setup_configs')->where('config_key', 'vip_setup')->exists();
        if (!$exists) {
            DB::table('vip_setup_configs')->insert([
                'config_key'  => 'vip_setup',
                'config_json' => json_encode($default, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vip_setup_configs');
    }
}
