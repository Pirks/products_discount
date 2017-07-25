<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <script src="js/jquery.min.js"></script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #000;
                font-family: 'Arial', sans-serif;
                padding: 0;
                margin: 0;
            }
            h1 {
                text-align: center;
                font-size: 26px;
                color: #2b542c;
            }
            .table {
                border: 1px solid #ddd;
                width: 90%;
                margin: 0px auto;
                border-spacing: 0;
                border-collapse: collapse;
            }
            .table th,
            .table td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }
            .table th a {
                color: #2b542c;
                text-decoration: none;
            }
            .table th a:hover {
                color: #2ab27b;
            }

            .btn {
                display: inline-block;
                padding: 10px;
                text-decoration: none;
                margin: 0;
                color: #fff;
                background-color: #337ab7;
                border-color: #2e6da4;
                font-size: 14px;
                min-width: 70px;
                text-align: center;
                border: 1px solid transparent;
                border-radius: 4px;
            }
            .btn:hover {
                color: #fff;
                background-color: #286090;
                border-color: #204d74;
            }
        </style>
    </head>
    <body>
        <div class="content">
            <h1>Products</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th><a href="?sort_field=id">ID</a></th>
                        <th><a href="?sort_field=name">Name</a></th>
                        <th><a href="?sort_field=price">Price</a></th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td><a href="javascript:" onclick="buyProduct('{{ route('api.product.buy', [$product->id]) }}')" class="btn">Buy</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>
</html>
<script>
    function buyProduct(url)
    {
        $.ajax({
            url: url,
            type: "put",
            dataType: 'json',
            success: function(responce) {
                location.reload();
            },
            error: function(responce) {
                alert(responce.responseJSON.errors);
            }
        });
    }
</script>