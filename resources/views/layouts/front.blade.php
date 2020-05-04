<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ trans('panel.site_title') }}</title>

  <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
  <link href="{{ asset('css/shop-homepage.css') }}" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="{{ route('index') }}">{{ trans('panel.site_title') }}</a>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <div class="col-lg-3">

        <h1 class="my-4">{{ trans('panel.site_title') }}</h1>
        <ul class="list-group" id="categories">
          @foreach($frontCategories as $parentCategory)
            <li class="list-group-item" data-id="{{ $parentCategory->id }}">
              <i class="fa fa-arrow-right"></i>
              <a href="{{ route('category', [$parentCategory]) }}">{{ $parentCategory->name }} ({{ $parentCategory->products_count }})</a>
            </li>
            @if($parentCategory->childCategories->count())
              <div class="list-second-level" data-id="{{ $parentCategory->id }}" style="display:none;">
                @foreach($parentCategory->childCategories as $category)
                  <li class="list-group-item" data-id="{{ $category->id }}">
                    <i class="fa fa-arrow-right"></i>
                    <a href="{{ route('category', [$parentCategory, $category]) }}">{{ $category->name }} ({{ $category->products_count }})</a>
                  </li>
                  @if($category->childCategories->count())
                    <div class="list-third-level" data-id="{{ $category->id }}" style="display:none;">
                      @foreach($category->childCategories as $childCategory)
                        <a
                          href="{{ route('category', [$parentCategory, $category, $childCategory->slug]) }}"
                          class="list-group-item{{ $loop->last ? ' mb-1' : '' }}"
                          data-id="{{ $childCategory->id }}"
                        >
                          {{ $childCategory->name }} ({{ $childCategory->products_count }})
                        </a>
                      @endforeach
                  </div>
                  @endif
                @endforeach
              </div>
            @endif
          @endforeach
        </ul>
      </div>
      <!-- /.col-lg-3 -->

      <div class="col-lg-9">

        @yield('content')

      </div>
      <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; {{ trans('panel.site_title') }} {{ date('Y') }}</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script>
    $(function () {
      $('#categories li').click(function () {
        var $this = $(this);
        var id = $this.data('id');

        // Collapse siblings
        $this.siblings('li[data-id!="' + id + '"]').children('i').addClass('fa-arrow-right').removeClass('fa-arrow-down');
        $this.siblings('div[data-id!="' + id + '"]').hide();

        $this.children('i').toggleClass('fa-arrow-right').toggleClass('fa-arrow-down');
        $this.siblings('div[data-id="' + id + '"]').toggle();
      });

      @if(isset($selectedCategories))
        @foreach($selectedCategories as $selected)
          @if($loop->index < 2)
            $('#categories .list-group-item[data-id="{{ $selected }}"]').click();
          @endif
          @if($loop->last)
            $('#categories .list-group-item[data-id="{{ $selected }}"]').toggleClass('active');
          @endif
        @endforeach
      @endif
    });
  </script>
</body>

</html>
