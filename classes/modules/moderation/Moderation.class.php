<?php

class PluginModeration_ModuleModeration extends ModuleORM
{
    
    const STATE_MODERATE = 1;
    const STATE_DENIED = 2;


    public function Init() {
        parent::Init(); 
    }
    
    public function ToModeration($oEntity) {
        if(!$oModeration = $this->GetEntityModeration($oEntity)){
            $oModeration = Engine::GetEntity('PluginModeration_Moderation_Moderation', [
                'entity' => get_class($oEntity),
                'entity_id' => $oEntity->_getPrimaryKeyValue()
            ]);
        }
        
        $oBehavior = $this->GetBehaviorEntity($oEntity);
        
        $this->Message_AddNotice($this->Lang_Get('plugin.moderation.notices.in_moderation.message', ['title' => $oBehavior->getTitle()]));
        
        $oModeration->setState(self::STATE_MODERATE);
        
        return $oModeration->Save();
    }
    
    public function GetModerationEntities() {
        return $this->GetModerationItemsByFilter([
            '#cache' => ['moderation_entities', 60*60*24],
            '#group' => 'entity'
        ]);
    }
    
    public function GetEntityModeration($oEntity) { 
        return $this->GetModerationByFilter([
            'entity' => get_class($oEntity),
            'entity_id' => $oEntity->_getPrimaryKeyValue()
        ]);
    }
    
    public function IsModerated($oEntity) {
        return !($this->GetEntityModeration($oEntity));
    }
    
    public function GetCountModeration() {
        return $this->PluginModeration_Moderation_GetCountFromModerationByFilter([
            'state' => PluginModeration_ModuleModeration::STATE_MODERATE
        ]);
    }
    
    /**
     * Удалить все модерации данного объекта
     * @param type $oEntity
     */
    public function RemoveModerations($oEntity) {
        $aModerations = $this->PluginModeration_Moderation_GetModerationItemsByFilter([
            'entity' => get_class( $oEntity ),
            'id' => $oEntity->_getPrimaryKeyValue()
        ]);
        
        foreach ($aModerations as $oModeration) {
            $oModeration->Delete();
        }
    }
    
    public function GetBehaviorEntity($oEntity) {
        $aBehaviors = $oEntity->GetBehaviors();
        $isBehaviorModeration = false;
        foreach ($aBehaviors as $oBehavior) {
            if ($oBehavior instanceof PluginModeration_ModuleModeration_BehaviorEntity) {
                return $oBehavior;
            }
        }
        
        return false;
    }
}