<!-- Footer -->
@if(session('phantom.preferences.menu_type')=='side')
    @php $menu_top='' @endphp
@elseif(session('phantom.preferences.menu_type')=='top')
    @php $menu_top='menu-top' @endphp
@endif

<footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline text-xxs">
        web template by <strong><a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    </div>
    {{ date('Y') }} © <strong><a href="#">DVPLEX</a></strong>
    <div id="footer-widgets">
        <footer-widget></footer-widget>
        <div class="btn-group dropup">
            <button type="button" class="btn btn-xs btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Info
            </button>
            <div class="dropdown-menu bg-secondary" style="">
                <table class="table table-borderless table-condensed mb-0">
                    <tbody>
                    <tr>
                        <td width="60">User</td>
                        <td><strong>{{ Auth::user()->username }}</strong></td>
                    </tr>
                    <tr>
                        <td width="60">IP</td>
                        <td><strong>{{ get_ip() }}</strong></td>
                    </tr>
                    <tr>
                        <td width="60">
                            Generated
                        </td>
                        <td width="60">
                            <strong> {{ round((microtime(true) - LARAVEL_START),2) }} sec.</strong>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</footer>
