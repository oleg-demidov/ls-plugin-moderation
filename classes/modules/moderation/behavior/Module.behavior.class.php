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
 * Поведение, которое необходимо добавлять к ORM модулю сущности у которой добавляются категории
 *
 * @package application.modules.category
 * @since 2.0
 */
class PluginModeration_ModuleModeration_BehaviorModule extends Behavior
{
    /**
     * Дефолтные параметры
     *
     * @var array
     */
    protected $aParams = array(
        'target_type' => '',
    );
    /**
     * Список хуков
     *
     * @var array
     */
    protected $aHooks = array(
        
        'module_orm_GetItemsByFilter_before' => array(
            'CallbackGetItemsByFilterBefore',
            1000
        )
    );

    /**
     * Модифицирует фильтр в ORM запросе
     *
     * @param $aParams
     */
    public function CallbackGetItemsByFilterBefore($aParams)
    {
        $oEntity = Engine::GetEntity($aParams['sEntityFull']);
        
        $aBehaviors = $oEntity->GetBehaviors();
        $isBehaviorModeration = false;
        foreach ($aBehaviors as $oBehavior) {
            if ($oBehavior instanceof PluginModeration_ModuleModeration_BehaviorEntity) {
                $isBehaviorModeration = true;
                break;
            }
        }
        
        if(!$isBehaviorModeration){
            return false;
        }
        
        $aModerations = $this->PluginModeration_Moderation_GetModerationItemsByFilter([
            'entity' => $aParams['sEntityFull'],
            '#index-from' => 'entity_id'
        ]);    
        
        if(!$aModerations){
            return false;
        }
        
        if(!isset($aParams['aFilter']['#where'])){
            $aParams['aFilter']['#where'] = [];
        }
                
        $aParams['aFilter']['#where']["t.{$oEntity->_getPrimaryKey()} NOT IN (?a)"] = [array_keys($aModerations)];
    }

    

    
}