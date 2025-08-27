<!DOCTYPE html>
<html lang="ar">
    @include('Doctor.partials.head')
    <body>
        <div class="container-scroller">
           
            <div class="container-fluid page-body-wrapper">
                @include('Doctor.partials.navbar')
                <div class="main-panel" >
                    <div class="content-wrapper" style="background-color: #0F172A">
                        <main id="main" class="main" >
                            @yield('main')
                        </main>
                    </div>
                    @include('Doctor.partials.footer')
                </div>
            </div>
            @include('Doctor.partials.sidebar')
        </div>
        @include('Doctor.partials.scripts')
    </body>
</html>