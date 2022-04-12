<?php

declare(strict_types=1);

namespace OH\AbandonedCart\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class ConfigProvider
 * @package OH\AbandonedCart\Model
 */
class ConfigProvider
{
    /**
     * @var string
     */
    const XML_CONFIG_PATH_ENABLED = 'abandoned_cart/settings/enabled_%s';

    /**
     * @var string
     */
    const XML_CONFIG_PATH_TMPL_EMAIL = 'abandoned_cart/settings/email_tmpl_%s';

    /**
     * @var ScopeInterface
     */
    private $scopeInterface;

    public function __construct(
        ScopeConfigInterface $scopeInterface
    ) {
        $this->scopeInterface = $scopeInterface;
    }

    /**
     * Check if is enabled
     *
     * @param int $number
     * @return bool
     */
    public function isEnable(int $number = 1): ?bool
    {
        return $this->scopeInterface->isSetFlag(str_replace('%s', (string)$number, self::XML_CONFIG_PATH_ENABLED), ScopeInterface::SCOPE_STORE);
    }

    /**
     * Retrieve template email
     *
     * @param int $number
     * @return string
     */
    public function getTmplEmail(int $number = 1): string
    {
        return $this->scopeInterface->getValue(str_replace('%s', (string)$number, self::XML_CONFIG_PATH_TMPL_EMAIL), ScopeInterface::SCOPE_STORE);
    }
}
