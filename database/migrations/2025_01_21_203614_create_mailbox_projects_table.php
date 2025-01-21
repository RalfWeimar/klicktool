<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('mailbox_projects', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mailbox_id');
            $table->foreign('mailbox_id')->references('id')->on('mailbox');
            $table->bigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('project');
            $table->index(['mailbox_id', 'project_id']);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mailbox_projects');
    }
};
