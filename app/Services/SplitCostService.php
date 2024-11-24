<?php

namespace App\Services;

use Illuminate\Http\Request;
use Throwable;

class SplitCostService
{
//    public function splitcost(Request $request)
//    {
//        try {
//            $data_pilot = clone $request;
//            $data_copilot = clone $request;
//
//            $counter_split_value = ($request->counter_stop-$request->counter_start)/2;
//            $counter_start_p    = $request->counter_start;
//            $counter_stop_p     = $counter_start_p+$counter_split_value;
//            $counter_start_c    = $counter_stop_p;
//            $counter_stop_c     = $counter_start_c+$counter_split_value;
//
//            $data_copilot->merge([
//                'user_id' => $data_pilot->copilot_id,
//                'copilot_id' => $data_pilot->user_id,
//            ]);
//            $data_pilot->merge([
//                'counter_start' => $counter_start_p,
//                'counter_stop' => $counter_stop_p,
//            ]);
//            $data_copilot->merge([
//                'counter_start' => $counter_start_c,
//                'counter_stop' => $counter_stop_c,
//            ]);
//
//            if ($request->engine_warmup == true) {
//                $warmup_split_value = ($request->counter_start-$request->warmup_start)/2;
//                $warmup_start_p     = $request->warmup_start;
//                $counter_start_p    = $request->warmup_start+$warmup_split_value;
//                $counter_stop_p     = $counter_start_p+$counter_split_value;
//                $warmup_start_c     = $counter_stop_p;
//                $counter_start_c    = $counter_stop_p+$warmup_split_value;
//                $counter_stop_c     = $counter_start_c+$counter_split_value;
//
//                $data_pilot->merge([
//                    'warmup_start' => $warmup_start_p,
//                    'counter_start' => $counter_start_p,
//                    'counter_stop' => $counter_stop_p,
//                ]);
//
//                $data_copilot->merge([
//                    'warmup_start' => $warmup_start_c,
//                    'counter_start' => $counter_start_c,
//                    'counter_stop' => $counter_stop_c,
//                ]);
//            };
//
//            return compact('data_pilot', 'data_copilot');
//        } catch (Throwable $exception) {
//            report($exception);
//            return back()->withToastError($exception->getMessage());
//        }
//    }
}
