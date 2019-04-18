
{foreach $aEntities as $oEntity}
    {component "moderation:entity.item" 
        sTitleField     = $sTitleField
        aModerateFields = $aModerateFields
        oEntity         = $oEntity}
{/foreach}
