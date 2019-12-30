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

namespace App\Http\Requests\User;

use App\DataMapper\DefaultSettings;
use App\Factory\UserFactory;
use App\Http\Requests\Request;
use App\Http\ValidationRules\NewUniqueUserRule;
use App\Http\ValidationRules\ValidUserForCompany;
use App\Libraries\MultiDB;
use App\Models\User;

class StoreUserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize() : bool
    {
        return auth()->user()->isAdmin();
    }

    public function rules()
    {
        $rules = [];

        $rules['first_name'] = 'required|string|max:100';
        $rules['last_name'] = 'required|string|max:100';

        if (config('ninja.db.multi_db_enabled')) {
            $rules['email'] = new ValidUserForCompany();
        }

        return $rules;
    }

    protected function prepareForValidation()
    {
        $input = $this->all();

        if (isset($input['company_user'])) {
            if (!isset($input['company_user']['is_admin'])) {
                $input['company_user']['is_admin'] = false;
            }

            if (!isset($input['company_user']['permissions'])) {
                $input['company_user']['permissions'] = '';
            }

            if (!isset($input['company_user']['settings'])) {
                $input['company_user']['settings'] = DefaultSettings::userSettings();
            }
        } else {
            $input['company_user'] = [
                'settings' => DefaultSettings::userSettings(),
                'permissions' => '',
            ];
        }

        $this->replace($input);
    }


    public function fetchUser() :User
    {
        $user = MultiDB::hasUser(['email' => $this->input('email')]);

        if (!$user) {
            $user = UserFactory::create();
        }

        return $user;
    }
}
