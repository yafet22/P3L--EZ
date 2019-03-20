<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Token;
use App\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\InvalidTokenException;
use App\Transformers\TokenTransformer;
use App\Transformers\UserTransformer;
use App\Exceptions\InvalidCredentialException;
use Hash;
use App\Events\TokenRefresh;

class TokenController extends RestController
{
    protected $transformer = TokenTransformer::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        try {
            $user = $this->validateUser($request->get('username'), $request->get('password'));
            $now = Carbon::now();

            $token = new Token;

            $token->id_user=$user->id_user;
            $token->token_username=str_random(32);
            $token->token_password=str_random(32);
            $token->save();

            $response = $this->generateItem($token);

            return $this->sendResponse($response, 201);

        } catch (InvalidCredentialExcpetion $e) {
            return $this->sendNotAuthorizeResponse($e->getMessage());
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function mobileauthenticate(Request $request)
    {
        try {
            $user = $this->validateUser($request->get('username'), $request->get('password'));

            $response = $this->generateItem($user,UserTransformer::class);

            return $this->sendResponse($response, 201);

        } catch (InvalidCredentialExcpetion $e) {
            return $this->sendNotAuthorizeResponse($e->getMessage());
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function validateUser($username,$password)
    {
        try{
            $user = User::where('username',$username)->firstOrFail();

            if(!password_verify($password, $user->password)){
                throw new InvalidCredentialException();
            }

            return $user;
        } catch(ModelNotFoundException $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function validateToken(Request $request)
    {
        try {
            $header = $request->header('Authorization');
            list($type, $payload) = explode(" ", $header);
            list($username, $password) = explode(":", base64_decode($payload));
            $token = Token::where('token_username', $username)->first();
            $user = User::find($token->id_user);
            event(new TokenRefresh($token));
            $item = $this->generateItem($user,UserTransformer::class);

            return $this->sendResponse($item);

        } catch (\Exception $e) {
            return $this->sendNotAuthorizeResponse($e->getMessage());
        } catch (InvalidTokenException $e) {
            throw $e;
        }
    }

    public function index()
    {
        $tokens = Token::all();
        $response = $this->generateCollection($tokens);
        return $this->sendResponse($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
