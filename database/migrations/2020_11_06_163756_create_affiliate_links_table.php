<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliateLinksTable extends Migration {

	public function up() {
		Schema::create('affiliate_links', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('userID');
            $table->string('name');
            $table->string('originalURL', 500);
            $table->string('affiliateURL', 500);
            $table->timestamp('purchased')->nullable()->default(null);
            $table->timestamp('payed')->nullable()->default(null);
			$table->timestamps();

            $table->foreign('userID')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
		});
	}

	public function down() {
		Schema::dropIfExists('affiliate_links');
	}
}
