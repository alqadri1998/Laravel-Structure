<?php

namespace App\Http\Middleware;

use App\Http\Libraries\ResponseBuilder;
use Auth;
use Closure;
//use JWTAuth;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;


class SDTyresJWT extends BaseMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (!$token = $this->auth->setRequest($request)->getToken()) {
            return (new ResponseBuilder(401, __('Token not provided')))->build();
        }
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['status' => 'Token is Invalid']);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['status' => 'Token is Expired']);
            }else{
                return response()->json(['status' => 'Authorization Token not found']);
            }
        }


        $request->request->add(['jwt' => ['user' => $user, 'token' => $token]]);
        return $next($request);
    }

}
