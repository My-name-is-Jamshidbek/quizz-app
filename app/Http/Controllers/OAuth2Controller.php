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
            'clientId' => (string) config('services.hemis.studentId'),
            'clientSecret' => (string) config('services.hemis.studentSecret'),
            'redirectUri' => (string) config('services.hemis.studentRedirectUri'),
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

    public function loginTeacher()
    {
        // Create the OAuth2 provider
        $employeeProvider = new GenericProvider([
            'clientId' => "" . env("TEACHER_ID"),
            'clientSecret' => "" . env("TEACHER_TOKEN"),
            'redirectUri' => "" . env("TEACHER_URL"),
            'urlAuthorize' => 'https://hemis.ubtuit.uz/oauth/authorize',
            'urlAccessToken' => 'https://hemis.ubtuit.uz/oauth/access-token',
            'urlResourceOwnerDetails' => 'https://hemis.ubtuit.uz/oauth/api/user?fields=id,uuid,type,roles,name,login,picture,email,university_id,phone',
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
        file_put_contents('test.txt', json_encode($request->all()));

        if ($request->has('code')) {
            // You have received the authorization code, now exchange it for an access token
            $employeeProvider = new GenericProvider([
                'clientId' => "" . env("STUDENT_ID"),
                'clientSecret' => "" . env("STUDENT_TOKEN"),
                'redirectUri' => "" . env("STUDENT_URL"),
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

            return redirect()->route('first-page');
        } else {
            return redirect()->route('login-page');
        }
    }

    public function callTeacher(Request $request)
    {
        if ($request->has('code')) {
            // You have received the authorization code, now exchange it for an access token
            $employeeProvider = new GenericProvider([
                'clientId' => "" . env("TEACHER_ID"),
                'clientSecret' => "" . env("TEACHER_TOKEN"),
                'redirectUri' => "" . env("TEACHER_URL"),
                'urlAuthorize' => 'https://hemis.ubtuit.uz/oauth/authorize',
                'urlAccessToken' => 'https://hemis.ubtuit.uz/oauth/access-token',
                'urlResourceOwnerDetails' => 'https://hemis.ubtuit.uz/oauth/api/user?fields=id,uuid,type,roles,name,login,picture,email,university_id,phone',
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

            //TODO: callback student save database and login
            $id = $data["employee_id_number"];
            $role = $data["roles"][0]["code"];
            $kafedra = KafedraService::getKafedraForMudir($id);
            $department = $kafedra[0];


            $this->save_callback_data($id, $data, $role, $department);

//            dd($data);
//            Cookie::queue('user', json_encode($data), 60 * 24);
//            Cookie::queue('selected_role', $role, 60 * 24);

            return redirect()->route('first-page');
        } else {
            return redirect()->route('login-page');
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
