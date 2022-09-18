<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Fixture Manager</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>
<body class="antialiased">
<div class="container">

    <div class="d-flex justify-content-center mt-5">
        <div class="col-md-3">
            <table class="table table-bordered">
                <thead>
                <tr class="bg-dark text-white">
                    <th scope="col ">Team Name</th>

                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Mark</td>

                </tr>
                <tr>
                    <td>Jacob</td>

                </tr>
                <tr>
                    <td>Larry</td>

                </tr>
                </tbody>
            </table>
            <div class="d-grid gap-2">
            <button class="btn btn-primary" type="button">Generate Fixtures</button>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8"
        crossorigin="anonymous"></script>

</body>


</html>
