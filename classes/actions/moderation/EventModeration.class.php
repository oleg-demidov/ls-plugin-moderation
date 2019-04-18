<?php

/**
 * Description of ActionModeration_EventModeration
 *
 * @author oleg
 */
class PluginModeration_ActionModeration_EventModeration extends Event {
    
    
    public function EventList()
    {
        $this->SetTemplateAction('list');
        
        $sEntity = $this->GetParam(0);
        
        if(!$sEntity){
            $aTypesEntity = $this->PluginModeration_Moderation_GetModerationEntities();
            if($aTypesEntity and !$this->GetParam(0)){
                $sEntity = array_shift($aTypesEntity)->getEntity();
                Router::LocationAction(Router::GetAction() . '/list/' . $sEntity);
            }
        }
                
        if(class_exists($sEntity)){
            $oEntity = Engine::GetEntity($sEntity);            
            $this->Viewer_Assign('aModerateFields', $this->getModerateFileds($oEntity));
            $this->Viewer_Assign('sEntityName', Engine::GetEntityName($oEntity));
            $this->Viewer_Assign('sEntityClass', $sEntity);
        } 
        
        $this->sMenuItemSelect = $sEntity;
        
    }
    
    public function EventAjaxList()
    {                        
        $this->Viewer_SetResponseAjax('json');
        $this->SetTemplate(false);
        
        $iStart = getRequest('start', 0);
        $iLimit = getRequest('limit', Config::Get('moderation.talk.page_count'));
        
        $oViewer = $this->Viewer_GetLocalViewer();
        
        if(class_exists(getRequest('entity'))){
            $oEntity = Engine::GetEntity(getRequest('entity'));
            
            $aModerations = $this->PluginModeration_Moderation_GetModerationItemsByFilter([
                'entity' => getRequest('entity'),
                '#index-from' => 'entity_id'
            ]);
        
            $aEntities = $this->PluginModeration_Moderation_GetItemsByFilter([
                $oEntity->_getPrimaryKey().' in' => array_keys($aModerations),
                '#limit'         => [ $iStart, $iLimit],
            ], getRequest('entity'));
            
            
            //$oViewer->GetSmartyObject()->addPluginsDir(Config::Get('path.application.server').'/classes/modules/viewer/plugs');
            $oViewer->Assign('aEntities', $aEntities);
            list($aModerationFields, $sTitleField) = $this->getModerateFileds($oEntity);
            $oViewer->Assign('aModerateFields', $aModerationFields);
            $oViewer->Assign('sTitleField', $sTitleField);
//            $sHtml = $oViewer->Fetch('component@moderation:entity.list');

            $iCountAll = sizeof($aModerations);
            
            $iCount = ($iCountAll - ($iStart+$iLimit))<0?0:($iCountAll - ($iStart+$iLimit));
            
            
            $this->Viewer_AssignAjax('countAll', $iCountAll);
            $this->Viewer_AssignAjax('count', $iCount);
        } 
        
        $this->Viewer_AssignAjax('html', $oViewer->Fetch('component@moderation:entity.list'));
        
    }
    
    private function getModerateFileds($oEntity) {
        $aBehaviors = $oEntity->GetBehaviors();
        foreach ($aBehaviors as $oBehavior) {            
            if ($oBehavior instanceof PluginModeration_ModuleModeration_BehaviorEntity) {
                return [$oBehavior->getFields(), $oBehavior->getParam('title_field')];
            }
        }
    }
    
    public function EventAjaxPublish()
    {
        $this->Viewer_SetResponseAjax('json');
        
        $iModerationCount = $this->PluginModeration_Moderation_GetCountFromModerationByFilter([
            'entity'        => getRequest('entity'),
            'entity_id'     => getRequest('entityId')
        ]);
        
        $this->Viewer_AssignAjax('remove', 1);
        $this->Viewer_AssignAjax('countAll', $iModerationCount);
    }
    
    
    public function EventAjaxDelete()
    {
        $this->Viewer_SetResponseAjax('json');
        
           
        
        $iModerationCount = $this->PluginModeration_Moderation_GetCountFromModerationByFilter([
            'entity'        => getRequest('entity'),
            'entity_id'     => getRequest('entityId')
        ]);
        
        $this->Viewer_AssignAjax('remove', 1);
        $this->Viewer_AssignAjax('countAll', $iModerationCount);
    }
    
    public function EventAjaxDenied()
    {
        $this->Viewer_SetResponseAjax('json');
        
           
        
        $iModerationCount = $this->PluginModeration_Moderation_GetCountFromModerationByFilter([
            'entity'        => getRequest('entity'),
            'entity_id'     => getRequest('entityId')
        ]);
        
        $this->Viewer_AssignAjax('remove', 1);
        $this->Viewer_AssignAjax('countAll', $iModerationCount);
    }
    
}
