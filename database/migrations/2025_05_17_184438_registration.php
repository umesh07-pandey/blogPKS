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
        Schema::create("registration", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("name");
            $table->string("email")->unique();
            $table->string("password");
            $table->enum('role', ['ADMIN','USER']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::dropIfExists('registration');
    }
};
