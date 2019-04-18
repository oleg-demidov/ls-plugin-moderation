

{component_define_params params=[ 'oEntity', 'aModerateFields', 'sTitleField']}

<div class="row mt-3">
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


    {component "bs-modal" 
        header      = {lang "plugin.moderation.list.title" entity=$oEntity->_getDataOne($sTitleField)}
        bmods       = "lg" 
        centered    = true 
        content     = $smarty.capture.contentEntity
        id          = $id
    }
    
    <div class="col-2 col-lg"></div>
</div>