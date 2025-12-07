<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Add password column to wx25_usu table
 * 
 * This migration adds a hashed password column to the wx25_usu table
 * to support modern password hashing (bcrypt/argon2).
 * The 'pazz' column will remain for backwards compatibility during migration.
 */
class AddPasswordToWx25UsuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wx25_usu', function (Blueprint $table) {
            // Add password column after pazz
            $table->string('password', 255)->nullable()->after('pazz');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wx25_usu', function (Blueprint $table) {
            $table->dropColumn('password');
        });
    }
}
