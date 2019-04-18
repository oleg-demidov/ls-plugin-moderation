<?php
/**
 * Таблица БД
 */
$config['$root$']['db']['table']['moderation_moderation'] = '___db.table.prefix___moderation';

/**
 * Роутинг
 */
$config['$root$']['router']['page']['moderation'] = 'PluginModeration_ActionModeration';

$config['$root$']['block']['moderation_menu'] = array(
    'action' => array(
        'moderation' => [
            '{moderation_list}'
        ]
    ),
    'blocks' => array(
        'left' => array(
            'menuModeration' => array('priority' => 100,'params' => array('plugin' => 'moderation'))
        )
    ),
    'clear'  => false,
);

return $config;