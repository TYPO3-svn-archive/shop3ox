{literal}
<script type="text/javascript">
function delete_product(pid) {
    document.getElementById('p'+pid).value = 0;
    document.getElementById('cartform').submit();
}
</script>
{/literal}

<b>cart</b><br /><br />

{if !$cart.products}
<b>empty</b>
{else}
<form id="cartform" action="/index.php?id={$page_id}&shop3ox=updatecart" method="POST">
    {foreach item=p from=$cart.products}
        <a href="/index.php?id={$page_id}&shop3ox=pid:{$p.uid}">{$p.title}</a> - {$p.price}{$p.currency} / qty: <input type="text" name="qty[{$p.uid}]" id="p{$p.uid}" value="{$p.qty}" size="2" />
        <a href="javascript:void(0);" onclick="delete_product({$p.uid});">delete</a><br />
    {/foreach}
    <input type="submit" value="Update" />
</form>
    <br /><br />
    {foreach item=t from=$cart.total key=currency}
        Total ({$currency}): {$t}<br />
    {/foreach}

<br />
<a href="/index.php?id={$page_id}">continue shopping</a> or go to <a href="#">checkout</a>
{/if}


<br />
<br />