<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;
use App\Models\Category;

class DndMenuItemSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::pluck('id', 'name');

        $items = [

            // ── Burger ────────────────────────────────────────────
            ['category' => 'Burger', 'name' => 'Aallu Tikki Burger',    'price' => 49,  'description' => 'Crispy aloo tikki patty with fresh veggies and sauces.',           'sort_order' => 1],
            ['category' => 'Burger', 'name' => 'Crispy Masala Burger',  'price' => 55,  'description' => 'Spicy crispy patty loaded with desi masala flavour.',              'sort_order' => 2],
            ['category' => 'Burger', 'name' => 'Cheese Masala Burger',  'price' => 65,  'description' => 'Masala patty topped with melted cheese.',                          'sort_order' => 3],
            ['category' => 'Burger', 'name' => 'Tandoori Cheese Burger','price' => 69,  'description' => 'Tandoori flavoured patty with cheese and chutneys.',               'sort_order' => 4],
            ['category' => 'Burger', 'name' => 'Makhani Cheese Burger', 'price' => 69,  'description' => 'Rich makhani spiced patty with cheese in a soft bun.',             'sort_order' => 5],

            // ── Sandwich ──────────────────────────────────────────
            ['category' => 'Sandwich', 'name' => 'Veg Grill Sandwich',         'price' => 69,  'description' => 'Grilled sandwich packed with fresh vegetables.',                   'sort_order' => 1],
            ['category' => 'Sandwich', 'name' => 'Cheese & Corn Sandwich',     'price' => 89,  'description' => 'Cheesy grilled sandwich with sweet corn filling.',                  'sort_order' => 2],
            ['category' => 'Sandwich', 'name' => 'Paneer Tandoori Sandwich',   'price' => 99,  'description' => 'Grilled sandwich with tandoori marinated paneer.',                  'sort_order' => 3],
            ['category' => 'Sandwich', 'name' => 'Paneer & Schezwan Sandwich', 'price' => 99,  'description' => 'Paneer sandwich with spicy Schezwan sauce.',                        'sort_order' => 4],

            // ── Pizza (listed as separate sizes) ──────────────────
            ['category' => 'Pizza', 'name' => 'Margerita (8")',              'price' => 99,  'description' => 'Classic tomato base with mozzarella cheese. 8 inch.',              'sort_order' => 1],
            ['category' => 'Pizza', 'name' => 'Margerita (10")',             'price' => 129, 'description' => 'Classic tomato base with mozzarella cheese. 10 inch.',             'sort_order' => 2],
            ['category' => 'Pizza', 'name' => 'Double Cheese Margerita (8")', 'price' => 129, 'description' => 'Extra cheese margerita pizza. 8 inch.',                           'sort_order' => 3],
            ['category' => 'Pizza', 'name' => 'Double Cheese Margerita (10")', 'price' => 149, 'description' => 'Extra cheese margerita pizza. 10 inch.',                          'sort_order' => 4],
            ['category' => 'Pizza', 'name' => 'OTC Pizza (8")',              'price' => 149, 'description' => 'Onion, Tomato & Capsicum pizza. 8 inch.',                           'sort_order' => 5],
            ['category' => 'Pizza', 'name' => 'OTC Pizza (10")',             'price' => 169, 'description' => 'Onion, Tomato & Capsicum pizza. 10 inch.',                          'sort_order' => 6],
            ['category' => 'Pizza', 'name' => 'Farmhouse Pizza (8")',        'price' => 159, 'description' => 'Loaded farmhouse pizza with assorted veggies. 8 inch.',            'sort_order' => 7],
            ['category' => 'Pizza', 'name' => 'Farmhouse Pizza (10")',       'price' => 179, 'description' => 'Loaded farmhouse pizza with assorted veggies. 10 inch.',           'sort_order' => 8],
            ['category' => 'Pizza', 'name' => 'Paneer & Onion Pizza (8")',   'price' => 159, 'description' => 'Paneer and caramelised onion pizza. 8 inch.',                      'sort_order' => 9],
            ['category' => 'Pizza', 'name' => 'Paneer & Onion Pizza (10")',  'price' => 179, 'description' => 'Paneer and caramelised onion pizza. 10 inch.',                     'sort_order' => 10],
            ['category' => 'Pizza', 'name' => 'Makhani Paneer Pizza (8")',   'price' => 169, 'description' => 'Paneer pizza with rich makhani sauce. 8 inch.',                    'sort_order' => 11],
            ['category' => 'Pizza', 'name' => 'Makhani Paneer Pizza (10")',  'price' => 199, 'description' => 'Paneer pizza with rich makhani sauce. 10 inch.',                   'sort_order' => 12],
            ['category' => 'Pizza', 'name' => 'Over Loaded Pizza (8")',      'price' => 189, 'description' => 'Fully loaded pizza with all toppings. 8 inch.',                    'sort_order' => 13],
            ['category' => 'Pizza', 'name' => 'Over Loaded Pizza (10")',     'price' => 219, 'description' => 'Fully loaded pizza with all toppings. 10 inch.',                   'sort_order' => 14],

            // ── Fries ─────────────────────────────────────────────
            ['category' => 'Fries', 'name' => 'French Fries',        'price' => 69,  'description' => 'Crispy golden fries with ketchup.',                                   'sort_order' => 1],
            ['category' => 'Fries', 'name' => 'Peri Peri Fries',     'price' => 79,  'description' => 'Fries tossed in spicy peri peri seasoning.',                         'sort_order' => 2],
            ['category' => 'Fries', 'name' => 'Cheese Fries',        'price' => 89,  'description' => 'Crispy fries topped with melted cheese sauce.',                      'sort_order' => 3],
            ['category' => 'Fries', 'name' => 'Chilli Potato',       'price' => 89,  'description' => 'Crispy potato in Indo-Chinese chilli sauce.',                        'sort_order' => 4],
            ['category' => 'Fries', 'name' => 'Honey Chilli Potato', 'price' => 119, 'description' => 'Crispy potato in sweet and spicy honey chilli sauce.',               'sort_order' => 5],

            // ── Momos (Half = 5 pieces, Full = 10 pieces) ─────────
            ['category' => 'Momos', 'name' => 'Veg Steam Momos (Half)',         'price' => 39,  'description' => '5 pieces of steamed veg momos with chutney.',                   'sort_order' => 1],
            ['category' => 'Momos', 'name' => 'Veg Steam Momos (Full)',         'price' => 59,  'description' => '10 pieces of steamed veg momos with chutney.',                  'sort_order' => 2],
            ['category' => 'Momos', 'name' => 'Veg Fried Momos (Half)',         'price' => 49,  'description' => '5 pieces of crispy fried veg momos.',                           'sort_order' => 3],
            ['category' => 'Momos', 'name' => 'Veg Fried Momos (Full)',         'price' => 69,  'description' => '10 pieces of crispy fried veg momos.',                          'sort_order' => 4],
            ['category' => 'Momos', 'name' => 'Veg Kurkure Momos (Half)',       'price' => 59,  'description' => '5 pieces of crunchy kurkure coated veg momos.',                 'sort_order' => 5],
            ['category' => 'Momos', 'name' => 'Veg Kurkure Momos (Full)',       'price' => 79,  'description' => '10 pieces of crunchy kurkure coated veg momos.',                'sort_order' => 6],
            ['category' => 'Momos', 'name' => 'Veg Chilli Gravy Momos (Half)',  'price' => 79,  'description' => '5 pieces of veg momos in spicy chilli gravy.',                  'sort_order' => 7],
            ['category' => 'Momos', 'name' => 'Veg Chilli Gravy Momos (Full)',  'price' => 99,  'description' => '10 pieces of veg momos in spicy chilli gravy.',                 'sort_order' => 8],
            ['category' => 'Momos', 'name' => 'Paneer Steam Momos (Half)',      'price' => 49,  'description' => '5 pieces of steamed paneer momos with chutney.',                'sort_order' => 9],
            ['category' => 'Momos', 'name' => 'Paneer Steam Momos (Full)',      'price' => 79,  'description' => '10 pieces of steamed paneer momos with chutney.',               'sort_order' => 10],
            ['category' => 'Momos', 'name' => 'Paneer Fried Momos (Half)',      'price' => 59,  'description' => '5 pieces of crispy fried paneer momos.',                        'sort_order' => 11],
            ['category' => 'Momos', 'name' => 'Paneer Fried Momos (Full)',      'price' => 89,  'description' => '10 pieces of crispy fried paneer momos.',                       'sort_order' => 12],
            ['category' => 'Momos', 'name' => 'Paneer Kurkure Momos (Half)',    'price' => 69,  'description' => '5 pieces of crunchy kurkure coated paneer momos.',              'sort_order' => 13],
            ['category' => 'Momos', 'name' => 'Paneer Kurkure Momos (Full)',    'price' => 99,  'description' => '10 pieces of crunchy kurkure coated paneer momos.',             'sort_order' => 14],
            ['category' => 'Momos', 'name' => 'Paneer Chilli Gravy Momos (Half)', 'price' => 89, 'description' => '5 pieces of paneer momos in spicy chilli gravy.',             'sort_order' => 15],
            ['category' => 'Momos', 'name' => 'Paneer Chilli Gravy Momos (Full)', 'price' => 119, 'description' => '10 pieces of paneer momos in spicy chilli gravy.',           'sort_order' => 16],

            // ── Manchurian (Half = 4 pieces, Full = 8 pieces) ─────
            ['category' => 'Manchurian', 'name' => 'Dry Manchurian (Half)',   'price' => 49,  'description' => '4 pieces of crispy dry manchurian.',                           'sort_order' => 1],
            ['category' => 'Manchurian', 'name' => 'Dry Manchurian (Full)',   'price' => 79,  'description' => '8 pieces of crispy dry manchurian.',                           'sort_order' => 2],
            ['category' => 'Manchurian', 'name' => 'Gravy Manchurian (Half)', 'price' => 69,  'description' => '4 pieces of manchurian balls in rich gravy.',                  'sort_order' => 3],
            ['category' => 'Manchurian', 'name' => 'Gravy Manchurian (Full)', 'price' => 99,  'description' => '8 pieces of manchurian balls in rich gravy.',                  'sort_order' => 4],

            // ── Noodles ───────────────────────────────────────────
            ['category' => 'Noodles', 'name' => 'Veg Noodles (Half)',          'price' => 59,  'description' => 'Stir-fried veg noodles. Half portion.',                       'sort_order' => 1],
            ['category' => 'Noodles', 'name' => 'Veg Noodles (Full)',          'price' => 89,  'description' => 'Stir-fried veg noodles. Full portion.',                       'sort_order' => 2],
            ['category' => 'Noodles', 'name' => 'Chilli Garlic Noodles (Half)','price' => 69,  'description' => 'Spicy chilli garlic noodles. Half portion.',                  'sort_order' => 3],
            ['category' => 'Noodles', 'name' => 'Chilli Garlic Noodles (Full)','price' => 99,  'description' => 'Spicy chilli garlic noodles. Full portion.',                  'sort_order' => 4],
            ['category' => 'Noodles', 'name' => 'Schezwan Noodles (Half)',     'price' => 79,  'description' => 'Noodles tossed in spicy Schezwan sauce. Half portion.',       'sort_order' => 5],
            ['category' => 'Noodles', 'name' => 'Schezwan Noodles (Full)',     'price' => 109, 'description' => 'Noodles tossed in spicy Schezwan sauce. Full portion.',      'sort_order' => 6],

            // ── Pasta ─────────────────────────────────────────────
            ['category' => 'Pasta', 'name' => 'Red Sauce Pasta',   'price' => 109, 'description' => 'Penne pasta in tangy tomato based red sauce.',                          'sort_order' => 1],
            ['category' => 'Pasta', 'name' => 'White Sauce Pasta', 'price' => 119, 'description' => 'Penne pasta in creamy white béchamel sauce.',                           'sort_order' => 2],
            ['category' => 'Pasta', 'name' => 'Peri Peri Pasta',   'price' => 119, 'description' => 'Pasta tossed in spicy peri peri sauce.',                                'sort_order' => 3],

            // ── Maggie ────────────────────────────────────────────
            ['category' => 'Maggie', 'name' => 'Butter Maggie', 'price' => 49,  'description' => 'Classic Maggie noodles cooked with butter.',                               'sort_order' => 1],
            ['category' => 'Maggie', 'name' => 'Veg Maggie',    'price' => 69,  'description' => 'Maggie noodles loaded with fresh vegetables.',                             'sort_order' => 2],
            ['category' => 'Maggie', 'name' => 'Cheese Maggie', 'price' => 79,  'description' => 'Maggie noodles topped with melted cheese.',                               'sort_order' => 3],

            // ── Soup ──────────────────────────────────────────────
            ['category' => 'Soup', 'name' => 'Tomato Soup',       'price' => 69,  'description' => 'Classic creamy tomato soup.',                                            'sort_order' => 1],
            ['category' => 'Soup', 'name' => 'Veg Sweet Corn Soup','price' => 79,  'description' => 'Sweet and savoury veg sweet corn soup.',                                'sort_order' => 2],
            ['category' => 'Soup', 'name' => 'Hot & Sour Veg Soup','price' => 89,  'description' => 'Tangy and spicy Indo-Chinese hot & sour soup.',                         'sort_order' => 3],

            // ── Hot Drinks ────────────────────────────────────────
            ['category' => 'Hot Drinks', 'name' => 'Coffee',        'price' => 29,  'description' => 'Hot brewed coffee.',                                                   'sort_order' => 1],
            ['category' => 'Hot Drinks', 'name' => 'Black Coffee',  'price' => 29,  'description' => 'Strong hot black coffee.',                                             'sort_order' => 2],
            ['category' => 'Hot Drinks', 'name' => 'Kullad Coffee', 'price' => 49,  'description' => 'Traditional hot coffee served in a clay kullad.',                      'sort_order' => 3],
            ['category' => 'Hot Drinks', 'name' => 'Adarak Chai',   'price' => 25,  'description' => 'Freshly brewed ginger tea.',                                           'sort_order' => 4],

            // ── Cold Coffee ───────────────────────────────────────
            ['category' => 'Cold Coffee', 'name' => 'Cold Coffee (Medium)',        'price' => 49,  'description' => 'Chilled blended cold coffee. Medium.',                  'sort_order' => 1],
            ['category' => 'Cold Coffee', 'name' => 'Cold Coffee (Large)',         'price' => 79,  'description' => 'Chilled blended cold coffee. Large.',                   'sort_order' => 2],
            ['category' => 'Cold Coffee', 'name' => 'Kullad Cold Coffee (Medium)', 'price' => 69,  'description' => 'Cold coffee served in traditional kullad. Medium.',      'sort_order' => 3],
            ['category' => 'Cold Coffee', 'name' => 'Kullad Cold Coffee (Large)',  'price' => 89,  'description' => 'Cold coffee served in traditional kullad. Large.',       'sort_order' => 4],
            ['category' => 'Cold Coffee', 'name' => 'Vanilla Top Up',              'price' => 19,  'description' => 'Add vanilla flavour to any cold coffee.',                'sort_order' => 5],
            ['category' => 'Cold Coffee', 'name' => 'Chocolate Top Up',            'price' => 29,  'description' => 'Add chocolate flavour to any cold coffee.',              'sort_order' => 6],

            // ── Shakes ────────────────────────────────────────────
            ['category' => 'Shakes', 'name' => 'Strawberry Shake',    'price' => 69,  'description' => 'Thick and creamy strawberry milkshake.',                             'sort_order' => 1],
            ['category' => 'Shakes', 'name' => 'Chocolate Shake',     'price' => 69,  'description' => 'Rich and indulgent chocolate milkshake.',                           'sort_order' => 2],
            ['category' => 'Shakes', 'name' => 'Oreo Shake',          'price' => 79,  'description' => 'Creamy milkshake blended with Oreo cookies.',                       'sort_order' => 3],
            ['category' => 'Shakes', 'name' => 'Kitkat Shake',        'price' => 79,  'description' => 'Creamy milkshake blended with KitKat chocolate.',                   'sort_order' => 4],
            ['category' => 'Shakes', 'name' => 'Butter Scotch Shake', 'price' => 79,  'description' => 'Sweet and creamy butterscotch flavoured shake.',                    'sort_order' => 5],

            // ── Mocktail ──────────────────────────────────────────
            ['category' => 'Mocktail', 'name' => 'Virgin Mint Mojito',     'price' => 69,  'description' => 'Refreshing mint and lime mocktail.',                            'sort_order' => 1],
            ['category' => 'Mocktail', 'name' => 'Green Mint Mojito',      'price' => 69,  'description' => 'Fresh green mint mojito with a citrus twist.',                  'sort_order' => 2],
            ['category' => 'Mocktail', 'name' => 'Kala Khata Mojito',      'price' => 79,  'description' => 'Tangy kala khata flavoured mojito.',                            'sort_order' => 3],
            ['category' => 'Mocktail', 'name' => 'Lemon Ice Tea',          'price' => 79,  'description' => 'Chilled lemon flavoured iced tea.',                             'sort_order' => 4],
            ['category' => 'Mocktail', 'name' => 'Masala Lemonade Mojito', 'price' => 79,  'description' => 'Spiced masala lemonade with a mojito base.',                    'sort_order' => 5],

            // ── Combos ────────────────────────────────────────────
            ['category' => 'Combos', 'name' => 'Crispy Burger Combo',  'price' => 99,  'description' => 'Crispy Masala Burger + 1+1 Fries.',                                 'sort_order' => 1],
            ['category' => 'Combos', 'name' => 'Sandwich Combo',       'price' => 149, 'description' => '1 Sandwich + 2 Cold Coffee.',                                       'sort_order' => 2],
            ['category' => 'Combos', 'name' => 'Momo Combo',           'price' => 119, 'description' => '1/2 Plate Momos + 1/2 Plate Noodles + 1 Cold Coffee.',              'sort_order' => 3],
            ['category' => 'Combos', 'name' => 'Pizza Combo',          'price' => 309, 'description' => '1 OTC Pizza + 1 Sandwich + 2 Cold Coffee.',                         'sort_order' => 4],
            ['category' => 'Combos', 'name' => 'Pasta Combo',          'price' => 149, 'description' => '1 Red Sauce Pasta + 1 Dry Manchurian.',                             'sort_order' => 5],
        ];

        $count = 0;
        foreach ($items as $item) {
            $categoryId = $categories[$item['category']] ?? null;
            if (!$categoryId) continue;

            MenuItem::firstOrCreate(
                ['name' => $item['name'], 'category_id' => $categoryId],
                [
                    'category_id'  => $categoryId,
                    'name'         => $item['name'],
                    'description'  => $item['description'],
                    'price'        => $item['price'],
                    'sort_order'   => $item['sort_order'],
                    'is_available' => true,
                ]
            );
            $count++;
        }

        $this->command->info("  ✓ DND Cafe menu items created ({$count} items).");
    }
}