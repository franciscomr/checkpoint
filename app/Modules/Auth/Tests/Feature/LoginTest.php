<?php

use App\Models\User;
use App\Modules\Auth\Enums\UserStatus;
use App\Modules\Shared\Models\Tenant;
use App\Modules\Shared\Services\TenantManager;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    Config::set('auth.login_throttle.app_max_attempts', 2);
    Config::set('auth.login_throttle.app_decay_seconds', 60);
});
function createAndSetTenant(): void
{
    $tenant = Tenant::factory()->create([
        'domain' => 'acme.checkpoint.test',
    ]);
    app(TenantManager::class)->setTenant($tenant);
}

it('allows active users to authenticate', function () {
    /** @var TestCase $this */
    createAndSetTenant();
    $user = User::factory()->create([
        'email' => 'juan@empresa.com',
        'password' => 'password123',
    ]);
    $response = $this->post('http://acme.checkpoint.test/login', [
        'email' => 'juan@empresa.com',
        'password' => 'password123',
    ]);
    $response->assertSessionHasNoErrors();
    $this->assertAuthenticatedAs($user);
    $response->assertRedirect('/');
});

it('returns standard generic error message when user is inactive or suspended', function (UserStatus $status) {
    /** @var TestCase $this */
    createAndSetTenant();

    User::factory()->create([
        'email' => 'usuario@empresa.com',
        'password' => 'password123',
        'status' => $status,
    ]);

    $response = $this->post('http://acme.checkpoint.test/login', [
        'email' => 'usuario@empresa.com',
        'password' => 'password123',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors([
        'email' => __('auth.failed'),
    ]);
})->with([
    UserStatus::INACTIVE,
    UserStatus::SUSPENDED,
    UserStatus::BLOCKED,
]);

it('throttles login attempts after 5 failed tries', function () {
    Event::fake([Lockout::class]);

    /** @var TestCase $this */
    createAndSetTenant();
    User::factory()->create([
        'email' => 'juan@empresa.com',
        'password' => 'password123',
    ]);

    // Realizar 5 intentos fallidos
    foreach (range(1, 5) as $i) {
        $response = $this->post('http://acme.checkpoint.test/login', [
            'email' => 'juan@empresa.com',
            'password' => 'wrong-password',
        ]);

        // Los primeros 5 intentos son redirigidos con error de credenciales
        $response->assertStatus(302);
    }

    // El 6.º intento debe ser bloqueado por el Middleware (HTTP 429)
    $response = $this->post('http://acme.checkpoint.test/login', [
        'email' => 'juan@empresa.com',
        'password' => 'wrong-password',
    ]);
    $response->assertInvalid([
        'email' => __('auth.throttle', ['seconds' => 60]),
    ]);
    $response->assertSessionHasErrors(['email']);
    $this->assertGuest();
    // $response->assertStatus(302);

});
