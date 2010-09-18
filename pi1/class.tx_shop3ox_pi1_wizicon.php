<?php
/***************************************************************
*
*  (c) 2010 Vladimir Kizhuk <vladimir.kizhuk@gmail.com>
*  All rights reserved
*
***************************************************************/

/**
 * Class that adds the wizard icon.
 *
 * @author	Vladimir Kizhuk <vladimir.kizhuk@gmail.com>
 * @package	TYPO3
 * @subpackage	tx_shop3ox
 */
class tx_shop3ox_pi1_wizicon {

    /**
     * Processing the wizard items array
     *
     * @param	array		$wizardItems: The wizard items
     * @return	Modified array with wizard items
     */
    public function proc($wizardItems)	{
            global $LANG;

            $LL = $this->includeLocalLang();

            $wizardItems['plugins_tx_shop3ox_pi1'] = array(
                    'icon'=>t3lib_extMgm::extRelPath('shop3ox').'pi1/ce_wiz.gif',
                    'title'=>$LANG->getLLL('pi1_title',$LL),
                    'description'=>$LANG->getLLL('pi1_plus_wiz_description',$LL),
                    'params'=>'&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=shop3ox_pi1'
            );

            return $wizardItems;
    }

    /**
     * Reads the [extDir]/locallang.xml and returns the $LOCAL_LANG array found in that file.
     *
     * @return	The array with language labels
     */
    public function includeLocalLang()	{
            $llFile = t3lib_extMgm::extPath('shop3ox').'locallang.xml';
            $LOCAL_LANG = t3lib_div::readLLXMLfile($llFile, $GLOBALS['LANG']->lang);

            return $LOCAL_LANG;
    }
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/shop3ox/pi1/class.tx_shop3ox_pi1_wizicon.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/shop3ox/pi1/class.tx_shop3ox_pi1_wizicon.php']);
}

?>