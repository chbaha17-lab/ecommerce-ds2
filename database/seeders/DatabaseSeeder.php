<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Message;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $alice = User::factory()->create([
            'name' => 'Alice',
            'email' => 'alice@example.com',
        ]);

        $customer = User::factory()->create([
            'name' => 'Client Test',
            'email' => 'test@example.com',
        ]);

        $catBoissons = Category::create(['name' => 'Boissons']);
        $catPatisseries = Category::create(['name' => 'Pâtisseries']);
        $catSnacks = Category::create(['name' => 'Snacks']);

        $p1 = Product::create([
            'name' => 'Cappuccino',
            'description' => 'Café mousseux artisanal.',
            'price' => 6.50,
            'stock' => 40,
            'category_id' => $catBoissons->id,
            'image' => 'https://www.thespruceeats.com/thmb/oUxhx54zsjVWfPlrgedJU0MZ-y0=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/how-to-make-cappuccinos-766116-hero-01-a754d567739b4ee0b209305138ecb996.jpg',
        ]);

        $p2 = Product::create([
            'name' => 'Cheesecake',
            'description' => 'Portion individuelle.',
            'price' => 12.00,
            'stock' => 15,
            'category_id' => $catPatisseries->id,
            'image' => 'https://www.yumelise.fr/wp-content/uploads/2024/03/cheesecake-kinder-nutella.jpg',
        ]);

        $p3 = Product::create([
            'name' => 'Cookie chocolat',
            'description' => 'Grand cookie croustillant.',
            'price' => 4.00,
            'stock' => 60,
            'category_id' => $catSnacks->id,
            'image' => 'https://www.cuisinelolo.fr/wp-content/uploads/2020/04/Cookies-tout-chocolat-3.jpg',
        ]);

        $p4 = Product::create([
            'name' => 'Thé vert menthe',
            'description' => 'Infusion fraîche.',
            'price' => 5.00,
            'stock' => 30,
            'category_id' => $catBoissons->id,
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRaAWJGV4siFs7JZ7UA3TUqyzmDDYJ5qQzWOw&s',
        ]);

        $order = Order::create([
            'user_id' => $customer->id,
            'total_price' => $p1->price * 2 + $p3->price,
            'status' => Order::STATUS_PENDING,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $p1->id,
            'quantity' => 2,
            'price' => $p1->price,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $p3->id,
            'quantity' => 1,
            'price' => $p3->price,
        ]);

        Review::create([
            'user_id' => $customer->id,
            'product_id' => $p1->id,
            'rating' => 5,
            'comment' => 'Excellent café.',
        ]);

        Review::create([
            'user_id' => $alice->id,
            'product_id' => $p2->id,
            'rating' => 4,
            'comment' => 'Délicieux dessert.',
        ]);

        Message::create([
            'sender_id' => $customer->id,
            'receiver_id' => $alice->id,
            'body' => 'Bonjour, livrez-vous demain ?',
        ]);

        Message::create([
            'sender_id' => $alice->id,
            'receiver_id' => $customer->id,
            'body' => 'Oui, entre 10h et 14h.',
            'read_at' => now(),
        ]);
    }
}
