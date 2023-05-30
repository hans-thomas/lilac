<?php


	namespace Hans\Lilac;


	use Hans\Lilac\Contracts\Trainers\Trainer;
	use Hans\Lilac\Services\LilacService;
	use Illuminate\Support\ServiceProvider;

	class LilacServiceProvider extends ServiceProvider {
		/**
		 * Register any application services.
		 *
		 * @return void
		 */
		public function register() {
			$this->app->singleton( 'lilac-service', LilacService::class );
			$this->app->bind( Trainer::class, fn() => app( lilac_config( 'trainer' ) ) );
		}

		/**
		 * Bootstrap any application services.
		 *
		 * @return void
		 */
		public function boot() {
			$this->mergeConfigFrom( __DIR__ . '/../config/config.php', 'lilac' );

			if ( $this->app->runningInConsole() ) {
				$this->publishes( [
					__DIR__ . '/../config/config.php' => config_path( 'lilac.php' )
				], 'lilac-config' );
			}
		}

	}
