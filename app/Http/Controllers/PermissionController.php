<?php

namespace App\Http\Controllers;

use App\Models\User;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use App\Traits\UserCheckRole;

use App\Http\Middleware\RoleOrPermissionMiddleware;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\TB_permission\modules;
use thiagoalessio\TesseractOCR\TesseractOCR;

use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use App\Models\TB_Constants\TB_Frontend\TB_Zone;

class PermissionController extends Controller
{

    use UserCheckRole;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // dd($request->route()->getActionMethod());

            if ($request->fun !== 'ignore') {
                $page = $request->page;
                return (new RoleOrPermissionMiddleware)->handle($request, $next, $page);
            }

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        if ($request->funs == 'roles') {
            $roles = Role::all();
            return view('constants.section-permissions.section-role.view', compact('roles'));
        } elseif ($request->funs == 'modules') {
            $modules = modules::all();
            return view('constants.section-permissions.section-module.list', compact('modules'));
        } elseif ($request->funs == 'permissions') {
            $permissions = Permission::all();
            // $modules = Module::orderBy('order')->get();
            return view('constants.section-permissions.section-permission.list', compact('permissions'));
        } elseif ($request->funs == 'users') {
            $users = User::where('zone', auth()->user()->zone)
                ->select('id', 'status', 'name', 'branch', 'email', 'zone', 'created_at', 'updated_at')
                ->get();

            return view('constants.section-users.view', compact('users'));
        }
    }

    public function create(Request $request)
    {
        if ($request->page == 'users-create') {
            // $this->authorize('create', User::class);
            $roles = $this->checkRoleAuthorizes(auth()->user()->getRoleNames()->toArray());
            $zones = TB_Zone::all();

            return view('constants.section-users.create', compact('roles', 'zones'));
        } elseif ($request->page == 'users-restore') {
            $users = User::onlyTrashed()->where('zone', auth()->user()->zone)->get();

            return view('constants.section-users.trash', compact('users'));
        } elseif ($request->page == 'getBranch') {
            try {
                $branchs = TB_Branchs::where('Zone_Branch', $request->zone)->get();
                return response()->json(['branchs' => $branchs], 200);
            } catch (\Throwable $e) {
                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
        }
    }

    public function edit(Request $request, $id)
    {
        if ($request->page == 'roles-edit') {
            $role = Role::findOrFail($id);

            // ตรวจสอบสิทธิ์ในการแก้ไขบทบาท
            // if (Gate::denies('roles-edit', $role)) {
            //     abort(403, 'คุณไม่มีสิทธิ์ในการแก้ไขบทบาทนี้');
            // }

            $role_permissions = $role->getAllPermissions()->pluck('id')->toArray();
            $modules = modules::whereIn('action', ['menu-mega', 'mega-action', 'action-front', 'menu-front'])
                ->with('permissions')
                ->get()
                ->groupBy('action');

            $menu_mega = $modules->get('menu-mega', collect());
            $maga_action = $modules->get('mega-action', collect());

            $menu_front = $modules->get('menu-front', collect());
            $action_front = $modules->get('action-front', collect())->sortBy('order');

            $back_modules = modules::where('action', 'backend')->with('permissions')->get();

            // $userAllPermissions = auth()->user()->getAllpermissions()->pluck('name');
            // $userRolePermission = auth()->user()->getPermissionsViaRoles()->pluck('name');
            // $userPermission = auth()->user()->permissions->pluck('name');
            // $usergetRoleNames = auth()->user()->getRoleNames();

            // dump($userAllPermissions, $userRolePermission, $userPermission);
            // dd($usergetRoleNames);

            // $permissionsModule = [1];

            // $userAllPermissions = auth()->user()->getAllPermissions();
            // $intersectedPermissions = $userAllPermissions->filter(function ($permission) use ($permissionsModule) {
            //     return in_array($permission->module_id, $permissionsModule);
            // });

            // $moduleIDs = $intersectedPermissions->pluck('name');
            return view('constants.section-permissions.section-role.edit', compact('role', 'role_permissions', 'back_modules', 'menu_mega', 'maga_action', 'menu_front', 'action_front'));
        } elseif ($request->page == 'users-edit') {
            $user = User::find($id);
            $zones = TB_Zone::all();
            $branchs = TB_Branchs::where('Zone_Branch', $user->zone)->get();
            $roles = $this->checkRoleAuthorizes(auth()->user()->getRoleNames()->toArray());
            $userRoles = $user->getRoleNames();

            return view('constants.section-users.edit', compact('user', 'zones', 'branchs', 'roles', 'userRoles'));
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->page == 'roles-edit') {
            DB::beginTransaction();
            try {
                $role = Role::findOrFail($id);
                $role->code = $request->code;
                $role->name = $request->name_en;
                $role->name_en = $request->name_en;
                $role->name_th = $request->name_th;
                $role->save();
                $role->syncPermissions($request->permissions);
                DB::commit();
                Log::channel('daily')->info($role);

                return response()->json(['message' => 'Successful', 'code' => 200], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::channel('daily')->error($e->getMessage());

                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
        } elseif ($request->page == 'users-edit') {
            DB::beginTransaction();
            try {
                $user = User::find($id);
                $user->name = $request->data['name'];
                $user->username = $request->data['username'];
                $user->email = $request->data['email'];
                $user->phone = str_replace(['(', ')', '-'], '', $request->data['phone']);
                if ($user->password_token != $request->data['password']) {
                    $user->password = Hash::make($request->data['password']);
                    $user->password_token = $request->data['password'];
                }
                $user->password_teams = base64_encode($request->data['password_Team']);
                $user->zone = $request->data['zone'];
                $user->branch = $request->data['branch'];
                $user->updated_at = Carbon::now();
                $user->save();

                $user->roles()->detach();
                $user->assignRole($request->data['roles']);
                DB::commit();
                Log::channel('daily')->info($user);

                $users = User::where('zone', auth()->user()->zone)
                    ->select('id', 'status', 'name', 'email', 'zone', 'branch', 'created_at', 'updated_at')
                    ->get();

                $view_data = view('constants.section-users.list', compact('users'))->render();
                return response()->json(['message' => 'Successful', 'view_data' => $view_data, 'code' => 200], 200);
            } catch (\Throwable $th) {
                DB::rollBack();
                Log::channel('daily')->error($th->getMessage());

                return response()->json(['message' => $th->getMessage(), 'code' => $th->getCode()], 500);
            }


        } elseif ($request->page == 'users-restore') {
            DB::beginTransaction();
            try {
                User::onlyTrashed()->find($id)->restore();
                $user = User::find($id);
                $user->update(['status' => 'active']);

                DB::commit();
                Log::channel('daily')->info($user);

                $users = User::where('zone', auth()->user()->zone)
                    ->select('id', 'status', 'name', 'email', 'zone', 'created_at', 'updated_at')
                    ->get();

                $view_data = view('constants.section-users.list', compact('users'))->render();
                return response()->json(['message' => 'คืนค่าผู้ใช้งานสำเร็จ', 'view_data' => $view_data, 'code' => 200], 200);
            } catch (\Throwable $th) {
                DB::rollBack();
                Log::channel('daily')->error($th->getMessage());

                return response()->json(['message' => $th->getMessage(), 'code' => $th->getCode()], 500);
            }

        }
    }

    public function store(Request $request)
    {
        if ($request->page == 'roles-create') {
            $checkRole = Role::all()->pluck('name')->toArray();
            if (in_array($request->name_role, $checkRole)) {
                return response()->json(['message' => 'Data found', 'code' => 200], 200);
            }

            DB::beginTransaction();
            try {
                $role = Role::create([
                    'code' => $request->code_role,
                    'name' => $request->name_role,
                    'name_en' => $request->name_en_role,
                    'name_th' => $request->name_th_role,
                    'guard_name' => 'web',
                ]);
                DB::commit();
                Log::channel('daily')->info($role);

                $roles = Role::all();
                $view = view('constants.section-permissions.section-role.data-list', compact('roles'))->render();
                return response()->json(['message' => 'Role created successfully' . Carbon::now()->format('Y-m-d H:i:s'), 'view' => $view, 'code' => 200], 200);
            } catch (\Exception $e) {
                DB::rollback();
                Log::channel('daily')->error($e->getMessage());

                return response()->json(['message' => $e->getMessage(), 'code' => 500], 500);
            }
        } elseif ($request->page == 'create-permissions') {
            try {
                $permission = Permission::create([
                    'name' => $request->name,
                    'name_en' => $request->name_en,
                    'name_th' => $request->name_th,
                    'guard_name' => auth()->getDefaultDriver(),
                    'module_id' => $request->module_id,
                    'created_at' => Carbon::now(),
                ]);

                return redirect()->back()->with('success', 'บันทึกข้อมูลสำเร็จ ' . Carbon::now()->format('Y-m-d H:i:s'));
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return redirect()->back()->withErrors(['error' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล ' . Carbon::now()->format('Y-m-d H:i:s')]);
            }
        } elseif ($request->page == 'create-modules') {
            try {
                $module = modules::create([
                    'action' => $request->action,
                    'name_en' => $request->name_en,
                    'name_th' => $request->name_th,
                    'created_at' => Carbon::now(),
                ]);
                $module->save();

                return redirect()->back()->with('success', 'บันทึกข้อมูลสำเร็จ ' . Carbon::now()->format('Y-m-d H:i:s'));
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return redirect()->back()->withErrors(['error' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล ' . Carbon::now()->format('Y-m-d H:i:s')]);
            }
        } elseif ($request->page == 'users-create') {
            $checkUser = user::withTrashed()
                ->where('name', 'like', $request->data['name'])
                ->where('username', 'like', $request->data['username'])
                ->where('email', $request->data['email'])
                ->get();

            if ($checkUser->isNotEmpty()) {
                return response()->json(['message' => 'มีผู้ใช้ในระบบแล้ว กรุณาตรวจสอบในถังขยะ', 'code' => 500], 500);
            }

            DB::beginTransaction();
            try {
                $user = User::create([
                    'status' => 'active',
                    'name' => $request->data['name'],
                    'username' => $request->data['username'],
                    'email' => $request->data['email'],
                    'phone' => str_replace(['(', ')', '-'], '', $request->data['phone']),
                    'password' => Hash::make($request->data['password']),
                    'password_token' => $request->data['password_confirmation'],
                    'password_teams' => base64_encode($request->data['password_Team']),
                    'zone' => $request->data['zone'],
                    'branch' => $request->data['branch'],
                    'created_at' => Carbon::now(),
                ]);
                $user->assignRole(@$request->data['roles']);
                DB::commit();
                Log::channel('daily')->info($user);


                $users = User::where('zone', auth()->user()->zone)
                    ->select('id', 'status', 'name', 'email', 'zone', 'created_at', 'updated_at')
                    ->get();

                $view_data = view('constants.section-users.list', compact('users'))->render();
                return response()->json(['view_data' => $view_data], 200);
            } catch (\Throwable $th) {
                DB::rollBack();
                Log::channel('daily')->error($th->getMessage());

                return response()->json(['message' => $th->getMessage(), 'code' => $th->getCode()], 500);
            }
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($request->page == 'users-delete') {
            DB::beginTransaction();
            try {
                $user = User::find($id);

                if ($user) {
                    $user->update(['status' => 'inactive']);
                    $user->delete();
                    $user->roles()->detach();
                    DB::commit();
                    Log::channel('daily')->info($user);

                    $users = User::where('zone', auth()->user()->zone)
                        ->select('id', 'status', 'name', 'email', 'zone', 'created_at', 'updated_at')
                        ->get();

                    $view_data = view('constants.section-users.list', compact('users'))->render();
                    return response()->json(['message' => 'ลบข้อมูลเรียบร้อย', 'view_data' => $view_data, 'code' => 200], 200);
                } else {
                    return response()->json(['message' => 'ไม่พบข้อมูลผู้ใช้', 'code' => 404], 404);
                }
            } catch (\Throwable $e) {
                DB::rollback();
                Log::channel('daily')->error($e->getMessage());

                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
        }
    }
}