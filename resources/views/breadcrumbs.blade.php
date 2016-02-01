<!--breadcrumbs start-->
<div class="breadcrumbs">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-sm-4">
        <h1>
          {{$breadcrumb_title}}
        </h1>
      </div>
      <div class="col-lg-6 col-sm-8">
        <ol class="breadcrumb pull-right">
          @foreach($breadcrumb_list as $item)
            @if($item == end($breadcrumb_list))
            <li class="active">
              {{$item[0]}}
            </li>
            @else
            <li>
              <a href="{{ url($item[1]) }}">
                {{$item[0]}}
              </a>
            </li>
            @endif
          @endforeach
        </ol>
      </div>
    </div>
  </div>
</div>
<!--breadcrumbs end-->
