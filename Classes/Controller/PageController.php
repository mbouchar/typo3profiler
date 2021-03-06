<?php

namespace Sng\Typo3profiler\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 CERDAN Yohann <cerdanyohann@yahoo.fr>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class PageController extends ActionController
{


    /**
     * action index
     *
     * @return void
     */
    public function indexAction()
    {
        $query = array();
        $query['SELECT'] = 'tx_typo3profiler_page.uid,pages.uid as "pageuid",pages.title as "pagetitle",parsetime,size,nocache,userint,nbqueries,logts';
        $query['FROM'] = 'tx_typo3profiler_page,pages';
        $query['WHERE'] = 'pages.uid=tx_typo3profiler_page.page';
        $query['GROUPBY'] = '';
        $query['ORDERBY'] = 'parsetime DESC';
        $query['LIMIT'] = '';
        $this->view->assign('query', $query);
    }

    /**
     * action show
     *
     * @param int $uid
     *
     * @return void
     */
    public function showAction($uid)
    {
        /** @var \TYPO3\CMS\Backend\Template\DocumentTemplate $doc */
        $doc = GeneralUtility::makeInstance('TYPO3\\CMS\\Backend\\Template\\DocumentTemplate');
        $doc->addStyleSheet('adminpanel', '/typo3/sysext/t3skin/stylesheets/standalone/admin_panel.css');
        $query['SELECT'] = 'tx_typo3profiler_page.uid,pages.uid as "pageuid",pages.title as "pagetitle",parsetime,size,nocache,userint,nbqueries,logts';
        $query['FROM'] = 'tx_typo3profiler_page,pages';
        $query['WHERE'] = 'pages.uid=tx_typo3profiler_page.page AND tx_typo3profiler_page.uid=' . intval($uid);
        $query['GROUPBY'] = '';
        $query['ORDERBY'] = '';
        $query['LIMIT'] = '';
        $res = $this->getDatabaseConnection()->exec_SELECT_queryArray($query);
        $row = $this->getDatabaseConnection()->sql_fetch_assoc($res);
        $this->getDatabaseConnection()->sql_free_result($res);
        $this->view->assign('item', $row);
    }

    /**
     * action flush
     *
     * @return void
     */
    public function flushAction()
    {
        $this->getDatabaseConnection()->exec_DELETEquery('tx_typo3profiler_page', '');
        $this->redirect('index');
    }

    /**
     * @return \TYPO3\CMS\Core\Database\DatabaseConnection
     */
    protected function getDatabaseConnection()
    {
        return $GLOBALS['TYPO3_DB'];
    }
}
