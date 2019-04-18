
{if $aEntities}
    <div class="row mt-3">
        <div class="col-1">{$aLang.plugin.moderation.list.cols.number}</div>
        <div class="col">{$aLang.plugin.moderation.list.cols.title}</div>
        <div class="col-2 col-lg"></div>
    </div>
{else}
    {component "blankslate" text=$aLang.plugin.moderation.list.blankslate.text}
{/if}



{foreach $aEntities as $oEntity}
    {component "moderation:entity.item" 
        sTitleField     = $sTitleField
        aModerateFields = $aModerateFields
        oEntity         = $oEntity}
{/foreach}
