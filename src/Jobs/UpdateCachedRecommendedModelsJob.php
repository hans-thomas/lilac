<?php

	namespace Hans\Lilac\Jobs;

	use Hans\Lilac\Facades\Lilac;
	use Hans\Lilac\Services\LilacService;
	use Illuminate\Bus\Queueable;
	use Illuminate\Contracts\Queue\ShouldQueue;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Foundation\Bus\Dispatchable;
	use Illuminate\Queue\InteractsWithQueue;
	use Illuminate\Queue\SerializesModels;

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
			if ( $this->relation == liliac_config( 'relatedWrappedByRelation' ) ) {
				Lilac::trainer( collect( [ $this->parent ] ), fresh: true );
			} else if ( $this->relation == liliac_config( 'relatedEntityRelation' ) ) {
				Lilac::trainer( $this->parent->{$this->relation}, fresh: true );
			}
		}

	}
