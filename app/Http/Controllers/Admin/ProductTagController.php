<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProductTagRequest;
use App\Http\Requests\StoreProductTagRequest;
use App\Http\Requests\UpdateProductTagRequest;
use App\ProductTag;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductTagController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('product_tag_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productTags = ProductTag::all();

        return view('admin.productTags.index', compact('productTags'));
    }

    public function create()
    {
        abort_if(Gate::denies('product_tag_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.productTags.create');
    }

    public function store(StoreProductTagRequest $request)
    {
        $productTag = ProductTag::create($request->all());

        return redirect()->route('admin.product-tags.index');

    }

    public function edit(ProductTag $productTag)
    {
        abort_if(Gate::denies('product_tag_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.productTags.edit', compact('productTag'));
    }

    public function update(UpdateProductTagRequest $request, ProductTag $productTag)
    {
        $productTag->update($request->all());

        return redirect()->route('admin.product-tags.index');

    }

    public function show(ProductTag $productTag)
    {
        abort_if(Gate::denies('product_tag_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.productTags.show', compact('productTag'));
    }

    public function destroy(ProductTag $productTag)
    {
        abort_if(Gate::denies('product_tag_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productTag->delete();

        return back();

    }

    public function massDestroy(MassDestroyProductTagRequest $request)
    {
        ProductTag::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }
}
