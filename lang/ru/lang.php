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

    // Products
    'products' => [
        'menu_label' => 'Товары',
        'list_title' => 'Управление товарами',
        'new_product' => 'Создать товар',
        'return_to_list' => 'Вернуться к списку товаров',
        'delete_confirm' => 'Вы действительно хотите удалить этот товар?',
        // Filters
        'filter_is_active' => 'Включены',
        // Scoreboard
        'count_is_active' => 'Товаров активно',
        'count_is_disabled' => 'Товаров отключено',
        'count_is_deleted' => 'Товаров удалено'
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
        'categories' => 'Отображать в категориях',
        'is_active' => 'Статус',
        'is_searchable' => 'Индексация',
        'is_unique_text' => 'Уникальное описание'
    ],

    // Categories
    'categories' => [
        'menu_label' => 'Категории',
        'list_title' => 'Управление категориями',
        'new_category' => 'Создать категорию',
        'reorder_categories' => 'Порядок категорий',
        'return_to_list' => 'Вернуться к списку категорий',
        'delete_confirm' => 'Вы действительно хотите удалить эту категорию?',
        // Scoreboard
        'count_is_active' => 'Категорий активно',
        'count_is_disabled' => 'Категорий отключено',
        'count_is_deleted' => 'Категорий удалено'
    ],
    'category' => [
        // Controls
        'label' => 'Категория',
        'create' => 'Создать категорию',
        'update' => 'Редактировать категорию',
        'preview' => 'Просмотр категории',
        'creating' => 'Создание категории',
        'saving' => 'Сохранение категории',
        'deleting' => 'Удаление категории',
        // Fields
        'name' => 'Название',
        'slug' => 'Параметр URL',
        'description' => 'Полное описание категории',
        'products_count' => 'Количество товаров',
        'is_active' => 'Статус',
        'is_searchable' => 'Индексация',
    ],

    // Meta
    'meta' => [
        'meta_title' => 'Мета заголовок',
        'meta_description' => 'Мета описание',
        'meta_keywords' => 'Мета ключи',
        'canonical_url' => 'Канонический URL',
        'redirect_url' => 'Редирект URL',
        'robot_index' => 'Индексация страницы',
        'robot_follow' => 'Индексация ссылок',
    ],
];
