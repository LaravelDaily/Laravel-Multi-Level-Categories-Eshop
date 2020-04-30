<?php

namespace App\Http\Requests;

use App\Product;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'name'         => [
                'required'],
            'price'        => [
                'required'],
            'categories.*' => [
                'integer'],
            'categories'   => [
                'array'],
            'tags.*'       => [
                'integer'],
            'tags'         => [
                'array'],
            'slug'         => [
                'required',
                'unique:products,slug,' . request()->route('product')->id],
        ];

    }
}
