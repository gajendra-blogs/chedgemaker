<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page-title') - {{ setting('app_name') }}</title>

    <script src="https://kit.fontawesome.com/3ec28a99a4.js" crossorigin="anonymous"></script>
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="{{ url('assets/img/icons/apple-touch-icon-144x144.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152"
        href="{{ url('assets/img/icons/apple-touch-icon-152x152.png') }}" />
    <link rel="icon" type="image/png" href="{{ url('assets/img/icons') }}" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{ url('assets/img/icons') }}" sizes="16x16" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
    <meta name="application-name" content="{{ setting('app_name') }}" />
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta name="msapplication-TileImage" content="{{ url('assets/img/icons/') }}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link media="all" type="text/css" rel="stylesheet" href="{{ url('assets/css/spinner.css') }}">
    <link media="all" type="text/css" rel="stylesheet" href="{{ url(mix('assets/css/vendor.css')) }}">
    <link media="all" type="text/css" rel="stylesheet" href="{{ url(mix('assets/css/app.css')) }}">

    @yield('styles')

    @hook('app:styles')
</head>

<body>
    @include('partials.navbar')
    <section id="loading">
        <div id="loading-content"></div>
    </section>
    <div id="ss"></div>
    <input type="hidden" id="downloadExcelFileUrl" value="">
    <div class="container-fluid">
        <div class="row">
            @include('partials.sidebar.main')
            <div class="content-page">
                <main role="main" class="px-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <script src="{{ url(mix('assets/js/vendor.js')) }}"></script>
    <script src="{{ url('assets/js/as/app.js') }}"></script>
    <script src="{{ url('assets/js/spinner.js') }}"></script>
    <script src="{{ url('assets/js/sorting/sorting.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js">
    </script> -->
    <script src="https://cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js">
    </script>


    <script>
        function changeStatus(id, status, table, inputAddress) {

            $.ajax({
                url: "{{ route('changeStatus') }}",
                method: "POST",
                data: {
                    id_var: id,
                    status_var: status,
                    table_var: table,
                },
                success: function (resp) {
                    console.log(resp);
                    if (resp.response) {
                        if (resp.status == 1) {
                            // console.log(inputAddress);
                            inputAddress.setAttribute("checked", true);
                            inputAddress.removeAttribute("onclick")
                            inputAddress.setAttribute("onclick",
                                `changeStatus('${resp.id}' ,'${resp.status}','${resp.table}',this)`);
                        } else {
                            inputAddress.setAttribute("checked", false);
                            inputAddress.removeAttribute("onclick");
                            inputAddress.setAttribute("onclick",
                                `changeStatus('${resp.id}' ,'${resp.status}','${resp.table}',this)`);
                        }
                        swal(
                            'Done!',
                            'You have changed status successfully!',
                            'success',
                        );
                    } else {
                        swal(
                            'Failed!',
                            'Something went wrong, Try again!',
                            'warning'
                        );
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        const downloadExcelFile = (table) => {
            var url = $("#downloadExcelFileUrl").val();

            $.ajax({
                url: url,
                type: 'GET',
                responseType: 'blob',
                data: {
                    table: table
                },
                success: function (response) {
                    console.log(response)
                    // const url = window.URL.createObjectURL(new Blob([response]));
                    // const link = document.createElement('a');
                    // link.setAttribute('download', 'file.xls');
                    // link.setAttribute('href', url);
                    // document.body.appendChild(link);
                    // link.click();
                    // console.log(link);
                }
            });
        }

    </script>
    @yield('scripts')

    @hook('app:scripts')
</body>

</html>
