<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Http\Controllers\BridgeController;

use App\Models\EmailDomainsForEvents;

class emailDomain implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($event_id)
    {
        $this->event_id = $event_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        # Right now it's only pulling one domain, can easily add two or more if needed
        $payload=array('event_id'=>$this->event_id);
        $api_parameter = "getEmailDomainsForEvents";
        $method = "POST";
        $domain = BridgeController::communicateWithNulirt($api_parameter, $method, $payload);
        $domain =json_decode($domain, true);

        // TODO: restricited domain is an array because it could be multiple
        if ($domain['status'] == 'restriction') {
            $retricted_domain = array($domain['EmailDomainsForEvents'][0]['domain']);
            $email = substr($value, strpos($value, '@') + 1);
            return in_array($email, $restricted_domain);

        } else {
            // Because there is no restriction
            return true;
        }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $messages = [
        'email.domain' => 'Domain issue, only emails with a certain domain can sign up for this acocunt'
      ];
        // TODO why is this YO
        return ['YO' => 'Domain issue, only emails with a certain domain can sign up for this acocunt.'];
    }
}
