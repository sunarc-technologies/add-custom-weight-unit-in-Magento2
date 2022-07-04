<?php
namespace Sunarc\CustomWeight\Model\Config\Source;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;

class WeightUnit extends \Magento\Directory\Model\Config\Source\WeightUnit
{
    /**
     * CustomWeight module enable/disable
     */
    const XML_PATH_WEIGHT_ENABLE = 'customweight/general/enable';
    /**
     * ScopeConfigInterface
     *
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * Custom Weight constructor.
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\Action\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    // Get Custom Weight Module Enable / Disable Status
    public function getEnableModule()
    {
        $enableModule = $this->_scopeConfig->getValue(
            self::XML_PATH_WEIGHT_ENABLE,
            ScopeInterface::SCOPE_STORE
        );

        return $enableModule;
    }

    // Get Custom Weight Value
    public function getWeightValue()
    {
        return $this->_scopeConfig->getValue(
            "customweight/general/weight",
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $this->storeManager->getStore()->getStoreId()
        );
    }    

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        $module=$this->getEnableModule();

        $enableModule = $this->_scopeConfig->getValue(
            self::XML_PATH_WEIGHT_ENABLE,
            ScopeInterface::SCOPE_STORE
        );

        if ($module) {
            return [
                ['value' => $this->getWeightValue(), 'label' => __($this->getWeightValue())],
                ['value' => 'lbs', 'label' => __('lbs')],
                ['value' => 'kgs', 'label' => __('kgs')]
            ];
            
        } else {
            return [['value' => 'lbs', 'label' => __('lbs')],
            ['value' => 'kgs', 'label' => __('kgs')]];

        }
    }
}
