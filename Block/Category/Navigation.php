<?php


namespace SuttonSilver\CustomCategoryNav\Block\Category;

class Navigation extends \Magento\Framework\View\Element\Template
{

    protected $_categoryFactory;
    protected $_registry;

    private $collection;

    public $count = 0;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Helper\Category $categoryHelper,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory  $categoryFactory,
        array $data = array())
    {
        parent::__construct($context, $data);
        $this->_categoryFactory = $categoryFactory;
        $this->_registry = $registry;
    }

    public function getCurrentCategory()
    {
        $_category = $this->_registry->registry('current_category');
        return $_category;
    }

    public function getProductCount(){
        return $this->count;
    }

    private function getCategoryList()
    {
        $_category = $this->getCurrentCategory();
        $ids = [];
        foreach($_category->getChildrenCategories() as $item)
        {
            $ids[] = $item->getId();
        }
        $collection = $this->_categoryFactory->create()->addAttributeToSelect('*')
            ->addAttributeToFilter('is_active', 1)
            ->setOrder('position', 'ASC')
            ->addIdFilter($ids);
        $this->collection = $collection;
        return $this;
    }

    public function getLoadedCategoryList(){
        $this->getCategoryList();
        return $this->collection;
    }
}
