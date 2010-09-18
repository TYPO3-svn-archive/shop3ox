<?php
/***************************************************************
*
*  (c) 2010 Vladimir Kizhuk <vladimir.kizhuk@gmail.com>
*  All rights reserved
*
***************************************************************/


$LANG->includeLLFile('EXT:shop3ox/mod1/locallang.xml');
require_once(PATH_t3lib . 'class.t3lib_scbase.php');
$BE_USER->modAccess($MCONF,1);	// This checks permissions and exits if the users has no permission for entry.
	// DEFAULT initialization of a module [END]



/**
 * Module 'Shop3ox' for the 'shop3ox' extension.
 *
 * @author	Vladimir Kizhuk <vladimir.kizhuk@gmail.com>
 * @package	TYPO3
 * @subpackage	tx_shop3ox
 */
class  tx_shop3ox_module1 extends t3lib_SCbase {
    public $pageinfo;

    /**
     * Initializes the Module
     * @return	void
     */
    public function init()	{
            global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;

            parent::init();

            /*
            if (t3lib_div::_GP('clear_all_cache'))	{
                    $this->include_once[] = PATH_t3lib.'class.t3lib_tcemain.php';
            }
            */
    }

    /**
     * Adds items to the ->MOD_MENU array. Used for the function menu selector.
     *
     * @return	void
     */
    public function menuConfig()	{
            global $LANG;
            $this->MOD_MENU = Array (
                    'function' => Array (
                            '1' => $LANG->getLL('function1'),
                            '2' => $LANG->getLL('function2'),
                            '3' => $LANG->getLL('function3'),
                    )
            );
            parent::menuConfig();
    }

    /**
     * Main function of the module. Write the content to $this->content
     * If you chose "web" as main module, you will need to consider the $this->id parameter which will contain the uid-number of the page clicked in the page tree
     *
     * @return	[type]		...
     */
    public function main()	{
            global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;

            // Access check!
            // The page will show only if there is a valid page and if this page may be viewed by the user
            $this->pageinfo = t3lib_BEfunc::readPageAccess($this->id,$this->perms_clause);
            $access = is_array($this->pageinfo) ? 1 : 0;

            if (($this->id && $access) || ($BE_USER->user['admin'] && !$this->id))	{

                            // Draw the header.
                    $this->doc = t3lib_div::makeInstance('mediumDoc');
                    $this->doc->backPath = $BACK_PATH;
                    $this->doc->form='<form action="" method="post" enctype="multipart/form-data">';

                            // JavaScript
                    $this->doc->JScode = '
                            <script language="javascript" type="text/javascript">
                                    script_ended = 0;
                                    function jumpToUrl(URL)	{
                                            document.location = URL;
                                    }
                            </script>
                    ';
                    $this->doc->postCode='
                            <script language="javascript" type="text/javascript">
                                    script_ended = 1;
                                    if (top.fsMod) top.fsMod.recentIds["web"] = 0;
                            </script>
                    ';

                    $headerSection = $this->doc->getHeader('pages',$this->pageinfo,$this->pageinfo['_thePath']).'<br />'.$LANG->sL('LLL:EXT:lang/locallang_core.xml:labels.path').': '.t3lib_div::fixed_lgd_pre($this->pageinfo['_thePath'],50);

                    $this->content.=$this->doc->startPage($LANG->getLL('title'));
                    $this->content.=$this->doc->header($LANG->getLL('title'));
                    $this->content.=$this->doc->spacer(5);
                    $this->content.=$this->doc->section('',$this->doc->funcMenu($headerSection,t3lib_BEfunc::getFuncMenu($this->id,'SET[function]',$this->MOD_SETTINGS['function'],$this->MOD_MENU['function'])));
                    $this->content.=$this->doc->divider(5);


                    // Render content:
                    $this->moduleContent();


                    // ShortCut
                    if ($BE_USER->mayMakeShortcut())	{
                            $this->content.=$this->doc->spacer(20).$this->doc->section('',$this->doc->makeShortcutIcon('id',implode(',',array_keys($this->MOD_MENU)),$this->MCONF['name']));
                    }

                    $this->content.=$this->doc->spacer(10);
            } else {
                            // If no access or if ID == zero

                    $this->doc = t3lib_div::makeInstance('mediumDoc');
                    $this->doc->backPath = $BACK_PATH;

                    $this->content.=$this->doc->startPage($LANG->getLL('title'));
                    $this->content.=$this->doc->header($LANG->getLL('title'));
                    $this->content.=$this->doc->spacer(5);
                    $this->content.=$this->doc->spacer(10);
            }

    }

    /**
     * Prints out the module HTML
     *
     * @return	void
     */
    public function printContent()	{

            $this->content.=$this->doc->endPage();
            echo $this->content;
    }

    /**
     * Generates the module content
     *
     * @return	void
     */
    public function moduleContent()	{
            switch((string)$this->MOD_SETTINGS['function'])	{
                    case 1:
                            $content='<div align="center"><strong>Hello World!</strong></div><br />
                                    The "Kickstarter" has made this module automatically, it contains a default framework for a backend module but apart from that it does nothing useful until you open the script '.substr(t3lib_extMgm::extPath('shop3ox'),strlen(PATH_site)).'mod1/index.php and edit it!
                                    <hr />
                                    <br />This is the GET/POST vars sent to the script:<br />'.
                                    'GET:'.t3lib_div::view_array($_GET).'<br />'.
                                    'POST:'.t3lib_div::view_array($_POST).'<br />'.
                                    '';
                            $this->content.=$this->doc->section('Message #1:',$content,0,1);
                    break;
                    case 2:
                            $content='<div align=center><strong>Menu item #2...</strong></div>';
                            $this->content.=$this->doc->section('Message #2:',$content,0,1);
                    break;
                    case 3:
                            $content='<div align=center><strong>Menu item #3...</strong></div>';
                            $this->content.=$this->doc->section('Message #3:',$content,0,1);
                    break;
            }
    }

}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/shop3ox/mod1/index.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/shop3ox/mod1/index.php']);
}




// Make instance:
$SOBE = t3lib_div::makeInstance('tx_shop3ox_module1');
$SOBE->init();

// Include files?
foreach($SOBE->include_once as $INC_FILE)	include_once($INC_FILE);

$SOBE->main();
$SOBE->printContent();

?>