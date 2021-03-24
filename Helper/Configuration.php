<?php
/**
 * Landofcoder
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * https://landofcoder.com/license
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category   Landofcoder
 * @package    Lof_SeoHreflang
 * @copyright  Copyright (c) 2021 Landofcoder (https://landofcoder.com/)
 * @license    https://landofcoder.com/LICENSE-1.0.html
 */
namespace Lof\SeoHreflang\Helper;

class Configuration extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_CONFIGURATION_KEY = 'seo/configuration';
    const DEFAULT_HOMEPAGE_ID = 'web/default/cms_home_page';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    protected $config = null;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfigInterface
    )
    {
        parent::__construct($context);

        $this->scopeConfig = $scopeConfigInterface;
    }

    public function isEnabled()
    {
        return $this->getConfig()->getHreflangTagsEnabled();
    }

    public function getXDefaultStoreId()
    {
        return $this->getConfig()->getXDefault();
    }

    public function getHreflangScope()
    {
        return $this->getConfig()->getHreflangScope();
    }

    protected function getConfig()
    {
        if ($this->config === null) {
            $config = $this->scopeConfig->getValue(self::XML_PATH_CONFIGURATION_KEY, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            $this->config = new \Magento\Framework\DataObject($config);
        }

        return $this->config;
    }

    public function getDefaultHomepageId()
    {
        return $this->scopeConfig->getValue(self::DEFAULT_HOMEPAGE_ID, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
