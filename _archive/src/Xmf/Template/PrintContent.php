<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace Xmf\Template;

/**
 * PrintContent implements a simple page layout suited to printing
 *
 * @category  Xmf\Template\Breadcrumb
 * @package   Xmf
 * @author    trabis <lusopoemas@gmail.com>
 * @author    The SmartFactory <www.smartfactory.ca>
 * @copyright 2011-2018 XOOPS Project (https://xoops.org)
 * @license   GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @version   Release: 1.0
 * @link      https://xoops.org
 * @since     1.0
 */
class PrintContent extends AbstractTemplate
{
    /**
     * @var string
     */
    private $title = '';

    /**
     * @var string
     */
    private $description = '';

    /**
     * @var string
     */
    private $content = '';

    /**
     * @var bool
     */
    private $pagetitle = false;

    /**
     * @var int
     */
    private $width = 680;

    /**
     * init - called by parent::_construct
     *
     * @return void
     */
    protected function init()
    {
        $this->setTemplate(XMF_ROOT_PATH . '/templates/xmf_print.tpl');
    }

    /**
     * Render the print template
     *
     * @return void
     */
    protected function render()
    {
        $this->tpl->assign('xmf_print_pageTitle', $this->pagetitle ? $this->pagetitle : $this->title);
        $this->tpl->assign('xmf_print_title', $this->title);
        $this->tpl->assign('xmf_print_description', $this->description);
        $this->tpl->assign('xmf_print_content', $this->content);
        $this->tpl->assign('xmf_print_width', $this->width);
    }

    /**
     * setContent
     *
     * @param string $content page content
     *
     * @return PrintContent
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * getContent
     *
     * @return string page content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * setDescription
     *
     * @param string $description page description
     *
     * @return PrintContent
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * getDescription
     *
     * @return string page description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * setPagetitle
     *
     * @param boolean $pagetitle use page title
     *
     * @return PrintContent
     */
    public function setPagetitle($pagetitle)
    {
        $this->pagetitle = $pagetitle;
        return $this;
    }

    /**
     * getPagetitle
     *
     * @return boolean use page title
     */
    public function getPagetitle()
    {
        return $this->pagetitle;
    }

    /**
     * setTitle
     *
     * @param string $title page title
     *
     * @return PrintContent
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * getTitle
     *
     * @return string page title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * setWidth
     *
     * @param int $width page width in pixels
     *
     * @return PrintContent
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * getWidth
     *
     * @return int page width in pixels
     */
    public function getWidth()
    {
        return $this->width;
    }
}
