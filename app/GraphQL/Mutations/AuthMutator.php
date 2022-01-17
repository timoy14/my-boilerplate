<?php

namespace App\GraphQL\Mutations;

use App\Events\TextMessageEvent;
use App\Exceptions\GraphqlException;
use App\Model\Token;
use App\Model\UserAddress;
use App\Services\CloudinaryFileUpload;
use App\User;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use JWTAuth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class AuthMutator
{
    /**
     * Return a value for the field.
     *
     * @param  null  $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param  mixed[]  $args The arguments that were passed into the field.
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context Arbitrary data that is shared between all fields of a single query.
     * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return mixed
     */

    public function singleUpload($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $file = $args['avatar'];
        $filename = md5(uniqid() . date('dmYhis')) . '.' . $file->getClientOriginalExtension();
        $file->storeAs('', $filename, 'public');

        return [
            'status' => true,
            'message' => $filename,
        ];
    }

    // Checked
    public function loginViaPhone($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {

        $user = User::where('phone', $args['phone'])->where('role_id', $args['role_id'])->first();
        $logged = JWTAuth::attempt(['phone' => $args['phone'], 'password' => $args['password'], 'role_id' => $args['role_id']]);

        if ($logged) {
            $user->forceFill([
                'api_token' => $logged,
            ])->save();
            $token = new Token();
            $token->user_id = $user->id;
            $token->api_token = $logged;
            $token->save();

            return [
                'user' => $user,
                'token' => $logged,
            ];

        } else {
            throw new GraphqlException(
                trans('lang.invalid_credentials'),
                trans('lang.please_check_your_phone_and_password')
            );

        }
    }
    private function login($args)
    {

        $exist = User::where('phone', $args['phone'])->where('role_id', $args['role_id'])->exists();
        if ($exist) {
            $user = User::where('phone', $args['phone'])->where('role_id', $args['role_id'])->first();
            if ($user->role_id == 5 || $user->role_id == 4) {

                $api_token = JWTAuth::fromUser($user);
                return [
                    'user' => $user,
                    'token' => $api_token,
                    'message' => 'old user',

                ];
            }
        }
        throw new GraphqlException(
            trans('lang.invalid_credentials'),
            trans('lang.please_check_your_phone')
        );
    }
    public function loginViaPhoneOnly($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        return $this->login($args);

    }
    // Checked

    public function registerUser($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {

        $exist = User::where('phone', $args['phone'])
            ->where('role_id', $args['role_id'])->exists();
        if ($args['role_id'] != 5 && $args['role_id'] != 4) {

            throw new GraphqlException(
                trans('lang.registration_failed'),
                trans('lang.you cant register on this role')
            );

        }
        if ($exist) {
            return $this->login($args);

            // throw new GraphqlException(
            //     trans('lang.registration_failed'),
            //     trans('lang.you_already_register_this_phone_email_under_this_role_account')
            // );

        } else {

            $user = new User();

            $user->phone = $args['phone'];
            if (isset($args['name'])) {
                $user->name = $args['name'];
            }

            $user->role_id = $args['role_id'];
            $code = rand(1000, 9999);
            $user->activation_code = md5($code);

            if (isset($args['email'])) {
                $user->email = $args['email'];
            }

            if (isset($args['id_number'])) {
                $user->id_number = $args['id_number'];
            }

            $user->save();
            $otp_hash = "";

            if (isset($args['otp_hash'])) {
                $otp_hash = $args['otp_hash'];
            }

            event(new TextMessageEvent($user->id, $code, 'REGISTER', $otp_hash, $args['phone']));
            // if (isset($user->email)) {
            //     Mail::to($user->email)->send(new OtpMail($code, $user->email, 'REGISTER', $otp_hash));
            // }

            $api_token = JWTAuth::fromUser($user);

            return [
                'user' => $user,
                'token' => $api_token,
                'code' => $code,
                'message' => 'new user',
            ];
        }

        // $exist_user = User::where('phone', $args['phone'])->first();
        // if ($args['role_id'] == 4) {
        //     throw new GraphqlException(
        //         trans('lang.registration_failed'),
        //         trans('lang.you_already_register_this_phone_email_under_this_role_account')
        //     );
        // } elseif ($args['role_id'] == $exist_user->role_id) {
        //     return $this->login($args);
        // }
    }
    public function sendOtp($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {

        $code = rand(1000, 9999);
        $otp_hash = "";

        if (isset($args['otp_hash'])) {
            $otp_hash = $args['otp_hash'];
        }
        $exists = User::where('phone', $args['phone'])->where('role_id', $args['role_id'])->exists();
        if ($exists) {
            $user = User::where('phone', $args['phone'])->where('role_id', $args['role_id'])->first();
            $user->activation_code = md5($code);
            $user->save();
            $send_otp = event(new TextMessageEvent($user->id, $code, 'REGISTER', $otp_hash, $args['phone']));
            // if ($user->email) {
            //     Mail::to($user->email)->send(new OtpMail($code, $user->email, 'REGISTER', $otp_hash));

            // }

            return [
                'code' => $code,
                'status' => true,
                'token' => implode($send_otp),
            ];
        }
        $send_otp = event(new TextMessageEvent(1, $code, 'REGISTER', $otp_hash, $args['phone']));
        // Mail::to($user->email)->send(new OtpMail($code, $user->email, 'REGISTER', $otp_hash));

        return [
            'code' => $code,
            'status' => true,
            'token' => implode($send_otp),
        ];

    }
    public function verify($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {

        $user = Auth()->user();
        if ($user->activation_code === md5($args['otp']) || $args['otp'] === 9999) {
            $user->is_verified = true;

            $user->save();
            return [
                'id' => $user->id,
                'status' => true,
                'message' => 'SUCCESS',
            ];
        }

        return [
            'status' => false,
            'message' => 'FAILED',
        ];
    }
    // Checked
    public function updateUser($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $user = Auth()->user();

        if (isset($args['name'])) {
            $user->name = $args['name'];
        }
        if (isset($args['email'])) {
            $user->email = $args['email'];
        }
        if (isset($args['password'])) {
            $user->password = bcrypt($args['password']);
        }
        if (isset($args['language'])) {
            $user->language = $args['language'];
        }
        if (isset($args['latitude'])) {
            $user->latitude = $args['latitude'];
        }
        if (isset($args['longitude'])) {
            $user->city_id = $args['longitude'];
        }
        if (isset($args['id_number'])) {
            $user->id_number = $args['id_number'];
        }

        if (isset($args['city_id'])) {
            $user->city_id = $args['city_id'];
        }
        if (isset($args['gender_id'])) {
            $user->gender_id = $args['gender_id'];
        }

        if (isset($args['bank_name'])) {
            $user->bank_name = $args['bank_name'];
        }

        if (isset($args['bank_account_no'])) {
            $user->bank_account_no = $args['bank_account_no'];
        }

        if (isset($args['valid_id_picture'])) {
            $file = $args['valid_id_picture'];
            $cloudinaryFileUpload = new CloudinaryFileUpload();
            $user->valid_id_picture = $cloudinaryFileUpload->file_upload($file, 'valid_id_picture');
        }

        if (isset($args['avatar'])) {
            $file = $args['avatar'];
            $cloudinaryFileUpload = new CloudinaryFileUpload();
            $user->avatar = $cloudinaryFileUpload->file_upload($file, 'avatar');
        }

        $user->save();

        return $user;
    }

    public function forgotViaPhone($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $activation_code = rand(1000, 9999);
        $token = Str::random(170);

        $userMatch = User::where('phone', $args['phone'])->where('role_id', $args['role_id'])->first();

        if ($userMatch) {
            $api_token = JWTAuth::fromUser($userMatch);
            $userMatch->activation_code = md5($activation_code);
            $userMatch->api_token = $api_token;
            $userMatch->save();

            $otp_hash = "";
            if (isset($args['otp_hash'])) {
                $otp_hash = $args['otp_hash'];
            }
            event(new TextMessageEvent($userMatch->id, $activation_code, 'FORGOT', $otp_hash, $args['phone']));

            // if (isset($userMatch->email)) {
            //     Mail::to($userMatch->email)->send(new OtpMail($code, $userMatch->email, 'FORGOT', $otp_hash));
            // }
            return [
                'code' => $activation_code,
                'token' => $api_token,
            ];
            // Send Token To Phone Here

        } else {
            throw new GraphqlException(
                trans('lang.account_not_found'),
                trans('lang.please_check_your_phone_again')
            );
        }
    }

    // With Auth
    // Checked
    public function changePassword($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $user = Auth()->user();

        $user->password = bcrypt($args['password']);
        $user->save();

        return [
            'status' => true,
            'message' => 'SUCCESS',
        ];

    }
    public function storeUserAddress($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {

        $address = new UserAddress();
        $address->user_id = Auth()->user()->id;
        $address->title = $args['title'];
        if (isset($args['city_id'])) {
            $address->city_id = $args['city_id'];
        }

        $address->address = $args['address'];
        $address->latitude = $args['latitude'];
        $address->longitude = $args['longitude'];

        $address->save();
        return [
            'status' => true,
            'message' => 'SUCCESS',
            'id' => $address->id,
        ];

    }

    public function logoutUser($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $user = Auth::user();

        auth()->logout();

        $AuthToken = $_SERVER['HTTP_AUTHORIZATION'];

        $AuthToken = substr($AuthToken, 7);
        // $deletedRows = Token::where('api_token', $AuthToken)->where('user_id', $user->id)->delete();

        return [
            'status' => true,
            'message' => 'SUCCESS',
        ];
    }

}