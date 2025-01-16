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
        Schema::create('mailboxes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('slug', 200)->index();
            $table->enum('status', ["active","inactive"])->default('active');
            $table->text('description')->nullable();
            $table->integer('average_time')->default(60)->comment('Average time in seconds');
            $table->integer('average_pay')->default(600)->comment('Average pay in cents euro');
            $table->foreignId('client_id');
            $table->foreignId('project_id');
            $table->foreignId('box_id');
            $table->unique(['slug', 'project_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mailboxes');
    }
};
