<?php

/*
 * LiveStreet CMS
 * Copyright © 2018 OOO "ЛС-СОФТ"
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
 * @author Oleg Demodov <boxmilo@gmail.com>
 *
 */

/**
 * Description of BlockMenuSettings
 *
 * @author oleg
 */
class PluginModeration_BlockMenuModeration extends BlockMenu {

    public function __construct($aParams) {
        
        $aTypesEntity = $this->PluginModeration_Moderation_GetModerationEntities();
        
        if(!$aTypesEntity){
            return false;
        }

        foreach ($aTypesEntity as $oTypeEntity) {
            $this->Menu_Get('moderation')->appendChild(Engine::GetEntity("ModuleMenu_EntityItem", [
                'title' => Engine::GetEntityName(Engine::GetEntity($oTypeEntity->getEntity())), 
                'name' => $oTypeEntity->getEntity(), 
                'url' => Router::GetAction(). "/list/" . $oTypeEntity->getEntity(),
                'count' => $this->PluginModeration_Moderation_GetCountFromModerationByFilter([
                    "#cache" => ['countModeration', 60*60*24],
                    'entity' => $oTypeEntity->getEntity(), 
                    'state' => PluginModeration_ModuleModeration::STATE_MODERATE
                ])
            ]));
        }
        
        $aParams['name'] = 'moderation';
        parent::__construct($aParams);
    }   
    

}
