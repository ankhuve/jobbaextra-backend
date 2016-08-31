<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsDescriptionAndTitleAndSubtitleToFeaturedCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('featured_companies', function (Blueprint $table) {
            $table->string('title');
            $table->string('subtitle');
            $table->longText('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('featured_companies', function (Blueprint $table) {
            $table->dropColumn(['title', 'subtitle', 'description']);
        });
    }
}
