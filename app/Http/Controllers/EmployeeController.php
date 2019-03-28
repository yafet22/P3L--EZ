<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Employee;
use App\Role;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Transformers\EmployeeTransformer;

class EmployeeController extends RestController
{
    protected $transformer = EmployeeTransformer::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
        $response = $this->generateCollection($employees);
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
        $this->validate($request,[
            'address' => 'required',
            'phone_number' => 'required',
            'salary' => 'required',
            'id_role' => 'required',
            'id_branch' => 'required',            
        ]);
        
        $role = $request->id_role;

        $data = [
            'id_role' => $role,
            'id_branch' => $request->id_branch,
            'name' => $request->first_name.' '.$request->last_name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'salary' => $request->salary,
        ];
        
        $first_name=$request->first_name;
        $count = User::get()
            ->count()
            + 1;

        try {
            switch ($role) {
                case Role::ADMIN:
                    $employee = DB::transaction(function () use ($data, $first_name, $count) {
                        $user = User::create([
                            'username' => $first_name . $count,
                            'password' => bcrypt($first_name . $count),
                        ]);

                        return $user->employees()->create($data);
                    });

                    break;

                case Role::COSTUMER_SERVICE:
                    $employee = DB::transaction(function () use ($data, $first_name, $count) {
                        $user = User::create([
                            'username' => $first_name . $count,
                            'password' => bcrypt($first_name . $count),
                        ]);

                        return $user->employees()->create($data);
                    });
                    break;

                case Role::CASHIER:
                    $employee = DB::transaction(function () use ($data, $first_name, $count) {
                        $user = User::create([
                            'username' => $first_name . $count,
                            'password' => bcrypt($first_name . $count),
                        ]);

                        return $user->employees()->create($data);
                    });
                    break;

                case Role::MECHANIC:
                    $data = [
                        'id_role' => $role,
                        'id_branch' => $request->id_branch,
                        'name' => $request->first_name.' '.$request->last_name,
                        'address' => $request->address,
                        'phone_number' => $request->phone_number,
                        'salary' => $request->salary,
                    ];

                    $employee = Employees::create($data);
                    break;

                default:
                    break;
            }
               

                $response = $this->generateItem($employee);

                return $this->sendResponse($response, 201);
           

        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $employee=Employee::find($id);
            $response = $this->generateItem($employee);
            return $this->sendResponse($response);
        } catch (ModelNotFoundException $e) {
            return $this->sendNotFoundResponse('employee_not_found');
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
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
        try {

            $employee=Employee::find($id);

            $employee->name=$request->get('first_name').' '.$request->get('last_name');
            $employee->address=$request->get('address');
            $employee->phone_number=$request->get('phone_number');
            $employee->salary=$request->get('salary');
            $employee->id_role=$request->get('id_role');
            $employee->id_branch=$request->get('id_branch');
            $employee->id_user=$request->get('id_user');
            $employee->save();

            $response = $this->generateItem($employee);

            return $this->sendResponse($response, 201);

        }catch (ModelNotFoundException $e) {
            return $this->sendNotFoundResponse('employee_not_found');
        }
        catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $employee=Employee::find($id);
            $employee->delete();
            return response()->json('Success',200);
        } catch (ModelNotFoundException $e) {
            return $this->sendNotFoundResponse('employee_not_found');
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
}
