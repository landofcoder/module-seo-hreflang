<?php
if (interface_exists('Lof\BrandManagement\Api\BrandsRepositoryInterface')) {
    $store = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create('Magento\Store\Model\Store');
    if (!$store->load('second', 'code')->getId()) {
        $websiteId = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->get(
            'Magento\Store\Model\StoreManagerInterface'
        )->getWebsite()->getId();
        $groupId = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->get(
            'Magento\Store\Model\StoreManagerInterface'
        )->getWebsite()->getDefaultGroupId();
        $store->setCode(
            'second'
        )->setWebsiteId(
            $websiteId
        )->setGroupId(
            $groupId
        )->setName(
            'Second Store View'
        )->setSortOrder(
            10
        )->setIsActive(
            1
        );
        $store->save();
    }

    $brandRepository = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create('Lof\BrandManagement\Api\BrandsRepositoryInterface');

    $brand = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create('Lof\BrandManagement\Model\Brands');
    $brand
        ->setEntityId(1989)
        ->setStoreId(0)
        ->setUrlKey('enabled-brand')
        ->setLayoutUpdateXml('layout update xml')
        ->setBrandName('test_brand_name')
        ->setEnabled(1)
        ->setIsFeatured(1)
        ->setBrandIcon('testimage.png')
        ->setBrandAdditionalIcon('testimage_additional.png')
        ->setMetaTitle('Test meta title')
        ->setMetaDescription('Test meta description')
        ->setMetaRobots('NOINDEX,NOFOLLOW');
    $brandRepository->save($brand);

    $brand = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create('Lof\BrandManagement\Model\Brands');
    $brand
        ->setEntityId(1991)
        ->setStoreId(0)
        ->setUrlKey('disabled-brand')
        ->setLayoutUpdateXml('layout update xml')
        ->setBrandName('test_brand_name')
        ->setEnabled(0)
        ->setIsFeatured(1)
        ->setBrandIcon('testimage.png')
        ->setBrandAdditionalIcon('testimage_additional.png')
        ->setMetaTitle('Test meta title 2')
        ->setMetaDescription('Test meta description 2')
        ->setMetaRobots('NOINDEX,NOFOLLOW');
    $brandRepository->save($brand);
}
