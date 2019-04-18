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
            
            $oViewer = $this->Viewer_GetLocalViewer();
            //$oViewer->GetSmartyObject()->addPluginsDir(Config::Get('path.application.server').'/classes/modules/viewer/plugs');
            $oViewer->Assign('aEntities', $aEntities);
            list($aModerationFields, $sTitleField) = $this->getModerateFileds($oEntity);
            $oViewer->Assign('aModerateFields', $aModerationFields);
            $oViewer->Assign('sTitleField', $sTitleField);
            $sHtml = $oViewer->Fetch('component@moderation:entity.list');

            $iCountAll = sizeof($aModerations);
            
            $iCount = ($iCountAll - ($iStart+$iLimit))<0?0:($iCountAll - ($iStart+$iLimit));
            
            $this->Viewer_AssignAjax('html', $sHtml);
            $this->Viewer_AssignAjax('countAll', $iCountAll);
            $this->Viewer_AssignAjax('count', $iCount);
        } 
        
        
        
    }
    
    private function getModerateFileds($oEntity) {
        $aBehaviors = $oEntity->GetBehaviors();
        foreach ($aBehaviors as $oBehavior) {            
            if ($oBehavior instanceof PluginModeration_ModuleModeration_BehaviorEntity) {
                return [$oBehavior->getFields(), $oBehavior->getParam('title_field')];
            }
        }
    }
    
    public function EventAjaxResponses()
    {
        $this->Viewer_SetResponseAjax('json');
        
        $iStart = getRequest('start', 0);
        $iLimit = getRequest('limit', Config::Get('moderation.talk.page_count'));
        
        $aFilter =  [
            '#with'         => ['user'],
            '#index-from'   => 'id',
            '#order'        => ['date_create' => 'desc'],
            '#limit'         => [ $iStart, $iLimit],
            'state in'      => ['moderate']
        ];
        
        $aMessages = $this->Talk_GetResponseItemsByFilter($aFilter);

        $oViewer = $this->Viewer_GetLocalViewer();
        $oViewer->GetSmartyObject()->addPluginsDir(Config::Get('path.application.server').'/classes/modules/viewer/plugs');
        $oViewer->Assign('items', $aMessages, true);
        $sHtml = $oViewer->Fetch('component@moderation.response-list');
        
        $iCountAll = $this->Talk_GetCountFromResponseByFilter([ 'state' => 'moderate']);
        
        $iCount = ($iCountAll - ($iStart+$iLimit))<0?0:($iCountAll - ($iStart+$iLimit));
        
        $this->Viewer_AssignAjax('html', $sHtml);
        $this->Viewer_AssignAjax('countAll', $iCountAll);
        $this->Viewer_AssignAjax('count', $iCount);
    }
    
    public function EventAjaxPublish()
    {
        $this->Viewer_SetResponseAjax('json');
        
        if(!$oResponse = $this->Talk_GetResponseByFilter(['id' => getRequest('id')])){
            $this->Message_AddError($this->Lang_Get('talk.response.notice.error_not_found'));
            return;
        }
        
        if($oResponse->getState() == 'moderate'){
            $this->Rating_Vote(
                $oResponse->getUserId(), 
                $oResponse->getTargetType(), 
                $oResponse->getTargetId(), 
                $oResponse->getRating(), 
                $oResponse->getId()
            );
        }
        
        $oResponse->setState('publish');
        
        
                
        if($oResponse->Save()){
            /*
             * Оппевещение о ппублиакции
             */
            $this->Notify_Send(
                $oResponse->getUser(),
                'response_moderate.tpl',
                $this->Lang_Get('emails.response_moderate.subject'),
                ['oResponse' => $oResponse], null, true
            );
            
            $this->Message_AddNotice($this->Lang_Get('moderation.responses.notice.success_publish'));
        }else{
            $this->Message_AddError($this->Lang_Get('common.error.error'));
            return;
        }        
        
        $this->Viewer_AssignAjax('remove', 1);
        $this->Viewer_AssignAjax('countAll', 
        $this->Talk_GetCountFromResponseByFilter([ 'state' => 'moderate']));
    }
    
    
    public function EventAjaxDelete()
    {
        $this->Viewer_SetResponseAjax('json');
        
        if(!$oResponse = $this->Talk_GetResponseByFilter(['id' => getRequest('id')])){
            $this->Message_AddError($this->Lang_Get('talk.response.notice.error_not_found'));
            return;
        }
        
        $oResponse->setState('delete');
        $oResponse->deleteVote();
                
        if($oResponse->Save()){
            /*
             * Оповещение о удалении
             */
            $this->Notify_Send(
                $oResponse->getUser(),
                'response_deleted.tpl',
                $this->Lang_Get('emails.response_deleted.subject'),
                ['oResponse' => $oResponse], null, true
            );
            
            $this->Message_AddNotice($this->Lang_Get('moderation.responses.notice.success_delete'));
        }else{
            $this->Message_AddError($this->Lang_Get('common.error.error'));
            return;
        }        
        
        $this->Viewer_AssignAjax('remove', 1);
        $this->Viewer_AssignAjax('countAll', 
        $this->Talk_GetCountFromResponseByFilter([ 'state' => 'moderate']));
    }
    
}
