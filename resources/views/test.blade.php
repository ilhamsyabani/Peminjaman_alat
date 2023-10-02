<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</head>

<body>
    <div class="container m-4">
        <div class="input-group me-2 me-lg-3 fmxw-400">
            <span class="input-group-text">
                <svg class="icon icon-xs" x-description="Heroicon name: solid/search" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd"></path>
                </svg>
            </span>
            <input type="text" class="form-control" placeholder="cari data barang disini" name="search"
                id="searchmember" value="{{ old('search') ?? '' }}" autofocus>
        </div>
        <div class="m-4">
            <ul class="list-group" id="search-results">
            </ul>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            readData(); 

            $("#searchmember").keyup(function() {
                var strcari = $(this).val();
                if (strcari != "") {
                    $.ajax({
                        type: "get",
                        url: "{{ url('/search-member') }}",
                        data:
                            "search=" + strcari,  // Send data as an object
                        success: function(data) {
                            $("#search-results").html(data);
                        }
                    });
                } else {
                    // Handle empty search case if needed
                    readData();
                    // $("#search-results").html('');
                }
            });
        });

        function readData() {
            $.get("{{ url('/search-no-result') }}", {},
                function(data, status) {
                    $("#search-results").html(data);
                });
        }
    </script>
</body>

</html>
