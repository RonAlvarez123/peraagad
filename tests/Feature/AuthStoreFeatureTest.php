<?php

namespace Tests\Feature;

use App\Helper;
use App\Models\Account;
use App\Models\Code;
use App\Models\ColorGame;
use App\Models\Receipt;
use App\Models\User;
use App\Models\UserCaptcha;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthStoreFeatureTest extends TestCase
{
    use WithFaker;
    // use RefreshDatabase;


    /*
    *-----------------------------------
    *   Testing Order
    *   1. Admin
    *   2. Pioneer
    *   3. User
    *   4. Required Fields
    *-----------------------------------
    */

    // public function __construct()
    // {
    //     $this->setUpFaker();
    // }

    public function test_faker()
    {
        dd($this->faker->city . ' - ' . $this->faker->state);
    }

    public function test_a_user_can_visit_sign_up_page()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_a_pioneer_can_sign_up()
    {
        $userData = $this->getUserData();
        $userData['account_code'] = Helper::randomString(11);

        $response = $this->post('/register', $userData);

        $account = User::latest()->first()->account;

        $this->newAccountStats($account);
        $this->assertEquals(200, $account->money);
        $this->assertEquals(null, $account->referrer_id);
        $this->assertEquals('user', $account->role);
    }

    public function test_an_admin_can_sign_up()
    {
        $userData = $this->getUserData();
        $userData['account_code'] = 'admin' . Helper::randomString(1);
        $userData['role'] = 'admin';

        $response = $this->post('/register', $userData);

        $account = User::latest()->first()->account;

        $this->newAccountStats($account);
        $this->assertEquals(0, $account->money);
        $this->assertEquals(null, $account->referrer_id);
        $this->assertEquals('admin', $account->role);
    }




    /*
    *-----------------------------------
    *   USER
    *-----------------------------------
    */

    public function test_a_user_can_sign_up()
    {
        $codeFactory = Code::factory()->create(['user_id' => User::latest()->first()->user_id]);

        $code = Code::where(['account_code' => $codeFactory->account_code, 'used' => false])->first();

        $rootAccounts = $this->getRootAccounts(Account::where('user_id', $code->user_id)->first());

        $userData = $this->getUserData();
        $userData['account_code'] = $code->account_code;

        $response = $this->post('/register', $userData);

        $account = User::latest()->first()->account;
        $this->checkRootAccountsMoney($account, $rootAccounts);

        $code = Code::where(['account_code' => $codeFactory->account_code])->first();
        $this->assertEquals(true, $code->used);
        $this->newAccountStats($account);
        $this->assertEquals(200, $account->money);
        $this->assertNotEquals(null, $account->referrer_id, 'actual value is equals to expected');
        $this->assertEquals('user', $account->role);
    }



    /*
    *-----------------------------------
    *   REQUIRED FIELD TESTS
    *-----------------------------------
    */

    public function test_firstname_is_required()
    {
        $this->field_is_required('firstname');
    }

    public function test_middlename_is_required()
    {
        $this->field_is_required('middlename');
    }

    public function test_lastname_is_required()
    {
        $this->field_is_required('lastname');
    }

    public function test_phone_number_is_required()
    {
        $this->field_is_required('phone_number');
    }

    public function test_city_is_required()
    {
        $this->field_is_required('city');
    }

    public function test_province_is_required()
    {
        $this->field_is_required('province');
    }

    public function test_password_is_required()
    {
        $this->field_is_required('password');
        // dd(session('errors')->get('password')[0]);
    }



    /*
    *-----------------------------------
    *   HELPER METHODS
    *-----------------------------------
    */
    public function newAccountStats(Account $account)
    {
        $this->assertGreaterThanOrEqual(1, User::all()->count(), 'actual value is less than the expected value');
        $this->assertGreaterThanOrEqual(1, Account::all()->count(), 'actual value is less than the expected value');
        $this->assertEquals('basic', $account->level);
        $this->assertEquals(0, $account->direct);
        $this->assertEquals(0, $account->indirect);
        $this->assertEquals(0, $account->number_of_bonus_claimed);
        $this->assertEquals(null, $account->bonus_claimed_at);
        $this->assertGreaterThanOrEqual(1, Receipt::all()->count(), 'actual value is less than the expected value');
        $this->assertGreaterThanOrEqual(1, ColorGame::all()->count(), 'actual value is less than the expected value');
        $this->assertGreaterThanOrEqual(1, UserCaptcha::all()->count(), 'actual value is less than the expected value');
    }

    private function getUserData()
    {
        return [
            'firstname' => $this->faker->firstName,
            'middlename' => $this->faker->lastName,
            'lastname' => $this->faker->lastName,
            'phone_number' => '09' . Helper::randomNumber(9),
            'city' => $this->faker->city,
            'province' => $this->faker->state,
            'account_code' => Helper::randomString(11, 1),
            'password' => 'admin123',
            'password_confirmation' => 'admin123',
        ];
    }

    public function field_is_required($field)
    {
        $userData = $this->getUserData();
        $userData[$field] = '';

        $response = $this->post('/register', $userData);
        $response->assertSessionHasErrors($field);
    }

    private function checkRootAccountsExpectedMoney(Account $account, $rootAccounts)
    {
        $array = [];
        for ($i = 1; $i < count($rootAccounts); $i++) {
            $account = $account->getReferrerAccount;

            $array[] = ($i === 1)
                ? $rootAccounts[0]->money + 50 . ' - ' . $account->money
                : $rootAccounts[$i - 1]->money + 5 . ' - ' . $account->money;
        }
        return $array;
    }

    private function checkRootAccountsMoney(Account $account, $rootAccounts)
    {
        for ($i = 1; $i < count($rootAccounts); $i++) {
            $account = $account->getReferrerAccount;

            ($i === 1)
                ? $this->assertEquals($rootAccounts[0]->money + 50, $account->money)
                : $this->assertEquals($rootAccounts[$i - 1]->money + 5, $account->money);
        }
    }

    private function getRootAccounts(Account $account)
    {
        $rootAccounts[] = $account;
        for ($i = 1; $i <= 6; $i++) {
            if ($account->referrer_id === null) {
                break;
            }
            $account = Account::where('user_id', $account->referrer_id)->first();
            $rootAccounts[] = $account;
        }
        return $rootAccounts;
    }
}
