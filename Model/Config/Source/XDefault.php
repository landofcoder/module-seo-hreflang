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
namespace Lof\SeoHreflang\Model\Config\Source;

class XDefault implements \Magento\Framework\Option\ArrayInterface
{

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        $this->storeManager = $storeManager;
    }

    public function toOptionArray()
    {
        $options = [['label' => __('None'), 'value' => '-1']];

        $stores = $this->storeManager->getStores();
        foreach ($stores as $store) {
            $websiteName = $store->getWebsite()->getName();
            $storeName = $store->getName();
            $storeCode = $store->getCode();
            $storeId = $store->getStoreId();

            $value = $websiteName . " | " . $storeName . " (code: " . $storeCode . " | ID: " . $storeId . ")";

            $options[] = ['label' => $value, 'value' => $storeId];
        }

        return $options;
    }
}