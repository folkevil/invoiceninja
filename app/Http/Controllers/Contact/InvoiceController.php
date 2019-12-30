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

namespace App\Http\Controllers\Contact;

use App\Filters\InvoiceFilters;
use App\Http\Controllers\BaseController;
use App\Models\Invoice;
use App\Transformers\Contact\InvoiceTransformer;
use App\Utils\Traits\MakesHash;
use Illuminate\Http\Request;

class InvoiceController extends BaseController
{
    use MakesHash;

    protected $entity_type = Invoice::class;

    protected $entity_transformer = InvoiceTransformer::class;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * List Invoices
     *
     * @param  \App\Filters\InvoiceFilters  $filters  The filters
     *
     * @return \Illuminate\Http\Response
     */
    public function index(InvoiceFilters $filters)
    {
        $invoices = Invoice::filter($filters);
      
        return $this->listResponse($invoices);
    }
}
