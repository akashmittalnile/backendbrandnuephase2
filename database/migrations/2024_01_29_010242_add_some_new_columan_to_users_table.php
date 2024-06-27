<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeNewColumanToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('first_step',['0','1'])->default(0)->after('important');
            $table->enum('second_step',['0','1'])->default(0)->after('first_step');
            $table->enum('third_step',['0','1'])->default(0)->after('second_step');
            $table->enum('four_step',['0','1'])->default(0)->after('third_step');
            $table->enum('five_step',['0','1'])->default(0)->after('four_step');
            $table->enum('six_step',['0','1'])->default(0)->after('five_step');
            $table->enum('seven_step',['0','1'])->default(0)->after('six_step');
            $table->enum('eight_step',['0','1'])->default(0)->after('seven_step');
            $table->enum('nine_step',['0','1'])->default(0)->after('eight_step');
            $table->enum('ten_step',['0','1'])->default(0)->after('nine_step');
            $table->enum('eleven_step',['0','1'])->default(0)->after('ten_step');
            $table->text('shipping_address')->nullable()->after('eleven_step');
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
                'first_step',
                'second_step',
                'third_step',
                'four_step',
                'five_step',
                'six_step',
                'seven_step',
                'eight_step',
                'nine_step',
                'ten_step',
                'eleven_step',
                'shipping_address'
            ]);
        });
    }
}
