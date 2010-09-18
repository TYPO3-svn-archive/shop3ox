{literal}
<script language="javascript">
function show_image(image) {
    document.getElementById('imagebox').src = image;
}
</script>
{/literal}

<h2>product</h2>

{if $product}
<table border="1">
    <tr>
        <td valign="top">
            {if !$product.images.0}
            <img src="/typo3conf/ext/shop3ox/no_image.jpg" border="0" id="imagebox" />
            {else}
            <img src="/uploads/tx_shop3ox/{$product.images.0}" border="0" id="imagebox" />
            <!--<img src="/typo3conf/ext/shop3ox/thumb.php?src=/uploads/tx_shop3ox/{$product.images.0}&w=400&h=400" border="0" id="imagebox" />-->
            {/if}
            <br /><br />
            {foreach item=image from=$product.images}
                <a href="javascript:void(0);" onclick="show_image('/uploads/tx_shop3ox/{$image}');">
                <img src="/typo3conf/ext/shop3ox/thumb.php?src=/uploads/tx_shop3ox/{$image}" border="0" />
                </a>
            {/foreach}
        </td>

        <td valign="top">
            <h3>{$product.title}</h3>
            {$product.description}<br /><br />
            
            {if $product.files.0}
            <b>additional files:</b><br />
            {foreach item=file from=$product.files}
                <a href="/uploads/tx_shop3ox/{$file}">{$file}</a><br />
            {/foreach}
            <br />
            {/if}
            
            <b>price:</b> {$product.price}{$product.currency}<br /><br />

            {if $ext_conf.paypal_enabled}
            <form target="paypal" action="https://www{if $ext_conf.paypal_sandbox}.sandbox{/if}.paypal.com/cgi-bin/webscr" method="post">
                <!-- Identify your business so that you can collect the payments. -->
                <input type="hidden" name="business" value="{$ext_conf.paypal_account}">

                <!-- Specify a PayPal Shopping Cart Add to Cart button. -->
                <input type="hidden" name="cmd" value="_cart">
                <input type="hidden" name="add" value="1">

                <!-- Specify details about the item that buyers will purchase. -->
                <input type="hidden" name="item_name" value="{$product.title}">
                <input type="hidden" name="amount" value="{$product.price}">
                <input type="hidden" name="currency_code" value="{$product.currency_code}">

                <!-- Display the payment button. -->
                <input type="image" name="submit" border="0" src="https://www.paypal.com/en_US/i/btn/btn_cart_LG.gif" alt="PayPal - The safer, easier way to pay online">
                <img alt="" border="0" width="1" height="1" src="https://www.paypal.com/en_US/i/scr/pixel.gif" >
            </form>
            {else}
            <a href="/index.php?id={$page_id}&shop3ox=addtocart:{$product.uid}">add to cart</a>
            {/if}

        </td>
    </tr>
</table>

{else}
<b>There is no product with this id.</b>
{/if}