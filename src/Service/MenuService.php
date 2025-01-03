<?php

namespace App\Service;

class MenuService
{
    public function getMenuItems(): array
    {
        return [
            ['name' => 'Menus', 'route' => 'app_menu_index'], // Correct route name
            ['name' => 'Items', 'route' => 'app_item_index'], // Update if necessary
            ['name' => 'Categories', 'route' => 'app_category_index'],
        ];
    }
}
