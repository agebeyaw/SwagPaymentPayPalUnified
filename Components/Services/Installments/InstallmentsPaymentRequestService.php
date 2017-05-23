<?php
/**
 * Shopware 5
 * Copyright (c) shopware AG
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Shopware" is a registered trademark of shopware AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 */

namespace SwagPaymentPayPalUnified\Components\Services\Installments;

use SwagPaymentPayPalUnified\Components\Services\PaymentRequestService;
use SwagPaymentPayPalUnified\PayPalBundle\Structs\WebProfile;

class InstallmentsPaymentRequestService extends PaymentRequestService
{
    /**
     * {@inheritdoc}
     */
    public function getRequestParameters(WebProfile $profile, array $basketData, array $userData)
    {
        $result = parent::getRequestParameters($profile, $basketData, $userData);

        $result->getPayer()->setExternalSelectedFundingInstrumentType('CREDIT');
        $result->getRedirectUrls()->setReturnUrl($this->getReturnUrl());

        switch ($this->settings->get('paypal_payment_intent')) {
            case 0:
                $result->setIntent('sale');
                break;
            case 1: //Overwrite "authentication"
            case 2:
                $result->setIntent('order');
                break;
        }

        return $result;
    }

    /**
     * @return false|string
     */
    private function getReturnUrl()
    {
        return $this->router->assemble(
            [
                'controller' => 'PaypalUnifiedInstallments',
                'action' => 'return',
                'forceSecure' => true,
            ]
        );
    }
}