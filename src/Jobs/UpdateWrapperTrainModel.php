<?php

	namespace Hans\Lilac\Jobs;

	use Hans\Lilac\Facades\Lilac;
	use Illuminate\Bus\Queueable;
	use Illuminate\Contracts\Queue\ShouldQueue;
	use Illuminate\Foundation\Bus\Dispatchable;
	use Illuminate\Queue\InteractsWithQueue;
	use Illuminate\Queue\SerializesModels;
	use Illuminate\Support\Collection;

	class UpdateWrapperTrainModel implements ShouldQueue {
		use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

		/**
		 * Create a new job instance.
		 *
		 * @return void
		 */
		public function __construct(
			protected Collection $models
		) {

		}

		/**
		 * Execute the job.
		 *
		 * @return void
		 */
		public function handle() {
			Lilac::updateTrainModel( $this->models );
		}
	}