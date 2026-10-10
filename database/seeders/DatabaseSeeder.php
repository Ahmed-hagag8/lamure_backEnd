<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the Lamure Egypt database.
     */
    public function run(): void
    {
        $admin = User::create([
            'email' => 'admin@lamure.eg',
            'name' => 'Mohamed El-Sayed',
            'password' => 'admin123',
            'role' => 'ADMIN',
            'phone' => '+20 100 123 4567',
            'address' => '15 El-Tahrir St, Downtown, Cairo, Egypt',
        ]);

        $supplier1 = User::create([
            'email' => 'supplier@lamure.eg',
            'name' => 'Fatma Hassan',
            'password' => 'supplier123',
            'role' => 'SUPPLIER',
            'phone' => '+20 111 987 6543',
            'address' => '42 Corniche El-Nil, Garden City, Cairo, Egypt',
        ]);

        $supplier2 = User::create([
            'email' => 'khaled@lamure.eg',
            'name' => 'Khaled Mostafa',
            'password' => 'supplier123',
            'role' => 'SUPPLIER',
            'phone' => '+20 122 555 8888',
            'address' => '7 Fouad St, Alexandria, Egypt',
        ]);

        $customer1 = User::create([
            'email' => 'customer@lamure.eg',
            'name' => 'Nour El-Din',
            'password' => 'customer123',
            'role' => 'CUSTOMER',
            'phone' => '+20 100 222 3333',
            'address' => '28 Road 9, Maadi, Cairo, Egypt',
        ]);

        $customer2 = User::create([
            'email' => 'yasmin@lamure.eg',
            'name' => 'Yasmin Ahmed',
            'password' => 'customer123',
            'role' => 'CUSTOMER',
            'phone' => '+20 109 444 5555',
            'address' => '51 San Stefano, Alexandria, Egypt',
        ]);

        $customer3 = User::create([
            'email' => 'omar@lamure.eg',
            'name' => 'Omar Hassan',
            'password' => 'customer123',
            'role' => 'CUSTOMER',
            'phone' => '+20 115 666 7777',
            'address' => '12 El-Haram St, Giza, Egypt',
        ]);

        $this->command->info('✅ 6 users created');

        $clothing = Category::create([
            'name' => 'Clothing',
            'slug' => 'clothing',
            'description' => 'Premium Egyptian and international fashion — from casual to formal wear.',
            'image' => 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=800&q=80',
        ]);

        $electronics = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'description' => 'Latest gadgets, smart devices, and tech accessories available across Egypt.',
            'image' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=800&q=80',
        ]);

        $shoes = Category::create([
            'name' => 'Shoes',
            'slug' => 'shoes',
            'description' => 'Footwear for every occasion — sneakers, formal shoes, and sandals for the Egyptian climate.',
            'image' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=800&q=80',
        ]);

        $this->command->info('✅ 3 categories created');

        $products = [
            [
                'name' => 'Premium Egyptian Cotton T-Shirt',
                'slug' => 'premium-egyptian-cotton-tshirt',
                'description' => 'Made from 100% finest long-staple Egyptian cotton, this t-shirt offers unmatched softness, durability and breathability. Perfect for Cairo\'s warm climate.',
                'price' => 450, 'discount' => 15, 'stock' => 120, 'rating' => 4.8, 'review_count' => 234,
                'images' => [
                    'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800&q=80',
                    'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=800&q=80',
                ],
                'size' => 'M', 'color' => 'White', 'brand' => 'Lamure Essentials',
                'category_id' => $clothing->id, 'supplier_id' => $supplier1->id,
            ],
            [
                'name' => 'Casual Linen Blazer',
                'slug' => 'casual-linen-blazer',
                'description' => 'Lightweight tailored linen blazer, ideal for Egyptian summers and smart-casual gatherings in Zamalek and New Cairo.',
                'price' => 1200, 'discount' => 10, 'stock' => 45, 'rating' => 4.6, 'review_count' => 87,
                'images' => [
                    'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&q=80',
                    'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=800&q=80',
                ],
                'size' => 'L', 'color' => 'Navy', 'brand' => 'Cairo Couture',
                'category_id' => $clothing->id, 'supplier_id' => $supplier1->id,
            ],
            [
                'name' => 'Floral Summer Dress',
                'slug' => 'floral-summer-dress',
                'description' => 'Beautiful flowing floral midi dress made from breezy chiffon. Perfect for Sahel beach outings and warm evening gatherings.',
                'price' => 850, 'discount' => 20, 'stock' => 60, 'rating' => 4.9, 'review_count' => 156,
                'images' => [
                    'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=800&q=80',
                    'https://images.unsplash.com/photo-1496747611176-843222e1e57c?w=800&q=80',
                ],
                'size' => 'S', 'color' => 'Floral', 'brand' => 'Nile Fashions',
                'category_id' => $clothing->id, 'supplier_id' => $supplier1->id,
            ],
            [
                'name' => 'Relaxed Fit Joggers',
                'slug' => 'relaxed-fit-joggers',
                'description' => 'Comfortable heavyweight fleece joggers with a modern tapered fit and deep zipper pockets. Perfect for daily Egyptian lifestyle.',
                'price' => 550, 'discount' => 0, 'stock' => 200, 'rating' => 4.5, 'review_count' => 312,
                'images' => [
                    'https://images.unsplash.com/photo-1552902865-b72c031ac5ea?w=800&q=80',
                    'https://images.unsplash.com/photo-1506629082955-511b1aa562c8?w=800&q=80',
                ],
                'size' => 'L', 'color' => 'Black', 'brand' => 'Lamure Essentials',
                'category_id' => $clothing->id, 'supplier_id' => $supplier1->id,
            ],
            [
                'name' => 'Classic Oxford Button-Down Shirt',
                'slug' => 'classic-oxford-button-down-shirt',
                'description' => 'Structured premium Egyptian cotton oxford shirt with reinforced collar and pearl buttons. Designed for workdays and evening dinners.',
                'price' => 750, 'discount' => 10, 'stock' => 90, 'rating' => 4.7, 'review_count' => 142,
                'images' => [
                    'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=800&q=80',
                    'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?w=800&q=80',
                ],
                'size' => 'M', 'color' => 'Light Blue', 'brand' => 'Cairo Couture',
                'category_id' => $clothing->id, 'supplier_id' => $supplier1->id,
            ],
            [
                'name' => 'Embroidered Linen Kimono Cardigan',
                'slug' => 'embroidered-linen-kimono-cardigan',
                'description' => 'Handcrafted open-front linen layer with subtle geometric embroidery inspired by Upper Egypt heritage.',
                'price' => 1450, 'discount' => 15, 'stock' => 35, 'rating' => 4.9, 'review_count' => 68,
                'images' => [
                    'https://images.unsplash.com/photo-1585487000160-6ebcfceb0d03?w=800&q=80',
                    'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=800&q=80',
                ],
                'size' => 'Free', 'color' => 'Beige', 'brand' => 'Nile Fashions',
                'category_id' => $clothing->id, 'supplier_id' => $supplier1->id,
            ],
            [
                'name' => 'Slim Fit Stretch Chino Pants',
                'slug' => 'slim-fit-stretch-chino-pants',
                'description' => 'Versatile cotton twill chinos infused with elastane for active comfort during Cairo commutes and office hours.',
                'price' => 680, 'discount' => 0, 'stock' => 110, 'rating' => 4.6, 'review_count' => 189,
                'images' => [
                    'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?w=800&q=80',
                    'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?w=800&q=80',
                ],
                'size' => '32', 'color' => 'Khaki', 'brand' => 'Lamure Essentials',
                'category_id' => $clothing->id, 'supplier_id' => $supplier1->id,
            ],
            [
                'name' => 'Minimalist Oversized Hoodie',
                'slug' => 'minimalist-oversized-hoodie',
                'description' => 'Ultra-cozy 420 GSM brushed Egyptian cotton fleece hoodie with dropped shoulders and double-layered warm hood.',
                'price' => 890, 'discount' => 20, 'stock' => 80, 'rating' => 4.8, 'review_count' => 215,
                'images' => [
                    'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=800&q=80',
                    'https://images.unsplash.com/photo-1509967419530-da38b4704bc6?w=800&q=80',
                ],
                'size' => 'XL', 'color' => 'Charcoal', 'brand' => 'Lamure Essentials',
                'category_id' => $clothing->id, 'supplier_id' => $supplier1->id,
            ],
            [
                'name' => 'Silk Satin Evening Slip Dress',
                'slug' => 'silk-satin-evening-slip-dress',
                'description' => 'Lustrous cowl-neck slip dress tailored from fluid satin. Glamorous and flattering for celebrations and special dinners.',
                'price' => 1650, 'discount' => 10, 'stock' => 25, 'rating' => 4.9, 'review_count' => 54,
                'images' => [
                    'https://images.unsplash.com/photo-1566174053879-31528523f8ae?w=800&q=80',
                    'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=800&q=80',
                ],
                'size' => 'M', 'color' => 'Emerald Green', 'brand' => 'Cairo Couture',
                'category_id' => $clothing->id, 'supplier_id' => $supplier1->id,
            ],
            [
                'name' => 'Mercerized Cotton Polo Shirt',
                'slug' => 'mercerized-cotton-polo-shirt',
                'description' => 'Refined pique polo crafted with mercerized Egyptian cotton yarns for a subtle luster and silky, breathable wear.',
                'price' => 520, 'discount' => 0, 'stock' => 140, 'rating' => 4.5, 'review_count' => 160,
                'images' => [
                    'https://images.unsplash.com/photo-1625910513413-722143547190?w=800&q=80',
                    'https://images.unsplash.com/photo-1586363104862-3a5e2ab60d99?w=800&q=80',
                ],
                'size' => 'L', 'color' => 'Navy Blue', 'brand' => 'Lamure Essentials',
                'category_id' => $clothing->id, 'supplier_id' => $supplier1->id,
            ],

            [
                'name' => 'Wireless Noise-Cancelling Headphones',
                'slug' => 'wireless-noise-cancelling-headphones',
                'description' => 'Premium over-ear headphones with active noise cancellation and 40-hour battery life. Shuts out noisy traffic and metro commutes.',
                'price' => 2500, 'discount' => 25, 'stock' => 35, 'rating' => 4.7, 'review_count' => 198,
                'images' => [
                    'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&q=80',
                    'https://images.unsplash.com/photo-1484704849700-f032a568e944?w=800&q=80',
                ],
                'color' => 'Matte Black', 'brand' => 'SoundPro',
                'category_id' => $electronics->id, 'supplier_id' => $supplier2->id,
            ],
            [
                'name' => 'Smart Watch Pro X',
                'slug' => 'smart-watch-pro-x',
                'description' => 'Feature-packed smartwatch with bright AMOLED display, continuous heart-rate tracking, GPS, and 5-day battery life.',
                'price' => 3200, 'discount' => 15, 'stock' => 50, 'rating' => 4.6, 'review_count' => 145,
                'images' => [
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800&q=80',
                    'https://images.unsplash.com/photo-1546868871-af0de0ae72be?w=800&q=80',
                ],
                'color' => 'Silver', 'brand' => 'TechGear',
                'category_id' => $electronics->id, 'supplier_id' => $supplier2->id,
            ],
            [
                'name' => 'Portable Bluetooth Speaker',
                'slug' => 'portable-bluetooth-speaker',
                'description' => 'Waterproof IP67 rugged portable speaker with rich 360° stereo sound and 12-hour playback. Perfect for Sahel beaches and pool gatherings.',
                'price' => 1800, 'discount' => 30, 'stock' => 75, 'rating' => 4.4, 'review_count' => 267,
                'images' => [
                    'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=800&q=80',
                    'https://images.unsplash.com/photo-1545454675-3531b543be5d?w=800&q=80',
                ],
                'color' => 'Midnight Blue', 'brand' => 'SoundPro',
                'category_id' => $electronics->id, 'supplier_id' => $supplier2->id,
            ],
            [
                'name' => 'USB-C Fast Charger 65W GaN',
                'slug' => 'usb-c-fast-charger-65w',
                'description' => 'Dual-port GaN fast wall charger with intelligent power allocation. Charges laptops, tablets, and phones safely on Egyptian 220V power.',
                'price' => 650, 'discount' => 0, 'stock' => 150, 'rating' => 4.8, 'review_count' => 423,
                'images' => [
                    'https://images.unsplash.com/photo-1583863788434-e58a36330cf0?w=800&q=80',
                    'https://images.unsplash.com/photo-1616401784845-180882ba9ba8?w=800&q=80',
                ],
                'color' => 'White', 'brand' => 'ChargeTech',
                'category_id' => $electronics->id, 'supplier_id' => $supplier2->id,
            ],
            [
                'name' => 'True Wireless ANC Earbuds',
                'slug' => 'true-wireless-anc-earbuds',
                'description' => 'Ergonomic in-ear wireless earbuds with active noise cancellation, wireless charging case, and 30 hours total battery life.',
                'price' => 1450, 'discount' => 20, 'stock' => 95, 'rating' => 4.7, 'review_count' => 310,
                'images' => [
                    'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=800&q=80',
                    'https://images.unsplash.com/photo-1606220588913-b3aacb4d2f46?w=800&q=80',
                ],
                'color' => 'Pearl White', 'brand' => 'SoundPro',
                'category_id' => $electronics->id, 'supplier_id' => $supplier2->id,
            ],
            [
                'name' => 'Mechanical RGB Gaming Keyboard',
                'slug' => 'mechanical-rgb-gaming-keyboard',
                'description' => 'Tactile hot-swappable mechanical keyboard featuring Arabic & English keycaps with dynamic per-key RGB backlighting.',
                'price' => 2100, 'discount' => 15, 'stock' => 40, 'rating' => 4.8, 'review_count' => 118,
                'images' => [
                    'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=800&q=80',
                    'https://images.unsplash.com/photo-1595225476474-87563907a212?w=800&q=80',
                ],
                'color' => 'Space Gray', 'brand' => 'TechGear',
                'category_id' => $electronics->id, 'supplier_id' => $supplier2->id,
            ],
            [
                'name' => 'Ergonomic Wireless Mouse',
                'slug' => 'ergonomic-wireless-mouse',
                'description' => 'Sculpted wireless mouse with silent clicks, precision 4000 DPI tracking sensor, and dual Bluetooth / 2.4G USB connectivity.',
                'price' => 720, 'discount' => 10, 'stock' => 85, 'rating' => 4.5, 'review_count' => 94,
                'images' => [
                    'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=800&q=80',
                    'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=800&q=80',
                ],
                'color' => 'Matte Black', 'brand' => 'TechGear',
                'category_id' => $electronics->id, 'supplier_id' => $supplier2->id,
            ],
            [
                'name' => '20000mAh Magnetic Power Bank',
                'slug' => '20000mah-magnetic-power-bank',
                'description' => 'Heavy-duty slim power bank with strong magnetic snap-on wireless charging and 22.5W Power Delivery fast cable charging.',
                'price' => 1100, 'discount' => 0, 'stock' => 130, 'rating' => 4.6, 'review_count' => 280,
                'images' => [
                    'https://images.unsplash.com/photo-1609592426815-5386f7b1e428?w=800&q=80',
                    'https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?w=800&q=80',
                ],
                'color' => 'Deep Blue', 'brand' => 'ChargeTech',
                'category_id' => $electronics->id, 'supplier_id' => $supplier2->id,
            ],
            [
                'name' => 'Smart LED Desk Lamp with Wireless Charger',
                'slug' => 'smart-led-desk-lamp-wireless-charger',
                'description' => 'Eye-friendly flicker-free architectural LED desk lamp with adjustable color temperatures and integrated 15W wireless charging base.',
                'price' => 950, 'discount' => 15, 'stock' => 65, 'rating' => 4.7, 'review_count' => 102,
                'images' => [
                    'https://images.unsplash.com/photo-1534353436294-0dbd4bdac845?w=800&q=80',
                    'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=800&q=80',
                ],
                'color' => 'Brushed Aluminum', 'brand' => 'TechGear',
                'category_id' => $electronics->id, 'supplier_id' => $supplier2->id,
            ],
            [
                'name' => '4K Ultra HD Action Camera',
                'slug' => '4k-ultra-hd-action-camera',
                'description' => 'Waterproof 4K 60FPS sports camera with gyroscope stabilization and dual screens, built for Red Sea diving and Sinai desert adventures.',
                'price' => 3800, 'discount' => 20, 'stock' => 28, 'rating' => 4.9, 'review_count' => 76,
                'images' => [
                    'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=800&q=80',
                    'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?w=800&q=80',
                ],
                'color' => 'Obsidian Black', 'brand' => 'TechGear',
                'category_id' => $electronics->id, 'supplier_id' => $supplier2->id,
            ],

            [
                'name' => 'Classic Leather Oxford Shoes',
                'slug' => 'classic-leather-oxford-shoes',
                'description' => 'Handcrafted genuine leather oxford dress shoes with Goodyear welt construction. Timeless elegance for downtown Cairo meetings.',
                'price' => 2200, 'discount' => 10, 'stock' => 30, 'rating' => 4.9, 'review_count' => 89,
                'images' => [
                    'https://images.unsplash.com/photo-1614252369475-531eba835eb1?w=800&q=80',
                    'https://images.unsplash.com/photo-1533867617858-e7b97e060509?w=800&q=80',
                ],
                'size' => '42', 'color' => 'Brown', 'brand' => 'Cairo Leather Co.',
                'category_id' => $shoes->id, 'supplier_id' => $supplier1->id,
            ],
            [
                'name' => 'Retro Running Sneakers',
                'slug' => 'retro-running-sneakers',
                'description' => 'Vintage-inspired athletic sneakers with responsive cushioning foam, built for all-day comfort along Alexandria Corniche.',
                'price' => 1500, 'discount' => 20, 'stock' => 85, 'rating' => 4.7, 'review_count' => 321,
                'images' => [
                    'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800&q=80',
                    'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=800&q=80',
                ],
                'size' => '43', 'color' => 'Red/White', 'brand' => 'StreetRunner',
                'category_id' => $shoes->id, 'supplier_id' => $supplier2->id,
            ],
            [
                'name' => 'Comfortable Leather Sandals',
                'slug' => 'comfortable-leather-sandals',
                'description' => 'Genuine calfskin strap sandals with contoured anatomic footbeds. Crafted for Egypt\'s warm climate and relaxed outings.',
                'price' => 750, 'discount' => 0, 'stock' => 110, 'rating' => 4.5, 'review_count' => 178,
                'images' => [
                    'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=800&q=80',
                    'https://images.unsplash.com/photo-1562273138-f46be4ebdf33?w=800&q=80',
                ],
                'size' => '41', 'color' => 'Tan', 'brand' => 'Nile Comfort',
                'category_id' => $shoes->id, 'supplier_id' => $supplier1->id,
            ],
            [
                'name' => 'High-Top Canvas Sneakers',
                'slug' => 'high-top-canvas-sneakers',
                'description' => 'Classic high-top canvas sneakers with vulcanized rubber soles and reinforced toe caps. A streetwear essential.',
                'price' => 900, 'discount' => 15, 'stock' => 95, 'rating' => 4.3, 'review_count' => 245,
                'images' => [
                    'https://images.unsplash.com/photo-1494496195158-c3becb4f2475?w=800&q=80',
                    'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?w=800&q=80',
                ],
                'size' => '44', 'color' => 'Black', 'brand' => 'StreetRunner',
                'category_id' => $shoes->id, 'supplier_id' => $supplier2->id,
            ],
            [
                'name' => 'Suede Chelsea Boots',
                'slug' => 'suede-chelsea-boots',
                'description' => 'Rich velvety suede boots with elastic side panels and durable crepe rubber soles for distinguished winter styling.',
                'price' => 2400, 'discount' => 10, 'stock' => 40, 'rating' => 4.8, 'review_count' => 112,
                'images' => [
                    'https://images.unsplash.com/photo-1638247025967-b4e38f787b76?w=800&q=80',
                    'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=800&q=80',
                ],
                'size' => '42', 'color' => 'Camel', 'brand' => 'Cairo Leather Co.',
                'category_id' => $shoes->id, 'supplier_id' => $supplier1->id,
            ],
            [
                'name' => 'Slip-On Leather Loafers',
                'slug' => 'slip-on-leather-loafers',
                'description' => 'Supple full-grain leather penny loafers with hand-stitched apron toe and cushioned insole for effortless sophistication.',
                'price' => 1950, 'discount' => 15, 'stock' => 55, 'rating' => 4.6, 'review_count' => 84,
                'images' => [
                    'https://images.unsplash.com/photo-1614252369475-531eba835eb1?w=800&q=80',
                    'https://images.unsplash.com/photo-1560769629-975ec94e6a86?w=800&q=80',
                ],
                'size' => '43', 'color' => 'Dark Brown', 'brand' => 'Cairo Leather Co.',
                'category_id' => $shoes->id, 'supplier_id' => $supplier1->id,
            ],
            [
                'name' => 'Trail Running Sport Shoes',
                'slug' => 'trail-running-sport-shoes',
                'description' => 'Engineered breathable mesh runners with deep multidirectional traction lugs, ready for asphalt and outdoor desert trails.',
                'price' => 1650, 'discount' => 0, 'stock' => 70, 'rating' => 4.7, 'review_count' => 195,
                'images' => [
                    'https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?w=800&q=80',
                    'https://images.unsplash.com/photo-1515955656352-a1fa3ffcd111?w=800&q=80',
                ],
                'size' => '44', 'color' => 'Olive Green', 'brand' => 'StreetRunner',
                'category_id' => $shoes->id, 'supplier_id' => $supplier2->id,
            ],
            [
                'name' => 'Minimalist White Leather Tennis Shoes',
                'slug' => 'minimalist-white-leather-sneakers',
                'description' => 'Clean-cut low-profile sneakers crafted with premium full-grain white leather and durable stitched rubber cupsole.',
                'price' => 1350, 'discount' => 20, 'stock' => 100, 'rating' => 4.9, 'review_count' => 410,
                'images' => [
                    'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?w=800&q=80',
                    'https://images.unsplash.com/photo-1560769629-975ec94e6a86?w=800&q=80',
                ],
                'size' => '41', 'color' => 'Pure White', 'brand' => 'Lamure Essentials',
                'category_id' => $shoes->id, 'supplier_id' => $supplier1->id,
            ],
            [
                'name' => 'Woven Canvas Beach Espadrilles',
                'slug' => 'woven-canvas-beach-espadrilles',
                'description' => 'Lightweight slip-on espadrilles with natural braided jute sole and breathable canvas upper, made for Mediterranean getaways.',
                'price' => 620, 'discount' => 0, 'stock' => 85, 'rating' => 4.4, 'review_count' => 130,
                'images' => [
                    'https://images.unsplash.com/photo-1560343090-f0409e92791a?w=800&q=80',
                    'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?w=800&q=80',
                ],
                'size' => '42', 'color' => 'Navy Stripe', 'brand' => 'Nile Comfort',
                'category_id' => $shoes->id, 'supplier_id' => $supplier1->id,
            ],
            [
                'name' => 'Chunky Sole Streetwear Sneakers',
                'slug' => 'chunky-sole-streetwear-sneakers',
                'description' => 'Bold futuristic silhouette dad shoes with multi-panel layered mesh and suede accents, featuring an ultra-cushioned midsole.',
                'price' => 1750, 'discount' => 25, 'stock' => 60, 'rating' => 4.5, 'review_count' => 167,
                'images' => [
                    'https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2?w=800&q=80',
                    'https://images.unsplash.com/photo-1575537302964-96cd47c06b1b?w=800&q=80',
                ],
                'size' => '43', 'color' => 'Gray/Black', 'brand' => 'StreetRunner',
                'category_id' => $shoes->id, 'supplier_id' => $supplier2->id,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        $this->command->info('✅ ' . count($products) . ' products created');

        $allProducts = Product::all();
        $p1 = $allProducts[0];
        $p2 = $allProducts[10];
        $p3 = $allProducts[20];

        $order1 = Order::create([
            'user_id' => $customer1->id,
            'total' => 3425,
            'status' => 'DELIVERED',
            'payment_method' => 'COD',
            'address' => '28 Road 9, Maadi, Cairo, Egypt',
        ]);
        $order1->items()->createMany([
            ['product_id' => $p1->id, 'quantity' => 2, 'price' => $p1->discounted_price],
            ['product_id' => $p2->id, 'quantity' => 1, 'price' => $p2->discounted_price],
        ]);

        $order2 = Order::create([
            'user_id' => $customer2->id,
            'total' => 1980,
            'status' => 'SHIPPED',
            'payment_method' => 'CARD',
            'address' => '51 San Stefano, Alexandria, Egypt',
        ]);
        $order2->items()->create([
            'product_id' => $p3->id, 'quantity' => 1, 'price' => $p3->discounted_price,
        ]);

        $order3 = Order::create([
            'user_id' => $customer3->id,
            'total' => 2650,
            'status' => 'PAID',
            'payment_method' => 'WALLET',
            'address' => '12 El-Haram St, Giza, Egypt',
        ]);
        $order3->items()->create([
            'product_id' => $allProducts[5]->id,
            'quantity' => 1,
            'price' => $allProducts[5]->discounted_price,
        ]);

        $this->command->info('✅ 3 sample orders created');

        Review::insert([
            ['id' => (string) \Illuminate\Support\Str::uuid(), 'user_id' => $customer1->id, 'product_id' => $p1->id, 'rating' => 5, 'comment' => 'Best Egyptian cotton t-shirt I have ever owned! Shipping to Maadi was fast.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => (string) \Illuminate\Support\Str::uuid(), 'user_id' => $customer2->id, 'product_id' => $p1->id, 'rating' => 5, 'comment' => 'So soft and comfortable. Worth every pound!', 'created_at' => now(), 'updated_at' => now()],
            ['id' => (string) \Illuminate\Support\Str::uuid(), 'user_id' => $customer3->id, 'product_id' => $p2->id, 'rating' => 4, 'comment' => 'Great headphones, noise cancellation works perfectly on the Cairo metro.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => (string) \Illuminate\Support\Str::uuid(), 'user_id' => $customer1->id, 'product_id' => $p3->id, 'rating' => 5, 'comment' => 'Beautiful shoes. True Egyptian craftsmanship.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => (string) \Illuminate\Support\Str::uuid(), 'user_id' => $customer2->id, 'product_id' => $allProducts[2]->id, 'rating' => 5, 'comment' => 'Perfect summer dress for Sahel! Got so many compliments.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => (string) \Illuminate\Support\Str::uuid(), 'user_id' => $customer3->id, 'product_id' => $allProducts[9]->id, 'rating' => 4, 'comment' => 'Very comfortable sneakers. Great for walking around Zamalek.', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $this->command->info('✅ 6 reviews created');
        $this->command->info('🎉 Lamure Egypt database seeded successfully!');
    }
}
