<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Http\Requests\ProfilePictureRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Account;
use App\Models\User;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::select('user_id', 'firstname', 'middlename', 'lastname', 'phone_number', 'city', 'province', 'account_code', 'profile_pic', 'created_at', 'updated_at')->where('id', auth()->user()->user_id)
            ->with([
                'account' => function ($query) {
                    $query->select('user_id', 'money', 'level', 'direct', 'indirect', 'role', 'bonus_claimed_at', 'number_of_bonus_claimed');
                }
            ])->first();

        return view('profile.index')->with('user', $user)->with('account', $user->account);
    }

    public function bonus()
    {
        $account = Account::select('id', 'user_id', 'money', 'number_of_bonus_claimed', 'bonus_claimed_at')->where('user_id', auth()->user()->user_id)->first();
        if ($account->getDailyBonus()) {
            return redirect()->route('profile.index')
                ->with('status', 'You have claimed your daily bonus.');
        }

        return redirect()->route('profile.index');
    }

    public function update(ProfileUpdateRequest $request)
    {
        $user = User::select('id', 'user_id', 'password', 'updated_at')->where('user_id', auth()->user()->user_id)->first();

        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->route('profile.index')
                ->withErrors(array_merge(ProfileService::getMainError(), ['old_password' => 'The password is incorrect.']));
        } elseif (Hash::check($request->new_password, $user->password)) {
            return redirect()->route('profile.index')
                ->withErrors(array_merge(ProfileService::getMainError(), ['new_password' => 'The new password is the same as the old password.']));
        }

        if ($user->changePassword($request->new_password)) {
            return redirect()->route('profile.index')
                ->with('status', 'You have changed your password.');
        }

        return redirect()->route('profile.index')
            ->withErrors(ProfileService::getMainError());
    }

    public function picture(ProfilePictureRequest $request)
    {
        return redirect()->route('profile.index'); // MAKE THIS A COMMENT TO ENABLE PROFILE PICTURE UPLOAD

        $user = User::select('id', 'user_id', 'profile_pic')->where('user_id', auth()->user()->user_id)->first();

        if ($user->profile_pic != null) {
            return redirect()->route('profile.index');
        }

        $request->file('file')->storeAs('public/profile', $filePath = Helper::renameFile('/profile', $request->file('file')->getClientOriginalName(), 15));

        if ($user->setProfilePic($filePath)) {
            return redirect()->route('profile.index')
                ->with('status', 'You have successfully set your profile picture.');
        }
    }
}
