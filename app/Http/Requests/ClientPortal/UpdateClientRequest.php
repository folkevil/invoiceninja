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

namespace App\Http\Requests\ClientPortal;

use App\Http\Requests\Request;
use App\Utils\Traits\MakesHash;

class UpdateClientRequest extends Request
{
    use MakesHash;
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize() : bool
    {
        return $this->encodePrimaryKey(auth()->user()->id) === request()->segment(3);
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'file' => 'sometimes|nullable|max:100000|mimes:png,svg,jpeg,gif,jpg,bmp'
        ];
    }
}
