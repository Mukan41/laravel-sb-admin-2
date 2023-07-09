<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * @OA\Post(
     *      path="/api/register",
     *      operationId="RegisterAPI",
     *      tags={"Customer"},
     *      summary="Customer Register API",
     *      description="validate registeration data",
     *      @OA\Parameter(
     *          name="name",
     *          in="query",
     *          description="Customer name",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="role",
     *          in="query",
     *          description="Customer role",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="phone",
     *          in="query",
     *          description="Customer phone number",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="email",
     *          in="query",
     *          description="Customer email",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          in="query",
     *          description="Customer password",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *          )
     *       ),
     *      @OA\Parameter(
     *          name="password_confirmation",
     *          in="query",
     *          description="confirm password",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *          )
     *       ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function RegisterAPI(Request $request)
    {
        $name=$request->name;
        $role=$request->role;
        $phone=$request->phone;
        $email = $request->email;
        $password = $request->password;

        $validation = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric', 'min:10', 'unique:' . Customer::class],
            'email' => ['required', 'email', 'max:255', 'unique:' . Customer::class],
            'password' => ['required','string','regex:/[a-z]/','regex:/[A-Z]/','regex:/[0-9]/', 'regex:/[@$!%*#?&]/','min:8', 'max:255','confirmed']
        ]);
        if ($validation->fails()) {
            return response()->json([$validation->errors()]);
        }

        elseif ($validation->passes()) {
            Customer::insert([
                'name' => $name,
                'role' => $role,
                'phone' => $phone,
                'email' => $email,
                'password' => Hash::make($password)
            ]);
            $customer =Customer::where(['email'=>$email])->first();
            $customer["token"] = $customer->createToken('MyApp')->plainTextToken;
            return response()->json([$customer]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * @OA\Post(
     *      path="/api/login",
     *      operationId="store",
     *      tags={"Customer"},
     *      summary="Customer Login API",
     *      description="Returns Customer Token",
     *      @OA\Parameter(
     *          name="email",
     *          in="query",
     *          description="User email",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          in="query",
     *          description="User password",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *          )
     *       ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */


     // Login APIs
    public function LoginAPI(Request $request){


        
        $email = $request->email;
        $password = $request->password;

        
       $validation = Validator::make($request->all(),[
                'email' => ['required','email', 'max:255'],
                'password' => ['required', 'string', 'max:255']
            ]);
        if ($validation->fails()) {
            return response()->json([$validation->errors()]);
        }


        if ( Customer::where(['email'=>$email])->count()==0) {
            return response()->json(["message"=>"email not match","data"=>null]);
        }
        $Customer = Customer::where(['email'=>$email])->first();

        
        if (!Hash::check($password, $Customer->password)) {
            return response()->json(["message"=>"password not match","data"=>null]);
        }
        $Customer["token"] = $Customer->createToken('MyApp')->plainTextToken;
            

        return response()->json([$Customer]);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
