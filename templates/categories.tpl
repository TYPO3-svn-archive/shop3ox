<b>categories</b><br />
{if !$categories}
<b>no categories</b>
{else}
    {foreach item=c from=$categories}
        <a href="/index.php?id={$page_id}&shop3ox=cid:{$c.uid}">{$c.name}</a><br />
    {/foreach}
{/if}

<hr>