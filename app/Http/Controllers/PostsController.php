<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Multividas\ApiResponser\Facades\ApiResponser;

class PostsController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            // $x = 10/0;
            return ApiResponser::showAll(Post::all());
        } catch (ValidationException $e) {
            return $this->handleValidationException($e);
        } catch (\Throwable $e) {
            return $this->handleInternalError($e);
        }
    }

    public function show(string $postId): JsonResponse
    {
        try {
            $post = Post::find($postId);

            if (!$post instanceof Post) {
                return $this->infoResponse('Post Not Found', 404, (object)[]);
            }

            return ApiResponser::showOne($post);
        } catch (\Throwable $e) {
            return $this->handleInternalError($e);
        }
    }
}
