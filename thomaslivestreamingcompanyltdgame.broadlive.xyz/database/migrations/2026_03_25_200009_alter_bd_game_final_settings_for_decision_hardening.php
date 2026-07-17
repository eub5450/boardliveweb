<?php

use Illuminate\Database\Migrations\Migration;

class AlterBdGameFinalSettingsForDecisionHardening extends Migration
{
    public function up()
    {
        // Intentionally no-op: superseded by later hardening migrations.
        // Kept for historical migration chain integrity in environments where it already ran.
    }

    public function down()
    {
        // Intentionally no-op.
    }
}
