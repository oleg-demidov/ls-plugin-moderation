

{component_define_params params=[ 'oEntity', 'aModerateFields', 'sTitleField']}

<div class="row mt-3">
    <div class="col-1">{$oEntity->_getPrimaryKeyValue()}</div>

    <div class="col">{$oEntity->_getDataOne($sTitleField)}</div>
    {*{foreach $aModerateFields as $field}
        <div class="col">{$oEntity->_getDataOne($field)}</div>
    {/foreach}*}

    <div class="col-2 col-lg"></div>
</div>