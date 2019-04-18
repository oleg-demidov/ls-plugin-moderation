{**
 * Отзывы
 *}
{extends 'layouts/layout.base.tpl'}


{block 'layout_page_title'}
    <h2 class="page-header">{lang "plugin.moderation.list.title" entity=$sEntityName}</h2>
{/block}
                    
{block 'layout_content'}
    <div class="row mt-3">
        <div class="col-1">{$aLang.plugin.moderation.list.cols.number}</div>
        
        <div class="col">{$aLang.plugin.moderation.list.cols.title}</div>
        {*{foreach $aModerateFields as $field}
            <div class="col">{$field}</div>
        {/foreach}*}

        <div class="col-2 col-lg"></div>
    </div>
        
    {component "ajax.list" 
        attributes  = [
            'data-param-entity' => $sEntityClass
        ]
        url     = {router page="{$sModerationAction}/ajax-list"} 
        limit   = Config::Get('moderation.talk.page_count')
        counterSelector="[data-count-moderation]"}
{/block}