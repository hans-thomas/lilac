<?php

	namespace Hans\Lilac\Jobs;

	use Hans\Lilac\LilacService;
	use Illuminate\Bus\Queueable;
	use Illuminate\Contracts\Queue\ShouldQueue;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Foundation\Bus\Dispatchable;
	use Illuminate\Queue\InteractsWithQueue;
	use Illuminate\Queue\SerializesModels;
	use Illuminate\Support\Arr;

	class UpdateCachedRecommendedModelsJob implements ShouldQueue {
		use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

		private string $relation;
		private Model $parent;
		private array $ids;

		/**
		 * Create a new job instance.
		 *
		 * @return void
		 */
		public function __construct( string $relation, Model $parent, array $ids ) {
			$this->relation = $relation;
			$this->parent   = $parent;
			$this->ids      = $ids;
		}

		/**
		 * Execute the job.
		 *
		 * @return void
		 */
		public function handle() {
			if ( $this->relation == $this->getConfig( 'relatedWrappedByRelation' ) ) {
				app( LilacService::class )->trainer( collect( [ $this->parent ] ), fresh: true );
			} else if ( $this->relation == $this->getConfig( 'relatedEntityRelation' ) ) {
				app( LilacService::class )->trainer( $this->parent->{$this->relation}, fresh: true );
			}
		}

		protected function getConfig( string $key, $default = null ) {
			return Arr::get( config( 'lilac' ), $key, $default );
		}
	}
