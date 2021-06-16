<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

</head>
<body>
<iframe src="http://localhost:3000/authz.html" name="example"/>

    <script>
        window.addEventListener("message", function(event) {

            if (event.origin != 'http://lara') {
                console.log(event.origin + ' origin is invalid');
                return;
            }

            console.log("Client App received: " + event.data );

        });

        let win = window.frames.example;
        win.postMessage([client_id => "505"], "http://lara");
    </script>



</body>
</html>


