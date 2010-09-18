<h2>products list</h2>

{if !$prods}
    <b>no products</b>
{else}

<table>
    <tr>
    {foreach item=prod from=$prods name=loop}
        <td valign="top">
            <a href="/index.php?id={$page_id}&shop3ox=pid:{$prod.uid}">
            {if !$prod.images.0}
            <img src="/typo3conf/ext/shop3ox/no_image.jpg" border="0" />
            {else}
            <img src="/typo3conf/ext/shop3ox/thumb.php?src=/uploads/tx_shop3ox/{$prod.images.0}" border="0" />
            {/if}
            </a><br />
            {$prod.title}<br />
            {$prod.price}{$prod.currency}<br />

            {if $ext_conf.paypal_enabled}
            <form target="paypal" action="https://www{if $ext_conf.paypal_sandbox}.sandbox{/if}.paypal.com/cgi-bin/webscr" method="post">
                <!-- Identify your business so that you can collect the payments. -->
                <input type="hidden" name="business" value="{$ext_conf.paypal_account}">

                <!-- Specify a PayPal Shopping Cart Add to Cart button. -->
                <input type="hidden" name="cmd" value="_cart">
                <input type="hidden" name="add" value="1">

                <!-- Specify details about the item that buyers will purchase. -->
                <input type="hidden" name="item_name" value="{$prod.title}">
                <input type="hidden" name="amount" value="{$prod.price}">
                <input type="hidden" name="currency_code" value="{$prod.currency_code}">

                <!-- Display the payment button. -->
                <input type="image" name="submit" border="0" src="https://www.paypal.com/en_US/i/btn/btn_cart_LG.gif" alt="PayPal - The safer, easier way to pay online">
                <img alt="" border="0" width="1" height="1" src="https://www.paypal.com/en_US/i/scr/pixel.gif" >
            </form>
            {else}
            <a href="/index.php?id={$page_id}&shop3ox=addtocart:{$prod.uid}">add to cart</a>
            {/if}
            
        </td>
    {if $smarty.foreach.loop.iteration % 5 == 0 && !$smarty.foreach.loop.last}
    </tr>
    <tr>
    {/if}
    {/foreach}
    </tr>
</table>
{/if}