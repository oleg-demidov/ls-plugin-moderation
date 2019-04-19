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
 * @author Oleg Demidov 
 *
 */

/**
 * Экшен обработки ajax запросов
 * Ответ отдает в JSON фомате
 *
 * @package actions
 * @since 1.0
 */
class PluginModeration_ActionModeration extends ActionPlugin{
    
    protected $sMenuItemSelect = '';
    
    public function Init()
    {
        if(!$this->CheckUserAccess()){
            $this->Message_AddError($this->Lang_Get('common.error.system.code.404'), '404');
            Router::LocationAction('error/404');
        }
        
        $this->SetDefaultEvent('list');
        
    }
    
    protected function RegisterEvent() {
        $this->RegisterEventExternal('Moderation', 'PluginModeration_ActionModeration_EventModeration');
        $this->AddEventPreg('/^list$/i', '/^([\w_]+)?$/i',  '/^(moderation|denied)?$/i', ['Moderation::EventList' , 'moderation_list']);
        $this->AddEventPreg('/^ajax-list$/i', 'Moderation::EventAjaxList');
        $this->AddEventPreg('/^ajax-publish$/i',  'Moderation::EventAjaxPublish');
        $this->AddEventPreg('/^ajax-delete$/i',  'Moderation::EventAjaxDelete');
        $this->AddEventPreg('/^ajax-denied/i',  'Moderation::EventAjaxDenied');
    }
    
    /**
     * Проверка корректности профиля
     */
    protected function CheckUserAccess()
    {
        /**
         * Проверяем есть ли такой юзер
         */
        if (!$this->oUserCurrent = $this->User_GetUserCurrent()) {
            return false;
        }        
        
        if($this->oUserCurrent->isAdministrator()){
            return true;
        } 
        
        if(! $this->Rbac_IsAllow('moderation')){
            return false;
        }
        
        return true;
    }
    
    /**
     * Выполняется при завершении каждого эвента
     */
    public function EventShutdown()
    {
        $this->Viewer_Assign('sModerationAction', Router::GetAction());
        $this->Menu_Get('moderation')->setActiveItem($this->sMenuItemSelect);

    }
}