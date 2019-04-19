<?php


class PluginModeration_HookMenuUser extends Hook{
    public function RegisterHook()
    {
        $this->AddHook('engine_init_complete', 'NavUser');        
    }

    /**
     * Добавляем в главное меню 
     */
    public function NavUser($aParams)
    {
        if(!$oUser = $this->User_GetUserCurrent()){
            return false;
        }
        
        $oMenu = $this->Menu_Get('user');
        
        if($oUser->isAdministrator() or $this->Rbac_IsAllow('moderation')){
        
            $oMenu->appendChild(Engine::GetEntity("ModuleMenu_EntityItem", [
                'name' => 'moderation',
                'title' => 'plugin.moderation.menu_user.text',
                'url' => 'moderation',
                'count' => $this->PluginModeration_Moderation_GetCountModeration()
            ]));
        }
        
    }

}
