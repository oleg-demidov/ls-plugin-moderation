<?php

return [
    'list' => [
        'title' => 'Модерация %%entity%%',
        'cols' => [
            'number' => 'Номер',
            'title' => 'Название'
        ],
        'nav' => [
            'moderation' => 'На модерации',
            'denied' => 'Отказано'
        ],
        'blankslate' => [
            'text' => 'Объектов для модерации нет.'
        ]
    ],
    'menu_user' => [
        'text' => 'Модерация'
    ],
    'actions' => [
        'publish'   => 'Опубликовать',
        'denied'    => 'Отказать',
        'delete'    => 'Удалить',
        'notices' => [
            'confirm_delete' => 'Вы действительно хотите удалить?'
        ]
    ],
    'notices' => [
        'in_moderation' => [
            'text' => 'Спасибо за %%label%%. %%label%% <strong>%%title%%</strong> находится на модерации.'
        ]
    ]
];