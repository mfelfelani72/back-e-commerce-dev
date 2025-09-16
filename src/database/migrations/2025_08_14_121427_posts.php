<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Posts Table
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->enum('status', ['draft', 'published', 'scheduled', 'archived', 'private'])->default('draft');
            $table->dateTime('published_at')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('primary_category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->foreignId('guest_author_id')->nullable()->constrained('guest_authors')->onDelete('set null');
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedInteger('likes_count')->default(0);
            $table->unsignedInteger('comments_count')->default(0);
            $table->unsignedInteger('shares_count')->default(0);
            $table->string('featured_image', 2048)->nullable();
            $table->string('thumbnail_image', 2048)->nullable();
            $table->string('meta_title', 255)->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->json('og_meta')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_pinned')->default(false);
            $table->boolean('allow_comments')->default(true);
            $table->string('reading_time', 10)->nullable();
            $table->json('custom_fields')->nullable();
            $table->string('language', 10)->default('fa');
            $table->timestamps();
            $table->softDeletes();
            $table->fullText(['title', 'excerpt', 'content']);
        });

        // 2. Category-Post Pivot Table
        Schema::create('post_category', function (Blueprint $table) {
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->primary(['post_id', 'category_id']);
        });

        // 3. Post-Tag Pivot Table
        Schema::create('post_tag', function (Blueprint $table) {
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->primary(['post_id', 'tag_id']);
        });

        // 4. Related Posts Table
        Schema::create('post_related', function (Blueprint $table) {
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->foreignId('related_post_id')->constrained('posts')->onDelete('cascade');
            $table->primary(['post_id', 'related_post_id']);
            $table->integer('order')->default(0);
        });

        // 5. Comments Table
        Schema::create('post_comments', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('parent_id')->nullable()->constrained('post_comments')->onDelete('cascade');
            $table->string('author_name', 100)->nullable();
            $table->string('author_email', 100)->nullable();
            $table->string('author_website', 255)->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->enum('status', ['pending', 'approved', 'spam', 'trash'])->default('pending');
            $table->unsignedInteger('likes_count')->default(0);
            $table->unsignedInteger('dislikes_count')->default(0);
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 6. Post Views Table
        Schema::create('post_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->string('session_id', 255)->nullable();
            $table->string('referer', 1000)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('device', 50)->nullable();
            $table->string('browser', 100)->nullable();
            $table->string('platform', 100)->nullable();
            $table->boolean('is_robot')->default(false);
            $table->timestamps();
        });

        // 7. Post Shares Table
        Schema::create('post_shares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('platform', ['facebook', 'twitter', 'linkedin', 'telegram', 'whatsapp', 'email', 'other']);
            $table->timestamps();
        });

        // 8. Media Table
        Schema::create('posts_media', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->uuid('uuid')->nullable();
            $table->string('collection_name');
            $table->string('name');
            $table->string('file_name');
            $table->string('mime_type')->nullable();
            $table->string('disk');
            $table->string('conversions_disk')->nullable();
            $table->unsignedBigInteger('size');
            $table->json('manipulations');
            $table->json('custom_properties');
            $table->json('generated_conversions');
            $table->json('responsive_images');
            $table->unsignedInteger('order_column')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts_media');
        Schema::dropIfExists('post_shares');
        Schema::dropIfExists('post_views');
        Schema::dropIfExists('post_comments');
        Schema::dropIfExists('post_related');
        Schema::dropIfExists('post_tag');
        Schema::dropIfExists('post_category');
        Schema::dropIfExists('posts');
    }
};