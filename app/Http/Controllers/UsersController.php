<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Multividas\ApiResponser\Facades\ApiResponser;

class UsersController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            // $x = 10/0;
            return ApiResponser::showAll(User::all());
        } catch (ValidationException $e) {
            return $this->handleValidationException($e);
        } catch (\Throwable $e) {
            return $this->handleInternalError($e);
        }
    }

    public function show(string $userId): JsonResponse
    {
        try {
            $user = User::find($userId);

            if (!$user instanceof User) {
                return $this->infoResponse('User Not Found', 404, (object)[]);
            }

            return ApiResponser::showOne($user);
        } catch (\Throwable $e) {
            return $this->handleInternalError($e);
        }
    }
}
