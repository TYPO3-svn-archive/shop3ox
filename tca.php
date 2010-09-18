<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_shop3ox_categories'] = array (
	'ctrl' => $TCA['tx_shop3ox_categories']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,starttime,endtime,fe_group,name'
	),
	'feInterface' => $TCA['tx_shop3ox_categories']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'starttime' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'default'  => '0',
				'checkbox' => '0'
			)
		),
		'endtime' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'checkbox' => '0',
				'default'  => '0',
				'range'    => array (
					'upper' => mktime(3, 14, 7, 1, 19, 2038),
					'lower' => mktime(0, 0, 0, date('m')-1, date('d'), date('Y'))
				)
			)
		),
		'fe_group' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',
			'config'  => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
					array('LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.any_login', -2),
					array('LLL:EXT:lang/locallang_general.xml:LGL.usergroups', '--div--')
				),
				'foreign_table' => 'fe_groups'
			)
		),
		'name' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:shop3ox/locallang_db.xml:tx_shop3ox_categories.name',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required,trim',
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, name')
	),
	'palettes' => array (
		'1' => array('showitem' => 'starttime, endtime, fe_group')
	)
);



$TCA['tx_shop3ox_products'] = array (
	'ctrl' => $TCA['tx_shop3ox_products']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,starttime,endtime,fe_group,title,description,price,currency,images,files,category'
	),
	'feInterface' => $TCA['tx_shop3ox_products']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'starttime' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'default'  => '0',
				'checkbox' => '0'
			)
		),
		'endtime' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'checkbox' => '0',
				'default'  => '0',
				'range'    => array (
					'upper' => mktime(3, 14, 7, 1, 19, 2038),
					'lower' => mktime(0, 0, 0, date('m')-1, date('d'), date('Y'))
				)
			)
		),
		'fe_group' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',
			'config'  => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
					array('LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.any_login', -2),
					array('LLL:EXT:lang/locallang_general.xml:LGL.usergroups', '--div--')
				),
				'foreign_table' => 'fe_groups'
			)
		),
		'title' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:shop3ox/locallang_db.xml:tx_shop3ox_products.title',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required,trim',
			)
		),
		'description' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:shop3ox/locallang_db.xml:tx_shop3ox_products.description',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',
				'rows' => '5',
				'wizards' => array(
					'_PADDING' => 2,
					'RTE' => array(
						'notNewRecords' => 1,
						'RTEonly'       => 1,
						'type'          => 'script',
						'title'         => 'Full screen Rich Text Editing|Formatteret redigering i hele vinduet',
						'icon'          => 'wizard_rte2.gif',
						'script'        => 'wizard_rte.php',
					),
				),
			)
		),
		'price' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:shop3ox/locallang_db.xml:tx_shop3ox_products.price',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'double2,nospace',
			)
		),
		'currency' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:shop3ox/locallang_db.xml:tx_shop3ox_products.currency',		
			'config' => array (
				'type' => 'select',
				'items' => array (
					array('LLL:EXT:shop3ox/locallang_db.xml:tx_shop3ox_products.currency.I.0', '$'),
					array('LLL:EXT:shop3ox/locallang_db.xml:tx_shop3ox_products.currency.I.1', '€'),
				),
				'size' => 1,	
				'maxitems' => 1,
			)
		),
		'images' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:shop3ox/locallang_db.xml:tx_shop3ox_products.images',		
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => 'gif,png,jpeg,jpg',	
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],	
				'uploadfolder' => 'uploads/tx_shop3ox',
				'show_thumbs' => 1,	
				'size' => 10,	
				'minitems' => 0,
				'maxitems' => 10,
			)
		),
		'files' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:shop3ox/locallang_db.xml:tx_shop3ox_products.files',		
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => '',	
				'disallowed' => 'php,php3',	
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],	
				'uploadfolder' => 'uploads/tx_shop3ox',
				'size' => 10,	
				'minitems' => 0,
				'maxitems' => 10,
			)
		),
		'category' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:shop3ox/locallang_db.xml:tx_shop3ox_products.category',		
			'config' => array (
				'type' => 'group',	
				'internal_type' => 'db',	
				'allowed' => 'tx_shop3ox_categories',	
				'size' => 10,	
				'minitems' => 0,
				'maxitems' => 10,	
				"MM" => "tx_shop3ox_products_category_mm",
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, title;;;;2-2-2, description;;;richtext[]:rte_transform[mode=ts];3-3-3, price, currency, images, files, category')
	),
	'palettes' => array (
		'1' => array('showitem' => 'starttime, endtime, fe_group')
	)
);
?>