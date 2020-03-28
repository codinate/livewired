<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class CreateNotificationMethodsTable extends Migration
{
    public function up()
    {
        Schema::create(Config::get('notification-methods.tables.notification_methods'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('notifiable');
            $table->string('name');
            $table->string('channel');

            foreach (Config::get('notification-methods.channels') as $channel) {
                foreach (\array_keys($channel['properties']) as $property) {
                    $table->string($property)->nullable();
                }
            }

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop(Config::get('notification-methods.tables.notification_methods'));
    }
}
