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
    *   TESTING ORDER
    *   1. Admin
    *   2. Pioneer
    *   3. User
    *   4. Required Fields
    *-----------------------------------
    */

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

        $account = User::where('account_code', $userData['account_code'])->first()->account;

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

        // dd($response);

        $account = User::where('account_code', $userData['account_code'])->first()->account;

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
        $codeFactory = Code::factory()
            ->create(['user_id' => Account::where('role', 'user')->orderBy('id', 'DESC')->first()->user->user_id]);
        $code = Code::where(['account_code' => $codeFactory->account_code, 'used' => false])->first();
        // Code::where(['account_code' => $code->account_code, 'used' => false])->update(['used' => true]); //force the test to fail

        $account = Account::where(['user_id' => $code->user_id])->first();
        $rootAccounts = $this->getRootAccounts(Account::where('user_id', $code->user_id)->first());

        $userData = $this->getUserData();
        $this->account_code_must_be_unique_and_unused($code->account_code);
        $userData['account_code'] = $code->account_code;

        $response = $this->post('/register', $userData);

        $account = User::where('account_code', $userData['account_code'])->first()->account;

        $this->checkRootAccountsMoney($account, $rootAccounts);

        $code = Code::where(['account_code' => $code->account_code])->first();
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
    public function test_required_fields()
    {
        $fields = $this->getFields();
        $fields[] = 'account_code';
        foreach ($fields as $field) {
            $this->field_is_required($field);
        }

        // dd(session('errors')->get('password')[0]);
    }


    /*
    *-----------------------------------
    *   FILTERING FIELDS WITH SPECIAL CHARACTERS
    *-----------------------------------
    */
    public function test_field_must_not_contain_special_characters()
    {
        $userData = $this->getUserData();
        foreach ($this->getFields() as $field) {
            foreach (Helper::getSpecialChars() as $character) {
                $userData[$field] = $character;

                $response = $this->post('/register', $userData);
                $response->assertSessionHasErrors($field);

                $this->assertEquals(true, in_array('You cannot include a special character.', session('errors')->get($field)));
            }
        }
    }


    /*
    *-----------------------------------
    *   OTHER TESTS
    *-----------------------------------
    */
    public function test_phone_number_must_be_unique()
    {
        $userData = $this->getUserData();
        $userData['phone_number'] = User::latest()->first()->phone_number ?? User::factory()->create()->phone_number;

        $response = $this->post('/register', $userData);
        $response->assertSessionHasErrors('phone_number');

        $this->assertEquals(true, in_array('The phone number has already been taken.', session('errors')->get('phone_number')));
    }


    /*
    *-----------------------------------
    *   HELPER METHODS
    *-----------------------------------
    */
    private function newAccountStats(Account $account)
    {
        $message = 'actual value is less than the expected value';
        $this->assertGreaterThanOrEqual(1, User::all()->count(), $message);
        $this->assertGreaterThanOrEqual(1, Account::all()->count(), $message);
        $this->assertEquals('basic', $account->level);
        $this->assertEquals(0, $account->direct);
        $this->assertEquals(0, $account->indirect);
        $this->assertEquals(0, $account->number_of_bonus_claimed);
        $this->assertEquals(null, $account->bonus_claimed_at);
        $this->assertGreaterThanOrEqual(1, Receipt::all()->count(), $message);
        $this->assertGreaterThanOrEqual(1, ColorGame::all()->count(), $message);
        $this->assertGreaterThanOrEqual(1, UserCaptcha::all()->count(), $message);
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

    private function getFields()
    {
        return [
            'firstname',
            'middlename',
            'lastname',
            'phone_number',
            'city',
            'province',
            'password',
        ];
    }

    private function field_is_required($field)
    {
        $userData = $this->getUserData();
        $userData[$field] = '';

        $response = $this->post('/register', $userData);
        $response->assertSessionHasErrors($field);
    }

    public function account_code_must_be_unique_and_unused($code)
    {
        $this->assertDatabaseHas('codes', ['account_code' => $code]);
    }

    private function checkRootAccountsExpectedMoney(Account $account, $rootAccounts) // JUST A HELPER TO GET RESULTS AND LOG IT
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
