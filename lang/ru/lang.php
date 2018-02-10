<?php

return [

    // Plugin
    'plugin' => [
        'name' => 'Каталог товаров',
        'description' => 'Управление товарами',
        'menu_label' => 'Каталог',
        'tab' => 'Каталог товаров',
        'access_products' => 'Управление товарами',
        'access_import_export' => 'Управление импортом и экспортом',
        'access_categories' => 'Управление категориями',
        'access_publishers' => 'Управление издательствами',
        'access_publisher_sets' => 'Управление сериями издательств',
        'access_bindings' => 'Управление связями',
        'access_binding_types' => 'Управление типами связей',
        'access_properties' => 'Управление свойствами товара',
        'access_settings' => 'Управление настройками каталога',
    ],

    // Products
    'products' => [
        'menu_label' => 'Товары',
        'list_title' => 'Управление товарами',
        'new_product' => 'Создать товар',
        'return_to_list' => 'Вернуться к списку товаров',
        'delete_confirm' => 'Вы действительно хотите удалить этот товар?',
        // Import & Export
        'import_product' => 'Импорт товаров',
        'export_product' => 'Экспорт товаров',
        // Filters
        'filter_is_active' => 'Включены',
        // Scoreboard
        'count_is_active' => 'Товаров активно',
        'count_is_disabled' => 'Товаров отключено',
        'count_is_deleted' => 'Товаров удалено'
    ],

    'product' => [
        // Controls
        'id' => 'Ид номер',
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
        'description' => 'Описание',
        'width' => 'Ширина',
        'height' => 'Высота',
        'depth' => 'Глубина',
        'weight' => 'Вес',
        'categories' => 'Категории',
        'properties' => 'Свойства',
        'publisher' => 'Издательсвто',
        'publisher_empty' => '--- Выберите издательсвто ---',
        'publisher_set' => 'Серия',
        'publisher_set_empty' => '--- Выберите серию ---',
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


    // Publishers
    'publishers' => [
        'menu_label' => 'Издательства',
        'list_title' => 'Управление издательствами',
        'new_publisher' => 'Создать издательство',
        'return_to_list' => 'Вернуться к списку издательств',
        'delete_confirm' => 'Вы действительно хотите удалить это издательство?',
        // Scoreboard
        'count_is_active' => 'Издательств активно',
        'count_is_disabled' => 'Издательств отключено',
        'count_is_deleted' => 'Издательств удалено'
    ],

    'publisher' => [
        // Controls
        'label' => 'Издательства',
        'create' => 'Создать издательство',
        'update' => 'Редактировать издательство',
        'preview' => 'Просмотр издательства',
        'creating' => 'Создание издательства',
        'saving' => 'Сохранение издательства',
        'deleting' => 'Удаление издательства',
        // Fields
        'name' => 'Название',
        'slug' => 'Параметр URL',
        'description' => 'Полное описание издательства',
        'sets_count' => 'Количество серий',
        'is_active' => 'Статус',
        'is_searchable' => 'Индексация',
    ],


    // PublisherSets
    'publisher_sets' => [
        'menu_label' => 'Серии',
        'list_title' => 'Управление сериями',
        'new_publisher_set' => 'Создать серию',
        'return_to_list' => 'Вернуться к списку серий',
        // Filters
        'filter_is_active' => 'Включены',
        'filter_by_publisher' => 'Издательство',
        // Scoreboard
        'count_is_active' => 'Серий активно',
        'count_is_disabled' => 'Серий отключено',
        'count_is_deleted' => 'Серий удалено'
    ],

    'publisher_set' => [
        // Controls
        'label' => 'Серии',
        'create' => 'Создание серии',
        'update' => 'Редактирование серии',
        'preview' => 'Просмотр серии',
        'delete' => 'Удаление серии',
        'delete_confirm' => 'Вы действительно хотите удалить эту серию?',
        // Fields
        'name' => 'Название',
        'slug' => 'Параметр URL',
        'publisher' => 'Издательство',
        'publisher_empty' => '--- Выберите издательство ---',
        'description' => 'Полное описание серии',
        'is_active' => 'Статус',
        'is_searchable' => 'Индексация',
    ],


    // Bindings
    'bindings' => [
        'menu_label' => 'Связи',
        'list_title' => 'Управление связями',
        'new_binding' => 'Создать связь',
        'return_to_list' => 'Вернуться к списку связей',
        // Scoreboard
        'count_is_active' => 'Связей активно',
        'count_is_disabled' => 'Связей отключено',
        'count_is_deleted' => 'Связей удалено'
    ],

    'binding' => [
        // Controls
        'label' => 'Связи',
        'create' => 'Создание связи',
        'update' => 'Редактирование связи',
        'preview' => 'Просмотр связи',
        'delete' => 'Удаление связи',
        'delete_confirm' => 'Вы действительно хотите удалить эту связь?',
        // Fields
        'name' => 'Название',
        'slug' => 'Параметр URL',
        'description' => 'Описание',
        'binding_type' => 'Тип связи',
        'binding_type_empty' => '--- Выберите тип связи ---',
        'is_active' => 'Статус',
        'is_searchable' => 'Индексация',
    ],

    // Binding Types
    'binding_types' => [
        'menu_label' => 'Типы связи',
        'menu_description' => 'Управление типами связей товара',
        'list_title' => 'Управление типами связи',
        'new_binding' => 'Создать тип связи',
        'return_to_list' => 'Вернуться к списку типов связи',
    ],

    'binding_type' => [
        // Fields
        'name' => 'Название',
        'code' => 'Код',
        'page' => 'Страница связи',
        'description' => 'Описание типа связи',
    ],


    // Product Properties
    'properties' => [
        'menu_label' => 'Свойства товара',
        'menu_description' => 'Управление свойствами товара',
        'new_property' => 'Создать свойство',
        'list_title' => 'Управление свойствами товара',
    ],

    'property' => [
        'label' => 'Свойства',
        'create' => 'Создание свойства',
        'update' => 'Редактирование свойства',
        'preview' => 'Просмотр свойства',
        'delete' => 'Удаление свойства',
        'delete_confirm' => 'Вы действительно хотите удалить это свойство?',
        // Fields
        'name' => 'Название',
        'code' => 'Код',
        'description' => 'Описание свойства',
        'is_active' => 'Статус',
    ],

    'property_value' => [
        'label' => 'Значение свойства',
        'value' => 'Значение'
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
