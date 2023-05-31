<?php

	namespace Hans\Lilac\Tests\Feature;

	use Hans\Lilac\Facades\Lilac;
	use Hans\Lilac\Tests\Core\Factories\CategoryFactory;
	use Hans\Lilac\Tests\Core\Factories\PostFactory;
	use Hans\Lilac\Tests\Core\Models\Post;
	use Hans\Lilac\Tests\TestCase;
	use Hans\Lilac\Trainers\EPAR;
	use Hans\Lilac\Trainers\PAR;
	use Illuminate\Support\Collection;
	use Illuminate\Support\Facades\Cache;
	use Mockery;

	class LilacServiceTest extends TestCase {
		protected function setUp(): void {
			parent::setUp();
			CategoryFactory::new()
			               ->count( 10 )
			               ->has( PostFactory::new()->count( 15 ) )
			               ->create();
		}

		/**
		 * @test
		 *
		 * @return void
		 */
		public function recommendsUsingEPAR(): void {
			$ids         = Post::query()->inRandomOrder()->limit( 5 )->get();
			$recommended = Lilac::trainer( new EPAR( $ids ) )->recommends( $ids );

			self::assertInstanceOf( Collection::class, $recommended );
			self::assertInstanceOf( Post::class, $recommended->first() );
			self::assertNotEmpty( $recommended );
		}

		/**
		 * @test
		 *
		 * @return void
		 */
		public function recommendsUsingPAR(): void {
			$ids         = Post::query()->inRandomOrder()->limit( 5 )->get();
			$recommended = Lilac::trainer( new PAR )->recommends( $ids );

			self::assertInstanceOf( Collection::class, $recommended );
			self::assertInstanceOf( Post::class, $recommended->first() );
			self::assertNotEmpty( $recommended );
		}

		/**
		 * @test
		 *
		 * @return void
		 */
		public function fresh(): void {
			$partialCacheMock = Mockery::mock( Cache::driver() )->makePartial();
			$partialCacheMock->shouldReceive( 'forget' )->once();
			Cache::swap( $partialCacheMock );

			$ids = Post::query()->inRandomOrder()->limit( 5 )->get();
			Lilac::fresh()->recommends( $ids );
		}

		/**
		 * @test
		 *
		 * @return void
		 */
		public function cache(): void {
			$partialCacheMock = Mockery::mock( Cache::driver() )->makePartial();
			$partialCacheMock->shouldNotReceive( 'forget' );
			Cache::swap( $partialCacheMock );

			$ids = Post::query()->inRandomOrder()->limit( 5 )->get();
			Lilac::recommends( $ids );
		}

		/**
		 * @test
		 *
		 * @return void
		 */
		public function limit(): void {
			$ids         = Post::query()->inRandomOrder()->limit( 5 )->get();
			$recommended = Lilac::limit( 10 )->recommends( $ids );

			self::assertCount( 10, $recommended );
		}

	}
