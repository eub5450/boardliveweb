<?php

use Illuminate\Database\Migrations\Migration;

class AlterBdGameFinalTokensForAuthHardening extends Migration
{
    public function up()
    {
        // Intentionally no-op: token hardening moved to later concrete migrations.
        // File retained to avoid breaking already-applied migration history.
    }

    public function down()
    {
        // Intentionally no-op.
    }
}
