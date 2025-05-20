<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("profile", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("registration_id");
            // $table->unsignedBigInteger("category_id");
            $table->foreign('registration_id')->references('id')->on('registration')->onDelete('cascade');
            // $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade'); // or whatever action you intend
            

            $table->date("dob")->nullable();
            $table->enum("gender", ["MALE", "FEMALE", "OTHER"])->nullable();
            $table->string("profilepic");
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
