<?php
/*
 * LiveStreet CMS
 * Copyright © 2013 OOO "ЛС-СОФТ"
 *
 * ------------------------------------------------------
 *
 * Official site: www.livestreetcms.com
 * Contact e-mail: office@livestreetcms.com
 *
 * GNU General Public License, version 2:
 * http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * ------------------------------------------------------
 *
 * @link http://www.livestreetcms.com
 * @copyright 2013 OOO "ЛС-СОФТ"
 * @author Oleg
 *
 */

/**
 * Поведение, которое необходимо добавлять к сущности (entity) у которой добавляются категории
 *
 * @package application.modules.category
 * @since 2.0
 */
class PluginModeration_ModuleModeration_BehaviorEntity extends Behavior
{
    /**
     * Дефолтные параметры
     *
     * @var array
     */
    protected $aParams = array(
        // Уникальный код
        'target_type'                    => '',
        // Колбек для сообщения о нажатии нравится.
        // Указывать можно строкой с полным вызовом метода модуля, например, "PluginArticle_Main_GetCountArticle"
        'callback_like'          => null,
    );
    
    /**
     * Список хуков
     *
     * @var array
     */
    protected $aHooks = array(
        'after_delete'   => 'CallbackAfterDelete'
    );
    

    /**
     * Инициализация
     */
    protected function Init()
    {
        parent::Init();
        
    }

    

    
}