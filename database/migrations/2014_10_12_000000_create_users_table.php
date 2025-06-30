<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('over_name', 60)->index()->comment('姓');
            $table->string('under_name', 60)->index()->comment('名');
            $table->string('over_name_kana', 60)->index()->comment('セイ');
            $table->string('under_name_kana', 60)->index()->comment('メイ');
            $table->string('mail_address', 60)->unique()->comment('メールアドレス');
            $table->tinyInteger('sex')->index()->comment('性別');
            $table->date('birth_day')->index()->comment('生年月日');
            $table->tinyInteger('role')->index()->comment('権限');
            $table->string('password', 191)->comment('パスワード');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes()->comment('削除日時');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
