

{component_define_params params=[ 'oEntity', 'aModerateFields', 'sTitleField']}

<div class="row mt-3 entity-item">
    <div class="col-1">{$oEntity->_getPrimaryKeyValue()}</div>

    <div class="col">
        {$id = "entity{$oEntity->_getPrimaryKeyValue()}"}
        {component "bs-button" 
            com         = "link"
            url         = "#"
            text        = $oEntity->_getDataOne($sTitleField)
            bmods       = "success" 
            attributes  = [ "data-toggle" => "modal", "data-target" => "#{$id}" ]}
    </div>
    
    {capture name="contentEntity"}
        {foreach $aModerateFields as $field}
            <div>{$field}:</div>
            <div class="ml-3">{$oEntity->_getDataOne($field)}</div>
            <hr>
        {/foreach}
    {/capture}
    
    {capture name="footerEntity"}
        
        {component "bs-button"
            text        = $aLang.plugin.moderation.actions.publish 
            bmods       = "success"
            icon        = "check"
            attributes = [
                'data-param-id' => $oEntity->getId(),
                'data-ajax-btn' => "true",
                'data-url'  => {router page="moderation/ajax-publish"},
                'data-item-selector'  => '.entity-item'
            ]
        }
        
        {component "bs-button"
            text    = $aLang.plugin.moderation.actions.denied 
            icon    = "ban"
            bmods   = "warning"
            attributes = [
                'data-param-id' => $oEntity->getId(),
                'data-ajax-btn' => "true",
                'data-confirm'  => "true",
                'data-confirm-message'  => $aLang.moderation.responses.notice.confirm_publish,
                'data-url'  => {router page="moderation/ajax-denied"},
                'data-item-selector'  => '.response-item'
            ]
        }
        
        {component "bs-button"
            text    = $aLang.plugin.moderation.actions.delete 
            icon    = "trash-alt"
            bmods   = "danger"
            attributes = [
                'data-param-id' => $oEntity->getId(),
                'data-ajax-btn' => "true",
                'data-confirm'  => "true",
                'data-confirm-message'  => $aLang.moderation.responses.notice.confirm_delete,
                'data-url'  => {router page="moderation/ajax-delete"},
                'data-item-selector'  => '.response-item'
            ]
        }
       
    {/capture}



    {component "bs-modal" 
        header      = {lang "plugin.moderation.list.title" entity=$oEntity->_getDataOne($sTitleField)}
        bmods       = "lg" 
        centered    = true 
        content     = $smarty.capture.contentEntity
        footer      = $smarty.capture.footerEntity
        id          = $id
    }
    
    <div class="col-2 col-lg"></div>
</div>