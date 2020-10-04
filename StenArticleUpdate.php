<?php

namespace StenArticleUpdate;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;

class StenArticleUpdate extends Plugin
{
    /**
     * @param InstallContext $context
     */
    public function install(InstallContext $context)
    {
        $service = $this->container->get('shopware_attribute.crud_service');

        $service->update('s_articles_attributes', 'color', 'string', [
            'label' => 'Color',
            'supportText' => 'the color of the article',
            'helpText' => 'The color of the article choosed by the customer',

            //user has the opportunity to translate the attribute field for each shop
            'translatable' => true,

            //attribute will be displayed in the backend module
            'displayInBackend' => true,

            //in case of multi_selection or single_selection type, article entities can be selected,
            'entity' => 'Shopware\Models\Article\Article',

            //numeric position for the backend view, sorted ascending
            'position' => 100,

            //user can modify the attribute in the free text field module
            'custom' => true,

//            //in case of combo box type, defines the selectable values
//            'arrayStore' => [
//                ['key' => '1', 'value' => 'first value'],
//                ['key' => '2', 'value' => 'second value']
//            ],
        ]);

        $service->update('s_articles_attributes', 'weight', 'integer', [
            'label' => 'Weight',
            'supportText' => 'the weight of the article',
            'helpText' => 'The weight of the article choosed by the customer',

            //user has the opportunity to translate the attribute field for each shop
            'translatable' => true,

            //attribute will be displayed in the backend module
            'displayInBackend' => true,

            //in case of multi_selection or single_selection type, article entities can be selected,
            'entity' => 'Shopware\Models\Article\Article',

            //numeric position for the backend view, sorted ascending
            'position' => 101,

            //user can modify the attribute in the free text field module
            'custom' => true,

//            //in case of combo box type, defines the selectable values
//            'arrayStore' => [
//                ['key' => '1', 'value' => 'first value'],
//                ['key' => '2', 'value' => 'second value']
//            ],
        ]);

    }


    /**
     * @param UninstallContext $context
     */
    public function uninstall(UninstallContext $context)
    {
        $service = $this->container->get('shopware_attribute.crud_service');
        $service->delete('s_articles_attributes', 'color');
        $service->delete('s_articles_attributes', 'weight');
    }
}
