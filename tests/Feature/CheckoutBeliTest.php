<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckoutBeliTest extends TestCase
{
    use RefreshDatabase;

    private function seedCart()
    {
        $product = Product::factory()->create([
            'stock' => 10,
            'price' => 100000,
        ]);

        session([
            'keranjang' => [
                [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => 100000,
                    'rental_price' => 50000,
                    'qty' => 1,
                ]
            ]
        ]);

        return $product;
    }

    private function validData()
    {
        $payment = PaymentMethod::factory()->create();

        return [
            'type' => 'buy',
            'full_name' => 'Galang',
            'email' => 'galang@gmail.com',
            'phone' => '08123456789',
            'province' => 'Jawa Timur',
            'city' => 'Sidoarjo',
            'district' => 'Buduran',
            'address' => 'Jl. Mawar',
            'postal_code' => '61252',
            'payment_method_id' => $payment->id,
        ];
    }

    /** TC01 */
    public function test_pemesanan_berhasil()
    {
        $this->seedCart();

        $response = $this->post(
            route('checkout.process'),
            $this->validData()
        );

        $response->assertRedirect();
    }

    /** TC02 */
    public function test_nama_100_karakter_diterima()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['full_name'] = str_repeat('A',100);

        $response = $this->post(route('checkout.process'),$data);

        $response->assertRedirect();
    }

    /** TC03 */
    public function test_nama_lebih_dari_100_karakter_ditolak()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['full_name'] = str_repeat('A',101);

        $response = $this->from('/')
            ->post(route('checkout.process'),$data);

        $response->assertSessionHasErrors('full_name');
    }

    /** TC04 */
    public function test_nama_kosong()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['full_name'] = '';

        $response = $this->from('/')
            ->post(route('checkout.process'),$data);

        $response->assertSessionHasErrors('full_name');
    }

    /** TC05 */
    public function test_nomor_wa_9_digit_diterima()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['phone'] = '123456789';

        $response = $this->post(route('checkout.process'),$data);

        $response->assertRedirect();
    }

    /** TC06 */
    public function test_nomor_wa_13_digit_diterima()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['phone'] = '1234567890123';

        $response = $this->post(route('checkout.process'),$data);

        $response->assertRedirect();
    }

    /** TC07 */
    public function test_nomor_wa_8_digit_ditolak()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['phone'] = '12345678';

        $response = $this->from('/')
            ->post(route('checkout.process'),$data);

        $response->assertSessionHasErrors('phone');
    }

    /** TC08 */
    public function test_nomor_wa_14_digit_ditolak()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['phone'] = '12345678901234';

        $response = $this->from('/')
            ->post(route('checkout.process'),$data);

        $response->assertSessionHasErrors('phone');
    }

    /** TC09 */
    public function test_nomor_wa_kosong()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['phone'] = '';

        $response = $this->from('/')
            ->post(route('checkout.process'),$data);

        $response->assertSessionHasErrors('phone');
    }

    /** TC10 */
    public function test_alamat_200_karakter_diterima()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['address'] = str_repeat('A',200);

        $response = $this->post(route('checkout.process'),$data);

        $response->assertRedirect();
    }

    /** TC11 */
    public function test_alamat_lebih_dari_200_karakter_ditolak()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['address'] = str_repeat('A',201);

        $response = $this->from('/')
            ->post(route('checkout.process'),$data);

        $response->assertSessionHasErrors('address');
    }

    /** TC12 */
    public function test_alamat_kosong()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['address'] = '';

        $response = $this->from('/')
            ->post(route('checkout.process'),$data);

        $response->assertSessionHasErrors('address');
    }

    /** TC13 */
    public function test_keranjang_kosong()
    {
        $response = $this->from('/')
            ->post(route('checkout.process'),$this->validData());

        $response->assertSessionHas('error');
    }

    /** TC14 */
    public function test_email_salah()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['email'] = 'galang';

        $response = $this->from('/')
            ->post(route('checkout.process'),$data);

        $response->assertSessionHasErrors('email');
    }

    /** TC15 */
    public function test_email_kosong()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['email'] = '';

        $response = $this->post(route('checkout.process'), $data);

        $response->assertSessionHasErrors('email');
    }

    /** TC16 */
    public function test_provinsi_kosong()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['province'] = '';

        $response = $this->post(route('checkout.process'), $data);
        $response->assertSessionHasErrors('province');
    }

    /** TC17 */
    public function test_kota_kosong()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['city'] = '';

        $response = $this->from('/')
            ->post(route('checkout.process'),$data);

        $response->assertSessionHasErrors('city');
    }

    /** TC18 */
    public function test_kecamatan_kosong()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['district'] = '';

        $response = $this->from('/')
            ->post(route('checkout.process'),$data);

        $response->assertSessionHasErrors('district');
    }

    /** TC19 */
    public function test_kode_pos_kosong()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['postal_code'] = '';

        $response = $this->from('/')
            ->post(route('checkout.process'),$data);

        $response->assertSessionHasErrors('postal_code');
    }

    /** TC20 */
    public function test_kode_pos_string()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['postal_code'] = 'ABCDE';

        $response = $this->post(route('checkout.process'),$data);

        $response->assertRedirect();
    }

    /** TC21 */
    public function test_metode_pembayaran_kosong()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['payment_method_id'] = '';

        $response = $this->from('/')
            ->post(route('checkout.process'),$data);

        $response->assertSessionHasErrors('payment_method_id');
    }
}