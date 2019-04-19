{**
 * Отзывы
 *}
{extends 'layouts/layout.base.tpl'}


{block 'layout_page_title'}
    <h2 class="page-header">{lang "plugin.moderation.list.title" entity=$sEntityName}</h2>
{/block}
                    
{block 'layout_content'}

    {component "bs-nav" 
        activeItem = $sState
        bmods = "tabs"
        items = [
            [ 
                url => {router page="{$sModerationAction}/list/{$sEntityClass}/moderation"},
                text => $aLang.plugin.moderation.list.nav.moderation,
                name => 'moderation',
                count => $countModeration
            ],
            [ 
                url => {router page="{$sModerationAction}/list/{$sEntityClass}/denied"},
                text => $aLang.plugin.moderation.list.nav.denied,
                name => 'denied',
                count => $countDenied
            ]
        ]}
        
    {component "ajax.list" 
        classes = "mt-2"
        attributes  = [
            'data-param-entity' => $sEntityClass,
            'data-param-state'  => $sState
        ]
        url     = {router page="{$sModerationAction}/ajax-list"} 
        limit   = Config::Get('moderation.talk.page_count')
        counterSelector="[data-count-moderation]"}
{/block}