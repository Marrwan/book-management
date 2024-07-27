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
        Schema::table('books', function (Blueprint $table) {
            $table->string('genre')->after('title'); // Add the 'genre' column
            $table->string('author')->after('genre'); // Add the 'author' column
            $table->year('published_year')->after('author'); // Add the 'published_year' column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('genre');
            $table->dropColumn('author');
            $table->dropColumn('published_year');
        });
    }
};
