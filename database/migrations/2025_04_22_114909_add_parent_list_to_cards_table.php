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
        Schema::table('cards', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_list')->nullable(); // Menambahkan kolom parent_list
            $table->foreign('parent_list')->references('id')->on('parent_lists')->onDelete('set null'); // Menambahkan foreign key
        });
    }
    public function down()
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->dropColumn('parent_list'); // Menghapus kolom parent_list jika rollback
        });
    }
};
