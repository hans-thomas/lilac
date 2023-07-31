<?php

    use Hans\Lilac\Tests\Core\Models\Category;
    use Hans\Lilac\Tests\Core\Models\Post;
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class() extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('category_post', function (Blueprint $table) {
                $table->foreignIdFor(Category::class)->constrained();
                $table->foreignIdFor(Post::class)->constrained();

                $table->primary([( new Category() )->getForeignKey(), ( new Post() )->getForeignKey()]);
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('category_post');
        }
    };
