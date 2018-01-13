<?php

return [
    'plugin' => [
        'name' => 'Каталог товаров',
        'description' => 'Управление товарами',
        'menu_label' => 'Каталог',
        'tab' => 'Каталог товаров',
        'access_products' => 'Управление товарами',
        'access_settings' => 'Управление настройками каталога',
    ],
    'products' => [
        'menu_label' => 'Товары',
        'list_title' => 'Управление товарами',
        'new_product' => 'Создать товар',
        'return_to_list' => 'Вернуться к списку товаров',
        'delete_confirm' => 'Вы действительно хотите удалить этот товар?',
        // Filters
        'filter_is_active' => 'Включены'
    ],
    'product' => [
        // Controls
        'label' => 'Товар',
        'create' => 'Создать товар',
        'update' => 'Редактировать товар',
        'preview' => 'Просмотр товара',
        'creating' => 'Создание товара',
        'saving' => 'Сохранение товара',
        'deleting' => 'Удаление товара',
        // Fields
        'title' => 'Название',
        'slug' => 'Параметр URL',
        'sku' => 'SKU код',
        'isbn' => 'ISBN номер',
        'price' => 'Цена',
        'description' => 'Полное описание товара',
        'width' => 'Ширина',
        'height' => 'Высота',
        'depth' => 'Глубина',
        'weight' => 'Вес',
        'is_active' => 'Статус',
        'is_searchable' => 'Разрешить индесацию для поиска',
        'is_unique_text' => 'Содержит уникальное описание'
    ],
];
