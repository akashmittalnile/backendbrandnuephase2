<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumanToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('current_status')->nullable()->after('remember_token');
            $table->string('health_concerns', 500)->nullable()->after('current_status');
            $table->string('current_motivation')->nullable()->after('health_concerns');
            $table->string('past_diet', 500)->nullable()->after('current_motivation');
            $table->string('past_program', 500)->nullable()->after('past_diet');
            $table->string('personal_need', 500)->nullable()->after('past_program');
            $table->string('metabolism')->nullable()->after('personal_need');
            $table->string('important', 500)->nullable()->after('metabolism');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'current_status',
                'health_concerns',
                'current_motivation',
                'past_diet',
                'past_program',
                'personal_need',
                'metabolism',
                'important',
            ]);
        });
    }
}
