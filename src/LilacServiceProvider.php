<?php


	namespace Hans\Lilac;


	use Hans\Lilac\Contracts\Trainers\Trainer;
	use Illuminate\Support\Facades\Route;
	use Illuminate\Support\ServiceProvider;

	class LilacServiceProvider extends ServiceProvider {
		/**
		 * Register any application services.
		 *
		 * @return void
		 */
		public function register() {
			$this->app->singleton( 'lilac-facade', fn() => new LilacService );
			$this->app->bind( Trainer::class, fn() => app( config( 'lilac.trainer' ) ) );
		}

		/**
		 * Bootstrap any application services.
		 *
		 * @return void
		 */
		public function boot() {
			$this->publishes( [
				__DIR__ . '/../config/config.php' => config_path( 'lilac.php' )
			], 'lilac-config' );
			$this->loadMigrationsFrom( __DIR__ . '/../database/migrations' );
			$this->mergeConfigFrom( __DIR__ . '/../config/config.php', 'lilac' );

			$this->registerRoutes();
		}

		/**
		 * Define routes setup.
		 *
		 * @return void
		 */
		protected function registerRoutes() {
			Route::prefix( 'lilac' )->middleware( 'api' )->group( __DIR__ . '/../routes/api.php' );
		}

	}
