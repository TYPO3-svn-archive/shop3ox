<b>cartbox</b>
<br /><br />

{if $ext_conf.paypal_enabled}

    <form target="paypal" action="https://www{if $ext_conf.paypal_sandbox}.sandbox{/if}.paypal.com/cgi-bin/webscr" method="post">
        <!-- Identify your business so that you can collect the payments. -->
        <input type="hidden" name="business" value="{$ext_conf.paypal_account}">

        <!-- Specify a PayPal Shopping Cart View Cart button. -->
        <input type="hidden" name="cmd" value="_cart">
        <input type="hidden" name="display" value="1">

        <!-- Display the View Cart button. -->
        <input type="image" name="submit" border="0" src="https://www.paypal.com/en_US/i/btn/btn_viewcart_LG.gif" alt="PayPal - The safer, easier way to pay online" />
        <img alt="" border="0" width="1" height="1" src="https://www.paypal.com/en_US/i/scr/pixel.gif" />
    </form>

{else}

    {if !$cart.products}
    <b>your cart is empty</b>
    {else}

        {foreach item=p from=$cart.products}
            <a href="/index.php?id={$page_id}&shop3ox=pid:{$p.uid}">{$p.title}</a> - {$p.price}{$p.currency} / qty: {$p.qty}<br />
        {/foreach}
        <!--
        {foreach item=t from=$cart.total key=currency}
            Total ({$currency}): {$t}<br />
        {/foreach}
        -->
    <br />
    <a href="/index.php?id={$page_id}&shop3ox=cart">go to cart</a> or <a href="#">checkout</a>
    {/if}

{/if}


<br />
<br />