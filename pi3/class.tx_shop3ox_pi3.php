<?php
/***************************************************************
*
*  (c) 2010 Vladimir Kizhuk <vladimir.kizhuk@gmail.com>
*  All rights reserved
*
***************************************************************/

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'Shop3ox Categories' for the 'shop3ox' extension.
 *
 * @author	Vladimir Kizhuk <vladimir.kizhuk@gmail.com>
 * @package	TYPO3
 * @subpackage	tx_shop3ox
 */
class tx_shop3ox_pi3 extends tslib_pibase {
	public $prefixId      = 'tx_shop3ox_pi3';		// Same as class name
	public $scriptRelPath = 'pi3/class.tx_shop3ox_pi3.php';	// Path to this script relative to the extension dir.
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

                $this->smarty = tx_smarty::smarty(); // smarty obj
                $this->smarty->setSmartyVar('template_dir','EXT:shop3ox/templates');
                //$this->smarty->setSmartyVar('error_reporting ', E_ALL);
                $this->smarty->assign('page_id', $GLOBALS['TSFE']->id);

                $categories = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('uid, name', 'tx_shop3ox_categories', 'deleted != 1 AND hidden != 1');
                
                $this->smarty->assign('categories', $categories);
                return $this->smarty->fetch('categories.tpl');
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/shop3ox/pi3/class.tx_shop3ox_pi3.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/shop3ox/pi3/class.tx_shop3ox_pi3.php']);
}

?>