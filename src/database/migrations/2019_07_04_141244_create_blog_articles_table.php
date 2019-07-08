<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->bigInteger('author_id')->index()->unsigned()->nullable();
            $table->foreign('author_id')->references('id')->on('users')->onDelete('no action');
            $table->longText('content')->nullable();
            $table->string('feature_image')->nullable();
            $table->string('status')->default('draft');
            $table->text('meta')->nullable();
            $table->string('slug')->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('blog_categories_has_articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('blog_category_id')->index()->unsigned();
            $table->foreign('blog_category_id')->references('id')->on('blog_categories')->onDelete('cascade');
            $table->integer('blog_article_id')->index()->unsigned();
            $table->foreign('blog_article_id')->references('id')->on('blog_articles')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('blog_articles_has_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('blog_article_id')->index()->unsigned();
            $table->foreign('blog_article_id')->references('id')->on('blog_articles')->onDelete('cascade');
            $table->integer('blog_tag_id')->index()->unsigned();
            $table->foreign('blog_tag_id')->references('id')->on('blog_tags')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_articles_has_tags');
        Schema::dropIfExists('blog_categories_has_articles');
        Schema::dropIfExists('blog_articles');
    }
}
