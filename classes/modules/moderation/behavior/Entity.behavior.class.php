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
    private $bObjectIsNew = false;
    /**
     * Дефолтные параметры
     *
     * @var array
     */
    
    protected $aParams = array(
        // Поля которые нужно модерировать 
        'moderation_fields' => [],
        // Поле сущности в котором хранится короткое имя сущности
        'title_field'       => 'title',
        // Вызывается после успешной модерации метод сущности
        'callback_moderate' => 'afterModerate',
        // Вызывается после неуспешной модерации
        'callback_denied' => 'afterDenied',
        // Название сущности
        'label' => 'Объект'
    );
    
    /**
     * Список хуков
     *
     * @var array
     */
    protected $aHooks = array(
        'after_save'     => 'CallbackAfterSave',
        'before_save'    => 'CallbackBeforeSave',
        'after_delete'   => 'CallbackAfterDelete',
    );
    
    private function objectIsChanged(){
        $aChangeFileds = array_keys($this->oObject->_getDataFieldsForDb(true));
        $aChangeFieldsParam = array_uintersect($aChangeFileds, $this->getParam('moderation_fields'), "strcasecmp");
        return $aChangeFieldsParam;
    }
    
    /**
     * Отправляет на модерацию в случае если обьект взят из базы и изменен
     */
    public function CallbackBeforeSave() {
        $this->bObjectIsNew = $this->oObject->_isNew();
        
        if (!$this->oObject->_isNew() and $this->objectIsChanged()) {
            $this->PluginModeration_Moderation_ToModeration($this->oObject);
        }
    }
    
    /**
     *  Отправляет на модерацию в случае если обьект новый только что добавлен в базу
     */
    public function CallbackAfterSave() {
        if($this->bObjectIsNew){
            $this->PluginModeration_Moderation_ToModeration($this->oObject);
        }
        
    }
    
    public function CallbackAfterDelete() {
        $this->PluginModeration_Moderation_RemoveModerations($this->oObject);
    }
    
    public function getFields() {
        return $this->getParam('moderation_fields');
    }
    
    /**
     * Пытается взять Имя сущности с учетом параметра title_field вызывая геттер
     * @return string
     */
    public function getTitle() {
        return func_text_words(call_user_func([$this->oObject, 'get'.func_camelize($this->getParam('title_field'))]),3);
    }
    
    public function getLabel() {
        return $this->getParam('label');
    }
    
    public function isModerated() {
        return $this->PluginModeration_Moderation_IsModerated($this->oObject);
    }
    
    public function getModeration() {
        return $this->PluginModeration_Moderation_GetEntityModeration($this->oObject);
    }
    
    /**
     * Инициализация
     */
    protected function Init()
    {
        parent::Init();
        
    }

    

    
}