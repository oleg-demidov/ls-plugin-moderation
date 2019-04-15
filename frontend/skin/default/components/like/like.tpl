
{extends "component@bs-button"}

{block 'button_options'}
    {component_define_params params=[ 'target_type', 'target_id', 'state', 'count', 'target' ]}
    
    {$icon = [icon => "thumbs-up", display => 'r', classes => 'mr-1']}
    
    {if $target}
        {$count = $target->like->getCount()}
        {$state = $target->like->getUserLike()}
        {$target_type = $target->like->getParam('target_type')}
        {$target_id = $target->getId()}
    {/if}
        
    {$attributes['data-btn-ajax'] = true}
    {$attributes['data-like'] = true}
    {$attributes['data-param-target-type'] = $target_type}
    {$attributes['data-param-target-id'] = $target_id}
    {$attributes['data-param-state'] = {$state|default:1}}
    {$attributes['data-loading-text'] = "<i class='fa fa-circle-o-notch fa-spin'></i> {$text}"}
    
    
    
    {if $state}
        {$classes = "active"}
    {/if}
    
    {if !$count}
        {$badgeClasses = "d-none"}
    {/if}

    {$badge = [
        text => {$count|default:1},
        classes => $badgeClasses,
        bmods => $bmods
    ]}
    
{/block}
