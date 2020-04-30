<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductTagRequest;
use App\Http\Requests\UpdateProductTagRequest;
use App\Http\Resources\Admin\ProductTagResource;
use App\ProductTag;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductTagApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('product_tag_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProductTagResource(ProductTag::all());

    }

    public function store(StoreProductTagRequest $request)
    {
        $productTag = ProductTag::create($request->all());

        return (new ProductTagResource($productTag))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);

    }

    public function show(ProductTag $productTag)
    {
        abort_if(Gate::denies('product_tag_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProductTagResource($productTag);

    }

    public function update(UpdateProductTagRequest $request, ProductTag $productTag)
    {
        $productTag->update($request->all());

        return (new ProductTagResource($productTag))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);

    }

    public function destroy(ProductTag $productTag)
    {
        abort_if(Gate::denies('product_tag_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productTag->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }
}
