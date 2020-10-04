<?php

namespace StenArticleUpdate\Subscriber;

use Enlight\Event\SubscriberInterface;
use Enlight_Controller_Action;
use Shopware\Bundle\AttributeBundle\Service\DataLoaderInterface;
use Shopware\Components\Model\ModelManager;
use Shopware\Components\Plugin\ConfigReader;
use Shopware\Models\Article\Detail;

class RouteSubscriber implements SubscriberInterface
{

    private $pluginDirectory;
    /**
     * @var array
     */
    private $config;
    /**
     * @var ModelManager
     */
    private $modelManager;
    /**
     * @var DataLoaderInterface
     */
    private $dataLoader;

    /**
     * RouteSubscriber constructor.
     * @param $pluginName
     * @param $pluginDirectory
     * @param ConfigReader $configReader
     * @param ModelManager $modelManager
     * @param DataLoaderInterface $dataLoader
     */
    public function __construct($pluginName, $pluginDirectory, ConfigReader $configReader, ModelManager $modelManager, DataLoaderInterface $dataLoader)
    {
        $this->pluginDirectory = $pluginDirectory;

        $this->config = $configReader->getByPluginName($pluginName);

        $this->modelManager = $modelManager;
        $this->dataLoader = $dataLoader;
    }

    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Detail' => 'onPostDispatch'
        ];
    }

    public function onPostDispatch(\Enlight_Controller_ActionEventArgs $args)
    {
        /** @var Enlight_Controller_Action $controller */
        $controller = $args->get('subject');
        $view = $controller->View();

        $view->addTemplateDir($this->pluginDirectory . '/Resources/views');

        $sArticle = $view->getAssign('sArticle');

//        $builder = $this->modelManager->createQueryBuilder();
//        $attribute = $builder->select('attribute.color', 'attribute.weight')
//            ->from(Detail::class, 'articleDetail')
//            ->leftJoin('articleDetail.attribute', 'attribute')
//            ->where('articleDetail.id = :id')
//            ->setParameter('id', $sArticle['articleDetailsID'])
//            ->getQuery()
//            ->getOneOrNullResult();

//        $this->dumb($attribute);

        $attribute = $this->dataLoader->load('s_articles_attributes',$sArticle['articleDetailsID']);
//        $this->dumb($attribute);

        /** @var Detail $articleDetail */
        $articleDetail = $this->modelManager->find(Detail::class, $sArticle['articleDetailsID']);

        if ($articleDetail) {
            $attribute = $articleDetail->getAttribute();
        }

        $sArticle = array_merge(
            $sArticle,
            [
                'Sten' => [
                    'color' => $attribute->getColor(),
                    'weight' => $attribute->getWeight(),
                ]
            ]
        );

//        $this->dumb($sArticle);
        $view->assign('sArticle', $sArticle);


    }

    function dumb($data){
        /* error_log(_METHOD.'::'.LINE_.'::$filePath> '.print_r($filePath, 1)); */
        highlight_string("<?php\n " . var_export($data, true) . "?>");
        echo '<script>document.getElementsByTagName("code")[0].getElementsByTagName("span")[1].remove() ;document.getElementsByTagName("code")[0].getElementsByTagName("span")[document.getElementsByTagName("code")[0].getElementsByTagName("span").length - 1].remove() ; </script>';
        die();
    }
}
