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
namespace Lof\SeoHreflang\Block;

class Hreflang extends \Magento\Framework\View\Element\Template
{
    protected $_template = 'Lof_SeoHreflang::hreflang.phtml';

    const X_DEFAULT = 'x-default';
    const QUERY_SEPARATOR = '&amp;';

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * @var \Lof\SeoHreflang\Helper\Configuration
     */
    protected $configuration;

    /**
     * @var \Lof\SeoHreflang\Model\EntityPool
     */
    protected $entityPool;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\App\RequestInterface $request,
        \Lof\SeoHreflang\Helper\Configuration $configuration,
        \Lof\SeoHreflang\Model\EntityPool $entityPool,
        array $data = []
    )
    {
        parent::__construct($context, $data);

        $this->storeManager = $storeManager;
        $this->urlBuilder = $urlBuilder;
        $this->request = $request;
        $this->configuration = $configuration;
        $this->entityPool = $entityPool;
    }

    public function getAlternateLinks()
    {
        $alternateLinks = [];

        /** @var \Lof\SeoHreflang\Model\Entity\EntityInterface $entity */
        $entity = $this->entityPool->getEntity();

        if (empty($entity)) {
            return $alternateLinks;
        }

        $stores = $this->getStores();
        foreach ($stores as $store) {
            if (!$entity->isActive($store)) {
                continue;
            }

            $alternateLink = $this->getAlternateLink($entity, $store);

            if (empty($alternateLink)) {
                continue;
            }

            $alternateLinks[$store->getId()] = $alternateLink;
        }

        $this->addXDefaultUrl($alternateLinks);

        return $alternateLinks;
    }

    public function isEnabled()
    {
        return $this->configuration->isEnabled();
    }

    protected function getStores()
    {
        if ($this->configuration->getHreflangScope() === \Lof\SeoHreflang\Model\Config\Source\HreflangScope::GLOBAL) {
            return $this->storeManager->getStores();
        } else {
            return $this->storeManager->getGroup()->getStores();
        }
    }

    protected function getAlternateLink(\Lof\SeoHreflang\Model\Entity\EntityInterface $entity, $store)
    {
        $url = $entity->getUrl($store);

        if (empty($url)) {
            return null;
        }

        $url = $this->addQueryToUrl($url);

        $alternateLink = [
            'url' => $url,
            'code' => $this->getHreflangCode($store)
        ];

        return new \Magento\Framework\DataObject($alternateLink);
    }

    /**
     * It is required that language and region codes are separated by dash "-"
     * instead of underscore "_" which Magento returns.
     *
     * @param \Magento\Store\Model\Store $store
     * @return string
     */
    protected function getHreflangCode($store)
    {
        return $store->getHreflangCode() ? $store->getHreflangCode() : str_replace('_', '-', $store->getCode());
    }

    protected function addXDefaultUrl(&$alternateLinks)
    {
        $xDefaultStoreId = $this->configuration->getXDefaultStoreId();

        if ($xDefaultStoreId < 0) {
            return;
        }

        if (!isset($alternateLinks[$xDefaultStoreId])) {
            return;
        }

        $xDefaultLink = clone $alternateLinks[$xDefaultStoreId];
        $xDefaultLink->setCode(self::X_DEFAULT);

        $alternateLinks[self::X_DEFAULT] = $xDefaultLink;
    }

    public function addQueryToUrl($url)
    {
        $queryValue = $this->request->getQueryValue();

        if (empty($queryValue)) {
            return $url;
        }

        $query = http_build_query($queryValue, '', self::QUERY_SEPARATOR);

        $splitedUrl = parse_url($url);

        $rawUrl = $splitedUrl['scheme'] . '://' . $splitedUrl['host'] . $splitedUrl['path'];

        $urlWithQuery = sprintf('%s?%s', $rawUrl, $query);

        $url = $this->urlBuilder->getUrl($urlWithQuery);
        $url = trim($url, '/');

        return $url;
    }
}
