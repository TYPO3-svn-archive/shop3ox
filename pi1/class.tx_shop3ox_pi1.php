<?php
/***************************************************************
*
*  (c) 2010 Vladimir Kizhuk <vladimir.kizhuk@gmail.com>
*  All rights reserved
*
***************************************************************/

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'Shop3ox' for the 'shop3ox' extension.
 *
 * @author	Vladimir Kizhuk <vladimir.kizhuk@gmail.com>
 * @package	TYPO3
 * @subpackage	tx_shop3ox
 */
class tx_shop3ox_pi1 extends tslib_pibase {
	public $prefixId      = 'tx_shop3ox_pi1';		// Same as class name
	public $scriptRelPath = 'pi1/class.tx_shop3ox_pi1.php';	// Path to this script relative to the extension dir.
	public $extKey        = 'shop3ox';	// The extension key.
	public $pi_checkCHash = true;

        public $ccode = array('$' => 'USD', '€' => 'EUR'); // currency codes
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	public function main($content, $conf) {
            //error_reporting(E_ALL);
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();

                // get extension config
                $this->ext_conf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey]);

                $this->smarty = tx_smarty::smarty(); // smarty obj
                $this->smarty->setSmartyVar('template_dir','EXT:shop3ox/templates');
                $this->smarty->assign('page_id', $GLOBALS['TSFE']->id);
                $this->smarty->assign('ext_conf', $this->ext_conf);
                
                
                $session = $GLOBALS['TSFE']->fe_user->getKey('ses', 'tx_shop3ox');
                if(!isset($session['cart'])) {
                    $session['cart'] = array();
                    $GLOBALS['TSFE']->fe_user->setKey('ses', 'tx_shop3ox', $session);
                    $GLOBALS['TSFE']->fe_user->storeSessionData();
                }

                // get params
                $params = array('showlatest');
                if (isset($_GET['shop3ox'])) {
                    $params = explode(':', $_GET['shop3ox']);
                    if(isset($params[1])) {
                        $params[1] = intval($params[1]);
                    } else {
                        $params[1] = 0;
                    }
                }

                switch ($params[0]) {
                    case 'showlatest':
                        $content = $this->showLatestProducts(10);
                        break;
                    
                    case 'cid':
                        $content = $this->showCategory($params[1]);
                        break;

                    case 'pid':
                        $content = $this->showProduct($params[1]);
                        break;

                    case 'addtocart':
                        $content = $this->addToCart($params[1]);
                        break;

                    case 'updatecart':
                        $content = $this->updateCart();
                        break;

                    case 'cart':
                        $content = $this->showCart();
                        break;

                    default:
                        $content = $this->showLatestProducts(10);
                        break;
                }

		//return $this->pi_wrapInBaseClass($content);
                return $content;
	}

        public function showLatestProducts($limit) {
            $prods = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*', 'tx_shop3ox_products', 'deleted != 1 AND hidden != 1', null, 'uid DESC', $limit);
            $prods = $this->prepareProducts($prods);
            $this->smarty->assign('prods', $prods);
            return $this->smarty->fetch('catalog.tpl');
        }

        public function showCategory($cid) {
            $prods = array();
            $cat = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('uid', 'tx_shop3ox_categories', 'deleted != 1 AND hidden != 1 AND uid = '.$cid);
            if(!empty($cat)) {
                $pids = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('uid_local as pid', 'tx_shop3ox_products_category_mm', 'uid_foreign = '.$cat[0]['uid']);
                if(!empty($pids)) {
                    $pidset = '';
                    foreach($pids as $p) {
                        $pidset .= $p['pid'].',';
                    }
                    $pidset = substr($pidset, 0, -1);
                    $prods = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*', 'tx_shop3ox_products', 'deleted != 1 AND hidden != 1 AND uid IN ('.$pidset.')');
                    $prods = $this->prepareProducts($prods);
                }
            }

            $this->smarty->assign('prods', $prods);
            return $this->smarty->fetch('catalog.tpl');
        }

        public function showProduct($pid) {
            $product = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*', 'tx_shop3ox_products', 'deleted != 1 AND hidden != 1 AND uid = '.$pid);
            if(!empty($product)) {
                $product[0]['images'] = explode(',', $product[0]['images']);
                $product[0]['files'] = explode(',', $product[0]['files']);
                $product[0]['currency_code'] = $this->ccode[$product[0]['currency']];
            }
            
            $this->smarty->assign('product', $product[0]);
            return $this->smarty->fetch('product.tpl');
        }

        public function addToCart($pid) {
            $product = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*', 'tx_shop3ox_products', 'deleted != 1 AND hidden != 1 AND uid = '.$pid);
            $session = $GLOBALS['TSFE']->fe_user->getKey('ses', 'tx_shop3ox');
            if(!empty($product)) {
                $product[0]['images'] = explode(',', $product[0]['images']);
                $product[0]['files'] = explode(',', $product[0]['files']);
                
                
                if(isset($session['cart']['products'][$pid])) {
                    $session['cart']['products'][$pid]['qty']++;
                    $session['cart']['products'][$pid]['total'] = $session['cart']['products'][$pid]['qty'] * $session['cart']['products'][$pid]['price'];
                } else {
                    $session['cart']['products'][$pid] = $product[0];
                    $session['cart']['products'][$pid]['qty'] = 1;
                    $session['cart']['products'][$pid]['total'] = $session['cart']['products'][$pid]['price'];
                }

                // setup currency
                foreach($session['cart']['products'] as $p) {
                    $session['cart']['total'][$p['currency']] = 0;
                }

                foreach($session['cart']['products'] as $p) {
                    $session['cart']['total'][$p['currency']] += $p['total'];
                }

                $GLOBALS['TSFE']->fe_user->setKey('ses', 'tx_shop3ox', $session);
                $GLOBALS['TSFE']->fe_user->storeSessionData();
            }
            
            $this->smarty->assign('cart', $session['cart']);
            return $this->smarty->fetch('cart.tpl');
        }

        public function updateCart() {
            $data = $_POST['qty'];
            foreach($data as $pid => $qty) {
                $data[$pid] = intval($qty);
            }

            $session = $GLOBALS['TSFE']->fe_user->getKey('ses', 'tx_shop3ox');
            foreach($session['cart']['products'] as $p) {
                if($data[$p['uid']] == 0) {
                    unset($session['cart']['products'][$p['uid']]);
                    unset($session['cart']['total'][$p['currency']]);
                    continue;
                }
                $session['cart']['products'][$p['uid']]['qty'] = $data[$p['uid']];
                $session['cart']['products'][$p['uid']]['total'] = $data[$p['uid']] * $session['cart']['products'][$p['uid']]['price'];
            }

            // setup currency
            foreach($session['cart']['products'] as $p) {
                $session['cart']['total'][$p['currency']] = 0;
            }

            foreach($session['cart']['products'] as $p) {
                $session['cart']['total'][$p['currency']] += $p['total'];
            }

            $GLOBALS['TSFE']->fe_user->setKey('ses', 'tx_shop3ox', $session);
            $GLOBALS['TSFE']->fe_user->storeSessionData();
            $this->smarty->assign('cart', $session['cart']);
            return $this->smarty->fetch('cart.tpl');
        }

        public function showCart() {
            $session = $GLOBALS['TSFE']->fe_user->getKey('ses', 'tx_shop3ox');
            if(!isset($session['cart'])) {
                $session['cart'] = array();
            }

            $this->smarty->assign('cart', $session['cart']);
            return $this->smarty->fetch('cart.tpl');
        }

        public function prepareProducts($prods) {
            
            foreach ($prods as $key => $prod) {
                $prods[$key]['images'] = explode(',', $prod['images']);
                $prods[$key]['currency_code'] = $this->ccode[$prod['currency']];
            }
            return $prods;
        }
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/shop3ox/pi1/class.tx_shop3ox_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/shop3ox/pi1/class.tx_shop3ox_pi1.php']);
}

?>