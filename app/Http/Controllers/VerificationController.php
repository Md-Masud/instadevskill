<?php

namespace App\Http\Controllers;
use App\Repository\interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    private $userRepo;
    public function __construct(UserRepositoryInterface $userRepository)

    {
        $this->userRepo = $userRepository;

    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify($id, Request $request)
    {
        if (!$request->hasValidSignature()) {
            return response()->json([
                'message' => 'Invalid/expired url provided'
            ], 401);
        }

        $user =$this->userRepo->find($id);


        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return response()->json([
            'message' => "Email successfully verified",
        ], 200);
    }

}
