<?php

namespace App\Http\Controllers\Api;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\Api\EmployeeRequest;
use App\Http\Requests\Api\ImageRequest;
use App\Transformers\EmployeeTransformer;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    /**
     * 获取个人信息
     */
    public function show()
    {
        return $this->response->item($this->user(), new EmployeeTransformer())
            ->setMeta([
                'access_token' => \Auth::guard('api')->fromUser($this->user()),
                'token_type' => 'Bearer',
                'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60
            ]);
    }


    public function update(EmployeeRequest $request)
    {
        $user = $this->user();
        $attributes = $request->only(['name', 'email']);
        $user->update($attributes);
        return $this->response->item($user, new EmployeeTransformer());
    }


    public function changePassword(Request $request)
    {
        if($request->password && $request->password == $request->password_confirmation){
            $this->user()->password = bcrypt($request->password);
            $this->user()->save();
            return $this->response->item($this->user(), new EmployeeTransformer())->setStatusCode(201);
        }
        return $this->response->errorUnauthorized('密码输入有误');
    }

    public function avatarStore(ImageRequest $request, ImageUploadHandler $uploader)
    {
        $user = $this->user();
        $size = $request->type == 'avatar' ? 362 : 1024;
        $result = $uploader->save($request->image, str_plural($request->type), $user->id, $size);
        $user->avatar = $result['path'];
        $user->save();
        return $this->response->item($user, new EmployeeTransformer())->setStatusCode(201);
    }
}
