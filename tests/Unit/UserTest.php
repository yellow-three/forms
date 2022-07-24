<?php

namespace YellowThree\VoyagerForms\Tests\Unit;

use App\User;
use Tests\TestCase;
use YellowThree\VoyagerForms\Form;
use YellowThree\VoyagerForms\FormInput;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Pvtl\VoyagerForms\Tests\Utilities\FactoryUtilities;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $form;

    public function setUp()
    {
        parent::setUp();

        \YellowThree\VoyagerForms\Tests\Unit\FormTest::createForm();
    }

    public function testIfSuperUserCanSelectAFormView()
    {
        $user = factory(User::class)->make([
            'role_id' => 1,
        ]);

        return $this->actingAs($user)
            ->get('/admin/forms')
            ->assertStatus('200')
            ->assertSee('name="form_view"');
    }

    public function testIfAdminUserCanSelectAFormView()
    {
        $user = factory(User::class)->make([
            'role_id' => 1,
        ]);

        return $this->actingAs($user)
            ->get('/admin/forms')
            ->assertStatus('200')
            ->assertDontSee('name="form_view"');
    }
}
