<?php

namespace App\Console\Commands;

use App\Models\TrainingPlan;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdatePlan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plan:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update training plan at the end of the day';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $plans = TrainingPlan::all();
        $now = Carbon::createFromFormat('m/d/Y',Carbon::now());
        foreach ($plans as $plan) {
            $date_end = Carbon::createFromFormat('m/d/Y',$plan->date_end);
            $check = $now->lte($date_end);
            if ($check) {
                if ($plan->current_score >= $plan->goal_score ) $plan->status = "success";
                else $plan->status = "fail";
                $plan->update();
            }
        }
    }
}
