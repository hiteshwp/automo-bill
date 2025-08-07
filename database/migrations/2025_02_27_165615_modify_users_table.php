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
        Schema::table('users', function (Blueprint $table) {
            $table->string('businessname')->nullable();
            $table->string('countrycode')->nullable();
            $table->string('mobilenumber')->unique()->nullable();
            $table->string('taxnumber')->nullable();
            $table->text('address')->nullable();
            $table->foreignId('country_id')->nullable()->constrained('tbl_countries')->onDelete('cascade');
            $table->foreignId('state_id')->nullable()->constrained('tbl_states')->onDelete('cascade');
            $table->foreignId('city_id')->nullable()->constrained('tbl_cities')->onDelete('cascade');
            $table->string('zip')->nullable();
            $table->string('website')->nullable();
            $table->string('user_type')->nullable();
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
