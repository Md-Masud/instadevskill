<?php

namespace App\Http\Controllers;
use App\Repository\interfaces\FollowRepositoryInterface;
use App\Repository\interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    private $userRepo;
    private $followRepo;
    public function __construct(UserRepositoryInterface $userRepository,
                                FollowRepositoryInterface $followRepository)
    {
        $this->userRepo = $userRepository;
        $this->followRepo = $followRepository;
    }
    public  function follow(Request $request)
    {
        $this->validate($request,[
            'user_id' => 'required|exists:users,id',
        ]);
        $user=$this->userRepo->find($request->user_id);
        if($user->account_type=1)
        {
            $followed=$this->followRepo->create([
                'user_id' => $request->user_id,
                'follower_id' => Auth::id(),
            ]);
            return response()->json([
                'follow' => $followed
            ]);
        } else {
            return response()->json([
                'message' => 'This is a private account. This user needs to approve before following',
            ]);
        }

    }
    public  function  follows(Request $request)
    {
        //$id=Auth::id();
        //$follows=DB::table('follows')->leftJoin('users' ,'users.id','=','follows.user_id')->where('follows.user_id','=',$request->user()->id)->get();
     $follows=$this->followRepo->with(['user'=>function($query)
    {
        $query->select('id','username','name','email');
    }])->where('user_id',$request->user()->id)->get()->pluck('user');

        return response()->json($follows);
    }
}
