<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckoutSewaTest extends TestCase
{
    use RefreshDatabase;

    private function seedCart()
    {
        $product = Product::factory()->create([
            'stock' => 10,
            'price' => 100000,
            'rental_price' => 50000,
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
            'type' => 'rent',
            'full_name' => 'Galang',
            'email' => 'galang@gmail.com',
            'phone' => '08123456789',
            'province' => 'Jawa Timur',
            'city' => 'Sidoarjo',
            'district' => 'Buduran',
            'address' => 'Jl. Mawar No. 1',
            'postal_code' => '61252',
            'payment_method_id' => $payment->id,
            'rent_start' => now()->addDay()->format('Y-m-d'),
            'rent_end' => now()->addDays(3)->format('Y-m-d'),
        ];
    }

    /** TC-BF-8V */
    public function test_pemesanan_sewa_berhasil()
    {
        $this->seedCart();

        $response = $this->post(
            route('checkout.process'),
            $this->validData()
        );

        $response->assertRedirect();

        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseCount('order_items', 1);
    }

    /** TC-BF-8W */
    public function test_nama_100_karakter_diterima()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['full_name'] = str_repeat('A', 100);

        $response = $this->post(route('checkout.process'), $data);

        $response->assertRedirect();
    }

    /** TC-BF-8X */
    public function test_nama_lebih_dari_100_karakter_ditolak()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['full_name'] = str_repeat('A', 101);

        $response = $this->from('/')
            ->post(route('checkout.process'), $data);

        $response->assertSessionHasErrors('full_name');
    }

    /** TC-BF-8Y */
    public function test_nama_kosong()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['full_name'] = '';

        $response = $this->from('/')
            ->post(route('checkout.process'), $data);

        $response->assertSessionHasErrors('full_name');
    }

    /** TC-BF-8Z */
    public function test_nomor_wa_9_digit_diterima()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['phone'] = '123456789';

        $response = $this->post(route('checkout.process'), $data);

        $response->assertRedirect();
    }

    /** TC-BF-8AA */
    public function test_nomor_wa_13_digit_diterima()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['phone'] = '1234567890123';

        $response = $this->post(route('checkout.process'), $data);

        $response->assertRedirect();
    }

    /** TC-BF-8AB */
    public function test_nomor_wa_8_digit_ditolak()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['phone'] = '12345678';

        $response = $this->from('/')
            ->post(route('checkout.process'), $data);

        $response->assertSessionHasErrors('phone');
    }

    /** TC-BF-8AC */
    public function test_nomor_wa_14_digit_ditolak()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['phone'] = '12345678901234';

        $response = $this->from('/')
            ->post(route('checkout.process'), $data);

        $response->assertSessionHasErrors('phone');
    }

    /** TC-BF-8AD */
    public function test_nomor_wa_kosong()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['phone'] = '';

        $response = $this->from('/')
            ->post(route('checkout.process'), $data);

        $response->assertSessionHasErrors('phone');
    }

    /** TC-BF-8AE */
    public function test_alamat_200_karakter_diterima()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['address'] = str_repeat('A', 200);

        $response = $this->post(route('checkout.process'), $data);

        $response->assertRedirect();
    }

    /** TC-BF-8AF */
    public function test_alamat_201_karakter_ditolak()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['address'] = str_repeat('A', 201);

        $response = $this->from('/')
            ->post(route('checkout.process'), $data);

        $response->assertSessionHasErrors('address');
    }

    /** TC-BF-8AG */
    public function test_alamat_kosong()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['address'] = '';

        $response = $this->from('/')
            ->post(route('checkout.process'), $data);

        $response->assertSessionHasErrors('address');
    }

    /** TC-BF-8AH */
    public function test_keranjang_kosong()
    {
        $response = $this->from('/')
            ->post(route('checkout.process'), $this->validData());

        $response->assertSessionHas('error');
    }

    /** TC-BF-8AI */
    public function test_email_salah()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['email'] = 'galang';

        $response = $this->from('/')
            ->post(route('checkout.process'), $data);

        $response->assertSessionHasErrors('email');
    }

    /** TC-BF-8AJ */
    public function test_email_kosong()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['email'] = '';

        $response = $this->from('/')
            ->post(route('checkout.process'), $data);

        $response->assertSessionHasErrors('email');
    }

    /** TC-BF-8AK */
    public function test_provinsi_kosong()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['province'] = '';

        $response = $this->from('/')
            ->post(route('checkout.process'), $data);

        $response->assertSessionHasErrors('province');
    }

    /** TC-BF-8AL */
    public function test_kota_kosong()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['city'] = '';

        $response = $this->from('/')
            ->post(route('checkout.process'), $data);

        $response->assertSessionHasErrors('city');
    }

    /** TC-BF-8AM */
    public function test_kecamatan_kosong()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['district'] = '';

        $response = $this->from('/')
            ->post(route('checkout.process'), $data);

        $response->assertSessionHasErrors('district');
    }

    /** TC-BF-8AN */
    public function test_kode_pos_kosong()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['postal_code'] = '';

        $response = $this->from('/')
            ->post(route('checkout.process'), $data);

        $response->assertSessionHasErrors('postal_code');
    }

    /** TC-BF-8AO */
    public function test_kode_pos_string()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['postal_code'] = 'ABCDE';

        $response = $this->post(route('checkout.process'), $data);

        $response->assertRedirect();
    }

    /** TC-BF-8AP */
    public function test_metode_pembayaran_kosong()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['payment_method_id'] = '';

        $response = $this->from('/')
            ->post(route('checkout.process'), $data);

        $response->assertSessionHasErrors('payment_method_id');
    }

    /** TC-BF-8AQ */
    public function test_tanggal_mulai_kosong()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['rent_start'] = '';

        $response = $this->from('/')
            ->post(route('checkout.process'), $data);

        $response->assertSessionHasErrors('rent_start');
    }

    /** TC-BF-8AR */
    public function test_tanggal_akhir_kosong()
    {
        $this->seedCart();

        $data = $this->validData();
        $data['rent_end'] = '';

        $response = $this->from('/')
            ->post(route('checkout.process'), $data);

        $response->assertSessionHasErrors('rent_end');
    }

    /** TC-BF-8AS */
    public function test_tanggal_akhir_sama_dengan_mulai()
    {
        $this->seedCart();

        $data = $this->validData();

        $tanggal = now()->addDay()->format('Y-m-d');

        $data['rent_start'] = $tanggal;
        $data['rent_end'] = $tanggal;

        $response = $this->from('/')
            ->post(route('checkout.process'), $data);

        $response->assertSessionHasErrors('rent_end');
    }

    /** TC-BF-8AT */
    public function test_tanggal_akhir_sebelum_tanggal_mulai()
    {
        $this->seedCart();

        $data = $this->validData();

        $data['rent_start'] = now()->addDays(5)->format('Y-m-d');
        $data['rent_end'] = now()->addDays(3)->format('Y-m-d');

        $response = $this->from('/')
            ->post(route('checkout.process'), $data);

        $response->assertSessionHasErrors('rent_end');
    }
}