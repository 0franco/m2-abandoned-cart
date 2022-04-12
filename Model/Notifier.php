<?php

namespace OH\AbandonedCart\Model;

use Magento\Framework\App\Area;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;


/**
 * Class Notifier
 * @package OH\AbandonedCart\Model
 */
class Notifier
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var TransportBuilder
     */
    private $transportBuilder;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var TimezoneInterface
     */
    private $localeDate;

    /**
     * @var UrlInterface
     */
    private $urlInterface;

    public function __construct(
        UrlInterface $url,
        TimezoneInterface $timezone,
        LoggerInterface $logger,
        ConfigProvider $configProvider,
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager
    ) {
        $this->urlInterface = $url;
        $this->localeDate = $timezone;
        $this->configProvider = $configProvider;
        $this->logger = $logger;
        $this->storeManager = $storeManager;
        $this->transportBuilder = $transportBuilder;
    }

    public function send($aCart, $sequence = 1)
    {
        try {
            $data = [
                'data' => []
            ];

            $transport = $this->transportBuilder
                ->setTemplateIdentifier($this->configProvider->getTmplEmail($sequence))
                ->setTemplateOptions([
                    'area' => Area::AREA_FRONTEND,
                    'store' => $this->storeManager->getStore()->getId()
                ])
                ->setTemplateVars($data)
                ->setFromByScope('general')
                ->addTo($aCart['customer_email'])
                ->getTransport();

            $transport->sendMessage();
        } catch (\Exception $e) {
            $this->logger->critical(sprintf('Error notifying abandoned cart, customer_email: %s, error: %s', $aCart['customer_email'], $e->getMessage()));
        }

        return false;
    }

    /**
     * Get frontend url,
     *
     * This is workaround for urlBuilder that have a preference and all urls are generated for the admin side
     *
     * @param string $routePath
     * @param null $scope
     * @param null $store
     * @param null $params
     * @return string
     */
    public function getFrontendUrl($routePath, $scope = null, $store = null, $params = null): string
    {
        if ($scope) {
            $this->urlInterface->setScope($scope);
            $paramsOrg = [
                '_current' => false,
                '_nosid' => true,
                '_query' => [\Magento\Store\Model\StoreManagerInterface::PARAM_NAME => $store]
            ];

            $href = $this->urlInterface->getUrl(
                $routePath,
                $params ? array_merge($params, $paramsOrg) : $paramsOrg
            );
        } else {
            $paramsOrg = [
                '_current' => false,
                '_nosid' => true
            ];

            $href = $this->urlInterface->getUrl(
                $routePath,
                $params ? array_merge($params, $paramsOrg) : $paramsOrg
            );
        }

        return $href;
    }
}
