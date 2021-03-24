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
namespace Lof\SeoHreflang\Block\System\Store\Edit\Form;

class Store extends \Magento\Backend\Block\System\Store\Edit\Form\Store
{
    /**
     * Prepare store specific fieldset
     *
     * @param \Magento\Framework\Data\Form $form
     * @return void
     */
    protected function _prepareStoreFieldset(\Magento\Framework\Data\Form $form)
    {
        parent::_prepareStoreFieldset($form);

        $fieldset = $form->getForm()->getElement('store_fieldset');

        $storeModel = $this->_coreRegistry->registry('store_data');
        
        $fieldset->addField(
            'store_hreflang_code',
            'text',
            [
                'name' => 'store[hreflang_code]',
                'label' => __('Hreflang Code'),
                'value' => $storeModel->getHreflangCode(),
                'required' => false,
                'class' => 'cs-csfeature__logo',
                'note' => 'The value like x-default, en, de-CH. Learn more on: <a href="https://support.google.com/webmasters/answer/189077">https://support.google.com/webmasters/answer/189077</a>'
            ]
        );
    }
}
