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
        // Поля которые нужно модерировать
        'moderation_fields' => [],
        'title_field'        => 'title'
    );
    
    /**
     * Список хуков
     *
     * @var array
     */
    protected $aHooks = array(
        'after_save'     => 'CallbackAfterSave',
        'after_delete'   => 'CallbackAfterDelete',
    );
    
    public function CallbackAfterSave() {
        $this->PluginModeration_Moderation_ToModeration($this->oObject);
    }
    
    public function getFields() {
        return $this->getParam('moderation_fields');
    }
    
    public function getTitle() {
        return $this->oObject->_getDataOne($this->getParam('title_field'));
    }
    
    /**
     * Инициализация
     */
    protected function Init()
    {
        parent::Init();
        
    }

    

    
}