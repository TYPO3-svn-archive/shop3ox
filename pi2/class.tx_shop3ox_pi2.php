<?php
/***************************************************************
*
*  (c) 2010 Vladimir Kizhuk <vladimir.kizhuk@gmail.com>
*  All rights reserved
*
***************************************************************/

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'Shop3ox Cart' for the 'shop3ox' extension.
 *
 * @author	Vladimir Kizhuk <vladimir.kizhuk@gmail.com>
 * @package	TYPO3
 * @subpackage	tx_shop3ox
 */
class tx_shop3ox_pi2 extends tslib_pibase {
	public $prefixId      = 'tx_shop3ox_pi2';		// Same as class name
	public $scriptRelPath = 'pi2/class.tx_shop3ox_pi2.php';	// Path to this script relative to the extension dir.
	public $extKey        = 'shop3ox';	// The extension key.
	public $pi_checkCHash = true;
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	public function main($content, $conf) {
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
        }

        $this->smarty->assign('cart', $session['cart']);
        return $this->smarty->fetch('cartbox.tpl');
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/shop3ox/pi2/class.tx_shop3ox_pi2.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/shop3ox/pi2/class.tx_shop3ox_pi2.php']);
}

?>