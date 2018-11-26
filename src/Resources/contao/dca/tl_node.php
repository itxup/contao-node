<?php

/*
 * Node Bundle for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2018, terminal42 gmbh
 * @author     terminal42 <https://terminal42.ch>
 * @license    MIT
 */

$GLOBALS['TL_DCA']['tl_node'] = [
    // Config
    'config' => [
        'label' => &$GLOBALS['TL_LANG']['MOD']['nodes'][0],
        'dataContainer' => 'Table',
        'enableVersioning' => true,
        'markAsCopy' => 'name',
        'onload_callback' => [
            ['terminal42_node.listener.data_container', 'onLoadCallback'],
        ],
        'sql' => [
            'keys' => [
                'id' => 'primary',
                'pid,type,languages' => 'index',
            ],
        ],
    ],

    // List
    'list' => [
        'sorting' => [
            'mode' => 5,
            'icon' => 'filemanager.svg', // @todo
            'paste_button_callback' => ['terminal42_node.listener.data_container', 'onPasteButtonCallback'],
            'panelLayout' => 'filter;search',
        ],
        'label' => [
            'fields' => ['name'],
            'format' => '%s',
            'label_callback' => ['terminal42_node.listener.data_container', 'onLabelCallback'],
        ],
        'global_operations' => [
            'toggleNodes' => [
                'label' => &$GLOBALS['TL_LANG']['MSC']['toggleAll'],
                'href' => 'ptg=all',
                'class' => 'header_toggle',
                'showOnSelect' => true,
            ],
            'all' => [
                'label' => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href' => 'act=select',
                'class' => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"',
            ],
        ],
        'operations' => [
            'edit' => [
                'label' => &$GLOBALS['TL_LANG']['tl_node']['edit'],
                'href' => 'table=tl_content',
                'icon' => 'edit.svg',
                'button_callback' => ['terminal42_node.listener.data_container', 'onEditButtonCallback'],
            ],
            'editheader' => [
                'label' => &$GLOBALS['TL_LANG']['tl_node']['editheader'],
                'href' => 'act=edit',
                'icon' => 'header.svg',
            ],
            'copy' => [
                'label' => &$GLOBALS['TL_LANG']['tl_node']['copy'],
                'href' => 'act=paste&amp;mode=copy',
                'icon' => 'copy.svg',
                'attributes' => 'onclick="Backend.getScrollOffset()"',
            ],
            'copyChilds' => [
                'label' => &$GLOBALS['TL_LANG']['tl_node']['copyChilds'],
                'href' => 'act=paste&amp;mode=copy&amp;childs=1',
                'icon' => 'copychilds.svg',
                'attributes' => 'onclick="Backend.getScrollOffset()"',
            ],
            'cut' => [
                'label' => &$GLOBALS['TL_LANG']['tl_node']['cut'],
                'href' => 'act=paste&amp;mode=cut',
                'icon' => 'cut.svg',
                'attributes' => 'onclick="Backend.getScrollOffset()"',
            ],
            'delete' => [
                'label' => &$GLOBALS['TL_LANG']['tl_node']['delete'],
                'href' => 'act=delete',
                'icon' => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\''.$GLOBALS['TL_LANG']['MSC']['deleteConfirm'].'\'))return false;Backend.getScrollOffset()"',
            ],
            'show' => [
                'label' => &$GLOBALS['TL_LANG']['tl_node']['show'],
                'href' => 'act=show',
                'icon' => 'show.svg',
            ],
        ],
    ],

    // Palettes
    'palettes' => [
        'default' => '{name_legend},name,type;{filter_legend},languages',
    ],

    // Fields
    'fields' => [
        'id' => [
            'sql' => ['type' => 'integer', 'unsigned' => true, 'autoincrement' => true],
        ],
        'pid' => [
            'label' => &$GLOBALS['TL_LANG']['tl_node']['pid'],
            'foreignKey' => 'tl_node.name',
            'sql' => ['type' => 'integer', 'unsigned' => true, 'default' => 0],
        ],
        'sorting' => [
            'sql' => ['type' => 'integer', 'unsigned' => true, 'default' => 0],
        ],
        'tstamp' => [
            'label' => &$GLOBALS['TL_LANG']['tl_node']['tstamp'],
            'sql' => ['type' => 'integer', 'unsigned' => true, 'default' => 0],
        ],
        'name' => [
            'label' => &$GLOBALS['TL_LANG']['tl_node']['name'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
            'sql' => ['type' => 'string', 'length' => 255, 'default' => ''],
        ],
        'type' => [
            'label' => &$GLOBALS['TL_LANG']['tl_node']['type'],
            'exclude' => true,
            'filter' => true,
            'inputType' => 'select',
            'options' => [
                \Terminal42\NodeBundle\Model\NodeModel::TYPE_CONTENT,
                \Terminal42\NodeBundle\Model\NodeModel::TYPE_FOLDER,
            ],
            'reference' => &$GLOBALS['TL_LANG']['tl_node']['typeRef'],
            'eval' => ['submitOnChange' => true, 'tl_class' => 'w50'],
            'sql' => ['type' => 'string', 'length' => 7, 'default' => ''],
        ],
        'languages' => [
            'label' => &$GLOBALS['TL_LANG']['tl_node']['languages'],
            'exclude' => true,
            'filter' => true,
            'inputType' => 'select',
            'options_callback' => ['terminal42_node.listener.data_container', 'onLanguagesOptionsCallback'],
            'eval' => ['multiple' => true, 'chosen' => true, 'csv' => ',', 'tl_class' => 'clr'],
            'sql' => ['type' => 'string', 'length' => 255, 'default' => ''],
        ],
    ],
];
