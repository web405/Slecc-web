<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up():void{
  Schema::create('venues',function(Blueprint $t){$t->id();$t->string('title');$t->string('slug')->unique();$t->string('type')->default('Event Space');$t->text('summary')->nullable();$t->longText('description')->nullable();$t->string('image_url')->nullable();$t->json('features')->nullable();$t->string('capacity_note')->nullable();$t->integer('sort_order')->default(0);$t->boolean('is_published')->default(true);$t->timestamps();});
  Schema::create('services',function(Blueprint $t){$t->id();$t->string('title');$t->string('slug')->unique();$t->text('summary')->nullable();$t->longText('description')->nullable();$t->string('image_url')->nullable();$t->string('icon')->default('✦');$t->integer('sort_order')->default(0);$t->boolean('is_published')->default(true);$t->timestamps();});
  Schema::create('events',function(Blueprint $t){$t->id();$t->string('title');$t->string('slug')->unique();$t->text('summary')->nullable();$t->longText('description')->nullable();$t->string('image_url')->nullable();$t->date('event_date')->nullable();$t->date('end_date')->nullable();$t->string('status')->default('Past');$t->integer('sort_order')->default(0);$t->boolean('is_published')->default(true);$t->timestamps();});
  Schema::create('clients',function(Blueprint $t){$t->id();$t->string('name');$t->string('industry')->nullable();$t->string('logo_url')->nullable();$t->integer('sort_order')->default(0);$t->boolean('is_published')->default(true);$t->timestamps();});
  Schema::create('enquiries',function(Blueprint $t){$t->id();$t->string('name');$t->string('email');$t->string('phone');$t->string('organization')->nullable();$t->string('interest');$t->foreignId('venue_id')->nullable()->constrained('venues')->nullOnDelete();$t->date('event_date')->nullable();$t->unsignedInteger('attendees')->nullable();$t->text('message');$t->string('status')->default('New');$t->text('admin_notes')->nullable();$t->timestamps();});
 }public function down():void{Schema::dropIfExists('enquiries');Schema::dropIfExists('clients');Schema::dropIfExists('events');Schema::dropIfExists('services');Schema::dropIfExists('venues');}
};
