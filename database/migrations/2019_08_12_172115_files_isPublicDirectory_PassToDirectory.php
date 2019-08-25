<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FilesIsPublicDirectoryPassToDirectory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('files', function($table){
            $table->boolean('is_public_file')->default(false);
            $table->string('password_file')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('files', function($table){
            $table->dropColumn('is_public_file');
            $table->dropColumn('password_file');
        });
    }
}
