<?php
/**
 * Invoice Ninja (https://invoiceninja.com)
 *
 * @link https://github.com/invoiceninja/invoiceninja source repository
 *
 * @copyright Copyright (c) 2019. Invoice Ninja LLC (https://invoiceninja.com)
 *
 * @license https://opensource.org/licenses/AAL
 */

namespace App\Utils\Traits;

use App\Models\Client;
use App\Models\SystemLog;

/**
 * Class SystemLogTrait
 * @package App\Utils\Traits
 */
trait SystemLogTrait
{
    public function sysLog($log, $category_id = SystemLog::GATEWAY_RESPONSE, $event_id = SystemLog::GATEWAY_FAILURE, Client $client = null)
    {
        if ($client != null) {
            $this->client = $client;
        }

        $sl = [
            'client_id' => $this->client->id,
            'company_id' => $this->client->company->id,
            'user_id' => $this->client->user_id,
            'log' => $log,
            'category_id' => $category_id,
            'event_id' => $event_id,
        ];

        SystemLog::create($sl);
    }
}
