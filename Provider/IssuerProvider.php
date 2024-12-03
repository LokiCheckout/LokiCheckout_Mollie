<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Provider;

use Mollie\Payment\Service\Mollie\GetIssuers;
use Mollie\Payment\Service\Mollie\MollieApiClient;

class IssuerProvider
{
    public function __construct(
        private GetIssuers $getIssuers,
        private MollieApiClient $mollieApiClient,
    ) {
    }

    /**
     * @return array
     */
    public function getIssuers(string $method = ''): array
    {
        if (empty($method)) {
            return [];
        }

        $method = str_replace('mollie_methods_', '', $method);
        $mollieApiClient = $this->mollieApiClient->loadByStore();
        return (array) $this->getIssuers->execute($mollieApiClient, $method, 'list');
    }

    public function getIssuerLabel(string $issuer): string
    {
        list($method, $issuerCode) = explode('_', $issuer);
        $issuers = $this->getIssuers($method);
        foreach ($issuers as $issuerData) {
            if ($issuerData['id'] === $issuer) {
                return $issuerData['name'];
            }
        }

        return '';
    }
}
