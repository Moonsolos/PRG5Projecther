<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('decks', function (Blueprint $table) {
            $table->string('status')->default('active'); // You can adjust the default value if needed
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('decks', function (Blueprint $table) {
            //
        });
    }
};
