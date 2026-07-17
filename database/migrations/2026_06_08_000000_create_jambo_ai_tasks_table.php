<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJamboAiTasksTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('jambo_ai_tasks')) {
            return;
        }
        Schema::create('jambo_ai_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('source_app', 40)->index();
            $table->string('source_domain', 191)->nullable()->index();
            $table->string('admin_id', 40)->index();
            $table->text('message');
            $table->string('status', 32)->default('submitted')->index();
            $table->text('tooltip')->nullable();
            $table->text('done_note')->nullable();
            $table->string('created_by', 40)->nullable();
            $table->string('updated_by', 40)->nullable();
            $table->string('done_by', 40)->nullable();
            $table->timestamp('done_at')->nullable();
            $table->timestamps();
            $table->index(['source_app', 'admin_id', 'status']);
        });
    }

    public function down()
    {
        // Intentionally non-destructive for production rollback safety.
    }
}
