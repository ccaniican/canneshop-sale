<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 0. Seed Users (Admin & Customer)
        User::create([
            'name' => 'Admin Canne Apparel',
            'email' => 'admin@canne.shop',
            'phone' => '081299998888',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'user@canne.shop',
            'phone' => '081234567890',
            'role' => 'user',
            'password' => Hash::make('password'),
        ]);

        // 1. Categories
        $categoriesData = [
            [
                'name' => 'Oversized Hoodies',
                'slug' => 'oversized-hoodies',
                'icon' => 'sparkles',
                'description' => 'Hoodie oversized premium berbahan fleece lembut cocok untuk streetwear modern.',
            ],
            [
                'name' => 'Streetwear T-Shirts',
                'slug' => 'streetwear-tshirts',
                'icon' => 'shirt',
                'description' => 'Kaos washed vintage 24s combed tebal dengan sablon grafis eksklusif.',
            ],
            [
                'name' => 'Jackets & Outerwear',
                'slug' => 'jackets-outerwear',
                'icon' => 'layers',
                'description' => 'Jaket denim, bomber, dan windbreaker edisi terbatas.',
            ],
            [
                'name' => 'Pants & Cargo',
                'slug' => 'pants-cargo',
                'icon' => 'scissors',
                'description' => 'Celana cargo tactical dan chino santai fit modern.',
            ],
            [
                'name' => 'Accessories',
                'slug' => 'accessories',
                'icon' => 'shopping-bag',
                'description' => 'Tote bag canvas, beanie, dan gelang streetwear.',
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[$cat['slug']] = Category::create($cat);
        }

        // 2. Products (Using 100% Local Images from public/images/products/)
        $productsData = [
            [
                'category_id' => $categories['oversized-hoodies']->id,
                'name' => 'Canne Heavyweight Heavy Metal Hoodie',
                'slug' => 'canne-heavyweight-heavy-metal-hoodie',
                'description' => 'Hoodie oversized terbuat dari 100% Cotton Fleece 330gsm. Memiliki potongan drop-shoulder khas streetwear premium dengan embroidery logo CanneShop di dada dan grafik aesthetic di bagian belakang.',
                'price' => 389000,
                'discount_price' => 329000,
                'stock' => 18,
                'sizes' => ['S', 'M', 'L', 'XL'],
                'color' => 'Jet Black',
                'image' => '/images/products/oversized_hoodie.jpg',
                'badge' => 'BESTSELLER',
                'rating' => 4.9,
                'review_count' => 124,
                'is_featured' => true,
            ],
            [
                'category_id' => $categories['streetwear-tshirts']->id,
                'name' => 'Canne Acid Washed Vintage Tee',
                'slug' => 'canne-acid-washed-vintage-tee',
                'description' => 'Kaos oversized gaya vintage acid wash. Terbuat dari Cotton Combed 24s yang melalui proses treatment pencucian khusus untuk memberikan efek washed retro unik.',
                'price' => 219000,
                'discount_price' => 179000,
                'stock' => 25,
                'sizes' => ['S', 'M', 'L', 'XL'],
                'color' => 'Washed Dark Grey',
                'image' => '/images/products/streetwear_tshirt.jpg',
                'badge' => 'HOT DEAL',
                'rating' => 4.8,
                'review_count' => 89,
                'is_featured' => true,
            ],
            [
                'category_id' => $categories['jackets-outerwear']->id,
                'name' => 'Canne Distressed Raw Denim Jacket',
                'slug' => 'canne-distressed-raw-denim-jacket',
                'description' => 'Jaket denim 14oz premium dengan aksen distressed & ripped finishing secara presisi. Dilengkapi saku fungsional interior dan kancing besi custom.',
                'price' => 489000,
                'discount_price' => 429000,
                'stock' => 12,
                'sizes' => ['M', 'L', 'XL'],
                'color' => 'Obsidian Blue',
                'image' => '/images/products/denim_jacket.jpg',
                'badge' => 'LIMITED',
                'rating' => 5.0,
                'review_count' => 46,
                'is_featured' => true,
            ],
            [
                'category_id' => $categories['pants-cargo']->id,
                'name' => 'Canne Tactical Techwear Cargo Pants',
                'slug' => 'canne-tactical-techwear-cargo-pants',
                'description' => 'Celana cargo 6 saku berbahan twill stretch tebal tahan gesekan. Dilengkapi tali strap pengatur angkle & buckle adjuster pada pinggang.',
                'price' => 349000,
                'discount_price' => 299000,
                'stock' => 15,
                'sizes' => ['M', 'L', 'XL'],
                'color' => 'Matte Black',
                'image' => '/images/products/celana.jpg',
                'badge' => 'NEW',
                'rating' => 4.7,
                'review_count' => 38,
                'is_featured' => true,
            ],
            [
                'category_id' => $categories['streetwear-tshirts']->id,
                'name' => 'Canne Stussy Edition Graphic Tee',
                'slug' => 'canne-stussy-edition-graphic-tee',
                'description' => 'Kaos edisi khusus dengan grafik logo stussy streetwear khas di bagian depan dan belakang. Katun combed 24s adem.',
                'price' => 229000,
                'discount_price' => 189000,
                'stock' => 20,
                'sizes' => ['S', 'M', 'L', 'XL'],
                'color' => 'White / Black',
                'image' => '/images/products/stussy.jpg',
                'badge' => 'POPULAR',
                'rating' => 4.9,
                'review_count' => 78,
                'is_featured' => false,
            ],
            [
                'category_id' => $categories['jackets-outerwear']->id,
                'name' => 'Canne Carhartt Workwear Utility Jacket',
                'slug' => 'canne-carhartt-workwear-utility-jacket',
                'description' => 'Jaket workwear bahan duck canvas tebal dengan kantong dada utility multifungsi. Tahan angin dan sangat tahan lama.',
                'price' => 529000,
                'discount_price' => 469000,
                'stock' => 10,
                'sizes' => ['M', 'L', 'XL'],
                'color' => 'Brown Canvas',
                'image' => '/images/products/carhartt.jpg',
                'badge' => 'EXCLUSIVE',
                'rating' => 4.9,
                'review_count' => 64,
                'is_featured' => false,
            ],
            [
                'category_id' => $categories['accessories']->id,
                'name' => 'Canne Signature Heavy Canvas Tote Bag',
                'slug' => 'canne-signature-heavy-canvas-tote-bag',
                'description' => 'Tote bag berbahan canvas 16oz tebal dengan resleting penutup utama dan kompartemen laptop 14 inch di bagian dalam.',
                'price' => 149000,
                'discount_price' => 119000,
                'stock' => 30,
                'sizes' => ['One Size'],
                'color' => 'Off White / Black',
                'image' => '/images/products/cart.jpg',
                'badge' => 'TRENDING',
                'rating' => 4.9,
                'review_count' => 67,
                'is_featured' => false,
            ],
            [
                'category_id' => $categories['oversized-hoodies']->id,
                'name' => 'Canne Minimalist Casual Streetwear Apparel Set',
                'slug' => 'canne-minimalist-casual-streetwear-apparel-set',
                'description' => 'Set pakaian streetwear kasual dengan warna washed estetik. Cocok dipakai santai sehari-hari maupun OOTD.',
                'price' => 399000,
                'discount_price' => 349000,
                'stock' => 14,
                'sizes' => ['S', 'M', 'L', 'XL'],
                'color' => 'Charcoal Grey',
                'image' => '/images/products/home.jpg',
                'badge' => 'SALE',
                'rating' => 4.8,
                'review_count' => 52,
                'is_featured' => false,
            ],
        ];

        foreach ($productsData as $prod) {
            Product::create($prod);
        }

        // 3. Coupons
        Coupon::create([
            'code' => 'CANNE10',
            'discount_type' => 'percent',
            'discount_value' => 10,
            'min_spend' => 100000,
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'CANNE50K',
            'discount_type' => 'fixed',
            'discount_value' => 50000,
            'min_spend' => 300000,
            'is_active' => true,
        ]);

        // 4. Sample Order
        $sampleOrder = Order::create([
            'order_number' => 'CNS-' . strtoupper(Str::random(8)),
            'customer_name' => 'Budi Santoso',
            'customer_email' => 'user@canne.shop',
            'customer_phone' => '081234567890',
            'shipping_address' => 'Jl. Sudirman No. 45, RT 02 / RW 05',
            'city' => 'Jakarta Selatan',
            'postal_code' => '12190',
            'courier' => 'JNE Express (Next Day)',
            'payment_method' => 'QRIS Instan',
            'payment_status' => 'Paid',
            'order_status' => 'Diproses',
            'subtotal' => 508000,
            'discount_amount' => 50800,
            'shipping_cost' => 15000,
            'grand_total' => 472200,
            'notes' => 'Tolong titipkan di pos sekuriti jika rumah kosong.',
        ]);

        OrderItem::create([
            'order_id' => $sampleOrder->id,
            'product_id' => 1,
            'product_name' => 'Canne Heavyweight Heavy Metal Hoodie',
            'price' => 329000,
            'quantity' => 1,
            'size' => 'L',
            'color' => 'Jet Black',
            'subtotal' => 329000,
        ]);

        OrderItem::create([
            'order_id' => $sampleOrder->id,
            'product_id' => 2,
            'product_name' => 'Canne Acid Washed Vintage Tee',
            'price' => 179000,
            'quantity' => 1,
            'size' => 'M',
            'color' => 'Washed Dark Grey',
            'subtotal' => 179000,
        ]);
    }
}
