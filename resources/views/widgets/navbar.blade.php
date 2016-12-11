<div class="bs-example bs-navbar-top-example" data-example-id="navbar-fixed-to-top">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-6">
                <ul class="nav navbar-nav">
                    @foreach ($menu as $key => $item)
                        <li><a href="{{ $item['url'] }}">{{ $item['title'] }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>
</div>