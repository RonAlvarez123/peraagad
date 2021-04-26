<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ProfileUpdateFeatureTest extends TestCase
{
    use WithoutMiddleware;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
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
            $errors[] = session('errors')->get($field)[0];
        }
        // dd(session('errors')->get('password')[0]);
    }


    /*
    *-----------------------------------
    *   HELPER METHODS
    *-----------------------------------
    */
    private function getUserData()
    {
        return [
            'old_password' => 'admin123',
            'new_password' => 'admin1234',
            'new_password_confirmation' => 'admin1234',
        ];
    }

    private function getFields()
    {
        return [
            'old_password',
            'new_password',
        ];
    }

    private function field_is_required($field)
    {
        $userData = $this->getUserData();
        $userData[$field] = '';

        $response = $this->put('/myaccount/profile', $userData);
        $response->assertSessionHasErrors($field);
    }
}
