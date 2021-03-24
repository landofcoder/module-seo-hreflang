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

class HreflangScope implements \Magento\Framework\Option\ArrayInterface
{
    const GLOBAL = 'global';
    const STOREGROUP = 'storegroup';

    public function toOptionArray()
    {
        return [self::GLOBAL => __('Global'), self::STOREGROUP => __('Store Group')];
    }
}