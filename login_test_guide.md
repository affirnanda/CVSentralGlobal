# Step-by-Step Guide: Admin Login Testing with PHPUnit

As your mentor, I have created this guide to walk you through how to implement and run tests for your admin login section.

In Laravel, authentication logic involves HTTP requests, validation rules, session states, and database verification. Because of these layers, we test this using **Feature Tests** rather than isolated unit tests. This ensures the routing, controller, validation rules, and database integration all work harmoniously.

---

## 1. Database Setup for Testing

Before running tests, we want to make sure they run in an isolated environment so they don't affect or empty your development database. 

This is configured in the `phpunit.xml` file located in your project root. The configuration is already set to use an **in-memory SQLite database**:

```xml
<php>
    <env name="DB_CONNECTION" value="sqlite"/>
    <env name="DB_DATABASE" value=":memory:"/>
</php>
```

> [!NOTE]
> An in-memory SQLite database is extremely fast and is wiped clean automatically after each test run.

---

## 2. Test File Location and Setup

The test file is located at `tests/Feature/LoginTest.php`.

To ensure every test starts with a clean slate, we use the `Illuminate\Foundation\Testing\RefreshDatabase` trait. This trait runs your database migrations before the test suite starts and rolls them back after the tests are complete.

Here is the structured template we will use:

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    
    // Test cases will go here...
}
```

---

## 3. Implementing the 6 Test Cases

Here is the implementation of the six scenarios you requested.

### Case 1: Correct Email and Password
This case creates a user, sends a POST request with the correct credentials, and asserts that the user is successfully authenticated and redirected to the dashboard.

```php
public function test_login_dengan_email_dan_password_yang_benar()
{
    // Arrange: Create a user in the database
    $user = User::factory()->create([
        'email' => 'admin@example.com',
        'password' => bcrypt('password123'),
    ]);

    // Act: Submit credentials
    $response = $this->post('/login', [
        'email' => 'admin@example.com',
        'password' => 'password123',
    ]);

    // Assert: User is logged in and redirected
    $this->assertAuthenticatedAs($user);
    $response->assertRedirect(route('dashboard'));
}
```

### Case 2: Email Not Registered
Attempts to login with an email address that does not exist in the database.

```php
public function test_login_dengan_email_belum_terdaftar()
{
    $response = $this->post('/login', [
        'email' => 'notregistered@example.com',
        'password' => 'password123',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors(['email']);
}
```

### Case 3: Email Format Invalid
Verifies that validation blocks email inputs that do not match a proper email pattern (e.g., missing `@` or domain).

```php
public function test_login_dengan_format_email_tidak_valid()
{
    $response = $this->post('/login', [
        'email' => 'invalid-email-format',
        'password' => 'password123',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors(['email']);
}
```

### Case 4: Email Not Input In (Empty)
Verifies that the `email` field is required.

```php
public function test_login_tanpa_mengisi_email()
{
    $response = $this->post('/login', [
        'email' => '',
        'password' => 'password123',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors(['email']);
}
```

### Case 5: Wrong Password
Creates a user, but sends the wrong password. It verifies the login fails and triggers validation errors under the `email` field.

```php
public function test_login_dengan_password_salah()
{
    $user = User::factory()->create([
        'email' => 'admin@example.com',
        'password' => bcrypt('password123'),
    ]);

    $response = $this->post('/login', [
        'email' => 'admin@example.com',
        'password' => 'wrongpassword',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors(['email']);
}
```

### Case 6: Password Not Input In (Empty)
Verifies that the `password` field is required.

```php
public function test_login_tanpa_mengisi_password()
{
    $response = $this->post('/login', [
        'email' => 'admin@example.com',
        'password' => '',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors(['password']);
}
```

---

## 4. How to Run the Tests

To run these tests from your terminal, execute the following command in the project root folder:

```bash
php artisan test --filter LoginTest
```

### Expected Output
When running successfully, you will see output similar to this:

```plain
   PASS  Tests\Feature\LoginTest
  ✓ login dengan email dan password yang benar                                                                   0.42s  
  ✓ login dengan email belum terdaftar                                                                           0.23s  
  ✓ login dengan format email tidak valid                                                                        0.09s  
  ✓ login tanpa mengisi email                                                                                    0.02s  
  ✓ login dengan password salah                                                                                  0.23s  
  ✓ login tanpa mengisi password                                                                                 0.02s  

  Tests:    6 passed (20 assertions)
  Duration: 1.16s
```

---

> [!TIP]
> **Key Takeaway**: By writing tests this way, you make sure that future changes to the login validation rules or controllers won't break the registration or login processes without notifying you.
