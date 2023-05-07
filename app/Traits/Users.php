<?php

namespace App\Traits;

//use Twilio;
use Aloha\Twilio\Twilio;
use App\Http\Libraries\Uploader;
use App\Jobs\SendEmail;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Twilio\Jwt\JWT;
use Tymon\JWTAuth\Facades\JWTAuth;

trait Users {

    use EMails,
        SendsPasswordResetEmails,
        Upload,
        PluckPivot,
        RegistersUsers,
        Translations,
        Price;

    private $reqData;
    private $traitsUser;

    /**
     * UserService constructor.
     * @param $data
     * @param null $user
     */

    public function setUsersTraitData($reqData, $user = null)
    {
        $this->reqData = $reqData;

        $this->traitsUser = $user;
    }

    public function registerUser()
    {
        $data = $this->reqData->only([
                'first_name',
                'last_name',
                'email',
                'phone',
                'gender',
                'address',
                'password',
                'google_id',
                'facebook_id',
                'instagram_id'

            ]

        );
        $data['is_verified'] = 0;

        if (!isset($data['gender'])) {

            $data['gender'] = '';

        }

        if (!isset($data['phone'])) {

            $data['phone'] = '';

        }

        if (!isset($data['address'])) {

            $data['address'] = '';

        }

        if (!isset($data['google_id'])) {
            $data['google_id'] = '';
        }

        if (!isset($data['facebook_id'])) {
            $data['facebook_id'] = '';

        }

        if (!isset($data['instagram_id'])) {
            $data['instagram_id'] = '';

        }

        if ($data['instagram_id'] != '' || $data['facebook_id'] != '' || $data['google_id'] != '') {
            $data['is_verified'] = 1;
        }

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'gender' => $data['gender'],
            'email' => $data['email'],
            'user_phone' => $data['phone'],
            'password' => bcrypt($data['password']),
            'address' => $data['address'],
            'google_id' => $data['google_id'],
            'facebook_id' => $data['facebook_id'],
            'instagram_id' => $data['instagram_id'],
            'is_verified' => $data['is_verified']
        ]);

        if (!$user->is_verified) {
            $this->sendVerificationCode($user);
        }
        return $user;
    }

    public function updateUser()
    {
        $data = $this->reqData->only([

            'first_name',

            'last_name',

            'email',

            'phone',

            'profile_pic',

            'user_latitude',

            'user_longitude',

            'city_id'

        ]);
        try {

            if (isset($data['profile_pic'])) {

                $uploader = new Uploader('profile_pic');

                if ($uploader->isValidFile()) {

                    $uploader->upload('photos', $uploader->fileName);

                    if ($uploader->isUploaded()) {

                        $data['user_image'] = $uploader->getUploadedPath();

                    }

                }

            }

            $emailchange = false;

            if ($this->traitsUser->email != $data['email']) {

                $data['is_verified'] = 0;

                $emailchange = true;

            }

            $this->traitsUser->update($data);

            if ($emailchange) {

                $this->resendVerificationCode();

            }

            return $this->traitsUser;

        } catch (\Exception $exception) {

            return false;

        };
    }

    public function sendVerificationCode($user)
    {
        if ($user->is_verified == 0) {

            $data['verification_code'] = rand(1000, 9999);

            $data['receiver_email'] = $user->email;

            $data['receiver_name'] = $user->fullName;

            $data['sender_name'] = config('app.name');

            $data['sender_email'] = config('settings.email');

            $user->update(['verification_code' => $data['verification_code']]);

//            SendEmail::dispatch($data, 'emails.email_verification', __('Email verification code'), $data['receiver_email'], $data['sender_email']);
//
            $this->sendMail($data, 'emails.email_verification', 'Email verification code', $data['receiver_email'], $data['sender_email']);

            return $user;

        }

    }

    public function resendVerificationCode()

    {

        $user = $this->sendVerificationCode($this->traitsUser);

        return $user;

    }

    public function verifyEmail()

    {

        $data = $this->reqData->only('verification_code');

        $user = $this->traitsUser;

        if ($user != null) {

            if ($user->verification_code == $data['verification_code']) {

                $user->update(['verification_code' => '', 'is_verified' => 1, 'is_active' => 1]);

            }

        }

        return $user;

    }

    public function forgotPassword()

    {

        $rData = $this->reqData->only('email');

        if (isset($rData['email'])) {

            $user = User::where(['email' => $rData['email']])->active()->first();

            if ($user) {

                $code = rand(1000, 9999);

                $data['receiver_name'] = $user->full_name;

                $data['receiver_email'] = $user->email;

                $data['sender_name'] = config('app.name');

                $data['sender_email'] = config('settings.email');

                $data['verification_code'] = $code;

                $user->update(['verification_code' => $code]);

//                SendEmail::dispatch($data, 'emails.forgot_password', 'Email verification code', $data['receiver_name'], $data['sender_email']);
//
                $this->sendMail($data, 'emails.forgot_password', 'Email verification code', $data['receiver_name'], $data['sender_email']);

                return $user;

            } else {

                return false;

            }

        }

        return false;

    }

    public function resetPassword()

    {

        $reqData = $this->reqData->only('email', 'password', 'verification_code');

        $user = User::where("email", $reqData["email"])->first();

        if ($user) {

            if ($reqData['verification_code'] == $user->verification_code) {

                $user->update(

                    [

                        'password' => bcrypt($reqData['password']),

                        'verification_code' => ''

                    ]);

                return $user;

            }

        }

        return false;

    }

    public function updateUserPassword()

    {

        $data = $this->reqData->only('current_password', 'password');

        $user = $this->traitsUser;

        if (isset($data['current_password'])) {

            if (\Hash::check($data['current_password'], $user->password)) {

                $password = bcrypt($data['password']);

            } else {

                return false;

            }

        } else {

            $password = bcrypt($user->password);

        }

        if ($user->update(['password' => $password])) {

            return $user;

        }

        return false;

    }

    public function userSocialLogin()

    {

        $socialLoginColumn = 'google_id';

        $requestData = $this->reqData;

        if (!empty($requestData['facebook_id'])) {

            $socialLoginColumn = 'facebook_id';

        }
        if (!empty($requestData['instagram_id'])) {

            $socialLoginColumn = 'instagram_id';

        }

        // check if user exists

        $userExists = User::where([$socialLoginColumn => $requestData[$socialLoginColumn]])->first();

        if ($userExists) {

            $user = $userExists;

        } else {

            // try to find with email

            $userExists = User::where(['email' => $requestData['email']])->first();

            if ($userExists) {

                $userExists->$socialLoginColumn = $requestData[$socialLoginColumn];

                $userExists->save();

                $userExists = $userExists;

            } else {

                return false;

//                $userData = $this->reqData;
//
//                $userData['is_verified'] = 1;
//
//                $userData['user_image'] = env('USER_DEFAULT_IMAGE');
//
//                $userExists = User::create($userData);

            }

        }

        if ($userExists) {

            return $userExists;

        }

        return false;

    }

    public function contactUs()

    {

        $from = $this->reqData->email;

        $subject = $this->reqData->subject;

        $name = $this->reqData->full_name;

        $data['receiver_name'] = config('app.name');

        $data['receiver_email'] = config('settings.email');

        $data['sender_name'] = $name;

        $data['sender_email'] = $from;

//        SendEmail::dispatch($data, 'emails.forgot_password', $subject, $name, $from);
//
        $this->sendMail($data, 'emails.forgot_password', $subject, $name, $from);

    }

    public function featuresPackages($fromApi = 0)

    {

        $packages = Package::with(['languages'])
            ->whereHas('languages')
            ->orderBy('id', 'desc')
            ->paginate(env('DEFAULT_PAGINATION', 12));

        $this->setTranslations($packages);

        if ($fromApi) {

            $rate = getConversionRate();

            foreach ($packages as $key => $package) {

                $packages[$key]->price = $this->getPriceObject($package->price, $rate);

            }

        }


        return $packages;

    }
}
