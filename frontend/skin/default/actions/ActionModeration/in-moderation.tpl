{**
 * Отзывы
 *}
{extends 'layouts/layout.base.tpl'}


{block 'layout_page_title'}
{*    <h2 class="page-header"></h2>*}
{/block}
                    
{block 'layout_content'}
    
    {component "bs-jumbotron" 
        classes   = "border border-warning bg-white"
        content = {lang "plugin.moderation.notices.in_moderation.text" label=$oBehavior->getLabel() title=$oBehavior->getTitle()}}
{/block}