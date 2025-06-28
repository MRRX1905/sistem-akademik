# Panduan Testing Sistem Akademik Kampus

## Daftar Isi
1. [Unit Testing](#unit-testing)
2. [Feature Testing](#feature-testing)
3. [Browser Testing](#browser-testing)
4. [API Testing](#api-testing)
5. [Performance Testing](#performance-testing)
6. [Security Testing](#security-testing)
7. [Test Data](#test-data)

## Unit Testing

### Setup Testing Environment
```bash
# Install PHPUnit
composer require --dev phpunit/phpunit

# Copy testing configuration
cp phpunit.xml.example phpunit.xml
```

### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Unit/UserTest.php

# Run tests with coverage
php artisan test --coverage
```

### Example Unit Tests

#### User Model Test
```php
<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'admin'
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'admin'
        ]);
    }

    public function test_user_role_methods()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $dosen = User::factory()->create(['role' => 'dosen']);
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);

        $this->assertTrue($admin->isAdmin());
        $this->assertTrue($dosen->isDosen());
        $this->assertTrue($mahasiswa->isMahasiswa());
    }
}
```

#### Mahasiswa Model Test
```php
<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MahasiswaTest extends TestCase
{
    use RefreshDatabase;

    public function test_mahasiswa_has_user_relationship()
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);
        $mahasiswa = Mahasiswa::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $mahasiswa->user);
        $this->assertEquals($user->id, $mahasiswa->user->id);
    }

    public function test_mahasiswa_nim_is_unique()
    {
        Mahasiswa::factory()->create(['nim' => '2021001']);

        $this->expectException(\Illuminate\Database\QueryException::class);
        
        Mahasiswa::factory()->create(['nim' => '2021001']);
    }
}
```

## Feature Testing

### Authentication Tests
```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => bcrypt('password')
        ]);

        $response = $this->post('/login', [
            'username' => 'testuser',
            'password' => 'password'
        ]);

        $response->assertRedirect();
        $this->assertAuthenticated();
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => bcrypt('password')
        ]);

        $response = $this->post('/login', [
            'username' => 'testuser',
            'password' => 'wrongpassword'
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}
```

### Admin Dashboard Tests
```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\MataKuliah;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_dashboard()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
    }

    public function test_dashboard_shows_correct_statistics()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        // Create test data
        Mahasiswa::factory()->count(5)->create();
        Dosen::factory()->count(3)->create();
        MataKuliah::factory()->count(8)->create();

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertViewHas('totalMahasiswa', 5);
        $response->assertViewHas('totalDosen', 3);
        $response->assertViewHas('totalMataKuliah', 8);
    }

    public function test_non_admin_cannot_access_admin_dashboard()
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);
        
        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(403);
    }
}
```

### CRUD Tests
```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MahasiswaCRUDTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_mahasiswa()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $mahasiswaData = [
            'nim' => '2021001',
            'nama_lengkap' => 'Test Mahasiswa',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2000-01-01',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Test No. 123',
            'no_hp' => '081234567890',
            'program_studi' => 'Teknik Informatika',
            'angkatan' => 2021,
            'status' => 'aktif',
            'email' => 'test@example.com',
            'username' => 'testmahasiswa',
            'password' => 'password'
        ];

        $response = $this->actingAs($admin)->post('/admin/mahasiswa', $mahasiswaData);

        $response->assertRedirect();
        $this->assertDatabaseHas('mahasiswas', [
            'nim' => '2021001',
            'nama_lengkap' => 'Test Mahasiswa'
        ]);
    }

    public function test_admin_can_update_mahasiswa()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $mahasiswa = Mahasiswa::factory()->create();

        $updateData = [
            'nama_lengkap' => 'Updated Name',
            'alamat' => 'Updated Address'
        ];

        $response = $this->actingAs($admin)->put("/admin/mahasiswa/{$mahasiswa->id}", $updateData);

        $response->assertRedirect();
        $this->assertDatabaseHas('mahasiswas', [
            'id' => $mahasiswa->id,
            'nama_lengkap' => 'Updated Name',
            'alamat' => 'Updated Address'
        ]);
    }

    public function test_admin_can_delete_mahasiswa()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $mahasiswa = Mahasiswa::factory()->create();

        $response = $this->actingAs($admin)->delete("/admin/mahasiswa/{$mahasiswa->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('mahasiswas', ['id' => $mahasiswa->id]);
    }
}
```

## Browser Testing

### Setup Laravel Dusk
```bash
composer require --dev laravel/dusk
php artisan dusk:install
```

### Example Browser Tests
```php
<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use App\Models\User;
use Laravel\Dusk\Browser;

class LoginTest extends DuskTestCase
{
    public function test_user_can_login_via_browser()
    {
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => bcrypt('password')
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                    ->type('username', 'testuser')
                    ->type('password', 'password')
                    ->press('Login')
                    ->assertPathIs('/admin/dashboard');
        });
    }

    public function test_admin_can_create_mahasiswa_via_browser()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                    ->visit('/admin/mahasiswa/create')
                    ->type('nim', '2021001')
                    ->type('nama_lengkap', 'Test Mahasiswa')
                    ->type('tempat_lahir', 'Jakarta')
                    ->type('tanggal_lahir', '2000-01-01')
                    ->select('jenis_kelamin', 'L')
                    ->type('alamat', 'Jl. Test No. 123')
                    ->type('no_hp', '081234567890')
                    ->type('program_studi', 'Teknik Informatika')
                    ->type('angkatan', '2021')
                    ->select('status', 'aktif')
                    ->type('email', 'test@example.com')
                    ->type('username', 'testmahasiswa')
                    ->type('password', 'password')
                    ->press('Simpan')
                    ->assertSee('Mahasiswa berhasil ditambahkan');
        });
    }
}
```

## API Testing

### API Test Examples
```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_can_get_mahasiswa_list()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Mahasiswa::factory()->count(3)->create();

        $response = $this->actingAs($admin)->getJson('/api/mahasiswa');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        'current_page',
                        'data' => [
                            '*' => [
                                'id',
                                'nim',
                                'nama_lengkap',
                                'program_studi'
                            ]
                        ]
                    ]
                ]);
    }

    public function test_api_can_create_mahasiswa()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $mahasiswaData = [
            'nim' => '2021001',
            'nama_lengkap' => 'Test Mahasiswa',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2000-01-01',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Test No. 123',
            'no_hp' => '081234567890',
            'program_studi' => 'Teknik Informatika',
            'angkatan' => 2021,
            'status' => 'aktif',
            'email' => 'test@example.com',
            'username' => 'testmahasiswa',
            'password' => 'password'
        ];

        $response = $this->actingAs($admin)->postJson('/api/mahasiswa', $mahasiswaData);

        $response->assertStatus(201)
                ->assertJson([
                    'success' => true,
                    'message' => 'Mahasiswa berhasil ditambahkan'
                ]);
    }
}
```

## Performance Testing

### Load Testing with Artillery
```bash
# Install Artillery
npm install -g artillery

# Create test scenario
```

```yaml
# load-test.yml
config:
  target: 'http://localhost:8000'
  phases:
    - duration: 60
      arrivalRate: 10
  defaults:
    headers:
      Content-Type: 'application/json'

scenarios:
  - name: "Login and Dashboard Access"
    weight: 70
    flow:
      - post:
          url: "/login"
          json:
            username: "admin"
            password: "password"
      - get:
          url: "/admin/dashboard"
  
  - name: "API Endpoints"
    weight: 30
    flow:
      - get:
          url: "/api/mahasiswa"
```

```bash
# Run load test
artillery run load-test.yml
```

### Database Performance Tests
```php
<?php

namespace Tests\Performance;

use Tests\TestCase;
use App\Models\Mahasiswa;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DatabasePerformanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_mahasiswa_query_performance()
    {
        // Create 1000 mahasiswa records
        Mahasiswa::factory()->count(1000)->create();

        $startTime = microtime(true);
        
        $mahasiswas = Mahasiswa::with('user')->get();
        
        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        $this->assertLessThan(1.0, $executionTime, 'Query took too long');
        $this->assertCount(1000, $mahasiswas);
    }
}
```

## Security Testing

### Authentication Security Tests
```php
<?php

namespace Tests\Security;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_is_hashed()
    {
        $user = User::factory()->create([
            'password' => 'plaintextpassword'
        ]);

        $this->assertNotEquals('plaintextpassword', $user->password);
        $this->assertTrue(Hash::check('plaintextpassword', $user->password));
    }

    public function test_sql_injection_prevention()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $maliciousInput = "'; DROP TABLE users; --";

        $response = $this->actingAs($admin)->get("/admin/mahasiswa?search={$maliciousInput}");

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_csrf_protection()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/admin/mahasiswa', [
            'nim' => '2021001',
            'nama_lengkap' => 'Test'
        ]);

        $response->assertStatus(419); // CSRF token mismatch
    }
}
```

## Test Data

### Factories
```php
<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MahasiswaFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory()->create(['role' => 'mahasiswa'])->id,
            'nim' => $this->faker->unique()->numerify('2021###'),
            'nama_lengkap' => $this->faker->name(),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date(),
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'alamat' => $this->faker->address(),
            'no_hp' => $this->faker->phoneNumber(),
            'program_studi' => $this->faker->randomElement(['Teknik Informatika', 'Sistem Informasi']),
            'angkatan' => $this->faker->numberBetween(2018, 2023),
            'status' => $this->faker->randomElement(['aktif', 'nonaktif', 'lulus']),
        ];
    }
}
```

### Seeders for Testing
```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\MataKuliah;

class TestingSeeder extends Seeder
{
    public function run()
    {
        // Create test users
        User::factory()->count(10)->create(['role' => 'admin']);
        User::factory()->count(20)->create(['role' => 'dosen']);
        User::factory()->count(100)->create(['role' => 'mahasiswa']);

        // Create test data
        Mahasiswa::factory()->count(100)->create();
        Dosen::factory()->count(20)->create();
        MataKuliah::factory()->count(50)->create();
    }
}
```

## Running Tests

### Commands
```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Unit
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage --min=80

# Run browser tests
php artisan dusk

# Run performance tests
php artisan test --filter=Performance

# Run security tests
php artisan test --filter=Security
```

### CI/CD Integration
```yaml
# .github/workflows/tests.yml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v2
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'
        
    - name: Install dependencies
      run: composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist
      
    - name: Copy environment file
      run: cp .env.example .env
      
    - name: Generate key
      run: php artisan key:generate
      
    - name: Create database
      run: |
        mkdir -p database
        touch database/database.sqlite
      
    - name: Run migrations
      run: php artisan migrate
      
    - name: Run tests
      run: php artisan test
```

## Test Reports

### Coverage Report
```bash
# Generate coverage report
php artisan test --coverage --coverage-html=coverage

# View coverage report
open coverage/index.html
```

### Test Results
```bash
# Generate JUnit XML report
php artisan test --log-junit=junit.xml

# Generate HTML report
php artisan test --coverage-html=coverage
```

## Best Practices

1. **Test Isolation**: Each test should be independent
2. **Database Transactions**: Use RefreshDatabase trait
3. **Meaningful Names**: Use descriptive test method names
4. **Arrange-Act-Assert**: Follow AAA pattern
5. **Mock External Services**: Don't test external APIs
6. **Test Edge Cases**: Include boundary conditions
7. **Keep Tests Fast**: Avoid slow operations
8. **Maintain Test Data**: Use factories and seeders 