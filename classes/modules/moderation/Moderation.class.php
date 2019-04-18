<?php

class PluginModeration_ModuleModeration extends ModuleORM
{
    
    
    public function Init() {
        parent::Init(); 
    }
    
    public function ToModeration($oEntity) {
        $oModeration = Engine::GetEntity('PluginModeration_Moderation_Moderation', [
            'entity' => get_class($oEntity),
            'entity_id' => $oEntity->_getPrimaryKeyValue()
        ]);
        return $oModeration->Save();
    }
}