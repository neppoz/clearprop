<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\StatisticsService;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChangePasswordController extends Controller
{
    public function edit()
    {
        abort_if(Gate::denies('profile_password_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $collectionFinanceStatistics = new \Illuminate\Support\Collection();
//        if (\Gate::allows('profile_global_finance_access')) {
//            $getGlobalFinanceStatistics = (new StatisticsService())->getGlobalFinanceStatistics();
//            $collectionFinanceStatistics->push($getGlobalFinanceStatistics);
//        }
//        if (\Gate::allows('profile_instructor_finance_access')) {
//            $getInstructorFinanceStatistics = (new StatisticsService())->getInstructorFinanceStatistics();
//            $collectionFinanceStatistics->push($getInstructorFinanceStatistics);
//        }
        if (\Gate::allows('profile_personal_finance_access')) {
            $getPersonalFinanceStatistics = (new StatisticsService())->getPersonalFinanceStatistics();
            $collectionFinanceStatistics->push($getPersonalFinanceStatistics);
        }

        return view('auth.passwords.edit', compact('collectionFinanceStatistics'));
    }

    public function update(UpdatePasswordRequest $request)
    {
        auth()->user()->update($request->validated());

        return redirect()->route('profile.password.edit')->with('message', __('global.change_password_success'));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        auth()->user()->update($request->all());

        return redirect()->route('app.home')->withMessage(trans('global.update_success'));
    }
}
