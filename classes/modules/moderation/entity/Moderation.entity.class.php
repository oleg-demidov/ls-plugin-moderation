<?php

class PluginModeration_ModuleModeration_EntityModeration extends EntityORM
{
    
    
    protected $aValidateRules = [
        ['entity_id entity', 'exists']
    ];
    
    public function ValidateExists($sValue, $aParams) {
        if($this->PluginModeration_Like_GetLikeByFilter([
            'type_id' =>  $this->getTypeId(), 
            'target_id' =>  $this->getTargetId(), 
            'user_id' =>  $this->getUserId()
        ])){
            return $this->Lang_Get('plugin.like.like.notices.error_validate_exists');
        }
        return true;
    }
    
    /**
     * Получить сущность которая модерируется
     * 
     * @return type EntityORM
     */
    public function getEntityObject() {
        $oEntity = Engine::GetEntity($this->getEntity());
        return $this->PluginModeration_Moderation_GetByFilter(
            [
                $oEntity->_getPrimaryKey() => $this->getEntityId()
            ],
            $this->getEntity() 
        );
    }
}