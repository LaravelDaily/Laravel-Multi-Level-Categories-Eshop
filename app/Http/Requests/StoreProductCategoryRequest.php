<?php

namespace App\Http\Requests;

use App\ProductCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreProductCategoryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('product_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'name' => [
                'required'],
            'slug' => [
                'required',
                'unique:product_categories'],
        ];

    }
}
