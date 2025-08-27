<!DOCTYPE html>
<html lang="ar">
    @include('Assistant.partials.head')
    <body>
        <div class="container-scroller">
           
            <div class="container-fluid page-body-wrapper">
                @include('Assistant.partials.navbar')
                <div class="main-panel" >
                    <div class="content-wrapper" style="background-color: #0F172A">
                        <main id="main" class="main" >
                            @yield('main')
                        </main>
                    </div>
                    @include('Assistant.partials.footer')
                </div>
            </div>
            @include('Assistant.partials.sidebar')
        </div>
        @include('Assistant.partials.scripts')
    </body>
</html>