<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('name');
            $table->timestamps();
        });

        DB::table('statuses')->insert(array(
            #Invoice Statuses
            array('id' => '1','name' => 'Success','created_at' => NULL,'updated_at' => NULL),
            array('id' => '2','name' => 'Pending','created_at' => NULL,'updated_at' => NULL),
            array('id' => '3','name' => 'Failed','created_at' => NULL,'updated_at' => NULL),
          ));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};
