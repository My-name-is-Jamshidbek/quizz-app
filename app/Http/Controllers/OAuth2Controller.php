<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\User;
use App\Services\KafedraService;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use League\OAuth2\Client\Provider\GenericProvider;

class OAuth2Controller extends Controller
{
    public function login(Request $request)
    {
        return view('hemis.login');
    }


    public function loginStudent()
    {
        // Create the OAuth2 provider
        $employeeProvider = new GenericProvider([
            'clientId' => 7,
            'clientSecret' => "zyZU9yHh_omN8JFus2tF7vbNKwrfbOiNPt9j12Nq",
            'redirectUri' => "https://survey.ubtuit.uz/callback/student",
            'urlAuthorize' => 'https://student.ubtuit.uz/oauth/authorize',
            'urlAccessToken' => 'https://student.ubtuit.uz/oauth/access-token',
            'urlResourceOwnerDetails' => 'https://student.ubtuit.uz/oauth/api/user?fields=id,uuid,type,name,login,picture,email,university_id,phone,groups',
            'verify' => false,
        ]);
        $guzzyClient = new Client([
            'defaults' => [
                \GuzzleHttp\RequestOptions::CONNECT_TIMEOUT => 5,
                \GuzzleHttp\RequestOptions::ALLOW_REDIRECTS => true],
            \GuzzleHttp\RequestOptions::VERIFY => false,
        ]);

        $employeeProvider->setHttpClient($guzzyClient);

        // Redirect the user to the authorization URL
        $authorizationUrl = $employeeProvider->getAuthorizationUrl();
        return redirect()->away($authorizationUrl);
    }


    public function callStudent(Request $request)
    {
        file_put_contents('test.txt', "123");

        if ($request->has('code')) {
            // You have received the authorization code, now exchange it for an access token
            $employeeProvider = new GenericProvider([
                'clientId' => 7,
                'clientSecret' => "zyZU9yHh_omN8JFus2tF7vbNKwrfbOiNPt9j12Nq",
                'redirectUri' => "https://survey.ubtuit.uz/callback/student",
                'urlAuthorize' => 'https://student.ubtuit.uz/oauth/authorize',
                'urlAccessToken' => 'https://student.ubtuit.uz/oauth/access-token',
                'urlResourceOwnerDetails' => 'https://student.ubtuit.uz/oauth/api/user?fields=id,uuid,type,name,login,picture,email,university_id,phone,groups',
                'verify' => false,
            ]);
            $guzzyClient = new Client([
                'defaults' => [
                    \GuzzleHttp\RequestOptions::CONNECT_TIMEOUT => 5,
                    \GuzzleHttp\RequestOptions::ALLOW_REDIRECTS => true],
                \GuzzleHttp\RequestOptions::VERIFY => false,
            ]);

            $employeeProvider->setHttpClient($guzzyClient);

            $accessToken = $employeeProvider->getAccessToken('authorization_code', [
                'code' => $request->input('code'),
            ]);
            file_put_contents('test2.txt', $accessToken->getToken());
            // We have an access token, which we may use in authenticated
            // requests against the service provider's API.
            echo "<p>Access Token: <b>{$accessToken->getToken()}</b></p>";
            echo "<p>Refresh Token: <b>{$accessToken->getRefreshToken()}</b></p>";
            echo "Expired in: <b>" . date('m/d/Y H:i:s', $accessToken->getExpires()) . "</b></p>";
            echo "Already expired: <b>" . ($accessToken->hasExpired() ? 'expired' : 'not expired') . "</b></p>";

            // Using the access token, we may look up details about the
            // resource owner.
            $resourceOwner = $employeeProvider->getResourceOwner($accessToken);

            $data = $resourceOwner->toArray();

//            TODO: callback student save database and login
            $id = $data["student_id_number"];

            $this->save_callback_data($id, $data, "student", "0");
//            dd($data);
//            Cookie::queue('user', json_encode($data), 60 * 24);
//            Cookie::queue('selected_role', "student", 60 * 24);

            return redirect()->route('quiz');
        } else {
            return redirect()->route('/');
        }
    }

    public function save_callback_data($id, $data, $role, $department)
    {
        $user = User::find($id);
        if (isset($user)) {
            $user->id = $id;
            $user->data = json_encode($data);
            $user->selected_role = $role;
            $user->selected_department = $department;
            $user->save();
            Auth::login($user);
        } else {
            $user = new User();
            $user->id = $id;
            $user->data = json_encode($data);
            $user->selected_role = $role;
            $user->selected_department = $department;
            $user->save();
            Auth::login($user);
        }
    }
}
