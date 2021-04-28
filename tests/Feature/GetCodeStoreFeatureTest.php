<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\CodeRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class GetCodeStoreFeatureTest extends TestCase
{
    use WithoutMiddleware;

    public function test_a_user_can_perform_request_code()
    {
        $this->withoutExceptionHandling();

        $codeRequestsCount = CodeRequest::count();

        $user = Account::where('referrer_id', '!=', null)->first()->user;

        $response = $this->actingAs($user)
            ->post('/getcode/requestcode', $this->getData());

        $this->assertGreaterThan($codeRequestsCount, CodeRequest::count());
    }

    public function test_get_code_limit()
    {
        $account = Account::where('referrer_id', '!=', null)->first();

        $data = $this->getData();
        $data['number_of_codes'] = 9;

        $response = $this->actingAs($account->user)
            ->post('/getcode/requestcode', $data);

        // dd(session('errors')->get('number_of_codes')[0]);
        // dd($account->totalCodeRequests() + $account->totalCodes());

        $response->assertSessionHasErrors('number_of_codes');
        $this->assertEquals(true, (str_contains(session('errors')->get('number_of_codes')[0], 'comeback later to request a code after you sell some of your codes.')));
    }


    /*
    *-----------------------------------
    *   REQUIRED FIELD TESTS
    *-----------------------------------
    */
    public function test_required_fields()
    {
        $fields = $this->getFields();
        foreach ($fields as $field) {
            $this->field_is_required($field);
        }
        dd(session('errors'));
    }


    /*
    *-----------------------------------
    *   HELPER METHODS
    *-----------------------------------
    */
    public function getData()
    {
        return [
            'number_of_codes' => 2,
            'password' => 'admin123',
        ];
    }

    private function getFields()
    {
        return [
            'number_of_codes',
            'password',
        ];
    }

    private function field_is_required($field)
    {
        $data = $this->getData();
        $data[$field] = '';

        $response = $this->post('/getcode/requestcode', $data);
        $response->assertSessionHasErrors($field);
    }
}
