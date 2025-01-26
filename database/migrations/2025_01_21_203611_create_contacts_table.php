<?php

use App\Enums\Status;
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

        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->index();
            $table->string('slug')->unique();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->text('info')->nullable();
            $table->enum('position', ["geschäftsführer","projektleiter","manager","teamleiter","abteilungsleiter","techniker","datenbanktechniker","servicemitarbeiter"])->default('manager');
            $table->string('status')->default(Status::Pending->value);
            $table->index(['email']);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
