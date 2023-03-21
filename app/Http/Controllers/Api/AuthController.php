<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\UserForgetPasswordEmail;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator(
            $request->all(),
            [
                'name' => 'required | String | max:20',
                'email' => 'required | email |unique:owners,email',
                'phone' => 'required | numeric',
                'password' => 'required | String ',
                'city_id' => 'required|integer|exists:cities,id',
            ]
        );
        if (!$validator->fails()) {
            $owner = new Owner();
            $owner->name = $request->get('name');
            $owner->email = $request->get('email');
            $owner->phone = $request->get('phone');
            $owner->city_id = $request->get('city_id');
            $owner->password = Hash::make($request->get('password'));
            // $user->image_url = $request->input('image');
            $isSaved = $owner->save();
            return response()->json(
                [
                    'status' => $isSaved,
                    'message' => $isSaved ? 'Register sucessfully' : 'Registration failed !'
                ],
                $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->getMessageBag()->first()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function loginPersonal(Request $request)
    {

        $validator = Validator($request->all(), [
            'email' => 'required|email|exists:owners,email',
            'password' => 'required|string|min:3',
        ]);

        if (!$validator->fails()) {
            $owner = Owner::where('email', $request->get('email'))->first();
            if (Hash::check($request->get('password'), $owner->password)) {
                // dd($request);
                $token = $owner->createToken('owner');
                $owner->setAttribute('token', $token->accessToken);
                return response()->json(
                    [
                        'status' => true,
                        'message' => 'Logged in successfully',
                        'data' => $owner,
                    ],
                    Response::HTTP_OK,
                );
            } else {
                return response()->json(['message' => 'Login failed, wrong credentials'], Response::HTTP_BAD_REQUEST);
            }
        } else {

            // return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->getMessageBag()->first()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }


    public function logout(Request $request)
    {
        $revoked = auth('owner-api')->user()->token()->revoke();
        return response()->json(
            [
                'status' => $revoked,
                'message' => $revoked ? 'Logged out successfully' : 'Logout failed!',
            ],
            $revoked ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }

    public function forgotPassword(Request $request)
    {

        $validator = Validator(
            $request->all(),
            [
                'email' => 'required | email | exists:owners,email',
            ]
        );

        if (!$validator->fails()) {
            $code = random_int(1000, 9999);

            $owner = Owner::where('email', '=', $request->get('email'))->first();
            // dd($owner);
            $owner->verification_code = Hash::make($code);

            $isSaved = $owner->save();

            if ($isSaved) {
                Mail::to($owner)->send(new UserForgetPasswordEmail($owner, $code));
            }
            return response()->json(
                [
                    'status' => $isSaved,
                    'code' => $code,
                    'message' => $isSaved ? 'Forgot code sent successfully' : 'Forgot code sending failed !'
                ],
                $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->getMessageBag()->first()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function resetPassword(Request $request)
    {

        $validator = Validator(
            $request->all(),
            [
                'email' => 'required | email | exists:owners,email',
                'code' => 'required | numeric|digits:4',
                'new_password' => 'required',
            ]
        );

        if (!$validator->fails()) {
            $owner = Owner::where('email', '=', $request->get('email'))->first();
            if (!is_null($owner->verification_code)) {
                if (Hash::check($request->get('code'), $owner->verification_code)) {
                    $owner->password = Hash::make($request->get('new_password'));
                    $owner->verification_code = null;
                    $isSaved = $owner->save();
                    return response()->json(
                        [
                            'status' => $isSaved,
                            'message' => $isSaved ? 'Password change successfully' : 'Password chage failed !'
                        ],
                        $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
                    );
                } else {
                    return response()->json(
                        [
                            'status' => false,
                            'message' => 'verification code is not correct '
                        ],
                        Response::HTTP_BAD_REQUEST
                    );
                }
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'No password reset request exist'
                    ],
                    Response::HTTP_FORBIDDEN
                );
            }
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->getMessageBag()->first()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function changePassword(Request $request)
    {
        $validator = Validator(
            $request->all(),
            [
                'current_password' => 'required | current_password:owner-api',
                'new_password' => 'required',
            ]
        );

        if (!$validator->fails()) {
            $owner = $request->user('owner-api');
            $owner->password = Hash::make($request->get('new_password'));
            $isSaved = $owner->save();
            return response()->json(
                [
                    'status' => $isSaved,
                    'message' => $isSaved ? 'Password change successfully' : 'Password chage failed !'
                ],
                $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->getMessageBag()->first()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
