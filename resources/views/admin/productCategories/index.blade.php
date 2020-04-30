@extends('layouts.admin')
@section('content')
@can('product_category_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.product-categories.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.productCategory.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.productCategory.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-ProductCategory">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.productCategory.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.productCategory.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.productCategory.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.productCategory.fields.photo') }}
                        </th>
                        <th>
                            {{ trans('cruds.productCategory.fields.category') }}
                        </th>
                        <th>
                            {{ trans('cruds.productCategory.fields.slug') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productCategories as $key => $productCategory)
                        <tr data-entry-id="{{ $productCategory->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $productCategory->id ?? '' }}
                            </td>
                            <td>
                                {{ $productCategory->name ?? '' }}
                            </td>
                            <td>
                                {{ $productCategory->description ?? '' }}
                            </td>
                            <td>
                                @if($productCategory->photo)
                                    <a href="{{ $productCategory->photo->getUrl() }}" target="_blank">
                                        <img src="{{ $productCategory->photo->getUrl('thumb') }}" width="50px" height="50px">
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $productCategory->parentCategory->name ?? '' }}
                            </td>
                            <td>
                                {{ $productCategory->slug ?? '' }}
                            </td>
                            <td>
                                @can('product_category_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.product-categories.show', $productCategory->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('product_category_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.product-categories.edit', $productCategory->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('product_category_delete')
                                    <form action="{{ route('admin.product-categories.destroy', $productCategory->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('product_category_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.product-categories.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-ProductCategory:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
