{**
 * Отзывы
 *}
{extends 'layouts/layout.base.tpl'}


{block 'layout_page_title'}
    <h2 class="page-header">{lang "plugin.moderation.list.title" entity=$sEntityName}</h2>
{/block}
                    
{block 'layout_content'}
    
        
    {component "ajax.list" 
        attributes  = [
            'data-param-entity' => $sEntityClass
        ]
        url     = {router page="{$sModerationAction}/ajax-list"} 
        limit   = Config::Get('moderation.talk.page_count')
        counterSelector="[data-count-moderation]"}
{/block}