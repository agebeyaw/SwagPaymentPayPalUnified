{extends file="parent:frontend/index/sidebar.tpl"}

{block name="frontend_index_left_menu"}
    {$smarty.block.parent}
    {if $paypalUnifiedShowLogo || $paypalUnifiedShowInstallmentsLogo}
        {include file="frontend/paypal_unified/index/sidebar.tpl"}
    {/if}
{/block}
